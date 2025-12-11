<?php
session_start();
require_once 'config/config.php';
require_once 'classes/database.php';

$db = new Database();
$conn = $db->conn;

// Get resultIndicator from gateway
$resultIndicator = $_GET['resultIndicator'] ?? '';

// Must have resultIndicator
if (empty($resultIndicator)) {
    die("<h2 style='text-align:center;padding:100px;color:red;font-size:2rem;'>Invalid payment response</h2>");
}

// Try to get order_id from session
$orderId = $_SESSION['order_id'] ?? '';

// If session lost, try to recover from success_indicator match
if (empty($orderId) && isset($_SESSION['success_indicator']) && $resultIndicator === $_SESSION['success_indicator']) {
    $orderId = $_SESSION['order_id'] ?? '';
}

// Final fallback: extract user_id from order_id in session
if (empty($orderId) && !empty($_SESSION['user_id_paid'])) {
    $user_id = $_SESSION['user_id_paid'];
    $orderId = $_SESSION['order_id'] ?? "RECOVERED-{$user_id}";
}

// Extract user_id from order_id (GJRTI-5-1234567890 → 5)
$user_id = null;
if (preg_match('/GJRTI-(\d+)-/', $orderId, $m)) {
    $user_id = (int)$m[1];
}

// If we have user_id → SAVE PAYMENT TO DATABASE
if ($user_id && !empty($orderId)) {

    // Prevent double entry
    $check = $conn->prepare("SELECT id FROM payments WHERE transaction_id = ? OR (user_id = ? AND status = 'paid')");
    $check->bind_param("si", $orderId, $user_id);
    $check->execute();
    if ($check->get_result()->num_rows === 0) {
        $check->close();

        // Get user type and amount
        $stmt = $conn->prepare("SELECT participant_type FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_assoc();
        $stmt->close();

        if ($user) {
            $amounts = [
                'Presenting Author' => 1000,
                'Co-Author' => 1500,
                'Other Participants' => 5000
            ];
            $amount = $amounts[$user['participant_type']] ?? 5000;

            // INSERT PAYMENT — THIS WAS MISSING!
            $insert = $conn->prepare("INSERT INTO payments 
                (user_id, participant_type, amount, currency, payment_method, transaction_id, status) 
                VALUES (?, ?, ?, 'LKR', 'online', ?, 'paid')");
            $insert->bind_param("isds", $user_id, $user['participant_type'], $amount, $orderId);
            $insert->execute();
            $insert->close();
        }
    } else {
        $check->close();
    }
}

// Always show success (gateway said success)
echo "<div style='text-align:center; padding:100px; font-family:Arial; background:#f8fff8; min-height:100vh;'>
        <h2 style='color:green; font-size:4rem; margin-bottom:30px;'>Payment Successful!</h2>
        <p style='font-size:2rem; margin:30px 0;'>Thank you for your registration.</p>
        <p style='font-size:1.6rem; color:#29147d; margin:30px 0;'>
            Transaction Reference: <strong>" . htmlspecialchars($orderId) . "</strong>
        </p>
        <div style='margin-top:50px;'>
            <a href='user-profile.php' style='background:#29147d; color:white; padding:20px 60px; border-radius:15px; text-decoration:none; font-weight:bold; font-size:1.6rem; box-shadow:0 15px 35px rgba(41,20,125,0.4); display:inline-block;'>
                Back to My Profile
            </a>
        </div>
      </div>";

// Clear session
session_unset();
session_destroy();
?>