<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Client {
    protected $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM clients ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function create($name, $email) {
        // Generate a cryptographically secure random token
        $token = bin2hex(random_bytes(32));
        
        $stmt = $this->pdo->prepare("INSERT INTO clients (name, email, access_token) VALUES (:name, :email, :token)");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':token' => $token
        ]);
        
        return $this->pdo->lastInsertId();
    }
    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}
