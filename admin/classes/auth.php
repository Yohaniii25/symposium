<?php
session_start();

class Auth {  
    public function login($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['participant_type'] = $user['participant_type'];
        $_SESSION['logged_in'] = true;
    }

    public function isLoggedIn() {
        return isset($_SESSION['logged_in']);
    }

    public function user() {
        if ($this->isLoggedIn()) {
            return [
                'id'   => $_SESSION['user_id'],
                'name' => $_SESSION['user_name'],
                'email'=> $_SESSION['user_email'],
                'type' => $_SESSION['participant_type']
            ];
        }
        return null;
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }

    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            header("Location: login.php");
            exit();
        }
    }
}
?>