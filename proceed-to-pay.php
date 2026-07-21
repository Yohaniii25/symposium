<?php

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

// Check if already paid
$stmt = $conn->prepare("SELECT id FROM payments WHERE user_id = ? AND status IN ('paid','under_review')");
$stmt->bind_param("i", $user['id']);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
  header("Location: user-profile.php?msg=already_paid");
  exit();
}

// Set fee
$fees = [
  'Presenting Author' => 1000,
  'Co-Author' => 1500,
  'Other Participants' => 5000
];
$amount = $fees[$user['type']];
?>

<?php include 'includes/header.php'; ?>

<!-- HERO -->
<section class="subpage-hero">
  <div class="subpage-hero-bg">
    <img src="./assets/img/breadcrumb.jpeg" alt="">
    <div class="subpage-hero-overlay"></div>
  </div>
  <div class="subpage-hero-content">
    <h1 class="subpage-hero-title">Complete Your Payment</h1>
    <p class="subpage-hero-subtitle">GJRTI 3rd International Research Symposium 2025</p>
  </div>
</section>

<section class="section-padding-medium">
  <div class="container-max">

    <!-- FEE TABLE -->
    <div class="card-container-medium overflow-hidden mb-12">
      <div class="payment-header">
        <h3 class="text-2xl font-bold">Registration Fees</h3>
        <p class="text-sm opacity-90 mt-2">All fees are non-refundable once processed</p>
      </div>

      <div class="form-card-padding">
        <div class="table-responsive">
          <table class="table-theme bg-white">
            <thead>
              <tr class="table-header-gradient">
                <th class="px-6 py-4 text-left text-sm font-semibold">Participant Type</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">Local Fee</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">International Fee</th>
              </tr>
            </thead>
            <tbody class="divide-y-gray">
              <tr class="row-hover-emerald">
                <td class="px-6 py-5">
                  <div class="flex items-center gap-3">
                    <div class="icon-circle-box bg-emerald-100">
                      <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                      </svg>
                    </div>
                    <div>
                      <h4 class="text-base font-semibold">Presenting Author</h4>
                      <p class="text-xs text-gray-500">Main presenter</p>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-5 text-center text-xl font-bold text-emerald-600">LKR 1,000</td>
                <td class="px-6 py-5 text-center text-xl font-bold text-blue-600">USD 10</td>
              </tr>
              <tr class="row-hover-purple">
                <td class="px-6 py-5">
                  <div class="flex items-center gap-3">
                    <div class="icon-circle-box bg-purple-100">
                      <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21v-1a6 6 0 00-2-4.472" />
                      </svg>
                    </div>
                    <div>
                      <h4 class="text-base font-semibold">Co-Author</h4>
                      <p class="text-xs text-gray-500">Contributing author</p>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-5 text-center text-xl font-bold text-emerald-600">LKR 1,500</td>
                <td class="px-6 py-5 text-center text-xl font-bold text-blue-600">USD 15</td>
              </tr>
              <tr class="row-hover-amber">
                <td class="px-6 py-5">
                  <div class="flex items-center gap-3">
                    <div class="icon-circle-box bg-amber-100">
                      <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                    </div>
                    <div>
                      <h4 class="text-base font-semibold">Other Participants</h4>
                      <p class="text-xs text-gray-500">Attendees & guests</p>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-5 text-center text-xl font-bold text-emerald-600">LKR 5,000</td>
                <td class="px-6 py-5 text-center text-xl font-bold text-blue-600">USD 50</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- PAYMENT OPTIONS -->
    <div class="card-container-medium overflow-hidden">
      <div class="payment-header">
        <h3 class="text-2xl font-bold">Choose Your Payment Method</h3>
        <p class="text-sm opacity-90 mt-2">Secure • Fast • Reliable</p>
      </div>

      <div class="form-card-padding">
        <div class="payment-methods-grid">

          <!-- ONLINE PAYMENT CARD -->
          <a href="pay-online.php" class="block group">
            <div class="method-box-online">
              <div>
                <div class="method-icon-circle-green">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h10m-8 4h6a2 2 0 002-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                </div>
                <h4 class="text-3xl font-bold mb-4">Pay Online Now</h4>
                <p class="text-xl text-gray-600 mb-8">Credit/Debit Card • Instant Confirmation</p>
              </div>
              <div class="btn-pay-now">
                Pay Now
              </div>
            </div>
          </a>

          <!-- BANK SLIP CARD -->
          <form action="upload-slip.php" method="POST" enctype="multipart/form-data" class="block">
            <label class="cursor-pointer group block h-full">
              <div class="method-box-bank">
                <div>
                  <div class="method-icon-circle-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                  </div>
                  <h4 class="text-3xl font-bold mb-4">Bank Transfer</h4>
                  <p class="text-xl text-gray-600 mb-8">Upload slip after deposit</p>
                </div>
                <div class="space-y-4">
                  <input type="file" name="slip" required accept=".jpg,.jpeg,.png,.pdf"
                    class="file-input-theme">
                  <button type="submit"
                    class="btn-upload-slip">
                    Submit Payment Slip
                  </button>
                </div>
              </div>
            </label>
          </form>

        </div>
      </div>
    </div>

  </div>
</section>

<?php include 'includes/footer.php'; ?>