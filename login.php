<?php

require_once 'config/config.php';
require_once 'classes/database.php';
require_once 'classes/user.php';
require_once 'classes/admin.php';
require_once 'classes/auth.php';

$db = new Database();
$userModel = new User($db);
$adminModel = new Admin($db);
$auth = new Auth();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  if (empty($email) || empty($password)) {
    $message = "Please fill both fields";
  } else {
    // Try Admin First
    $admin = $adminModel->login($email, $password);
    if ($admin) {
      $auth->loginAdmin($admin);
      header("Location: admin/pages/dashboard.php");
      exit();
    }

    // Then Try Participant
    $user = $userModel->login($email, $password);
    if ($user) {
      $auth->loginParticipant($user);
      header("Location: user-profile.php");
      exit();
    }

    $message = "Invalid email or password";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - GJRTI Symposium</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="login-page-body">

  <div class="auth-wrapper">
    <div class="auth-card">

      <div class="card-header-gradient">
        <img src="assets/img/logo.png" alt="GJRTI" class="auth-logo">
        <h2 class="text-2xl font-bold">Login</h2>
      </div>

      <div class="auth-card-body">

        <?php if ($message): ?>
          <div class="alert-box-simple">
            <?= htmlspecialchars($message) ?>
          </div>
        <?php endif; ?>

        <form method="POST">
          <input type="email" name="email" required placeholder="Email"
            class="auth-input">

          <input type="password" name="password" required placeholder="Password"
            class="auth-input">

          <button type="submit"
            class="btn-auth-submit">
            Login
          </button>
        </form>

        <div class="text-center text-sm text-gray-600 mt-5">
          <a href="index.php" class="hover:text-primary">← Back to Home</a>
        </div>

        <!-- if not logged-in create account link -->
        <div class="text-center text-sm text-gray-600 mt-3">
          <span>Don't have an account? </span>
          <a href="signup.php" class="text-primary font-medium hover-underline">Create one</a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>