<?php
class User
{

    private $db;
    private $conn;

    public function __construct($database)
    {
        $this->db = $database;
        $this->conn = $this->db->getConnection();
    }


    // Register a new user — NOW SUPPORTS country_type
    public function register($data)
    {
        $sql = "INSERT INTO users (title, full_name, nic_passport, email, phone, food_preference, participant_type, country_type, password) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error); // for debugging
            return false;
        }

        $hashed = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt->bind_param(
            "sssssssss",
            $data['title'],
            $data['full_name'],
            $data['nic_passport'],
            $data['email'],
            $data['phone'],
            $data['food_preference'],
            $data['participant_type'],
            $data['country_type'],  // ← NEW
            $hashed
        );

        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        $stmt->close();

        return $result;
    }

    // Login user — includes country_type
    public function login($email, $password)
    {
        $sql = "SELECT id, title, full_name, email, phone, food_preference, participant_type, country_type, reference_no, password 
                FROM users WHERE email = ? LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    // Check if email exists
    public function emailExists($email)
    {
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

    // Get user by ID — includes country_type
    public function getUserById($id)
    {
        $sql = "SELECT id, title, full_name, email, phone, food_preference, participant_type, country_type, reference_no
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

    // Get user profile with payment status — includes country_type
    public function getUserWithPaymentStatus($id)
    {
        $sql = "SELECT 
                    u.id,
                    u.title,
                    u.full_name,
                    u.nic_passport,
                    u.email,
                    u.phone,
                    u.food_preference,
                    u.participant_type,
                    u.country_type,
                    u.reference_no,
                    u.created_at,
                    p.id AS payment_id,
                    p.amount,
                    p.currency,
                    p.payment_method,
                    p.transaction_id,
                    p.slip,
                    p.status AS payment_status,
                    p.created_at AS payment_date
                FROM users u
                LEFT JOIN payments p ON u.id = p.user_id AND p.status IN ('paid', 'under_review')
                WHERE u.id = ?
                ORDER BY p.created_at DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();

        return $data;
    }

    // Get all payments for a user
    public function getUserPayments($id)
    {
        $sql = "SELECT 
                    id,
                    amount,
                    currency,
                    payment_method,
                    transaction_id,
                    slip,
                    status,
                    created_at
                FROM payments
                WHERE user_id = ?
                ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $payments = [];
        while ($row = $result->fetch_assoc()) {
            $payments[] = $row;
        }
        $stmt->close();

        return $payments;
    }
}
