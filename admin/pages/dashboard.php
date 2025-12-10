<?php

require_once '../../config/config.php';
require_once '../../classes/database.php';
require_once '../../classes/user.php';
require_once '../../classes/admin.php';
require_once '../../classes/auth.php';

$auth = new Auth();

// Redirect if not admin
if (!$auth->isAdmin()) {
    header("Location: ../../login.php");
    exit();
}

// Static Data for First Phase (Replace with DB later)
$participants = [
    [
        'title' => 'Dr.', 'full_name' => 'Kamal Perera', 'nic' => '198012345678', 'email' => 'kamal@university.ac.lk',
        'phone' => '0771234567', 'food' => 'Non-Vegetarian', 'type' => 'Presenting Author',
        'payment_status' => 'Paid', 'amount' => 'LKR 1,000'
    ],
    [
        'title' => 'Ms.', 'full_name' => 'Nisansala Fernando', 'nic' => '199812345678', 'email' => 'nisan@gmail.com',
        'phone' => '0712345678', 'food' => 'Vegetarian', 'type' => 'Co-Author',
        'payment_status' => 'Paid', 'amount' => 'LKR 1,500'
    ],
    [
        'title' => 'Mr.', 'full_name' => 'Ruwan Silva', 'nic' => '197812345678', 'email' => 'ruwan@company.com',
        'phone' => '0701234567', 'food' => 'No Preference', 'type' => 'Other Participants',
        'payment_status' => 'Pending', 'amount' => 'LKR 5,000'
    ],
    [
        'title' => 'Prof.', 'full_name' => 'Sunil Jayasinghe', 'nic' => '196512345678', 'email' => 'sunil@edu.ac.lk',
        'phone' => '0779876543', 'food' => 'Halal', 'type' => 'Presenting Author',
        'payment_status' => 'Paid', 'amount' => 'LKR 1,000'
    ],
    // Add more as needed
];
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
  <div class="bg-gradient-to-r from-primary to-richpurple text-white py-6 shadow-xl">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
      <div class="flex items-center space-x-4">
        <img src="../../assets/img/logo.png" alt="GJRTI" class="h-14">
        <div>
          <h1 class="text-2xl font-bold">Admin Dashboard</h1>
          <p class="text-sm opacity-90">GJRTI 3rd International Research Symposium 2025</p>
        </div>
      </div>
      <a href="../../logout.php" class="bg-red-600 hover:bg-red-700 px-5 py-2 rounded-lg font-medium transition">
        Logout
      </a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="max-w-7xl mx-auto px-6 py-10">

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
      <div class="bg-gradient-to-r from-primary to-richpurple text-white p-6">
        <h2 class="text-2xl font-bold">Registered Participants</h2>
      </div>

      <!-- Filter -->
      <div class="p-6 border-b">
        <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
          <p class="text-gray-700 font-medium">Total: <span class="text-primary font-bold"><?= count($participants) ?></span> Participants</p>
          <div class="flex items-center gap-3">
            <label class="text-gray-700 font-medium">Filter by Type:</label>
            <select id="typeFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:border-accent outline-none">
              <option value="all">All Participants</option>
              <option value="Presenting Author">Presenting Author</option>
              <option value="Co-Author">Co-Author</option>
              <option value="Other Participants">Other Participants</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Scrollable Table -->
      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead class="bg-gray-50 border-b">
            <tr>
              <th class="px-6 py-4 font-bold text-primary">Name</th>
              <th class="px-6 py-4 font-bold text-primary">NIC/Passport</th>
              <th class="px-6 py-4 font-bold text-primary">Email</th>
              <th class="px-6 py-4 font-bold text-primary">Phone</th>
              <th class="px-6 py-4 font-bold text-primary">Food</th>
              <th class="px-6 py-4 font-bold text-primary">Type</th>
              <th class="px-6 py-4 font-bold text-primary">Payment</th>
              <th class="px-6 py-4 font-bold text-primary text-center">Action</th>
            </tr>
          </thead>
          <tbody id="participantTable" class="divide-y divide-gray-200">
            <?php foreach ($participants as $p): ?>
            <tr class="hover:bg-gray-50 transition participant-row" data-type="<?= $p['type'] ?>">
              <td class="px-6 py-4">
                <div class="font-medium"><?= htmlspecialchars($p['title'] . ' ' . $p['full_name']) ?></div>
              </td>
              <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($p['nic']) ?></td>
              <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($p['email']) ?></td>
              <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($p['phone']) ?></td>
              <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($p['food']) ?></td>
              <td class="px-6 py-4">
                <span class="px-3 py-1 rounded-full text-xs font-medium 
                  <?php
                  echo $p['type'] === 'Presenting Author' ? 'bg-blue-100 text-blue-800' :
                       ($p['type'] === 'Co-Author' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800');
                  ?>">
                  <?= $p['type'] ?>
                </span>
              </td>
              <td class="px-6 py-4">
                <span class="font-medium <?= $p['payment_status'] === 'Paid' ? 'text-green-600' : 'text-red-600' ?>">
                  <?= $p['payment_status'] ?> (<?= $p['amount'] ?>)
                </span>
              </td>
              <td class="px-6 py-4 text-center">
                <button class="text-red-600 hover:text-red-800 font-medium text-sm">
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
    // Filter by Participant Type
    document.getElementById('typeFilter').addEventListener('change', function() {
      const value = this.value;
      document.querySelectorAll('.participant-row').forEach(row => {
        const type = row.getAttribute('data-type');
        row.style.display = (value === 'all' || type === value) ? '' : 'none';
      });
    });
  </script>
</body>
</html>