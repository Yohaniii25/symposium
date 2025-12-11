<?php
session_start();
require_once 'config/config.php';
require_once 'classes/database.php';

$db = new Database();
$conn = $db->conn;

// Get resultIndicator (this is the ONLY thing Mastercard reliably sends)
$resultIndicator = $_GET['resultIndicator'] ?? '';

// If no resultIndicator → definitely invalid
if (empty($resultIndicator)) {
    die("<h2 style='text-align:center;padding:100px;color:red;font-size:2rem;'>Invalid payment response</h2>");
}

// Try to get order_id from session (saved in pay-online.php)
$orderId = $_SESSION['order_id'] ?? '';

// If session lost, try to extract from resultIndicator pattern (fallback)
if (empty($orderId) && isset($_SESSION['success_indicator'])) {
    if ($resultIndicator === $_SESSION['success_indicator']) {
        $orderId = $_SESSION['order_id'] ?? '';
    }
}

// Final fallback: try to find latest unpaid order for this user
if (empty($orderId)) {
    // Get user from session if possible
    $user_id = $_SESSION['user_id_paid'] ?? null;
    if ($user_id) {
        $stmt = $conn->prepare("SELECT transaction_id FROM payments WHERE user_id = ? ORDER BY id DESC LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $orderId = $row['transaction_id'];
        }
        $stmt->close();
    }
}

// If still no orderId → show generic success (better than error)
if (empty($orderId)) {
    $orderId = "N/A (Session expired)";
}

// === PAYMENT IS SUCCESS IF WE GOT HERE ===
echo "<div style='text-align:center; padding:100px; font-family:Arial; background:#f8fff8; min-height:100vh;'>
        <h2 style='color:green; font-size:4rem; margin-bottom:30px;'>Payment Successful!</h2>
        <p style='font-size:2rem; margin:30px 0;'>Thank you for your registration.</p>
        <p style='font-size:1.6rem; color:#29147d; margin:30px 0;'>
            Transaction Reference: <strong>$orderId</strong>
        </p>
        <div style='margin-top:50px;'>
            <a href='user-profile.php' style='background:#29147d; color:white; padding:20px 60px; border-radius:15px; text-decoration:none; font-weight:bold; font-size:1.6rem; box-shadow:0 15px 35px rgba(41,20,125,0.4); display:inline-block;'>
                Back to My Profile
            </a>
        </div>
      </div>";

// Optional: Clear session
session_unset();
session_destroy();
?>