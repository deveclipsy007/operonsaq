<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Project {
    protected $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT p.*, c.name as client_name 
                                   FROM projects p 
                                   JOIN clients c ON p.client_id = c.id 
                                   ORDER BY p.created_at DESC");
        return $stmt->fetchAll();
    }
    
    public function create($data) {
        $sql = "INSERT INTO projects (client_id, name, description, thalamic_setting, status, start_date, deadline, phases_count, project_value, payment_method, installments, installments_paid, contract_url, notes, health_status, custom_progress, custom_completed_items, custom_total_items, manager_name, manager_phone, github_url, provisional_url, definitive_url, next_action, next_action_deadline, next_action_type, featured_message) 
                VALUES (:client_id, :name, :description, :thalamic_setting, :status, :start_date, :deadline, :phases_count, :project_value, :payment_method, :installments, :installments_paid, :contract_url, :notes, :health_status, :custom_progress, :custom_completed_items, :custom_total_items, :manager_name, :manager_phone, :github_url, :provisional_url, :definitive_url, :next_action, :next_action_deadline, :next_action_type, :featured_message)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $sql = "UPDATE projects SET " . implode(', ', $fields) . " WHERE id = :id";
        $data['id'] = $id;
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT p.*, c.name as client_name 
                                   FROM projects p 
                                   JOIN clients c ON p.client_id = c.id 
                                   WHERE p.id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getEvents($projectId) {
        $stmt = $this->pdo->prepare("SELECT * FROM timeline_events 
                                     WHERE project_id = :project_id 
                                     ORDER BY created_at DESC");
        $stmt->execute([':project_id' => $projectId]);
        return $stmt->fetchAll();
    }

    public function createEvent($data) {
        $sql = "INSERT INTO timeline_events (project_id, title, description, type, status, completed_at, metadata) 
                VALUES (:project_id, :title, :description, :type, :status, :completed_at, :metadata)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function deleteEvent($id) {
        $stmt = $this->pdo->prepare("DELETE FROM timeline_events WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getByClient($clientId) {
        $stmt = $this->pdo->prepare("SELECT * FROM projects WHERE client_id = :client_id ORDER BY created_at DESC");
        $stmt->execute([':client_id' => $clientId]);
        return $stmt->fetchAll();
    }

    public function getIdeas($projectId) {
        $stmt = $this->pdo->prepare("SELECT * FROM project_ideas WHERE project_id = :project_id ORDER BY created_at DESC");
        $stmt->execute([':project_id' => $projectId]);
        return $stmt->fetchAll();
    }

    public function addIdea($data) {
        $sql = "INSERT INTO project_ideas (project_id, title, description, status) VALUES (:project_id, :title, :description, 'new')";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function logActivity($projectId, $type, $content) {
        $stmt = $this->pdo->prepare("INSERT INTO project_feedback (project_id, type, content) VALUES (:pid, :type, :content)");
        return $stmt->execute([
            ':pid' => $projectId, 
            ':type' => $type,
            ':content' => $content
        ]);
    }

    public function calculateProgress($projectId) {
        $events = $this->getEvents($projectId);
        
        // Filter only task-type events (not warnings/docs/articles)
        $tasks = array_filter($events, fn($e) => in_array($e['type'], ['MICRO', 'MACRO', 'CHECKPOINT']));
        
        $total = count($tasks);
        if ($total === 0) return 0;
        
        $done = count(array_filter($tasks, fn($e) => $e['status'] === 'done'));
        $inProgress = count(array_filter($tasks, fn($e) => $e['status'] === 'in_progress'));
        
        // In Progress counts as 50% (0.5)
        $weightedScore = $done + ($inProgress * 0.5);
        
        return round(($weightedScore / $total) * 100);
    }

    public function getCheckpoints($projectId) {
        $stmt = $this->pdo->prepare("SELECT * FROM timeline_events 
                                     WHERE project_id = :project_id AND type = 'CHECKPOINT'
                                     ORDER BY created_at ASC");
        $stmt->execute([':project_id' => $projectId]);
        return $stmt->fetchAll();
    }

    public function toggleEventStatus($id) {
        $stmt = $this->pdo->prepare("SELECT status FROM timeline_events WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $current = $stmt->fetch();
        
        if (!$current) return null;
        
        // Cycle: pending -> in_progress -> done -> pending
        $newStatus = 'pending';
        if ($current['status'] === 'pending') {
            $newStatus = 'in_progress';
        } elseif ($current['status'] === 'in_progress') {
            $newStatus = 'done';
        } else {
            $newStatus = 'pending';
        }
        
        $completedAt = $newStatus === 'done' ? date('Y-m-d H:i:s') : null;
        
        $stmt = $this->pdo->prepare("UPDATE timeline_events SET status = :status, completed_at = :completed_at WHERE id = :id");
        $stmt->execute([':status' => $newStatus, ':completed_at' => $completedAt, ':id' => $id]);
        
        return $newStatus;
    }
}
