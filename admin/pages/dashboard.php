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

// Fetch all users
$sql = "
    SELECT 
        id,
        reference_no,
        title,
        full_name,
        nic_passport,
        email,
        phone,
        food_preference,
        participant_type,
        abstract_name,
        created_at
    FROM users
    ORDER BY created_at DESC
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body class="admin-dashboard-body">

  <!-- Header -->
  <div class="dashboard-header">
    <div class="dashboard-header-container">
      <div class="dashboard-header-logo-section">
        <img src="../../assets/img/logo.jpg" alt="GJRTI" class="dashboard-header-logo">
        <div>
          <h1 class="text-3xl font-bold">Admin Dashboard</h1>
          <p class="opacity-90">Gem and Jewellery Research Symposium of Sri Lanka 2026</p>
        </div>
      </div>
      <div class="dashboard-header-stats-section">
        <span class="hidden md:block">Total Users: <strong><?= count($participants) ?></strong></span>
        <a href="../../logout.php" class="btn-profile-primary" style="background-color: var(--color-red-600); width: auto; padding: 0.75rem 1.5rem;">
          Logout
        </a>
        <!-- back to symposium button -->
        <a href="../../index.php" class="btn-profile-primary" style="background-color: var(--color-blue-600); width: auto; padding: 0.75rem 1.5rem;">
          Back to Symposium
        </a>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-6 py-10" style="width: 100%;">

    <!-- Stats Cards -->
    <div class="dashboard-stats-grid dashboard-stats-grid-3">
      <div class="stat-card">
        <p class="stat-card-title">Total Registered</p>
        <p class="stat-card-value text-val-primary"><?= count($participants) ?></p>
      </div>
      <div class="stat-card">
        <p class="stat-card-title">Presenting Authors</p>
        <p class="stat-card-value text-val-green">
          <?= count(array_filter($participants, fn($p) => $p['participant_type'] === 'Presenting Author')) ?>
        </p>
      </div>
      <div class="stat-card">
        <p class="stat-card-title">Other Participants</p>
        <p class="stat-card-value text-val-amber">
          <?= count(array_filter($participants, fn($p) => $p['participant_type'] !== 'Presenting Author')) ?>
        </p>
      </div>
    </div>

    <!-- Filters -->
    <div class="dashboard-filters-card">
      <div class="dashboard-filters-flex">
        <input type="text" id="searchInput" placeholder="Search by name, email, credentials, abstract..."
          class="filter-input filter-input-search">
        <select id="typeFilter" class="filter-select">
          <option value="all">All Categories</option>
          <option value="Presenting Author">Presenting Author</option>
          <option value="Other Participants">Other Participants</option>
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
              <th class="px-6 py-4 text-left text-sm font-bold text-primary">NIC / Passport</th>
              <th class="px-6 py-4 text-left text-sm font-bold text-primary">Email / Phone</th>
              <th class="px-6 py-4 text-left text-sm font-bold text-primary">Category / Type</th>
              <th class="px-6 py-4 text-left text-sm font-bold text-primary">Abstract Name / Number</th>

              <th class="px-6 py-4 text-left text-sm font-bold text-primary">Action</th>
            </tr>
          </thead>
          <tbody id="participantTable" class="divide-y-gray">
            <?php foreach ($participants as $p): ?>
              <tr class="dashboard-table-row participant-row"
                data-type="<?= $p['participant_type'] ?>"
                data-search="<?= strtolower($p['full_name'] . $p['email'] . $p['nic_passport'] . ($p['abstract_name'] ?? '') . $p['reference_no']) ?>">

                <td class="px-6 py-4">
                  <span class="font-mono-bold">
                    <?= htmlspecialchars($p['reference_no'] ?? '—') ?>
                  </span>
                </td>

                <td class="px-6 py-4">
                  <div class="font-semibold"><?= htmlspecialchars($p['title'] . ' ' . $p['full_name']) ?></div>
                </td>

                <td class="px-6 py-4 text-sm font-mono-bold">
                  <?= htmlspecialchars($p['nic_passport'] ?: '—') ?>
                </td>

                <td class="px-6 py-4 text-sm">
                  <div><?= htmlspecialchars($p['email']) ?></div>
                  <div class="text-gray-500"><?= htmlspecialchars($p['phone']) ?></div>
                </td>

                <td class="px-6 py-4">
                  <span class="badge-type <?= $p['participant_type'] === 'Presenting Author' ? 'badge-type-author-presenting' : (($p['participant_type'] === 'Co-Author' || $p['participant_type'] === 'Co-authors') ? 'badge-type-author-co' : 'badge-type-other') ?>">
                    <?= $p['participant_type'] ?>
                  </span>
                </td>

                <td class="px-6 py-4 text-sm">
                  <?= htmlspecialchars($p['abstract_name'] ?: '—') ?>
                </td>
                <!-- action with view, check or pending with bi bi icons-->
                <!-- action with view, check, or delete with bi bi icons -->
                <td class="px-6 py-4">
                  <div class="flex items-center gap-4">

                    <!-- View Icon -->
                    <a href="view_user.php?id=<?= $p['id'] ?>"
                      class="text-blue-600 hover:text-blue-800 transition-colors duration-200"
                      title="View Details">
                      <i class="bi bi-eye-fill text-xl"></i>
                    </a>

                    <!-- Check/Approve Icon -->
                    <!-- <a href="check_user.php?id=<?= $p['id'] ?>"
                      class="text-green-600 hover:text-green-800 transition-colors duration-200"
                      title="Check/Approve">
                      <i class="bi bi-check-circle-fill text-xl"></i>
                    </a> -->

                    <!-- Delete Icon -->
                    <a href="delete_user.php?id=<?= $p['id'] ?>"
                      onclick="return confirm('Are you sure you want to delete this user?');"
                      class="text-red-600 hover:text-red-800 transition-colors duration-200"
                      title="Delete User">
                      <i class="bi bi-trash-fill text-xl"></i>
                    </a>

                  </div>
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
    const rows = document.querySelectorAll('.participant-row');

    function filterTable() {
      const search = searchInput.value.toLowerCase();
      const type = typeFilter.value;

      rows.forEach(row => {
        const text = row.getAttribute('data-search');
        const rowType = row.getAttribute('data-type');

        const matchesSearch = text.includes(search);
        const matchesType = type === 'all' || rowType === type;

        row.style.display = matchesSearch && matchesType ? '' : 'none';
      });
    }

    searchInput.addEventListener('input', filterTable);
    typeFilter.addEventListener('change', filterTable);
  </script>
</body>

</html>