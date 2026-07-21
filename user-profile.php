<?php
require_once 'config/config.php';
require_once 'classes/database.php';
require_once 'classes/user.php';
require_once 'classes/auth.php';

$auth = new Auth();

// Security check
if (!$auth->isLoggedIn()) {
  header("Location: login.php");
  exit();
}

// Get basic logged-in data from session
$sessionUser = $auth->user();

$db = new Database();
$conn = $db->conn;

// FETCH COMPLETE USER DATA FROM DATABASE USING MYSQLI
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $sessionUser['email']);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$stmt->close();

if (!$userData) {
  // Fallback if data somehow goes missing
  die("User profile data could not be found.");
}

// Format Registration Date
$registeredDate = date('d F Y, h:i A', strtotime($userData['created_at']));

// Determine Status Badge Color
$statusBadge = 'badge-status-pending'; // Pending
if ($userData['status'] === 'approved') {
  $statusBadge = 'badge-status-approved';
} elseif ($userData['status'] === 'rejected') {
  $statusBadge = 'badge-status-rejected';
}

?>

<?php include 'includes/header.php'; ?>


<!-- PROFILE SECTION -->
<section class="profile-section-body">
  <div class="profile-container">

    <div class="profile-card">

      <!-- Profile Header -->
      <div class="profile-header">

        <div class="profile-header-left">
          <!-- Avatar -->
          <div class="profile-avatar-circle">
            <svg fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
          </div>

          <!-- Name & Title -->
          <div class="profile-name-section">
            <h2 class="profile-title">
              <?= htmlspecialchars($userData['title'] . ' ' . $userData['full_name']) ?>
            </h2>
            <p class="profile-subtitle">
              <?= htmlspecialchars($userData['participant_type']) ?>
            </p>
          </div>
        </div>

      </div>

      <!-- Profile Details Body -->
      <div class="profile-body">

        <div class="profile-body-header">
          <h3 class="profile-body-title">My Registration Details</h3>
          <p class="profile-body-subtitle">Registered: <?= $registeredDate ?></p>
        </div>

        <!-- Details Grid -->
        <div class="profile-details-grid">

          <!-- Reference Number -->
          <div class="profile-detail-item">
            <div class="profile-detail-icon-wrapper icon-wrapper-blue">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
              </svg>
            </div>
            <div class="profile-detail-content">
              <p class="profile-detail-label">Reference Number</p>
              <p class="profile-detail-value">
                <?= htmlspecialchars($userData['reference_no'] ?? 'Pending Assignment') ?>
              </p>
            </div>
          </div>

          <!-- Email -->
          <div class="profile-detail-item">
            <div class="profile-detail-icon-wrapper icon-wrapper-blue">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
            </div>
            <div class="profile-detail-content">
              <p class="profile-detail-label">Email Address</p>
              <p class="profile-detail-value"><?= htmlspecialchars($userData['email']) ?></p>
            </div>
          </div>

          <!-- Phone Number -->
          <div class="profile-detail-item">
            <div class="profile-detail-icon-wrapper icon-wrapper-green">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
            </div>
            <div class="profile-detail-content">
              <p class="profile-detail-label">Phone Number</p>
              <p class="profile-detail-value"><?= htmlspecialchars($userData['phone']) ?></p>
            </div>
          </div>

          <!-- NIC / Passport -->
          <div class="profile-detail-item">
            <div class="profile-detail-icon-wrapper icon-wrapper-purple">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
              </svg>
            </div>
            <div class="profile-detail-content">
              <p class="profile-detail-label">NIC / Passport No.</p>
              <p class="profile-detail-value">
                <?= !empty($userData['nic_passport']) ? htmlspecialchars($userData['nic_passport']) : 'Not Provided' ?>
              </p>
            </div>
          </div>



          <!-- Abstract Name (Only show if provided) -->
          <?php if (!empty($userData['abstract_name'])): ?>
            <div class="profile-abstract-card">
              <div class="profile-abstract-icon-wrapper">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
              </div>
              <div>
                <p class="profile-abstract-title">Submitted Abstract Name</p>
                <p class="profile-abstract-value"><?= htmlspecialchars($userData['abstract_name']) ?></p>
              </div>
            </div>
          <?php endif; ?>

        </div>


        <!-- Secondary Actions (Logout / Delete) -->
        <div class="profile-actions-secondary">
          <a href="logout.php" class="btn-profile-signout">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Sign Out
          </a>

          <a href="delete-user.php" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.');" class="btn-profile-delete">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Delete Account
          </a>
        </div>

      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>