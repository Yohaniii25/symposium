<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/classes/database.php';


$logDir = __DIR__ . '/logs/';
if (!is_dir($logDir)) mkdir($logDir, 0755, true);
$GLOBALS['logDir'] = $logDir;

function ipg_start($order_id, $amount, $reference_no, $installment_type, $user_id, $participant_type)
{
    $return_url = "https://sltdigital.site/gem/symposium/proceed-to-pay.php?ref=" . urlencode($reference_no);

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://test-bankofceylon.mtf.gateway.mastercard.com/api/rest/version/100/merchant/TEST700182200500/session',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => json_encode([
            "apiOperation" => "INITIATE_CHECKOUT",
            "checkoutMode" => "WEBSITE",
            "interaction" => [
                "operation" => "PURCHASE",
                "merchant" => ["name" => "Gem and Jewellery", "url" => "https://sltdigital.site/gem/"],
                "returnUrl" => "https://sltdigital.site/gem/symposium/payment-success.php?orderId=" . $order_id
            ],
            "order" => [
                "currency" => "LKR",
                "amount" => number_format($amount, 2, '.', ''),
                "id" => $order_id,
                "description" => "GJRTI Payment - Ref: $reference_no"
            ]
        ]),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Basic bWVyY2hhbnQuVEVTVDcwMDE4MjIwMDUwMDpiMWUzZTE1NjU3MWNlNGFhZTRmNzMzZTVmMWY1MGYyMw=='
        ],
    ]);

    $response = curl_exec($curl);
    if (curl_errno($curl)) die("Gateway error.");
    curl_close($curl);

    $data = json_decode($response, true);
    if (!isset($data['session']['id']) || !isset($data['successIndicator'])) die("Gateway failed.");

    $_SESSION['session_id'] = $data['session']['id'];
    $_SESSION['success_indicator'] = $data['successIndicator'];
    $_SESSION['order_id'] = $order_id;
    $_SESSION['reference_no'] = $reference_no;
    $_SESSION['amount_to_pay'] = $amount;
    $_SESSION['amount_paid'] = $amount;
    $_SESSION['user_id_paid'] = $user_id;
    $_SESSION['participant_type'] = $participant_type;
    $_SESSION['installment_type'] = $installment_type;

    session_write_close();

    echo '<!DOCTYPE html><html><head>
        <script src="https://test-bankofceylon.mtf.gateway.mastercard.com/static/checkout/checkout.min.js"
                data-error="errorCallback" data-cancel="cancelCallback"></script>
        <script>
            function errorCallback(){ alert("Failed"); location.href="' . $return_url . '"; }
            function cancelCallback(){ alert("Cancelled"); location.href="' . $return_url . '"; }
            Checkout.configure({ session: { id: "' . $data['session']['id'] . '" } });
        </script>
        </head><body>
        <div id="embed-target"></div>
        <script>window.onload = function(){ Checkout.showPaymentPage(); }</script>
        </body></html>';
    exit;
}

//MAIN LOGIC
$db = new Database();
$conn = $db->getConnection();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // If accessed via GET/direct link, show error
    if (!isset($_GET['ref'])) {
        die("Invalid access. Please use the payment form.");
    }
    $error = htmlspecialchars($_GET['error'] ?? '');
    echo '<!DOCTYPE html><html><head><title>Payment Error</title></head><body>';
    echo '<h1>Payment Processing Error</h1>';
    echo '<p>Reference: ' . htmlspecialchars($_GET['ref']) . '</p>';
    if ($error) echo '<p>Error: ' . $error . '</p>';
    echo '<p><a href="proceed-to-pay.php">Back to Payment</a></p>';
    echo '</body></html>';
    exit;
}

$reference_no   = trim($_POST['reference_no'] ?? '');
$payment_method = $_POST['payment_method'] ?? '';
$payment_option = $_POST['payment_option'] ?? '';

if (empty($reference_no) || empty($payment_method) || empty($payment_option)) {
    header("Location: proceed-to-pay.php?ref=" . urlencode($reference_no) . "&error=Missing+fields");
    exit;
}

// GET USER + PAYMENT INFO
$stmt = $conn->prepare("
    SELECT 
        u.id AS user_id,
        u.reference_no,
        u.participant_type
    FROM users u
    WHERE u.id = ?
");
$stmt->bind_param("s", $reference_no);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) die("Invalid reference.");

// If reference_no not set, update it now
if (empty($user['reference_no'])) {
    $update_stmt = $conn->prepare("UPDATE users SET reference_no = ? WHERE id = ?");
    $update_stmt->bind_param("si", $reference_no, $user['user_id']);
    $update_stmt->execute();
    $update_stmt->close();
    $user['reference_no'] = $reference_no;
}

// Calculate amount based on participant type
$payment_amounts = [
    'Presenting Author' => 1000,
    'Co-Author' => 1500,
    'Other Participants' => 5000
];

$amount_to_pay = $payment_amounts[$user['participant_type']] ?? 0;
if ($amount_to_pay <= 0) die("Invalid participant type.");

// Check if already paid
$check_stmt = $conn->prepare("SELECT id FROM payments WHERE user_id = ? AND status = 'paid'");
$check_stmt->bind_param("i", $user['user_id']);
$check_stmt->execute();
if ($check_stmt->get_result()->num_rows > 0) {
    $check_stmt->close();
    header("Location: payment-success.php?ref=$reference_no");
    exit;
}
$check_stmt->close();

$remaining_due = $amount_to_pay;
$total_paid = 0;
$is_first_payment = true;
$installment_type = 'full';

try {
    $conn->autocommit(FALSE);

    if ($payment_method === 'Online Payment') {
        $unique_order_id = $reference_no . '-' . strtoupper($installment_type) . '-' . time();
        $conn->commit();
        $conn->autocommit(TRUE);
        ipg_start($unique_order_id, $amount_to_pay, $reference_no, $installment_type, $user['user_id'], $user['participant_type']);
        exit;
    }

} catch (Exception $e) {
    if ($conn->autocommit(FALSE)) $conn->rollback();
    $conn->autocommit(TRUE);
    header("Location: proceed-to-pay.php?ref=" . urlencode($reference_no) . "&error=" . urlencode($e->getMessage()));
    exit;
}

// Handle Bank Slip Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_slip'])) {
    $targetDir = "uploads/payment_slips/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $file = $_FILES['slip'];
    $fileName = time() . "_" . $user['user_id'] . "." . pathinfo($file["name"], PATHINFO_EXTENSION);
    $targetFile = $targetDir . $fileName;

    $allowed = ['jpg','jpeg','png','pdf'];
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if (!in_array($fileType, $allowed)) {
        $message = "Only JPG, PNG, PDF allowed";
    } elseif ($file["size"] > 5000000) { // 5MB
        $message = "File too large (max 5MB)";
    } else {
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            // SAVE TO payments TABLE — use correct column names from schema
            $stmt = $conn->prepare("INSERT INTO payments 
                (user_id, participant_type, amount, currency, payment_method, slip, status) 
                VALUES (?, ?, ?, 'LKR', 'bank_slip', ?, 'under_review')");

            if (!$stmt) die("Database error: " . $conn->error);
            
            $stmt->bind_param("isds", $user['user_id'], $user['participant_type'], $amount_to_pay, $fileName);
            if ($stmt->execute()) {
                $stmt->close();
                header("Location: payment-success.php?ref=$reference_no");
                exit;
            } else {
                $message = "Database error. Try again.";
            }
            $stmt->close();
        } else {
            $message = "Failed to upload file";
        }
    }
}