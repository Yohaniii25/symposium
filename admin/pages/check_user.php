<!-- after clicking check user button in dashboard -->
<?php
require_once '../../config/config.php';
require_once '../../classes/database.php';
require_once '../../classes/user.php';

$database = new Database();
$user = new User($database);

if (isset($_GET['id'])) {
    $user->approve($_GET['id']);
    header("Location: view_user.php?id=" . urlencode($_GET['id']));
}
?>