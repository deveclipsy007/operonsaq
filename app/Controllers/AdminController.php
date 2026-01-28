<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;

class AdminController extends Controller {

    public function index() {
        $projectModel = new Project();
        $projects = $projectModel->getAll();
        
        $this->view('admin/dashboard', ['projects' => $projects], 'admin_layout');
    }

    public function projects() {
        $projectModel = new Project();
        $projects = $projectModel->getAll();
        $clientModel = new \App\Models\Client();
        $clients = $clientModel->getAll();
        
        // Filter out archived
        $projects = array_filter($projects, fn($p) => $p['status'] !== 'archived');
        
        $this->view('admin/projects/board', [
            'projects' => $projects,
            'clients' => $clients
        ], 'admin_layout');
    }

    public function create() {
        $clientModel = new \App\Models\Client();
        $clients = $clientModel->getAll();
        
        $this->view('admin/projects/create', ['clients' => $clients], 'admin_layout');
    }

    public function store() {
        // Basic Info
        $clientId = $_POST['client_id'] ?? null;
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $thalamicSetting = $_POST['thalamic_setting'] ?? 'hybrid';
        
        // Dates
        $startDate = $_POST['start_date'] ?? date('Y-m-d');
        $deadline = $_POST['deadline'] ?? null;

        // Expanded Financial & Contract Info
        $phasesCount = $_POST['phases_count'] ?? 0;
        $projectValue = $_POST['project_value'] ?? 0.00;
        $paymentMethod = $_POST['payment_method'] ?? 'Pix';
        $installments = $_POST['installments'] ?? 1;
        $installments = $_POST['installments'] ?? 1;
        $notes = $_POST['notes'] ?? '';
        
        // Manager & Links
        $managerName = $_POST['manager_name'] ?? 'A definir';
        $managerPhone = $_POST['manager_phone'] ?? '';
        $githubUrl = $_POST['github_url'] ?? '';
        $provisionalUrl = $_POST['provisional_url'] ?? '';
        $definitiveUrl = $_POST['definitive_url'] ?? '';

        // Next Action
        $nextAction = $_POST['next_action'] ?? null;
        $nextActionDeadline = $_POST['next_action_deadline'] ?? null;
        $nextActionType = $_POST['next_action_type'] ?? 'info';
        $featuredMessage = $_POST['featured_message'] ?? '';

        // Contract Upload Handling
        $contractUrl = null;
        if (!empty($_FILES['contract_file']['name'])) {
            $uploadDir = __DIR__ . '/../../public/uploads/contracts/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $fileName = time() . '_' . basename($_FILES['contract_file']['name']);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['contract_file']['tmp_name'], $targetPath)) {
                $contractUrl = '/uploads/contracts/' . $fileName;
            }
        }

        $projectModel = new Project();
        $projectModel->create([
            'client_id' => $clientId,
            'name' => $name,
            'description' => $description,
            'thalamic_setting' => $thalamicSetting,
            'status' => 'active',
            'start_date' => $startDate,
            'deadline' => $deadline,
            'phases_count' => $phasesCount,
            'project_value' => $projectValue,
            'payment_method' => $paymentMethod,
            'installments' => $installments,
            'installments_paid' => 0,
            'contract_url' => $contractUrl,
            'notes' => $notes,
            'health_status' => 'on_track',
            'custom_progress' => null,
            'custom_completed_items' => null,
            'custom_total_items' => null,
            'manager_name' => $managerName,
            'manager_phone' => $managerPhone,
            'github_url' => $githubUrl,
            'provisional_url' => $provisionalUrl,
            'definitive_url' => $definitiveUrl,
            'next_action' => $nextAction,
            'next_action_deadline' => $nextActionDeadline,
            'next_action_type' => $nextActionType,
            'featured_message' => $featuredMessage
        ]);

        header("Location: /admin");
        exit;
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: /admin");
            exit;
        }

        $projectModel = new Project();
        $project = $projectModel->find($id);

        $clientModel = new \App\Models\Client();
        $clients = $clientModel->getAll(); // Need clients for dropdown

        if (!$project) {
            header("Location: /admin");
            exit;
        }

        $this->view('admin/projects/edit', ['project' => $project, 'clients' => $clients], 'admin_layout');
    }

    public function update() {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header("Location: /admin");
            exit;
        }

        // --- Data Collection (Similar to Store) ---
        $data = [
            'client_id' => $_POST['client_id'] ?? null,
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'thalamic_setting' => $_POST['thalamic_setting'] ?? 'hybrid',
            'start_date' => $_POST['start_date'] ?? date('Y-m-d'),
            'deadline' => $_POST['deadline'] ?? null,
            'phases_count' => $_POST['phases_count'] ?? 0,
            'project_value' => $_POST['project_value'] ?? 0.00,
            'payment_method' => $_POST['payment_method'] ?? 'Pix',
            'installments' => $_POST['installments'] ?? 1,
            'installments_paid' => $_POST['installments_paid'] ?? 0,
            'notes' => $_POST['notes'] ?? '',
            'manager_name' => $_POST['manager_name'] ?? 'A definir',
            'manager_phone' => $_POST['manager_phone'] ?? '',
            'github_url' => $_POST['github_url'] ?? '',
            'provisional_url' => $_POST['provisional_url'] ?? '',
            'definitive_url' => $_POST['definitive_url'] ?? '',
            'next_action' => $_POST['next_action'] ?? null,
            'next_action_deadline' => $_POST['next_action_deadline'] ?? null,
            'next_action_type' => $_POST['next_action_type'] ?? 'info',
            'status' => $_POST['status'] ?? 'active',
            // KPI Overrides
            'health_status' => $_POST['health_status'] ?? 'on_track',
            'custom_progress' => $_POST['custom_progress'] === '' ? null : $_POST['custom_progress'],
            'custom_completed_items' => $_POST['custom_completed_items'] === '' ? null : $_POST['custom_completed_items'],
            'custom_total_items' => $_POST['custom_total_items'] === '' ? null : $_POST['custom_total_items'],
            'featured_message' => $_POST['featured_message'] ?? '',
            'locale' => $_POST['locale'] ?? 'pt-BR'
        ];

        // --- Contract Upload Handling for Update ---

        if (!empty($_FILES['contract_file']['name'])) {
            $uploadDir = __DIR__ . '/../../public/uploads/contracts/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $fileName = time() . '_' . basename($_FILES['contract_file']['name']);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['contract_file']['tmp_name'], $targetPath)) {
                $data['contract_url'] = '/uploads/contracts/' . $fileName;
            }
        }

        $projectModel = new Project();
        $projectModel->update($id, $data);
        
        $projectModel->logActivity($id, 'admin_update', 'Admin atualizou dados do projeto (Financeiro, Datas ou Metas).');

        header("Location: /admin/projects/show?id=" . $id);
        exit;
    }

    public function finance() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: /admin");
            exit;
        }

        $projectModel = new Project();
        $project = $projectModel->find($id);

        if (!$project) {
            header("Location: /admin");
            exit;
        }

        $this->view('admin/projects/finance', ['project' => $project], 'admin_layout');
    }

    public function updateFinance() {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header("Location: /admin");
            exit;
        }

        $data = [
            'project_value' => $_POST['project_value'] ?? 0.00,
            'payment_method' => $_POST['payment_method'] ?? 'Pix',
            'installments' => $_POST['installments'] ?? 1,
            'installments_paid' => $_POST['installments_paid'] ?? 0
        ];

        $projectModel = new Project();
        $projectModel->update($id, $data);

        header("Location: /admin/projects/finance?id=" . $id . "&success=1");
        exit;
    }

    public function feedback() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: /admin");
            exit;
        }

        $projectModel = new Project();
        $project = $projectModel->find($id);
        
        if (!$project) {
            header("Location: /admin");
            exit;
        }

        $clientModel = new \App\Models\Client();
        $client = $clientModel->find($project['client_id']);

        // Fetch Feedback Log
        $pdo = \App\Core\Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM project_feedback WHERE project_id = :pid ORDER BY created_at DESC");
        $stmt->execute([':pid' => $id]);
        $feedbacks = $stmt->fetchAll();

        // Fetch Timeline Events for Tasks View
        $events = $projectModel->getEvents($id);
        
        // Calculate Deadline/Health
        $deadline = $project['deadline'] ?? null;
        $daysRemaining = $deadline ? ceil((strtotime($deadline) - time()) / 86400) : 0;
        
        // Group Events by Phase (naive grouping based on order or metadata, here just list)
        // Ideally we map them to phases. For now pass raw events.

        $this->view('admin/projects/feedback', [
            'project' => $project,
            'client' => $client,
            'feedbacks' => $feedbacks,
            'events' => $events,
            'daysRemaining' => $daysRemaining
        ], 'admin_layout');
    }

    public function show() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: /admin");
            exit;
        }

        $projectModel = new Project();
        $project = $projectModel->find($id);
        $events = $projectModel->getEvents($id);

        // --- KPI Logic (Synced with ClientController) ---
        $startDate = strtotime($project['start_date'] ?? date('Y-m-d'));
        $deadline = strtotime($project['deadline'] ?? date('Y-m-d', strtotime('+30 days')));
        $now = time();

        $totalDays = max(1, ($deadline - $startDate) / (60 * 60 * 24));
        $daysPassed = max(0, ($now - $startDate) / (60 * 60 * 24));
        $daysRemaining = max(0, ceil($totalDays - $daysPassed));

        // Dynamic Phases Logic
        $allPhasesOrder = ['discovery', 'design', 'build', 'test', 'launch'];
        $phaseLabels = [
            'discovery' => 'Descoberta',
            'design' => 'Design',
            'build' => 'Desenvolvimento',
            'test' => 'Testes',
            'launch' => 'Lançamento'
        ];
        
        $currentPhaseKey = $project['current_phase'] ?? 'discovery';
        $foundActive = false;
        
        $phases = [];
        foreach ($allPhasesOrder as $key) {
            $status = 'pending';
            
            // If we found the active one, subsequent ones remain pending.
            // If we haven't found it yet, the current one is either completed (if not active) or active (if match).
            
            if ($key === $currentPhaseKey) {
                $status = 'active';
                $foundActive = true;
            } elseif (!$foundActive) {
                $status = 'completed';
            }
            
            $phases[] = [
                'id' => $key,
                'name' => $phaseLabels[$key],
                'status' => $status
            ];
        }

        $kpiEvents = array_filter($events, fn($e) => $e['type'] === 'CHECKPOINT');

        $kpis = [
            'days_remaining' => $daysRemaining,
            'total_tasks' => $project['custom_total_items'] ?? count($kpiEvents), 
            'done_tasks' => $project['custom_completed_items'] ?? count(array_filter($kpiEvents, fn($e) => $e['status'] === 'done')),
            'health' => $project['health_status'] ?? 'on_track', // 'on_track', 'at_risk', 'off_track'
            'progress' => $project['custom_progress'] ?? round((count(array_filter($kpiEvents, fn($e) => $e['status'] === 'done')) / max(1, count($kpiEvents))) * 100),
            'budget' => ['total' => $project['project_value'] ?? 0, 'spent' => 0] 
        ];
        
        $this->view('admin/projects/show', [
            'project' => $project, 
            'events' => $events,
            'kpis' => $kpis,
            'phases' => $phases
        ], 'admin_layout');
    }

    public function storeEvent() {
        $projectId = $_POST['project_id'] ?? '';
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $type = $_POST['type'] ?? 'MICRO';
        $status = $_POST['status'] ?? 'done';
        $progress = $_POST['progress_percent'] ?? 0;
        $tags = $_POST['tags'] ?? '';
        $isPinned = isset($_POST['is_pinned']) ? 1 : 0;
        $mermaid = $_POST['mermaid'] ?? '';
        
        // Dynamic Meta Fields
        $style = $_POST['style'] ?? 'info';
        $btnLabel = $_POST['btn_label'] ?? 'Acessar';

        // Prepare metadata JSON
        $metadata = [
            'progress_percent' => $progress,
            'tags' => array_map('trim', explode(',', $tags)),
            'is_pinned' => $isPinned,
            'mermaid' => $mermaid,
            'style' => $style,
            'btn_label' => $btnLabel,
            'images' => [] // Will handle uploads later
        ];

        // Handle Image Uploads
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = __DIR__ . '/../../public/uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                $name = time() . '_' . $_FILES['images']['name'][$key];
                if (move_uploaded_file($tmpName, $uploadDir . $name)) {
                    $metadata['images'][] = '/uploads/' . $name;
                }
            }
        }

        $projectModel = new Project();
        $projectModel->createEvent([
            'project_id' => $projectId,
            'title' => $title,
            'description' => $description,
            'type' => $type,
            'status' => $status,
            'completed_at' => $status === 'done' ? date('Y-m-d H:i:s') : null,
            'metadata' => json_encode($metadata)
        ]);
        
        // Send email notification to client
        $this->sendEventEmail($projectId, [
            'title' => $title,
            'description' => $description,
            'type' => $type
        ]);
        
        $projectModel->logActivity($projectId, 'admin_event', "Adicionou evento ($type): $title");

        header("Location: /admin/projects/show?id=" . $projectId);
        exit;
    }

    public function deleteEvent() {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header("Location: /admin");
            exit;
        }

        $projectModel = new Project();
        
        // Get event to find project_id for redirect
        $stmt = \App\Core\Database::getInstance()->prepare("SELECT project_id FROM timeline_events WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $event = $stmt->fetch();
        
        if ($event) {
            $projectModel->deleteEvent($id);
            header("Location: /admin/projects/show?id=" . $event['project_id']);
        } else {
            header("Location: /admin");
        }
        exit;
    }

    public function showClient() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: /admin/clients");
            exit;
        }

        $clientModel = new \App\Models\Client();
        $client = $clientModel->find($id);

        if (!$client) {
            header("Location: /admin/clients");
            exit;
        }

        $projectModel = new Project();
        $projects = $projectModel->getByClient($id);

        $this->view('admin/clients/show', [
            'client' => $client,
            'projects' => $projects
        ], 'admin_layout');
    }

    public function clients() { 
        $clientModel = new \App\Models\Client();
        $clients = $clientModel->getAll();
        $this->view('admin/clients/index', ['clients' => $clients], 'admin_layout');
    }

    public function createClient() {
        $this->view('admin/clients/create', [], 'admin_layout');
    }

    public function storeClient() {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        $pdo = \App\Core\Database::getInstance();
        $stmt = $pdo->prepare("INSERT INTO clients (name, email, password_hash, access_token) VALUES (:name, :email, :password_hash, :token)");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password_hash' => $passwordHash,
            ':token' => 'op_' . bin2hex(random_bytes(4)) // Keep for legacy/internal ref
        ]);
        
        header("Location: /admin/clients");
        exit;
    }

    public function deleteClient() {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header("Location: /admin/clients");
            exit;
        }

        $pdo = \App\Core\Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM clients WHERE id = :id");
        $stmt->execute([':id' => $id]);

        header("Location: /admin/clients");
        exit;
    }

    public function login() {
        $this->view('admin/login');
    }

    public function authenticate() {
        // Mock authentication for now
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if ($email === 'admin@operon.com' && $password === 'admin123') {
            $_SESSION['user_id'] = 1;
            $_SESSION['admin_logged_in'] = true;
            header("Location: /admin");
            exit;
        }
        
        header("Location: /login?error=1");
        exit;
    }
    public function updatePhase() {
        $id = $_POST['project_id'] ?? null;
        $phase = $_POST['phase'] ?? null;
        
        if (!$id || !$phase) {
            // Return JSON if AJAX, or redirect if form
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                 echo json_encode(['success' => false]);
                 exit;
            }
            header("Location: /admin");
            exit;
        }

        $projectModel = new Project();
        $projectModel->update($id, ['current_phase' => $phase]);
        $projectModel->logActivity($id, 'status_change', "Fase atualizada para: " . ucfirst($phase));

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
             echo json_encode(['success' => true]);
             exit;
        }

        header("Location: /admin/projects/show?id=" . $id);
        exit;
    }

    public function updateStatus() {
        $id = $_POST['project_id'] ?? null;
        $status = $_POST['status'] ?? null;
        
        if (!$id || !$status) {
             if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                 echo json_encode(['success' => false]);
                 exit;
            }
            header("Location: /admin");
            exit;
        }

        $projectModel = new Project();
        $projectModel->update($id, ['status' => $status]);
        $projectModel->logActivity($id, 'status_change', "Status do projeto alterado para: " . ucfirst($status));

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
             echo json_encode(['success' => true]);
             exit;
        }

        header("Location: /admin");
        exit;
    }



    public function deleteProject() {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header("Location: /admin");
            exit;
        }

        $projectModel = new Project();
        
        // Delete related data first (optional if CASCADE is set in DB, but good to be explicit/safe)
        $pdo = \App\Core\Database::getInstance();
        $pdo->prepare("DELETE FROM timeline_events WHERE project_id = :id")->execute([':id' => $id]);
        $pdo->prepare("DELETE FROM project_feedback WHERE project_id = :id")->execute([':id' => $id]);
        
        // Delete Project
        $pdo->prepare("DELETE FROM projects WHERE id = :id")->execute([':id' => $id]);

        header("Location: /admin");
        exit;
    }

    public function updateNextAction() {
        $projectId = $_POST['project_id'] ?? null;
        if (!$projectId) {
            header("Location: /admin");
            exit;
        }

        $nextAction = $_POST['next_action'] ?? null;
        $nextActionLink = $_POST['next_action_link'] ?? null;
        $nextActionDeadline = $_POST['next_action_deadline'] ?? null;
        $nextActionType = $_POST['next_action_type'] ?? 'info';

        $projectModel = new Project();

        // Handle Poll Data
        $nextActionData = null;
        if($nextActionType === 'poll') {
            $optionsRaw = $_POST['poll_options'] ?? '';
            $options = array_filter(array_map('trim', explode("\n", $optionsRaw)));
            
            // Preserve existing votes if possible
            $currentProject = $projectModel->find($projectId);
            $currentData = json_decode($currentProject['next_action_data'] ?? '{}', true);
            $currentVotes = $currentData['votes'] ?? [];

            $nextActionData = json_encode([
                'options' => array_values($options),
                'votes' => $currentVotes // Keep old votes (naively)
            ]);
        }

        $projectModel->update($projectId, [
            'next_action' => $nextAction,
            'next_action_link' => $nextActionLink,
            'next_action_deadline' => $nextActionDeadline,
            'next_action_type' => $nextActionType,
            'next_action_data' => $nextActionData
        ]);
        
        $projectModel->logActivity($projectId, 'admin_next_action', "Definiu Próxima Ação: $nextAction ($nextActionType)");

        header("Location: /admin/projects/show?id=" . $projectId);
        exit;
    }

    // =====================================================
    // CHECKPOINTS - Simplified Task Management
    // =====================================================

    public function checkpoints() {
        $projectId = $_GET['id'] ?? null;
        if (!$projectId) {
            header("Location: /admin");
            exit;
        }

        $projectModel = new Project();
        $project = $projectModel->find($projectId);
        
        if (!$project) {
            header("Location: /admin");
            exit;
        }

        $checkpoints = $projectModel->getCheckpoints($projectId);
        $progress = $projectModel->calculateProgress($projectId);

        $this->view('admin/projects/checkpoints', [
            'project' => $project,
            'checkpoints' => $checkpoints,
            'progress' => $progress
        ], 'admin_layout');
    }

    public function storeCheckpoint() {
        $projectId = $_POST['project_id'] ?? null;
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? 'Checkpoint de entrega';
        $deadline = $_POST['deadline'] ?? null;

        if (!$projectId || !$title) {
            header("Location: /admin");
            exit;
        }

        // Use default description if empty
        if (empty(trim($description))) {
            $description = 'Checkpoint de entrega';
        }

        $projectModel = new Project();
        $projectModel->createEvent([
            'project_id' => $projectId,
            'title' => $title,
            'description' => $description,
            'type' => 'CHECKPOINT',
            'status' => 'pending',
            'completed_at' => null,
            'metadata' => json_encode(['deadline' => $deadline])
        ]);

        // Send email notification
        $this->sendEventEmail($projectId, [
            'title' => $title,
            'description' => $description,
            'type' => 'CHECKPOINT'
        ]);

        $projectModel->logActivity($projectId, 'admin_checkpoint', "Adicionou checkpoint: $title");

        header("Location: /admin/projects/checkpoints?id=" . $projectId);
        exit;
    }

    public function toggleCheckpoint() {
        $id = $_POST['id'] ?? null;
        $projectId = $_POST['project_id'] ?? null;

        if (!$id) {
            echo json_encode(['success' => false, 'error' => 'ID não fornecido']);
            return;
        }

        $projectModel = new Project();
        $newStatus = $projectModel->toggleEventStatus($id);

        if ($newStatus === null) {
            echo json_encode(['success' => false, 'error' => 'Checkpoint não encontrado']);
            return;
        }

        // Return JSON for AJAX or redirect
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $progress = $projectModel->calculateProgress($projectId);
            echo json_encode([
                'success' => true, 
                'newStatus' => $newStatus,
                'progress' => $progress
            ]);
        } else {
            header("Location: /admin/projects/checkpoints?id=" . $projectId);
            exit;
        }
    }

    public function deleteCheckpoint() {
        $id = $_POST['id'] ?? null;
        $projectId = $_POST['project_id'] ?? null;

        if (!$id) {
            header("Location: /admin");
            exit;
        }

        $projectModel = new Project();
        $projectModel->deleteEvent($id);
        $projectModel->logActivity($projectId, 'admin_checkpoint', "Removeu checkpoint");

        header("Location: /admin/projects/checkpoints?id=" . $projectId);
        exit;
    }

    // =====================================================
    // EMAIL NOTIFICATION HELPER
    // =====================================================

    private function sendEventEmail($projectId, $event) {
        try {
            $projectModel = new Project();
            $project = $projectModel->find($projectId);
            
            if (!$project) return;

            $clientModel = new \App\Models\Client();
            $client = $clientModel->find($project['client_id']);

            if (!$client || empty($client['email'])) return;

            $emailService = new \App\Core\EmailService();
            $locale = $project['locale'] ?? 'pt-BR';

            $emailService->sendEventNotification(
                $client['email'],
                $client['name'],
                $project['name'],
                $event,
                $locale
            );

        } catch (\Exception $e) {
            // Log error but don't break the flow
            error_log("Email notification failed: " . $e->getMessage());
        }
    }

    public function logs() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: /admin");
            exit;
        }

        $projectModel = new Project();
        $project = $projectModel->find($id);

        if (!$project) {
            header("Location: /admin");
            exit;
        }

        // Fetch Logs (Events)
        $events = $projectModel->getTimeline($id);
        
        // Fetch Tickets
        $ticketModel = new \App\Models\Ticket();
        $tickets = $ticketModel->getByProject($id);

        // Fetch Feedback
        $pdo = \App\Core\Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM project_feedback WHERE project_id = :id ORDER BY created_at DESC");
        $stmt->execute([':id' => $id]);
        $feedbacks = $stmt->fetchAll();

        // Combine logs if user wants unified view, but passing separate works well for UI sections
        $this->view('admin/projects/logs', [
            'project' => $project,
            'events' => $events,
            'tickets' => $tickets,
            'feedbacks' => $feedbacks
        ], 'admin_layout');
    }
}
