<?php
session_start();
require_once 'config/config.php';
require_once 'classes/database.php';

if (!isset($_SESSION['success_indicator']) || !isset($_GET['resultIndicator'])) {
    header("Location: proceed-to-pay.php");
    exit();
}

if ($_GET['resultIndicator'] === $_SESSION['success_indicator']) {
    $db = new Database();
    $conn = $db->conn;

    $stmt = $conn->prepare("INSERT INTO payments (user_id, participant_type, amount, currency, payment_method, transaction_id, status) 
                            VALUES (?, ?, ?, 'LKR', 'online', ?, 'paid')");
    $stmt->bind_param("isds", $_SESSION['user_id_paid'], $_SESSION['participant_type'], $_SESSION['amount_paid'], $_SESSION['order_id']);
    $stmt->execute();

    // Clear session
    unset($_SESSION['session_id'], $_SESSION['success_indicator'], $_SESSION['order_id'], $_SESSION['amount_paid'], $_SESSION['user_id_paid']);
    
    echo "<h2 style='text-align:center; padding:100px; color:green;'>Payment Successful! Thank you.</h2>";
} else {
    echo "<h2 style='text-align:center; padding:100px; color:red;'>Payment Failed or Cancelled.</h2>";
}
?>