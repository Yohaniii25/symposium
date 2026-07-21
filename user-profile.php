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

$db = new Database();
$conn = $db->conn;

// Get user with payment status
$userClass = new User($db);
$userWithPayment = $userClass->getUserWithPaymentStatus($user['id']);
$userPayments = $userClass->getUserPayments($user['id']);

// Fallback to basic user data if needed
$userData = [
  'participant_type' => $userWithPayment['participant_type'] ?? '',
  'reference_no' => $userWithPayment['reference_no'] ?? '',
  'payment_status' => $userWithPayment['payment_status'] ?? 'Not Paid',
  'payment_method' => $userWithPayment['payment_method'] ?? 'N/A'
];

?>

<!-- profile.php -->
<?php include 'includes/header.php'; ?>

<!-- PROFILE SECTION -->
<section class="profile-section-body">
  <div class="container-max-medium">
    <div class="profile-card">

      <!-- Header -->
      <div class="profile-header-gradient">
        <div class="profile-avatar-wrapper">
          <svg fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
          </svg>
        </div>
        <h2 class="text-4xl font-bold"><?= htmlspecialchars($user['name']) ?></h2>
        <p class="text-xl opacity-90 mt-2"><?= htmlspecialchars($user['type']) ?></p>
      </div>

      <!-- Profile Details -->
      <div class="form-card-padding">
        <h3 class="profile-section-title">My Registration Details</h3>

        <div class="profile-grid">

          <div class="space-y-5">
            <div>
              <strong class="text-gray-600">Full Name:</strong>
              <p class="text-gray-900 font-medium mt-1"><?= htmlspecialchars($user['name']) ?></p>
            </div>

            <?php if (!empty($userWithPayment['abstract_name'])): ?>
              <div>
                <strong class="text-gray-600">Abstract Name/Number:</strong>
                <p class="text-gray-900 font-medium mt-1"><?= htmlspecialchars($userWithPayment['abstract_name']) ?></p>
              </div>
            <?php endif; ?>

            <!-- reference number -->
            <div>
              <strong class="text-gray-600">Reference Number:</strong>
              <p class="text-gray-900 font-medium mt-1"><?= htmlspecialchars($userData['reference_no'] ?? 'N/A') ?></p>
            </div>
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
              <strong class="text-gray-600">Payment Status:</strong>
              <p class="font-bold mt-1 <?= ($userData['payment_status'] === 'paid') ? 'text-green-600' : (($userData['payment_status'] === 'under_review') ? 'text-yellow-600' : 'text-red-600') ?>">
                <?= htmlspecialchars(ucfirst($userData['payment_status'])) ?>
              </p>
            </div>
            <div>
              <strong class="text-gray-600">Payment Method:</strong>
              <p class="text-gray-900 font-medium mt-1"><?= htmlspecialchars($userData['payment_method']) ?></p>
            </div>
            <?php if ($userWithPayment['transaction_id']): ?>
              <div>
                <strong class="text-gray-600">Transaction ID:</strong>
                <p class="text-gray-900 font-medium mt-1 text-sm"><?= htmlspecialchars($userWithPayment['transaction_id']) ?></p>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-12 profile-actions-grid">
          <a href="submit-abstract.php"
            class="btn-profile-primary">
            Submit Abstract
          </a>
          <a href="proceed-to-pay.php"
            class="btn-profile-accent">
            Proceed to Payment
          </a>
        </div>

        <div class="text-center mt-8 space-y-3">
          <div>
            <a href="logout.php" class="text-red-600 hover-underline font-medium">
              Logout
            </a>
          </div>
          <div>
            <a href="delete-user.php" class="text-gray-600 hover:text-red-700 hover-underline font-medium text-sm">
              Delete Account
            </a>
          </div>
        </div>

        <!-- Payment History Section -->
        <?php if (!empty($userPayments)): ?>
          <div class="mt-12 border-t pt-12">
            <h3 class="profile-section-title">Payment History</h3>
            <div class="table-responsive">
              <table class="table-theme">
                <thead>
                  <tr class="table-thead-light">
                    <th class="px-6 py-3 text-left font-bold text-gray-700">Date</th>
                    <th class="px-6 py-3 text-left font-bold text-gray-700">Amount</th>
                    <th class="px-6 py-3 text-left font-bold text-gray-700">Method</th>
                    <th class="px-6 py-3 text-left font-bold text-gray-700">Status</th>
                    <th class="px-6 py-3 text-left font-bold text-gray-700">Transaction ID</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($userPayments as $payment): ?>
                    <tr class="table-row-hover-light-bg">
                      <td class="px-6 py-4"><?= date('M d, Y', strtotime($payment['created_at'])) ?></td>
                      <td class="px-6 py-4 font-medium"><?= number_format($payment['amount'], 2) ?> <?= htmlspecialchars($payment['currency']) ?></td>
                      <td class="px-6 py-4"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $payment['payment_method']))) ?></td>
                      <td class="px-6 py-4">
                        <span class="badge-status <?=
                                                  ($payment['status'] === 'paid') ? 'badge-status-paid' : (($payment['status'] === 'under_review') ? 'badge-status-review' : (($payment['status'] === 'pending') ? 'badge-status-pending' : 'badge-status-failed'))
                                                  ?>">
                          <?= htmlspecialchars(ucfirst($payment['status'])) ?>
                        </span>
                      </td>
                      <td class="px-6 py-4 text-sm"><?= htmlspecialchars($payment['transaction_id'] ?? ($payment['slip'] ?? 'N/A')) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>