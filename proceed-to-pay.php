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

// Handle Bank Slip Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_slip'])) {
    $targetDir = "uploads/payment_slips/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $file = $_FILES['slip'];
    $fileName = time() . "_" . $user['id'] . "." . pathinfo($file["name"], PATHINFO_EXTENSION);
    $targetFile = $targetDir . $fileName;

    $allowed = ['jpg','jpeg','png','pdf'];
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if (!in_array($fileType, $allowed)) {
        $message = "Only JPG, PNG, PDF allowed";
    } elseif ($file["size"] > 5000000) {
        $message = "File too large (max 5MB)";
    } else {
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            $stmt = $conn->prepare("INSERT INTO payments 
                (user_id, participant_type, amount, currency, payment_method, slip_filename, status) 
                VALUES (?, ?, ?, 'LKR', 'bank_slip', ?, 'under_review')");
            $stmt->bind_param("isds", $user['id'], $user['type'], $amount, $fileName);
            $stmt->execute();
            $uploadSuccess = true;
        } else {
            $message = "Upload failed";
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

      <div class="p-8">

        <?php if ($uploadSuccess): ?>
          <!-- SUCCESS MESSAGE -->
          <div class="p-20 text-center bg-gradient-to-br from-green-50 to-emerald-50">
            <div class="w-24 h-24 bg-green-500 rounded-full mx-auto mb-8 flex items-center justify-center">
              <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
              </svg>
            </div>
            <h2 class="text-4xl font-bold text-green-700 mb-6">Payment Slip Uploaded!</h2>
            <p class="text-xl text-gray-700 mb-8">Your payment is under review. Confirmation within 24 hours.</p>
            <a href="user-profile.php" class="bg-primary text-white px-10 py-4 rounded-xl font-bold hover:bg-richpurple transition">
              Back to Profile
            </a>
          </div>

        <?php else: ?>

        <form method="POST" action="./pay-online.php" enctype="multipart/form-data" class="max-w-4xl mx-auto">
          
          <!-- Hidden fields for pay-online.php -->
          <input type="hidden" name="reference_no" value="<?php echo htmlspecialchars($user['id']); ?>">
          <input type="hidden" name="payment_option" value="full">

          <div class="grid md:grid-cols-2 gap-8">

            <!-- ONLINE PAYMENT -->
            <div class="group bg-gradient-to-br from-green-50 to-emerald-50 border-4 border-gray-200 hover:border-green-500 rounded-2xl p-10 text-center transition-all hover:shadow-2xl h-full flex flex-col justify-between" onclick="document.querySelector('form').submit();" style="cursor: pointer;">
              <input type="hidden" name="payment_method" value="Online Payment">
              <div>
                <div class="w-20 h-20 bg-green-500 rounded-full mx-auto mb-6 flex items-center justify-center">
                  <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h10m-8 4h6a2 2 0 002-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                  </svg>
                </div>
                <h4 class="text-2xl font-bold mb-4">Pay Online Now</h4>
                <p class="text-gray-600 mb-6">Credit/Debit Card • Instant Confirmation</p>
              </div>
              <div class="bg-green-600 text-white px-10 py-4 rounded-xl font-bold hover:bg-green-700 transition text-lg">
                Pay Now → 
              </div>
            </div>

            <!-- BANK SLIP -->
            <label class="cursor-pointer group">
              <input type="radio" name="payment_method" value="Bank Slip" required class="hidden" 
                     onclick="document.getElementById('uploadSection').classList.remove('hidden')">
              <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-4 border-gray-200 group-hover:border-primary rounded-2xl p-10 text-center transition-all hover:shadow-2xl h-full flex flex-col justify-between">
                <div>
                  <div class="w-20 h-20 bg-primary rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                  </div>
                  <h4 class="text-2xl font-bold mb-4">Bank Transfer</h4>
                  <p class="text-gray-600 mb-6">Upload slip after deposit</p>
                </div>
                <div class="text-center py-4 bg-primary/10 rounded-xl font-bold text-primary">
                  Click to Upload Slip
                </div>
              </div>
            </label>
          </div>

          <!-- UPLOAD SECTION -->
          <div id="uploadSection" class="mt-12 hidden">
            <div class="bg-gradient-to-br from-gray-50 to-white border-4 border-dashed border-primary rounded-2xl p-12 text-center">
              <svg class="w-16 h-16 text-primary mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
              </svg>
              <h4 class="text-2xl font-bold mb-6">Upload Your Bank Deposit Slip</h4>
              <p class="text-gray-600 mb-8">JPG, PNG, PDF • Max 5MB</p>

              <input type="file" name="slip" required accept=".jpg,.jpeg,.png,.pdf"
                     class="block w-full text-lg file:mr-6 file:py-4 file:px-10 file:rounded-xl file:bg-accent file:text-primary file:font-bold hover:file:bg-warmgold">

              <button type="submit" name="upload_slip"
                      class="mt-8 bg-primary text-white px-16 py-5 rounded-xl text-xl font-bold hover:bg-richpurple transition shadow-2xl">
                Submit Payment Slip
              </button>
            </div>
          </div>

          <?php if ($message): ?>
            <div class="mt-10 bg-red-50 border-l-4 border-red-500 text-red-700 p-6 rounded-xl text-center">
              <?= htmlspecialchars($message) ?>
            </div>
          <?php endif; ?>
        </form>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<script>
  // Show upload section only when "Bank Transfer" is clicked
  document.querySelectorAll('input[name="method"]').forEach(radio => {
    radio.addEventListener('change', function() {
      document.getElementById('uploadSection').classList.toggle('hidden', this.value !== 'slip');
    });
  });
</script>

<?php include 'includes/footer.php'; ?>