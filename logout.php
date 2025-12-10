<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Optional: Regenerate session ID for security
session_regenerate_id(true);

// Redirect to login page (or home)
header("Location: login.php");
exit();
?>