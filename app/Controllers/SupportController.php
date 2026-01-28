<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Ticket;
use App\Models\Project;

class SupportController extends Controller {

    // --- Admin Views ---

    public function index() {
        if (!isset($_SESSION['admin_logged_in'])) {
            header("Location: /admin/login");
            exit;
        }

        $ticketModel = new Ticket();
        $tickets = $ticketModel->getAll();

        // Also fetch Ideas (Unified Support Center)
        // We can use a direct query or Project model.
        // Let's use raw query for speed or Project model helper if exists. 
        // Project model has `getIdeas($projectId)`, but not getAll.
        $pdo = \App\Core\Database::getInstance();
        $ideas = $pdo->query("
            SELECT i.*, p.name as project_name 
            FROM project_ideas i 
            JOIN projects p ON i.project_id = p.id 
            ORDER BY i.created_at DESC
        ")->fetchAll();

        // Fetch Satisfaction Ratings (Feedbacks)
        $feedbacks = $pdo->query("
            SELECT f.*, p.name as project_name 
            FROM project_feedback f 
            JOIN projects p ON f.project_id = p.id 
            WHERE f.type = 'rating'
            ORDER BY f.created_at DESC
        ")->fetchAll();

        $this->view('admin/support/index', [
            'tickets' => $tickets,
            'ideas' => $ideas,
            'feedbacks' => $feedbacks
        ], 'admin_layout');
    }

    public function ticket($id = null) {
         if (!isset($_SESSION['admin_logged_in'])) {
            header("Location: /admin/login");
            exit;
        }
        
        $id = $_GET['id'] ?? null; // Routing might pass arg or GET
        if (!$id) { header("Location: /admin/support"); exit; }

        $ticketModel = new Ticket();
        $ticket = $ticketModel->find($id);
        $messages = $ticketModel->getMessages($id);

        // Fetch Attachments
        $pdo = \App\Core\Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM ticket_attachments WHERE ticket_id = :tid");
        $stmt->execute([':tid' => $id]);
        $attachments = $stmt->fetchAll();

        $this->view('admin/support/ticket', [
            'ticket' => $ticket,
            'messages' => $messages,
            'attachments' => $attachments
        ], 'admin_layout');
    }

    public function reply() {
        if (!isset($_SESSION['admin_logged_in'])) {
            header("Location: /admin/login");
            exit;
        }

        $ticketId = $_POST['ticket_id'];
        $message = $_POST['message'];
        
        if ($ticketId && $message) {
            $ticketModel = new Ticket();
            $ticketModel->addMessage($ticketId, 'admin', $message);
            $ticketModel->updateStatus($ticketId, 'in_progress'); // Mark as Answered/In Progress
            
            // Set as UNREAD for client
            $pdo = \App\Core\Database::getInstance();
            $stmt = $pdo->prepare("UPDATE tickets SET client_read = 0 WHERE id = :id");
            $stmt->execute([':id' => $ticketId]);
        }

        header("Location: /admin/support/ticket?id=" . $ticketId);
        exit;
    }
}
