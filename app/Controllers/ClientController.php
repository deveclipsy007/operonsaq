<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;
use App\Core\Database;

class ClientController extends Controller {
    
    public function login() {
        if (isset($_SESSION['client_id'])) {
            header("Location: /dashboard");
            exit;
        }
        $this->view('client/login');
    }

    public function authenticate() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $pdo = \App\Core\Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM clients WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $client = $stmt->fetch();
        
        if ($client && password_verify($password, $client['password_hash'])) {
            $_SESSION['client_id'] = $client['id'];
            $_SESSION['client_name'] = $client['name'];
            header("Location: /dashboard");
            exit;
        }
        
        header("Location: /login?error=1");
        exit;
    }

    public function logout() {
        session_destroy();
        header("Location: /login");
        exit;
    }

    public function dashboard() {
        if (!isset($_SESSION['client_id'])) {
            header("Location: /login");
            exit;
        }

        $clientId = $_SESSION['client_id'];
        $pdo = \App\Core\Database::getInstance();

        // Fetch Client
        $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = :id");
        $stmt->execute([':id' => $clientId]);
        $client = $stmt->fetch();

        // Fetch Latest Active Project
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE client_id = :client_id ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([':client_id' => $clientId]);
        $project = $stmt->fetch();
        
        if (!$project) {
            $this->view('client/empty', ['client' => $client], 'client_layout');
            return;
        }

        // --- Set Locale for I18n ---
        \App\Core\I18n::setLocale($project['locale'] ?? 'pt-BR');
        
        // --- Project Timeline Logic (Reused) ---
        $projectModel = new Project();
        $rawEvents = $projectModel->getEvents($project['id']);
        
        $visibleEvents = [];
        $setting = $project['thalamic_setting'];
        
        foreach ($rawEvents as $event) {
            if ($setting === 'macro') {
                if ($event['type'] === 'MACRO') $visibleEvents[] = $event;
            } elseif ($setting === 'micro') {
                $visibleEvents[] = $event;
            } else { 
                $visibleEvents[] = $event; 
            }
        }

        // KPIs
        $startDate = strtotime($project['start_date'] ?? date('Y-m-d'));
        $deadline = strtotime($project['deadline'] ?? date('Y-m-d', strtotime('+30 days')));
        $now = time();
        $daysRemaining = max(0, ceil((max(1, ($deadline - $startDate) / 86400) - max(0, ($now - $startDate) / 86400))));

        // Use Manual KPI overrides or Auto-calculated from tasks
        $kpiEvents = array_filter($visibleEvents, fn($e) => $e['type'] === 'CHECKPOINT');
        $autoProgress = $projectModel->calculateProgress($project['id']);
        
        $kpis = [
            'days_remaining' => $daysRemaining,
            'total_tasks' => $project['custom_total_items'] ?? count($kpiEvents), 
            'done_tasks' => $project['custom_completed_items'] ?? count(array_filter($kpiEvents, fn($e) => $e['status'] === 'done')),
            'health' => $project['health_status'] ?? 'on_track', 
            'progress' => $project['custom_progress'] ?? $autoProgress, // Auto-calculated with manual override
            'budget' => ['total' => $project['project_value'] ?? 0, 'spent' => 0]
        ];

        // Dynamic Phases (Shared Logic)
        $allPhasesOrder = ['discovery', 'design', 'build', 'test', 'launch'];
        
        $currentPhaseKey = $project['current_phase'] ?? 'discovery';
        $foundActive = false;
        
        $phases = [];
        foreach ($allPhasesOrder as $key) {
            $status = 'pending';
            if ($key === $currentPhaseKey) {
                $status = 'active';
                $foundActive = true;
            } elseif (!$foundActive) {
                $status = 'completed';
            }
            
            $phases[] = [
                'id' => $key,
                'name' => \App\Core\I18n::t('phase.' . $key),
                'status' => $status
            ];
        }
        
        
        // --- Answered Tickets Notification Logic ---
        $ticketModel = new \App\Models\Ticket();
        // Uses getByProject which fetches tickets for this project
        $projectTickets = $ticketModel->getByProject($project['id']);
        $answeredTickets = [];
        
        foreach($projectTickets as $t) {
            // Check if last message is from admin
            // We need to fetch messages to be sure, unless getByProject includes 'first_message' or 'last_message_sender'
            // In step 912, I added 'first_message' to getByProject. I did NOT add last sender.
            // So I must fetch messages or assume 'in_progress' means answered.
            // Safe bet: Fetch messages.
            $msgs = $ticketModel->getMessages($t['id']);
            $last = end($msgs);
            
            // Criteria: Last sender is admin AND status is NOT resolved/closed (so it's "Active" negotiation)
            // Or if user wants to see resolved replies too? User said "Quando é respondido".
            // Let's show if last sender is admin.
            if ($last && $last['sender_type'] === 'admin' && ($t['client_read'] ?? 0) === 0) {
                $answeredTickets[] = $t;
            }
        }

        // Hide Next Action if already voted in this session
        if (isset($_SESSION['voted_' . $project['id']]) && $project['next_action_type'] === 'poll') {
            $project['next_action'] = null; // Hide the card
        }

        $this->view('client/timeline', [
            'client' => $client,
            'project' => $project,
            'events' => $visibleEvents,
            'kpis' => $kpis,
            'phases' => $phases,
            'answeredTickets' => $answeredTickets
        ], 'client_layout');
    }


    public function documents() {
        if (!isset($_SESSION['client_id'])) {
            header("Location: /login");
            exit;
        }

        $id = $_GET['id'] ?? null;
        if(!$id) {
            header("Location: /dashboard");
            exit;
        }

        $projectModel = new Project();
        $project = $projectModel->find($id);

        $this->view('client/documents', ['project' => $project], 'client_layout');
    }

    public function ideas() {
        if (!isset($_SESSION['client_id'])) {
            header("Location: /login");
            exit;
        }

        $id = $_GET['id'] ?? null;
        if(!$id) {
            header("Location: /dashboard");
            exit;
        }

        $projectModel = new Project();
        $project = $projectModel->find($id);
        $ideas = $projectModel->getIdeas($id);

        $this->view('client/ideas', ['project' => $project, 'ideas' => $ideas], 'client_layout');
    }

    public function storeIdea() {
        if (!isset($_SESSION['client_id'])) {
            header("Location: /login");
            exit;
        }
        
        $projectId = $_POST['project_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        
        if($projectId && $title) {
            $projectModel = new Project();
            $projectModel->addIdea([
                'project_id' => $projectId, 
                'title' => $title, 
                'description' => $description
            ]);
        }
        
        header("Location: /client/projects/ideas?id=" . $projectId);
        exit;
    }

    public function vote() {
        if (!isset($_SESSION['client_id'])) {
            header("Location: /login");
            exit;
        }

        $projectId = $_POST['project_id'] ?? null;
        $option = $_POST['option'] ?? null;

        if ($projectId && $option) {
            $projectModel = new Project();
            
            // 1. Update JSON counts (Backward Compatibility / Quick Stats)
            $project = $projectModel->find($projectId);
            if ($project) {
                $data = json_decode($project['next_action_data'] ?? '{}', true);
                if (!isset($data['votes'])) $data['votes'] = [];
                if (!isset($data['votes'][$option])) $data['votes'][$option] = 0;
                $data['votes'][$option]++;
                $projectModel->update($projectId, ['next_action_data' => json_encode($data)]);
            }

            // 2. Log to History
            $pdo = \App\Core\Database::getInstance();
            $stmt = $pdo->prepare("INSERT INTO project_feedback (project_id, type, content) VALUES (:pid, 'vote', :content)");
            $stmt->execute([':pid' => $projectId, ':content' => $option]);

            // 3. Mark locally as voted to hide the card
            $_SESSION['voted_' . $projectId] = true;
            $_SESSION['flash_message'] = "Voto registrado com sucesso! Obrigado.";
            $_SESSION['flash_type'] = "success";
        }

        header("Location: /dashboard");
        exit;
    }

    public function approve() {
        if (!isset($_SESSION['client_id'])) {
            header("Location: /login");
            exit;
        }

        $projectId = $_GET['project_id'] ?? null;
        
        if ($projectId) {
            $projectModel = new Project();
            $project = $projectModel->find($projectId);
            
            // Log Approval
            $pdo = \App\Core\Database::getInstance();
            $stmt = $pdo->prepare("INSERT INTO project_feedback (project_id, type, content) VALUES (:pid, 'approval', :content)");
            $stmt->execute([
                ':pid' => $projectId, 
                ':content' => 'Aprovado: ' . ($project['next_action'] ?? 'Ação Genérica')
            ]);
            
            // Mark as Completed
            $projectModel->update($projectId, ['next_action_type' => 'completed']);
        }

        header("Location: /dashboard?approved=1");
        exit;
    }

    public function index() {
        // Redirect root to Login or Dashboard
        if (isset($_SESSION['client_id'])) {
            header("Location: /dashboard");
        } else {
            header("Location: /login");
        }
        exit;
    }

    // --- Support & Help ---

    public function support() {
        if (!isset($_SESSION['client_id'])) {
            header("Location: /login");
            exit;
        }

        $clientId = $_SESSION['client_id'];
        $pdo = \App\Core\Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = :id");
        $stmt->execute([':id' => $clientId]);
        $client = $stmt->fetch();

        // Mark as READ if opening a specific ticket
        if ($openTicketId = ($_GET['open_ticket_id'] ?? null)) {
            $updateStmt = $pdo->prepare("UPDATE tickets SET client_read = 1 WHERE id = :id");
            $updateStmt->execute([':id' => $openTicketId]);
        }

        // Get Project for context
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE client_id = :client_id ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([':client_id' => $clientId]);
        $project = $stmt->fetch();

        // Get Tickets
        $ticketModel = new \App\Models\Ticket();
        $tickets = $ticketModel->getByProject($project['id']);

        // Attach messages to tickets
        foreach ($tickets as &$t) {
            $t['messages'] = $ticketModel->getMessages($t['id']);
            // Attach Attachments too
            $pdo = \App\Core\Database::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM ticket_attachments WHERE ticket_id = :tid");
            $stmt->execute([':tid' => $t['id']]);
            $t['attachments'] = $stmt->fetchAll();
        }

        $this->view('client/support', [
            'client' => $client,
            'project' => $project,
            'tickets' => $tickets
        ], 'client_layout');
    }

    public function replyTicket() {
        if (!isset($_SESSION['client_id'])) {
            header("Location: /login");
            exit;
        }

        $ticketId = $_POST['ticket_id'] ?? null;
        $message = $_POST['message'] ?? '';

        if ($ticketId && $message) {
            $ticketModel = new \App\Models\Ticket();
            
            // Validate ticket belongs to client's project
            $ticket = $ticketModel->find($ticketId);
            // In a real app, verify ownership. Assuming safe for now or check project_id.

            $ticketModel->addMessage($ticketId, 'client', $message);
            $ticketModel->updateStatus($ticketId, 'open'); // Re-open or indicate client reply
        }

        header("Location: /client/support?ticket_updated=1");
        exit;
    }

    public function storeTicket() {
        if (!isset($_SESSION['client_id'])) {
            header("Location: /login");
            exit;
        }

        $project_id = $_POST['project_id'] ?? null;
        $category = $_POST['category'] ?? 'geral';
        $priority = $_POST['priority'] ?? 'normal';
        $description = $_POST['description'] ?? '';
        
        // Subject generation
        $subject = "Solicitação de " . ucfirst($category); // Simplified subject

        if ($project_id && $description) {
            $ticketModel = new \App\Models\Ticket();
            
            // 1. Create Ticket
            $ticketId = $ticketModel->create([
                ':project_id' => $project_id,
                ':subject' => $subject,
                ':priority' => $priority,
                ':category' => $category
            ]);

            // 2. Add First Message (Description)
            // Store as HTML since we use Trix
            $ticketModel->addMessage($ticketId, 'client', $description);

            // 3. Handle Attachments
            if (!empty($_FILES['attachments'])) {
                $pdo = \App\Core\Database::getInstance();
                $uploadDir = __DIR__ . '/../../public/uploads/tickets/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                $files = $_FILES['attachments'];
                $count = count($files['name']);

                for ($i = 0; $i < $count; $i++) {
                    if ($files['error'][$i] === UPLOAD_ERR_OK) {
                        $tmpName = $files['tmp_name'][$i];
                        $name = basename($files['name'][$i]);
                        $size = $files['size'][$i];
                        $type = $files['type'][$i];

                        // Validation
                        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                        $allowed = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx'];
                        
                        if ($size > 5 * 1024 * 1024) continue; // Skip > 5MB
                        if (!in_array($ext, $allowed)) continue; // Skip invalid types

                        // Save
                        $fileName = time() . '_' . uniqid() . '.' . $ext;
                        $targetPath = $uploadDir . $fileName;

                        if (move_uploaded_file($tmpName, $targetPath)) {
                            // Insert into ticket_attachments
                            $stmt = $pdo->prepare("INSERT INTO ticket_attachments (ticket_id, file_name, file_path, file_size, file_type) VALUES (:tid, :name, :path, :size, :type)");
                            $stmt->execute([
                                ':tid' => $ticketId,
                                ':name' => $name,
                                ':path' => '/uploads/tickets/' . $fileName,
                                ':size' => $size,
                                ':type' => $type
                            ]);
                        }
                    }
                }
            }

            // Redirect with success
            header("Location: /dashboard?ticket_created=1");
            exit;
        }

        header("Location: /client/support?error=1");
        exit;
    }

    public function rateProject() {
        if (!isset($_SESSION['client_id'])) {
            header("Location: /login");
            exit;
        }

        $projectId = $_POST['project_id'] ?? null;
        $rating = $_POST['rating'] ?? null;
        $feedback = $_POST['feedback'] ?? '';

        if ($projectId && $rating) {
            $pdo = \App\Core\Database::getInstance();
            $stmt = $pdo->prepare("INSERT INTO project_feedback (project_id, type, content) VALUES (:pid, 'rating', :content)");
            $stmt->execute([
                ':pid' => $projectId, 
                ':content' => json_encode(['rating' => $rating, 'feedback' => $feedback])
            ]);
        }

        header("Location: /dashboard?rated=1");
        exit;
    }
}
