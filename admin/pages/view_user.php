<?php
require_once '../../config/config.php';
require_once '../../classes/database.php';
require_once '../../classes/auth.php';

$auth = new Auth();
if (!$auth->isAdmin()) {
    header("Location: ../../login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: dashboard.php");
    exit();
}

$db = new Database();
$conn = $db->conn;

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
$stmt->close();

if (!$user) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant Profile - GJRTI Symposium</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>

<body class="admin-dashboard-body">

    <!-- Header -->
    <div class="dashboard-header">
        <div class="dashboard-header-container">
            <div class="dashboard-header-logo-section">
                <a href="dashboard.php" style="display: flex; align-items: center; gap: 1rem; color: #fff; text-decoration: none;">
                    <img src="../../assets/img/logo.png" alt="GJRTI" class="dashboard-header-logo">
                    <div>
                        <h1 class="text-3xl font-bold">Admin Dashboard</h1>
                        <p class="opacity-90">Participant Details View</p>
                    </div>
                </a>
            </div>
            <div>
                <a href="dashboard.php" class="btn-profile-primary" style="width: auto; padding: 0.75rem 1.5rem;">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <section class="profile-section-body" style="padding-top: 4rem; padding-bottom: 4rem;">
        <div class="container-max-medium">
            <div class="profile-card">

                <!-- Header -->
                <div class="profile-header-gradient">
                    <div class="profile-avatar-wrapper">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h2 class="text-4xl font-bold"><?= htmlspecialchars($user['title'] . ' ' . $user['full_name']) ?></h2>
                    <p class="text-xl opacity-90 mt-2"><?= htmlspecialchars($user['participant_type']) ?></p>
                </div>

                <!-- Details -->
                <div class="form-card-padding">
                    <h3 class="profile-section-title">Registration Summary</h3>

                    <div class="profile-grid">
                        <div class="space-y-5">
                            <div>
                                <strong class="text-gray-600">Reference Number:</strong>
                                <p class="text-gray-900 font-medium mt-1"><?= htmlspecialchars($user['reference_no'] ?: '—') ?></p>
                            </div>
                            <div>
                                <strong class="text-gray-600">NIC / Passport:</strong>
                                <p class="text-gray-900 font-medium mt-1 font-mono-bold"><?= htmlspecialchars($user['nic_passport'] ?: '—') ?></p>
                            </div>
                            <div>
                                <strong class="text-gray-600">Email Address:</strong>
                                <p class="text-gray-900 font-medium mt-1"><?= htmlspecialchars($user['email']) ?></p>
                            </div>
                            <div>
                                <strong class="text-gray-600">Contact Number:</strong>
                                <p class="text-gray-900 font-medium mt-1"><?= htmlspecialchars($user['phone']) ?></p>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <strong class="text-gray-600">Category / Type:</strong>
                                <p class="text-gray-900 font-medium mt-1">
                                    <span class="badge-type <?= $user['participant_type'] === 'Presenting Author' ? 'badge-type-author-presenting' : (($user['participant_type'] === 'Co-Author' || $user['participant_type'] === 'Co-authors') ? 'badge-type-author-co' : 'badge-type-other') ?>">
                                        <?= $user['participant_type'] ?>
                                    </span>
                                </p>
                            </div>
                            <div>
                                <strong class="text-gray-600">Country Origin:</strong>
                                <p class="text-gray-900 font-medium mt-1"><?= htmlspecialchars(ucfirst($user['country_type'] ?? 'local')) ?></p>
                            </div>
                            <div>
                                <strong class="text-gray-600">Abstract Name / Number:</strong>
                                <p class="text-gray-900 font-medium mt-1"><?= htmlspecialchars($user['abstract_name'] ?: '—') ?></p>
                            </div>

                            <div>
                                <strong class="text-gray-600">Registered Date:</strong>
                                <p class="text-gray-900 font-medium mt-1"><?= date('F d, Y - h:i A', strtotime($user['created_at'])) ?></p>
                            </div>
                        </div>
                    </div>

                    <div style="border-top: 1px solid var(--color-gray-200); margin-top: 3rem; padding-top: 2rem; display: flex; justify-content: flex-end;">
                        <a href="dashboard.php" class="btn-accent-large" style="width: auto; padding: 0.75rem 2rem; font-size: 1rem; border-radius: 0.5rem; text-decoration: none;">
                            Back to Dashboard
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </section>

</body>

</html>