<?php
session_start();
require_once 'config/config.php';
require_once 'classes/database.php';
require_once 'classes/auth.php';

$auth = new Auth();
if (!$auth->isParticipant()) {
    header("Location: login.php");
    exit();
}

$user = $auth->user();
$db = new Database();
$conn = $db->conn;

// Prevent double upload
$stmt = $conn->prepare("SELECT id FROM payments WHERE user_id = ? AND status IN ('paid','under_review')");
$stmt->bind_param("i", $user['id']);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    header("Location: user-profile.php?msg=already_paid");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['slip'])) {
    header("Location: proceed-to-pay.php");
    exit();
}

$targetDir = "uploads/payment_slips/";
if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

$file = $_FILES['slip'];
$ext = pathinfo($file["name"], PATHINFO_EXTENSION);
$fileName = time() . "_" . $user['id'] . "." . strtolower($ext);
$targetFile = $targetDir . $fileName;

$allowed = ['jpg','jpeg','png','pdf'];
if (!in_array(strtolower($ext), $allowed)) {
    die("Only JPG, PNG, PDF allowed");
}
if ($file["size"] > 5000000) {
    die("File too large");
}

if (move_uploaded_file($file["tmp_name"], $targetFile)) {
    $amount = ['Presenting Author' => 1000, 'Co-Author' => 1500, 'Other Participants' => 5000][$user['type']];

    $stmt = $conn->prepare("INSERT INTO payments 
        (user_id, participant_type, amount, currency, payment_method, slip, status) 
        VALUES (?, ?, ?, 'LKR', 'bank_slip', ?, 'under_review')");
    $stmt->bind_param("isds", $user['id'], $user['type'], $amount, $fileName);
    $stmt->execute();
    $stmt->close();

    header("Location: payment-success.php?method=slip");
    exit();
} else {
    die("Upload failed");
}
?>