<?php
require_once './admin/config/config.php';
require_once './admin/classes/Database.php';

$db = new Database();

// Your admin details
$email = "admin-symposium@gmail.com";
$password = "Y#sBLU3a";  // Strong password
$name = "GJRTI Symposium Admin";

$hashed = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO admins (name, email, password) VALUES (?, ?, ?)";
$stmt = $db->conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $hashed);

if ($stmt->execute()) {
    echo "<div style='font-family: Arial; text-align:center; padding:50px; background:#f0f8ff; color:#1a1a1a;'>
            <h1 style='color:green;'>Admin Created Successfully!</h1>
            <p><strong>Email:</strong> admin-symposium@gmail.com</p>
            <p><strong>Password:</strong> Y#sBLU3a</p>
            <hr>
            <p><a href='login.php' style='color:blue; text-decoration:underline;'>Go to Login</a></p>
            <p style='color:red; margin-top:20px;'><strong>Delete this file (add-admin.php) now!</strong></p>
          </div>";
} else {
    echo "<h2 style='color:red;'>Error: Admin already exists or DB issue.</h2>";
}
?>