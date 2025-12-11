<?php
session_start();
require_once 'config/config.php';
require_once 'classes/database.php';

$db = new Database();
$conn = $db->conn;

// Turn on errors temporarily
ini_set('display_errors', 1);
error_reporting(E_ALL);

$resultIndicator = $_GET['resultIndicator'] ?? '';
$orderId = $_GET['orderId'] ?? '';

// If no data at all → invalid
if (empty($resultIndicator) && empty($orderId)) {
    die("<h2 style='text-align:center;padding:100px;color:red;'>Invalid payment response</h2>");
}

// Try to extract user ID from order_id (GJRTI-5-1234567890 → user_id = 5)
$user_id = null;
if (preg_match('/GJRTI-(\d+)-/', $orderId, $m)) {
    $user_id = (int)$m[1];
}

if (!$user_id) {
    die("<h2 style='text-align:center;padding:100px;color:red;'>Invalid order format</h2>");
}

// Check if payment already recorded
$stmt = $conn->prepare("SELECT id FROM payments WHERE transaction_id = ?");
$stmt->bind_param("s", $orderId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Already saved → success
    $already_paid = true;
} else {
    $already_paid = false;

    // Get user details
    $user_stmt = $conn->prepare("SELECT participant_type FROM users WHERE id = ?");
    $user_stmt->bind_param("i", $user_id);
    $user_stmt->execute();
    $ures = $user_stmt->get_result();
    $user = $ures->fetch_assoc();
    $user_stmt->close();

    if (!$user) {
        die("User not found");
    }

    // Calculate amount
    $amounts = [
        'Presenting Author' => 1000,
        'Co-Author' => 1500,
        'Other Participants' => 5000
    ];
    $amount = $amounts[$user['participant_type']] ?? 5000;

    // Save payment
    $insert = $conn->prepare("INSERT INTO payments 
        (user_id, participant_type, amount, currency, payment_method, transaction_id, status) 
        VALUES (?, ?, ?, 'LKR', 'online', ?, 'paid')");
    $insert->bind_param("isds", $user_id, $user['participant_type'], $amount, $orderId);
    $insert->execute();
    $insert->close();
}

echo "<div style='text-align:center; padding:100px; font-family:Arial; background:#f8fff8; min-height:100vh;'>
        <h2 style='color:green; font-size:3rem;'>Payment Successful!</h2>
        <p style='font-size:1.6rem; margin:30px 0;'>Thank you for your registration.</p>
        <p style='font-size:1.2rem; color:#555;'>Transaction Reference: <strong>$orderId</strong></p>
        <a href='user-profile.php' style='background:#29147d; color:white; padding:15px 40px; border-radius:12px; text-decoration:none; font-weight:bold; font-size:1.3rem; display:inline-block; margin-top:20px;'>
            Back to Profile
        </a>
      </div>";
?>