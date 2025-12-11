<?php
session_start();

class Auth {

    // Login Participant
    public function loginParticipant($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['participant_type'] = $user['participant_type'];
        $_SESSION['user_reference'] = $user['reference_no'] ?? null;
        $_SESSION['role'] = 'participant';
        $_SESSION['logged_in'] = true;
    }

    // Login Admin
    public function loginAdmin($admin) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['role'] = 'admin';
        $_SESSION['logged_in'] = true;
    }

    public function isLoggedIn() {
        return isset($_SESSION['logged_in']);
    }

    public function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public function isParticipant() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'participant';
    }

    public function user() {
        if ($this->isParticipant()) {
            return [
                'id' => $_SESSION['user_id'],
                'name' => $_SESSION['user_name'],
                'email' => $_SESSION['user_email'],
                'type' => $_SESSION['participant_type']
            ];
        }
        return null;
    }

    public function admin() {
        if ($this->isAdmin()) {
            return [
                'id' => $_SESSION['admin_id'],
                'name' => $_SESSION['admin_name'],
                'email' => $_SESSION['admin_email']
            ];
        }
        return null;
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: ../login.php");
        exit();
    }

    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            header("Location: ../login.php");
            exit();
        }
    }
}
?>