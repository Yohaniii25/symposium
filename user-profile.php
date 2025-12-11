<?php 

require_once 'config/config.php';
require_once 'classes/database.php';
require_once 'classes/user.php';
require_once 'classes/auth.php';

$auth = new Auth();

// security check
if (!$auth->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// gets real logged-in data
$user = $auth->user();

// Optional: Get more details from DB if needed (like status, abstract)
$db = new Database();
$conn = $db->conn;
$stmt = $conn->prepare("SELECT status, participant_type FROM users WHERE id = ?");
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

?>

<!-- profile.php -->
<?php include 'includes/header.php'; ?>

<!-- PROFILE SECTION -->
<section class="py-20 bg-lightbg min-h-screen">
  <div class="max-w-4xl mx-auto px-6">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

      <!-- Header -->
      <div class="bg-gradient-to-r from-primary to-richpurple text-white py-12 text-center">
        <div class="w-32 h-32 bg-white/20 rounded-full mx-auto mb-6 flex items-center justify-center">
          <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
          </svg>
        </div>
        <h2 class="text-4xl font-bold"><?= htmlspecialchars($user['name']) ?></h2>
        <p class="text-xl opacity-90 mt-2"><?= htmlspecialchars($user['type']) ?></p>
      </div>

      <!-- Profile Details -->
      <div class="p-10 md:p-12">
        <h3 class="text-2xl font-bold text-primary mb-8 text-center">My Registration Details</h3>

        <div class="grid md:grid-cols-2 gap-10 text-lg">

          <div class="space-y-5">
            <div>
              <strong class="text-gray-600">Full Name:</strong>
              <p class="text-gray-900 font-medium mt-1"><?= htmlspecialchars($user['name']) ?></p>
            </div>
            <!-- reference number -->
            <div>
              <strong class="text-gray-600">Reference Number:</strong>
              <p class="text-gray-900 font-medium mt-1"><?= htmlspecialchars($_SESSION['user_reference'] ?? 'N/A') ?></p>
            <div>
              <strong class="text-gray-600">Email:</strong>
              <p class="text-gray-900 font-medium mt-1"><?= htmlspecialchars($user['email']) ?></p>
            </div>
            <div>
              <strong class="text-gray-600">Participant Type:</strong>
              <p class="text-gray-900 font-medium mt-1"><?= htmlspecialchars($user['type']) ?></p>
            </div>
          </div>

          <div class="space-y-5">
            <div>
              <strong class="text-gray-600">Registration Status:</strong>
              <p class="mt-1">
                <span class="px-4 py-2 rounded-full text-sm font-bold
                  <?= $userData['status'] === 'approved' ? 'bg-green-100 text-green-800' : 
                     ($userData['status'] === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') ?>">
                  <?= ucfirst($userData['status'] ?? 'Pending') ?>
                </span>
              </p>
            </div>

            <div>
              <strong class="text-gray-600">Payment Status:</strong>
              <p class="text-red-600 font-bold mt-1">Not Paid</p>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-12 grid md:grid-cols-2 gap-6">
          <a href="submit-abstract.php" 
             class="block text-center bg-primary text-white py-4 rounded-xl font-bold hover:bg-richpurple transition shadow-lg">
            Submit Abstract
          </a>
          <a href="proceed-to-pay.php" 
             class="block text-center bg-accent text-primary py-4 rounded-xl font-bold hover:bg-warmgold transition shadow-lg">
            Proceed to Payment
          </a>
        </div>

        <div class="text-center mt-8">
          <a href="logout.php" class="text-red-600 hover:text-red-800 font-medium">
            Logout
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>