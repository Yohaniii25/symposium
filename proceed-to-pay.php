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
<section class="relative bg-gradient-to-br from-primary/95 via-purple/90 to-richpurple/95 text-white py-20">
  <div class="absolute inset-0 z-0">
    <img src="./assets/img/breadcrumb.jpeg" alt="" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-black/60"></div>
  </div>
  <div class="relative z-10 text-center max-w-4xl mx-auto px-6">
    <h1 class="text-3xl md:text-4xl font-semibold mb-4">Complete Your Payment</h1>
    <p class="text-base md:text-lg opacity-90">GJRTI 3rd International Research Symposium 2025</p>
  </div>
</section>

<section class="py-16">
  <div class="max-w-6xl mx-auto px-6">

    <!-- FEE TABLE -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-12">
      <div class="bg-richpurple text-white px-8 py-8 text-center">
        <h3 class="text-2xl font-bold">Registration Fees</h3>
        <p class="text-sm opacity-90 mt-2">All fees are non-refundable once processed</p>
      </div>

      <div class="p-8">
        <div class="overflow-x-auto rounded-xl shadow-md border border-gray-200">
          <table class="w-full bg-white">
            <thead>
              <tr class="bg-gradient-to-r from-primary to-richpurple text-white">
                <th class="px-6 py-4 text-left text-sm font-semibold">Participant Type</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">Local Fee</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">International Fee</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr class="hover:bg-emerald-50 transition">
                <td class="px-6 py-5">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                      <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
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
              <tr class="hover:bg-purple-50 transition">
                <td class="px-6 py-5">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                      <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21v-1a6 6 0 00-2-4.472"/>
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
              <tr class="hover:bg-amber-50 transition">
                <td class="px-6 py-5">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                      <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
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
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
      <div class="bg-richpurple text-white px-8 py-6 text-center">
        <h3 class="text-2xl font-bold">Choose Your Payment Method</h3>
        <p class="text-sm opacity-90 mt-2">Secure • Fast • Reliable</p>
      </div>

      <div class="p-12">
        <div class="grid md:grid-cols-2 gap-12 max-w-5xl mx-auto">

          <!-- ONLINE PAYMENT CARD -->
          <a href="pay-online.php" class="block group">
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-4 border-gray-200 group-hover:border-green-500 rounded-2xl p-12 text-center transition-all hover:shadow-2xl h-full flex flex-col justify-between">
              <div>
                <div class="w-20 h-20 bg-green-500 rounded-full mx-auto mb-8 flex items-center justify-center">
                  <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h10m-8 4h6a2 2 0 002-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                  </svg>
                </div>
                <h4 class="text-3xl font-bold mb-4">Pay Online Now</h4>
                <p class="text-xl text-gray-600 mb-8">Credit/Debit Card • Instant Confirmation</p>
              </div>
              <div class="bg-green-600 text-white px-12 py-6 rounded-xl text-2xl font-bold hover:bg-green-700 transition shadow-xl">
                Pay Now
              </div>
            </div>
          </a>

          <!-- BANK SLIP CARD -->
          <form action="upload-slip.php" method="POST" enctype="multipart/form-data" class="block">
            <label class="cursor-pointer group block h-full">
              <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-4 border-gray-200 group-hover:border-primary rounded-2xl p-12 text-center transition-all hover:shadow-2xl h-full flex flex-col justify-between">
                <div>
                  <div class="w-20 h-20 bg-primary rounded-full mx-auto mb-8 flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                  </div>
                  <h4 class="text-3xl font-bold mb-4">Bank Transfer</h4>
                  <p class="text-xl text-gray-600 mb-8">Upload slip after deposit</p>
                </div>
                <div class="space-y-4">
                  <input type="file" name="slip" required accept=".jpg,.jpeg,.png,.pdf"
                         class="block w-full text-lg file:mr-6 file:py-4 file:px-10 file:rounded-xl file:bg-accent file:text-primary file:font-bold hover:file:bg-warmgold">
                  <button type="submit"
                          class="w-full bg-primary text-white py-5 rounded-xl text-xl font-bold hover:bg-richpurple transition shadow-xl">
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