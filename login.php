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
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { theme: { extend: { colors: {
      primary: '#29147d', accent: '#c0a35c', richpurple: '#2a1572', warmgold: '#c0a064', lightbg: '#e2f1fa'
    }}}};
  </script>
</head>
<body class="bg-lightbg min-h-screen flex items-center justify-center px-4">

  <div class="w-full max-w-sm">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

      <div class="bg-gradient-to-r from-primary to-richpurple text-white py-8 text-center">
        <img src="assets/img/logo.png" alt="GJRTI" class="h-16 mx-auto mb-3">
        <h2 class="text-2xl font-bold">Login</h2>
      </div>

      <div class="p-8 space-y-5">

        <?php if ($message): ?>
          <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg text-center text-sm font-medium">
            <?= htmlspecialchars($message) ?>
          </div>
        <?php endif; ?>

        <form method="POST">
          <input type="email" name="email" required placeholder="Email"
                 class="w-full px-5 py-3.5 border border-gray-300 rounded-lg focus:border-accent focus:outline-none text-base">

          <input type="password" name="password" required placeholder="Password"
                 class="w-full px-5 py-3.5 border border-gray-300 rounded-lg focus:border-accent focus:outline-none text-base mt-4">

          <button type="submit"
                  class="w-full bg-accent text-primary py-3.5 rounded-lg font-bold text-lg hover:bg-warmgold transition mt-6">
            Login
          </button>
        </form>

        <div class="text-center text-sm text-gray-600 mt-5">
          <a href="index.php" class="hover:text-primary">← Back to Home</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>