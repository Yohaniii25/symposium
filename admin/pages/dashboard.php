<?php
session_start();
require_once '../../config/config.php';
require_once '../../classes/database.php';
require_once '../../classes/auth.php';

$auth = new Auth();
if (!$auth->isAdmin()) {
    header("Location: ../../login.php");
    exit();
}

$db = new Database();
$conn = $db->conn;

// Fetch all users with payment info
$sql = "
    SELECT 
        u.id,
        u.reference_no,
        u.title,
        u.full_name,
        u.nic_passport,
        u.email,
        u.phone,
        u.food_preference,
        u.participant_type,
        COALESCE(p.status, 'pending') AS payment_status,
        p.slip AS slip_filename,
        CASE 
            WHEN u.participant_type = 'Presenting Author' THEN 1000
            WHEN u.participant_type = 'Co-Author' THEN 1500
            ELSE 5000 
        END AS amount
    FROM users u
    LEFT JOIN payments p ON u.id = p.user_id AND p.status IN ('paid','under_review')
    ORDER BY u.created_at DESC
";

$result = $conn->query($sql);
$participants = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - GJRTI Symposium</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { theme: { extend: { colors: {
      primary: '#29147d', accent: '#c0a35c', richpurple: '#2a1572', warmgold: '#c0a064', lightbg: '#e2f1fa'
    }}}};
  </script>
</head>
<body class="bg-lightbg min-h-screen">

  <!-- Header -->
  <div class="bg-gradient-to-r from-primary to-richpurple text-white py-6 shadow-2xl">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
      <div class="flex items-center space-x-6">
        <img src="../../assets/img/logo.png" alt="GJRTI" class="h-16">
        <div>
          <h1 class="text-3xl font-bold">Admin Dashboard</h1>
          <p class="opacity-90">GJRTI 3rd International Research Symposium 2025</p>
        </div>
      </div>
      <div class="flex items-center gap-6">
        <span class="hidden md:block">Total Users: <strong><?= count($participants) ?></strong></span>
        <a href="../../logout.php" class="bg-red-600 hover:bg-red-700 px-6 py-3 rounded-xl font-bold transition">
          Logout
        </a>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-6 py-10">

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
      <div class="bg-white rounded-2xl p-6 shadow-lg text-center">
        <p class="text-gray-600 text-sm">Total Registered</p>
        <p class="text-4xl font-bold text-primary"><?= count($participants) ?></p>
      </div>
      <div class="bg-white rounded-2xl p-6 shadow-lg text-center">
        <p class="text-gray-600 text-sm">Paid</p>
        <p class="text-4xl font-bold text-green-600">
          <?= count(array_filter($participants, fn($p) => $p['payment_status'] === 'paid')) ?>
        </p>
      </div>
      <div class="bg-white rounded-2xl p-6 shadow-lg text-center">
        <p class="text-gray-600 text-sm">Under Review</p>
        <p class="text-4xl font-bold text-amber-600">
          <?= count(array_filter($participants, fn($p) => $p['payment_status'] === 'under_review')) ?>
        </p>
      </div>
      <div class="bg-white rounded-2xl p-6 shadow-lg text-center">
        <p class="text-gray-600 text-sm">Pending</p>
        <p class="text-4xl font-bold text-red-600">
          <?= count(array_filter($participants, fn($p) => $p['payment_status'] === 'pending')) ?>
        </p>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
      <div class="flex flex-col md:flex-row gap-4 justify-between">
        <input type="text" id="searchInput" placeholder="Search by name, email, reference..." 
               class="px-6 py-3 border border-gray-300 rounded-xl focus:border-primary outline-none w-full md:w-96">
        <select id="typeFilter" class="px-6 py-3 border border-gray-300 rounded-xl focus:border-primary outline-none">
          <option value="all">All Participants</option>
          <option value="Presenting Author">Presenting Author</option>
          <option value="Co-Author">Co-Author</option>
          <option value="Other Participants">Other Participants</option>
        </select>
        <select id="paymentFilter" class="px-6 py-3 border border-gray-300 rounded-xl focus:border-primary outline-none">
          <option value="all">All Payments</option>
          <option value="paid">Paid</option>
          <option value="under_review">Under Review</option>
          <option value="pending">Pending</option>
        </select>
      </div>
    </div>

    <!-- Participants Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
      <div class="bg-gradient-to-r from-primary to-richpurple text-white p-6">
        <h2 class="text-2xl font-bold">Registered Participants</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50 border-b-2 border-gray-200">
            <tr>
              <th class="px-6 py-4 text-left text-sm font-bold text-primary">Ref No</th>
              <th class="px-6 py-4 text-left text-sm font-bold text-primary">Name</th>
              <th class="px-6 py-4 text-left text-sm font-bold text-primary">Email / Phone</th>
              <th class="px-6 py-4 text-left text-sm font-bold text-primary">Type</th>
              <th class="px-6 py-4 text-left text-sm font-bold text-primary">Payment</th>
              <th class="px-6 py-4 text-left text-sm font-bold text-primary">Slip</th>
              <th class="px-6 py-4 text-center text-sm font-bold text-primary">Action</th>
            </tr>
          </thead>
          <tbody id="participantTable" class="divide-y divide-gray-100">
            <?php foreach ($participants as $p): ?>
            <tr class="hover:bg-gray-50 transition participant-row" 
                data-type="<?= $p['participant_type'] ?>" 
                data-payment="<?= $p['payment_status'] ?>"
                data-search="<?= strtolower($p['full_name'] . $p['email'] . $p['reference_no']) ?>">
              
              <td class="px-6 py-4">
                <span class="font-mono text-primary font-bold text-sm">
                  <?= htmlspecialchars($p['reference_no'] ?? '—') ?>
                </span>
              </td>
              
              <td class="px-6 py-4">
                <div class="font-semibold"><?= htmlspecialchars($p['title'] . ' ' . $p['full_name']) ?></div>
                <div class="text-xs text-gray-500"><?= htmlspecialchars($p['nic_passport']) ?></div>
              </td>
              
              <td class="px-6 py-4 text-sm">
                <div><?= htmlspecialchars($p['email']) ?></div>
                <div class="text-gray-500"><?= htmlspecialchars($p['phone']) ?></div>
              </td>
              
              <td class="px-6 py-4">
                <span class="px-3 py-1 rounded-full text-xs font-bold
                  <?= $p['participant_type'] === 'Presenting Author' ? 'bg-blue-100 text-blue-800' :
                      ($p['participant_type'] === 'Co-Author' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800') ?>">
                  <?= $p['participant_type'] ?>
                </span>
              </td>
              
              <td class="px-6 py-4">
                <span class="inline-flex items-center gap-2 font-bold
                  <?= $p['payment_status'] === 'paid' ? 'text-green-600' : 
                      ($p['payment_status'] === 'under_review' ? 'text-amber-600' : 'text-red-600') ?>">
                  <span class="w-2 h-2 rounded-full <?= $p['payment_status'] === 'paid' ? 'bg-green-600' : 
                                                         ($p['payment_status'] === 'under_review' ? 'bg-amber-600' : 'bg-red-600') ?>"></span>
                  <?= ucfirst(str_replace('_', ' ', $p['payment_status'])) ?>
                </span>
                <div class="text-sm text-gray-600">LKR <?= number_format($p['amount']) ?></div>
              </td>
              
              <td class="px-6 py-4 text-center">
                <?php if ($p['slip_filename'] && $p['payment_status'] === 'under_review'): ?>
                  <a href="../../uploads/payment_slips/<?= htmlspecialchars($p['slip_filename']) ?>" 
                     target="_blank" class="text-primary hover:text-accent font-bold text-sm underline">
                    View Slip
                  </a>
                <?php else: ?>
                  <span class="text-gray-400 text-sm">—</span>
                <?php endif; ?>
              </td>
              
              <td class="px-6 py-4 text-center">
                <button onclick="if(confirm('Delete this user?')) window.location='delete-user.php?id=<?= $p['id'] ?>'"
                        class="text-red-600 hover:text-red-800 font-bold text-sm">
                  Delete
                </button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    // Search + Filter
    const searchInput = document.getElementById('searchInput');
    const typeFilter = document.getElementById('typeFilter');
    const paymentFilter = document.getElementById('paymentFilter');
    const rows = document.querySelectorAll('.participant-row');

    function filterTable() {
      const search = searchInput.value.toLowerCase();
      const type = typeFilter.value;
      const payment = paymentFilter.value;

      rows.forEach(row => {
        const text = row.getAttribute('data-search');
        const rowType = row.getAttribute('data-type');
        const rowPayment = row.getAttribute('data-payment');

        const matchesSearch = text.includes(search);
        const matchesType = type === 'all' || rowType === type;
        const matchesPayment = payment === 'all' || rowPayment === payment;

        row.style.display = matchesSearch && matchesType && matchesPayment ? '' : 'none';
      });
    }

    searchInput.addEventListener('input', filterTable);
    typeFilter.addEventListener('change', filterTable);
    paymentFilter.addEventListener('change', filterTable);
  </script>
</body>
</html>