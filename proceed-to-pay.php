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

$message = "";
$uploadSuccess = false;

// Check if already paid
$stmt = $conn->prepare("SELECT status FROM payments WHERE user_id = ? AND status IN ('paid','under_review')");
$stmt->bind_param("i", $user['id']);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
  header("Location: user-profile.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['upload_slip'])) {
    $targetDir = "uploads/payment_slips/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $file = $_FILES['slip'];
    $fileName = time() . "_" . $user['id'] . "." . pathinfo($file["name"], PATHINFO_EXTENSION);
    $targetFile = $targetDir . $fileName;

    $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if (!in_array($fileType, $allowed)) {
      $message = "Only JPG, PNG, PDF allowed";
    } elseif ($file["size"] > 5000000) {
      $message = "File too large (max 5MB)";
    } else {
      if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        // Save to payments table
        $stmt = $conn->prepare("INSERT INTO payments (user_id, participant_type, amount, currency, payment_method, slip_filename, status) VALUES (?, ?, ?, 'LKR', 'bank_slip', ?, 'under_review')");
        $amount = ($user['type'] === 'Presenting Author') ? 1000 : (($user['type'] === 'Co-Author') ? 1500 : 5000);
        $stmt->bind_param("isds", $user['id'], $user['type'], $amount, $fileName);
        $stmt->execute();
        $uploadSuccess = true;
      } else {
        $message = "Upload failed";
      }
    }
  }
}
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

    <!-- FEE TABLE CARD -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-12">
      <div class="bg-purple text-white px-8 py-8 text-center">
        <h3 class="text-2xl font-bold">Registration Fees</h3>
        <p class="text-sm opacity-90 mt-2">All fees are non-refundable once processed</p>
      </div>

      <!-- FEE TABLE - PROFESSIONAL TABLE VIEW -->
      <div class="p-8">
        <div class="overflow-x-auto rounded-xl shadow-md border border-gray-200">
          <table class="w-full bg-white">
            <thead>
              <tr class="bg-gradient-to-r from-blue-600 to-purple-700 text-white">
                <th class="px-6 py-4 text-left text-sm font-semibold">Participant Type</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">Local Fee</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">International Fee</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">

              <!-- Presenting Author -->
              <tr class="hover:bg-emerald-50 transition-colors duration-200">
                <td class="px-6 py-5">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                      <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                      </svg>
                    </div>
                    <div>
                      <h4 class="text-base font-semibold text-gray-800">Presenting Author</h4>
                      <p class="text-xs text-gray-500 mt-0.5">Main presenter of research paper</p>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-5 text-center">
                  <div class="text-xl font-bold text-emerald-600">LKR 1,000</div>
                </td>
                <td class="px-6 py-5 text-center">
                  <div class="text-xl font-bold text-blue-600">USD 10</div>
                </td>
              </tr>

              <!-- Co-Author -->
              <tr class="hover:bg-purple-50 transition-colors duration-200">
                <td class="px-6 py-5">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                      <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21v-1a6 6 0 00-2-4.472" />
                      </svg>
                    </div>
                    <div>
                      <h4 class="text-base font-semibold text-gray-800">Co-Author</h4>
                      <p class="text-xs text-gray-500 mt-0.5">Contributing author of research paper</p>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-5 text-center">
                  <div class="text-xl font-bold text-emerald-600">LKR 1,500</div>
                </td>
                <td class="px-6 py-5 text-center">
                  <div class="text-xl font-bold text-blue-600">USD 15</div>
                </td>
              </tr>

              <!-- Other Participants -->
              <tr class="hover:bg-amber-50 transition-colors duration-200">
                <td class="px-6 py-5">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                      <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                    </div>
                    <div>
                      <h4 class="text-base font-semibold text-gray-800">Other Participants</h4>
                      <p class="text-xs text-gray-500 mt-0.5">Attendees, observers & guests</p>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-5 text-center">
                  <div class="text-xl font-bold text-emerald-600">LKR 5,000</div>
                </td>
                <td class="px-6 py-5 text-center">
                  <div class="text-xl font-bold text-blue-600">USD 50</div>
                </td>
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

      <div class="p-8">
        <form method="POST" enctype="multipart/form-data" class="max-w-4xl mx-auto">

          <div class="grid md:grid-cols-2 gap-6 mb-8">

            <!-- ONLINE PAYMENT -->
            <label class="cursor-pointer group">
              <input type="radio" name="method" value="online" required class="hidden peer"
                onclick="document.getElementById('uploadSection').classList.add('hidden')">
              <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-gray-200 peer-checked:border-green-500 peer-checked:shadow-lg rounded-xl p-6 transition-all hover:shadow-md h-full flex flex-col">
                <div class="flex-grow">
                  <div class="w-12 h-12 bg-green-500 rounded-lg mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h10m-8 4h6a2 2 0 002-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                  </div>
                  <h4 class="text-lg font-bold text-gray-800 mb-2 text-center">Pay Online Now</h4>
                  <p class="text-sm text-gray-600 mb-4 text-center">Instant confirmation via Credit/Debit Card</p>

                </div>
                <a href="./pay-online.php" target="_blank"
                  class="bg-green-600 text-white px-6 py-3 rounded-lg text-sm font-semibold hover:bg-green-700 transition-colors text-center block">
                  Pay Now with PayHere
                </a>
              </div>
            </label>

            <!-- BANK SLIP -->
            <label class="cursor-pointer group">
              <input type="radio" name="method" value="slip" required class="hidden peer"
                onclick="document.getElementById('uploadSection').classList.remove('hidden')">
              <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-gray-200 peer-checked:border-blue-600 peer-checked:shadow-lg rounded-xl p-6 transition-all hover:shadow-md h-full flex flex-col">
                <div class="flex-grow">
                  <div class="w-12 h-12 bg-accent rounded-lg mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                  </div>
                  <h4 class="text-lg font-bold text-gray-800 mb-2 text-center">Bank Transfer</h4>
                  <p class="text-sm text-gray-600 mb-4 text-center">Upload slip after bank deposit</p>

                </div>
                <div class="text-center py-3 bg-accent rounded-lg font-semibold text-white text-sm">
                  Click to Upload Slip
                </div>
              </div>
            </label>
          </div>

          <!-- UPLOAD SECTION -->
          <div id="uploadSection" class="mt-8 hidden">
            <div class="bg-gradient-to-br from-gray-50 to-white border-2 border-dashed border-blue-300 rounded-xl p-8 text-center">
              <svg class="w-12 h-12 text-blue-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
              </svg>
              <h4 class="text-lg font-bold text-gray-800 mb-2">Upload Your Bank Deposit Slip</h4>
              <p class="text-sm text-gray-600 mb-6">Supported formats: JPG, PNG, PDF • Max 5MB</p>

              <input type="file" name="slip" required accept=".jpg,.jpeg,.png,.pdf"
                class="block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-semibold hover:file:bg-blue-100 cursor-pointer mb-6">

              <button type="submit" name="upload_slip"
                class="bg-blue-600 text-white px-8 py-3 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg">
                Submit Payment Slip
              </button>
            </div>
          </div>

        </form>
      </div>
    </div>

  </div>
</section>

<?php include 'includes/footer.php'; ?>