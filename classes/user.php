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

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // Login user — NOW RETURNS reference_no
    public function login($email, $password) {
        $sql = "SELECT id, title, full_name, email, phone, food_preference, participant_type, reference_no, password 
                FROM users WHERE email = ? LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($password, $user['password'])) {
            return $user; // Now includes reference_no
        }

        return false;
    }

    // Check if email exists
    public function emailExists($email) {
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();

        return $exists;
    }

    // Get user by ID — also returns reference_no
    public function getUserById($id) {
        $sql = "SELECT id, title, full_name, email, phone, food_preference, participant_type, reference_no, status 
                FROM users WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        return $user;
    }
}
?>