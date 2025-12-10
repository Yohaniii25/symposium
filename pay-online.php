<?php

require_once 'config/config.php';
require_once 'classes/database.php';
require_once 'classes/auth.php';

$auth = new Auth();
if (!$auth->isParticipant()) {
    header("Location: login.php");
    exit();
}

$user = $auth->user();
$amount = $_POST['amount'] ?? 0;
$user_id = $_POST['user_id'] ?? 0;

if ($amount <= 0 || $user_id != $user['id']) {
    die("Invalid request");
}

$order_id = "GJRTI-" . $user['id'] . "-" . time();
$reference_no = "USER" . $user['id'];

// YOUR ORIGINAL GEM IPG FUNCTION — 100% WORKING
function ipg_start($order_id, $amount, $reference_no, $user_id) {
    $return_url = "https://sltdigital.site/gem/proceed-to-pay.php?status=cancelled";
    $success_url = "https://sltdigital.site/gem/payment-success.php";

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://test-bankofceylon.mtf.gateway.mastercard.com/api/rest/version/100/merchant/TEST700182200500/session',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => json_encode([
            "apiOperation" => "INITIATE_CHECKOUT",
            "interaction" => [
                "operation" => "PURCHASE",
                "merchant" => ["name" => "GJRTI Symposium", "url" => "https://sltdigital.site/gem"],
                "returnUrl" => $success_url
            ],
            "order" => [
                "id" => $order_id,
                "amount" => number_format($amount, 2, '.', ''),
                "currency" => "LKR",
                "description" => "GJRTI Symposium Payment - User: $user_id"
            ]
        ]),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Basic bWVyY2hhbnQuVEVTVDcwMDE4MjIwMDUwMDpiMWUzZTE1NjU3MWNlNGFhZTRmNzMzZTVmMWY1MGYyMw=='
        ],
    ]);

    $response = curl_exec($curl);
    if (curl_errno($curl)) die("Gateway error: " . curl_error($curl));
    curl_close($curl);

    $data = json_decode($response, true);
    if (!isset($data['session']['id'])) die("Gateway failed: " . print_r($data, true));

    // Save session for success page
    $_SESSION['session_id'] = $data['session']['id'];
    $_SESSION['success_indicator'] = $data['successIndicator'];
    $_SESSION['order_id'] = $order_id;
    $_SESSION['amount_paid'] = $amount;
    $_SESSION['user_id_paid'] = $user_id;

    echo '<!DOCTYPE html><html><head>
        <script src="https://test-bankofceylon.mtf.gateway.mastercard.com/static/checkout/checkout.min.js"
                data-error="errorCallback" data-cancel="cancelCallback"></script>
        <script>
            function errorCallback(){ alert("Payment Failed"); location.href="'.$return_url.'"; }
            function cancelCallback(){ location.href="'.$return_url.'"; }
            Checkout.configure({ session: { id: "'.$data['session']['id'].'" } });
        </script>
        </head><body>
        <div class="text-center py-20 text-xl">Redirecting to payment gateway...</div>
        <script>Checkout.showPaymentPage();</script>
        </body></html>';
    exit;
}

// Start IPG
ipg_start($order_id, $amount, $reference_no, $user['id']);
?>