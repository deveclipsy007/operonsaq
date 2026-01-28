<?php

namespace App\Models;

use App\Core\Database;

class Ticket {
    protected $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    // --- Tickets ---

    public function create($data) {
        $sql = "INSERT INTO tickets (project_id, subject, status, priority) VALUES (:project_id, :subject, 'open', :priority)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function getAll() {
        // Fetch all tickets with project/client info
        $sql = "SELECT t.*, p.name as project_name, c.name as client_name 
                FROM tickets t 
                JOIN projects p ON t.project_id = p.id 
                JOIN clients c ON p.client_id = c.id
                ORDER BY t.updated_at DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function getByProject($projectId) {
        $sql = "SELECT t.*, 
            (SELECT message FROM ticket_messages WHERE ticket_id = t.id ORDER BY created_at ASC LIMIT 1) as first_message
            FROM tickets t 
            WHERE t.project_id = :pid 
            ORDER BY t.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':pid' => $projectId]);
        return $stmt->fetchAll();
    }

    public function find($id) {
        $sql = "SELECT t.*, p.name as project_name, c.name as client_name 
                FROM tickets t 
                JOIN projects p ON t.project_id = p.id 
                JOIN clients c ON p.client_id = c.id
                WHERE t.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function updateStatus($id, $status) {
        $stmt = $this->pdo->prepare("UPDATE tickets SET status = :status, updated_at = CURRENT_TIMESTAMP WHERE id = :id");
        return $stmt->execute([':id' => $id, ':status' => $status]);
    }

    // --- Messages ---

    public function addMessage($ticketId, $senderType, $message) {
        $sql = "INSERT INTO ticket_messages (ticket_id, sender_type, message) VALUES (:tid, :sender, :msg)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':tid' => $ticketId, ':sender' => $senderType, ':msg' => $message]);
        
        // Touch parent ticket
        $this->updateStatus($ticketId, 'in_progress'); // Example auto-status
    }

    public function getMessages($ticketId) {
        $stmt = $this->pdo->prepare("SELECT * FROM ticket_messages WHERE ticket_id = :tid ORDER BY created_at ASC");
        $stmt->execute([':tid' => $ticketId]);
        return $stmt->fetchAll();
    }

    public function getLastMessage($ticketId) {
        $stmt = $this->pdo->prepare("SELECT message, created_at FROM ticket_messages WHERE ticket_id = :tid ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([':tid' => $ticketId]);
        return $stmt->fetch();
    }
}
