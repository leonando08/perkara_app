<?php
class User
{
    private $conn;
    private $table = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // LOGIN
    public function login($username, $password)
    {
        $sql = "SELECT * FROM {$this->table} WHERE username=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            return $user; // login sukses
        }
        return false; // gagal login
    }

    // REGISTER
    public function register($username, $password, $role = "user")
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO {$this->table} (username, password, role) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $username, $hashedPassword, $role);
        return $stmt->execute();
    }
}
