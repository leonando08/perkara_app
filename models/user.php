<?php
class User
{
    private $conn;
    private $table = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login($username, $password)
    {
        $password = hash("sha256", $password);
        $sql = "SELECT * FROM {$this->table} WHERE username=? AND password=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function register($username, $password, $role = "user")
    {
        $password = hash("sha256", $password);
        $sql = "INSERT INTO {$this->table} (username, password, role) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->bind_param("sss", $username, $password, $role)->execute();
    }
}
