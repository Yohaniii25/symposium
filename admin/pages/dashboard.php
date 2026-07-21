<?php
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
        p.slip AS slip,
        p.transaction_id AS transaction_id,
        p.payment_method AS payment_method,
        CASE 
            WHEN u.participant_type = 'Presenting Author' THEN 1000
            WHEN u.participant_type = 'Co-Author' THEN 1500
            ELSE 5000 
        END AS amount
    FROM users u
    LEFT JOIN payments p ON u.id = p.user_id 
        AND p.status IN ('paid','under_review')
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
  <link rel="stylesheet" href="../../assets/css/styles.css">
</head>

<body class="admin-dashboard-body">

  <!-- Header -->
  <div class="dashboard-header">
    <div class="dashboard-header-container">
      <div class="dashboard-header-logo-section">
        <img src="../../assets/img/logo.png" alt="GJRTI" class="dashboard-header-logo">
        <div>
          <h1 class="text-3xl font-bold">Admin Dashboard</h1>
          <p class="opacity-90">GJRTI 3rd International Research Symposium 2025</p>
        </div>
      </div>
      <div class="dashboard-header-stats-section">
        <span class="hidden md:block">Total Users: <strong><?= count($participants) ?></strong></span>
        <a href="../../logout.php" class="btn-profile-primary" style="background-color: var(--color-red-600); width: auto; padding: 0.75rem 1.5rem;">
          Logout
        </a>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-6 py-10">

    <!-- Stats Cards -->
    <div class="dashboard-stats-grid">
      <div class="stat-card">
        <p class="stat-card-title">Total Registered</p>
        <p class="stat-card-value text-primary"><?= count($participants) ?></p>
      </div>
      <div class="stat-card">
        <p class="stat-card-title">Paid</p>
        <p class="stat-card-value text-green-600">
          <?= count(array_filter($participants, fn($p) => $p['payment_status'] === 'paid')) ?>
        </p>
      </div>
      <div class="stat-card">
        <p class="stat-card-title">Under Review</p>
        <p class="stat-card-value text-yellow-600">
          <?= count(array_filter($participants, fn($p) => $p['payment_status'] === 'under_review')) ?>
        </p>
      </div>
      <div class="stat-card">
        <p class="stat-card-title">Pending</p>
        <p class="stat-card-value text-red-600">
          <?= count(array_filter($participants, fn($p) => $p['payment_status'] === 'pending')) ?>
        </p>
      </div>
    </div>

    <!-- Filters -->
    <div class="dashboard-filters-card">
      <div class="dashboard-filters-flex">
        <input type="text" id="searchInput" placeholder="Search by name, email, reference..."
          class="filter-input filter-input-search">
        <select id="typeFilter" class="filter-select">
          <option value="all">All Participants</option>
          <option value="Presenting Author">Presenting Author</option>
          <option value="Co-Author">Co-Author</option>
          <option value="Other Participants">Other Participants</option>
        </select>
        <select id="paymentFilter" class="filter-select">
          <option value="all">All Payments</option>
          <option value="paid">Paid</option>
          <option value="under_review">Under Review</option>
          <option value="pending">Pending</option>
        </select>
      </div>
    </div>

    <!-- Participants Table -->
    <div class="profile-card">
      <div class="dashboard-card-header">
        <h2 class="text-2xl font-bold">Registered Participants</h2>
      </div>

      <div class="table-responsive">
        <table class="table-theme">
          <thead class="dashboard-table-thead">
            <tr>
              <th class="px-6 py-4 text-left text-sm font-bold text-primary">Ref No</th>
              <th class="px-6 py-4 text-left text-sm font-bold text-primary">Name</th>
              <th class="px-6 py-4 text-left text-sm font-bold text-primary">Email / Phone</th>
              <th class="px-6 py-4 text-left text-sm font-bold text-primary">Type</th>
              <th class="px-6 py-4 text-left text-sm font-bold text-primary">Payment</th>
              <th class="px-6 py-4 text-left text-sm font-bold text-primary">Proof</th>
            </tr>
          </thead>
          <tbody id="participantTable">
            <?php foreach ($participants as $p): ?>
              <tr class="dashboard-table-row participant-row"
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
                  <span class="badge-type <?= $p['participant_type'] === 'Presenting Author' ? 'badge-type-author-presenting' : ($p['participant_type'] === 'Co-Author' ? 'badge-type-author-co' : 'badge-type-other') ?>">
                    <?= $p['participant_type'] ?>
                  </span>
                </td>

                <td class="px-6 py-4 text-sm">
                  <span class="inline-flex items-center gap-2 font-bold
                  <?= $p['payment_status'] === 'paid' ? 'text-green-600' : ($p['payment_status'] === 'under_review' ? 'text-yellow-600' : 'text-red-600') ?>">
                    <span class="dot-indicator <?= $p['payment_status'] === 'paid' ? 'dot-paid' : ($p['payment_status'] === 'under_review' ? 'dot-review' : 'dot-pending') ?>"></span>
                    <?= ucfirst(str_replace('_', ' ', $p['payment_status'])) ?>
                  </span>
                  <div class="text-xs text-gray-600 mt-1">LKR <?= number_format($p['amount']) ?></div>
                </td>

                <td class="px-6 py-4 text-center">
                  <?php if ($p['payment_method'] === 'online' && $p['transaction_id']): ?>
                    <span class="font-mono text-sm text-primary font-bold">
                      <?= htmlspecialchars($p['transaction_id']) ?>
                    </span>
                  <?php elseif ($p['slip']): ?>
                    <a href="../../uploads/payment_slips/<?= htmlspecialchars($p['slip']) ?>"
                      target="_blank" class="text-primary hover:text-accent font-bold text-sm underline">
                      View Slip
                    </a>
                  <?php else: ?>
                    <span class="text-gray-400 text-sm">—</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
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