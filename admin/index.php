<?php

require_once 'config/config.php';
require_once 'classes/database.php';
require_once 'classes/user.php';
require_once 'classes/admin.php';
require_once 'classes/auth.php';

// Create instances
$db = new Database();
$userModel = new User($db);
$adminModel = new Admin($db);
$auth = new Auth();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $message = "Please fill email and password";
    } else {
        // First try Admin login
        $admin = $adminModel->login($email, $password);
        if ($admin) { 
            $auth->loginAdmin($admin);
            header("Location: admin/pages/dashboard.php");
            exit();
        }

        // Then try Participant login
        $user = $userModel->login($email, $password);
        if ($user) {
            $auth->loginParticipant($user);
            header("Location: dashboard.php");
            exit();
        }

        $message = "Invalid email or password";
    }
}
?>



<!-- LOGIN FORM -->
<section class="py-20 bg-lightbg">
  <div class="max-w-md mx-auto px-6">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

      <div class="bg-gradient-to-r from-primary to-richpurple text-white py-10 text-center">
        <img src="assets/img/logo.png" alt="GJRTI" class="h-20 mx-auto mb-4">
        <h2 class="text-3xl font-bold">Symposium Login</h2>
      </div>

      <div class="p-10">
        <?php if ($message): ?>
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-center">
            <?= htmlspecialchars($message) ?>
          </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
          <div>
            <input type="email" name="email" required placeholder="Email Address"
                   class="w-full px-6 py-4 border-2 border-gray-300 rounded-xl focus:border-accent outline-none text-lg">
          </div>

          <div>
            <input type="password" name="password" required placeholder="Password"
                   class="w-full px-6 py-4 border-2 border-gray-300 rounded-xl focus:border-accent outline-none text-lg">
          </div>

          <button type="submit"
                  class="w-full bg-accent text-primary py-5 rounded-xl text-xl font-bold hover:bg-warmgold transition shadow-xl">
            Login to Account
          </button>
        </form>

      </div>
    </div>
  </div>
</section>
