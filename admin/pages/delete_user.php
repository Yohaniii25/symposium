
<?php
require_once '../../config/config.php';
require_once '../../classes/database.php';
require_once '../../classes/user.php';

$database = new Database();
$user = new User($database);

if (isset($_GET['id'])) {
    $user->delete($_GET['id']);
    header("Location: dashboard.php");
}
?>