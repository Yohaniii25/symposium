<?php

class User {

    private $db;
    private $conn;

    public function __construct($database) {
        $this->db = $database;
        $this->conn = $this->db->getConnection();
    }

    // Register a new user
    public function register($data) {
        $sql = "INSERT INTO users (title, full_name, nic_passport, email, phone, food_preference, participant_type, password) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

       $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $hashed = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt->bind_param("ssssssss",
            $data['title'],
            $data['full_name'],
            $data['nic_passport'],
            $data['email'],
            $data['phone'],
            $data['food_preference'],
            $data['participant_type'],
            $hashed
        );
        return $stmt->execute();
    }

    // Login user
    public function login($email, $password) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }

    // Check if email exists
    public function emailExists($email) {
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    // Get user by ID
    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}


?>