<?php
session_start();
require_once 'config/config.php';
require_once 'classes/database.php';
require_once 'classes/user.php';
require_once 'classes/auth.php';

$db = new Database();
$userModel = new User($db);
$auth = new Auth();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title'            => trim($_POST['title']),
        'full_name'        => trim($_POST['full_name']),
        'nic_passport'     => trim($_POST['nic_passport']),
        'email'            => trim($_POST['email']),
        'phone'            => trim($_POST['phone']),
        'food_preference'  => $_POST['food_preference'],
        'participant_type' => $_POST['participant_type'],
        'password'         => $_POST['password'],
        'confirm_password' => $_POST['confirm_password']
    ];

    // Validation
    $errors = [];
    if (empty($data['title'])) $errors[] = "Title is required";
    if (empty($data['full_name'])) $errors[] = "Full name is required";
    if (empty($data['nic_passport'])) $errors[] = "NIC/Passport is required";
    if (empty($data['email'])) $errors[] = "Email is required";
    if (empty($data['phone'])) $errors[] = "Phone is required";
    if ($data['password'] !== $data['confirm_password']) $errors[] = "Passwords do not match";
    if (strlen($data['password']) < 6) $errors[] = "Password must be at least 6 characters";
    if ($userModel->emailExists($data['email'])) $errors[] = "Email already registered";

    if (!empty($errors)) {
        $message = implode("<br>", $errors);
    } else {
        unset($data['confirm_password']);

        // Register user first
        if ($userModel->register($data)) {
            // Get the newly created user ID
            $userId = $db->getConnection()->insert_id;

            // Generate reference number
            $year = date('Y');
            $refNumber = "GJRTI_SYMP_{$year}_" . str_pad($userId, 4, '0', STR_PAD_LEFT);
            // Save reference number to database
            $stmt = $db->getConnection()->prepare("UPDATE users SET reference_no = ? WHERE id = ?");
            $stmt->bind_param("si", $refNumber, $userId);
            $stmt->execute();
            $stmt->close();

            // Auto login
            $user = $userModel->login($data['email'], $_POST['password']);
            if ($user) {
                // Add reference_no to session for immediate use
                $_SESSION['user_reference'] = $refNumber;

                $auth->loginParticipant($user);
                header("Location: user-profile.php");
                exit();
            }
        } else {
            $message = "Registration failed. Please try again.";
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<!-- HERO SECTION -->
<section class="relative bg-gradient-to-br from-primary/95 via-purple/90 to-richpurple/95 text-white py-32">
  <div class="absolute inset-0 z-0">
    <img src="./assets/img/breadcrumb.jpeg" alt="" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-black/60"></div>
  </div>
  <div class="relative z-10 text-center max-w-4xl mx-auto px-6">
    <h1 class="text-5xl md:text-7xl font-bold mb-6">Online Registration</h1>
    <p class="text-xl opacity-90">Join the GJRTI 3rd International Research Symposium 2025</p>
  </div>
</section>

<!-- REGISTRATION FORM -->
<section class="py-20 bg-lightbg">
  <div class="max-w-4xl mx-auto px-6">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

      <div class="bg-gradient-to-r from-primary to-richpurple text-white p-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold">Create Your Symposium Account</h2>
        <p class="mt-3 text-lg opacity-90">Secure registration • One-time setup</p>
      </div>

      <div class="p-8 md:p-12">
        <?php if ($message): ?>
          <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-xl mb-8 text-center">
            <?= $message ?>
          </div>
        <?php endif; ?>

        <form method="POST" class="space-y-8">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div>
              <label class="block text-primary font-semibold mb-2">Title <span class="text-red-600">*</span></label>
              <select name="title" required class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-lg">
                <option value="">Select Title</option>
                <option <?= isset($data['title']) && $data['title']=='Prof.' ? 'selected' : '' ?>>Prof.</option>
                <option <?= isset($data['title']) && $data['title']=='Dr.' ? 'selected' : '' ?>>Dr.</option>
                <option <?= isset($data['title']) && $data['title']=='Mr.' ? 'selected' : '' ?>>Mr.</option>
                <option <?= isset($data['title']) && $data['title']=='Ms.' ? 'selected' : '' ?>>Ms.</option>
              </select>
            </div>

            <div>
              <label class="block text-primary font-semibold mb-2">Full Name <span class="text-red-600">*</span></label>
              <input type="text" name="full_name" value="<?= htmlspecialchars($data['full_name'] ?? '') ?>" required placeholder="Enter your full name"
                     class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-lg">
            </div>

            <div>
              <label class="block text-primary font-semibold mb-2">NIC / Passport / DL No. <span class="text-red-600">*</span></label>
              <input type="text" name="nic_passport" value="<?= htmlspecialchars($data['nic_passport'] ?? '') ?>" required placeholder="e.g. 199812345678"
                     class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-lg">
            </div>

            <div>
              <label class="block text-primary font-semibold mb-2">Email Address <span class="text-red-600">*</span></label>
              <input type="email" name="email" value="<?= htmlspecialchars($data['email'] ?? '') ?>" required placeholder="name@example.com"
                     class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-lg">
            </div>

            <div>
              <label class="block text-primary font-semibold mb-2">Contact Number <span class="text-red-600">*</span></label>
              <input type="tel" name="phone" value="<?= htmlspecialchars($data['phone'] ?? '') ?>" required placeholder="+94 77 123 4567"
                     class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-lg">
            </div>

            <div>
              <label class="block text-primary font-semibold mb-2">Food Preference <span class="text-red-600">*</span></label>
              <select name="food_preference" required class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-lg">
                <option value="">Select Preference</option>
                <option <?= ($data['food_preference']??'')=='Vegetarian' ? 'selected' : '' ?>>Vegetarian</option>
                <option <?= ($data['food_preference']??'')=='Non-Vegetarian' ? 'selected' : '' ?>>Non-Vegetarian</option>
                <option <?= ($data['food_preference']??'')=='Vegan' ? 'selected' : '' ?>>Vegan</option>
                <option <?= ($data['food_preference']??'')=='Halal' ? 'selected' : '' ?>>Halal</option>
                <option <?= ($data['food_preference']??'')=='No Preference' ? 'selected' : '' ?>>No Preference</option>
              </select>
            </div>

            <div>
              <label class="block text-primary font-semibold mb-2">Participant Type <span class="text-red-600">*</span></label>
              <select name="participant_type" required class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-lg">
                <option value="">Select Type</option>
                <option <?= ($data['participant_type']??'')=='Presenting Author' ? 'selected' : '' ?>>Presenting Author</option>
                <option <?= ($data['participant_type']??'')=='Co-Author' ? 'selected' : '' ?>>Co-Author</option>
                <option <?= ($data['participant_type']??'')=='Other Participants' ? 'selected' : '' ?>>Other Participants</option>
              </select>
            </div>

            <div>
              <label class="block text-primary font-semibold mb-2">Password <span class="text-red-600">*</span></label>
              <input type="password" name="password" required minlength="6" placeholder="Create password"
                     class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-lg">
            </div>

            <div>
              <label class="block text-primary font-semibold mb-2">Confirm Password <span class="text-red-600">*</span></label>
              <input type="password" name="confirm_password" required minlength="6" placeholder="Confirm password"
                     class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-accent focus:outline-none transition text-lg">
            </div>
          </div>

          <div class="text-center pt-10">
            <button type="submit"
                    class="bg-accent text-primary px-16 py-6 rounded-xl text-2xl font-bold hover:bg-warmgold transition-all shadow-2xl hover:shadow-3xl transform hover:scale-105 inline-flex items-center space-x-4">
              <span>Create Account</span>
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
              </svg>
            </button>
          </div>

          <p class="text-center text-gray-600 mt-8">
            Already have an account? 
            <a href="login.php" class="text-accent font-bold hover:underline">Login here</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>