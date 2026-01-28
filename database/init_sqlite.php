<?php
/**
 * Operon Cortex - Inicialização do Banco de Dados SQLite
 * Execute este script uma vez para criar o banco local
 */

$dbPath = __DIR__ . '/operon.sqlite';

// Criar ou conectar ao banco
$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Criando banco de dados SQLite...\n";

// Criar tabelas
$sql = <<<SQL

-- Tabela de Clientes
CREATE TABLE IF NOT EXISTS clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255),
    access_token VARCHAR(64) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Projetos
CREATE TABLE IF NOT EXISTS projects (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id INTEGER,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    thalamic_setting VARCHAR(20) DEFAULT 'hybrid',
    status VARCHAR(20) DEFAULT 'active',
    start_date DATE,
    deadline DATE,
    phases_count INTEGER DEFAULT 5,
    current_phase VARCHAR(50) DEFAULT 'discovery',
    project_value DECIMAL(10,2) DEFAULT 0,
    payment_method VARCHAR(50),
    installments INTEGER DEFAULT 1,
    installments_paid INTEGER DEFAULT 0,
    contract_url TEXT,
    github_url TEXT,
    notes TEXT,
    health_status VARCHAR(20) DEFAULT 'healthy',
    custom_progress INTEGER,
    custom_completed_items INTEGER,
    custom_total_items INTEGER,
    next_action TEXT,
    next_action_deadline DATE,
    next_action_type VARCHAR(50),
    next_action_data TEXT,
    next_action_link TEXT,
    manager_name VARCHAR(100),
    manager_phone VARCHAR(20),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

-- Tabela de Eventos da Timeline
CREATE TABLE IF NOT EXISTS timeline_events (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    project_id INTEGER NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    type VARCHAR(10) NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    completed_at DATETIME NULL,
    metadata TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

-- Tabela de Usuários (Admin)
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Feedback
CREATE TABLE IF NOT EXISTS project_feedback (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    project_id INTEGER NOT NULL,
    client_id INTEGER,
    type VARCHAR(50) NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id),
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

-- Tabela de Ideias
CREATE TABLE IF NOT EXISTS project_ideas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    project_id INTEGER NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    status VARCHAR(20) DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

-- Tabela de Tickets
CREATE TABLE IF NOT EXISTS tickets (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    project_id INTEGER NOT NULL,
    subject VARCHAR(200) NOT NULL,
    status VARCHAR(20) DEFAULT 'open',
    priority VARCHAR(20) DEFAULT 'normal',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

-- Tabela de Mensagens de Tickets
CREATE TABLE IF NOT EXISTS ticket_messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ticket_id INTEGER NOT NULL,
    sender_type VARCHAR(20) NOT NULL,
    sender_id INTEGER,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ticket_id) REFERENCES tickets(id)
);

-- Tabela de Anexos de Tickets
CREATE TABLE IF NOT EXISTS ticket_attachments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    message_id INTEGER NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_type VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (message_id) REFERENCES ticket_messages(id)
);

SQL;

$pdo->exec($sql);
echo "Tabelas criadas com sucesso!\n";

// Inserir admin padrão
$adminEmail = 'admin@operon.com';
$adminPass = password_hash('admin123', PASSWORD_DEFAULT);

$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$adminEmail]);
if (!$stmt->fetch()) {
    $stmt = $pdo->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
    $stmt->execute([$adminEmail, $adminPass]);
    echo "Admin criado: admin@operon.com / admin123\n";
} else {
    echo "Admin já existe.\n";
}

// Inserir cliente de exemplo
$stmt = $pdo->prepare("SELECT id FROM clients WHERE email = ?");
$stmt->execute(['cliente@exemplo.com']);
if (!$stmt->fetch()) {
    $token = 'op_' . bin2hex(random_bytes(8));
    $passHash = password_hash('cliente123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO clients (name, email, password_hash, access_token) VALUES (?, ?, ?, ?)");
    $stmt->execute(['Cliente Exemplo', 'cliente@exemplo.com', $passHash, $token]);
    $clientId = $pdo->lastInsertId();
    
    // Inserir projeto de exemplo
    $stmt = $pdo->prepare("INSERT INTO projects (client_id, name, description, status, current_phase) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$clientId, 'Projeto Demo', 'Um projeto de demonstração para testar o sistema.', 'active', 'design']);
    $projectId = $pdo->lastInsertId();
    
    // Inserir eventos de exemplo
    $events = [
        ['Kickoff do Projeto', 'Reunião inicial realizada com sucesso.', 'MACRO', 'done'],
        ['Briefing Aprovado', 'Cliente aprovou o briefing.', 'MICRO', 'done'],
        ['Wireframes em Andamento', 'Criando estrutura das telas.', 'MICRO', 'in_progress'],
    ];
    foreach ($events as $e) {
        $stmt = $pdo->prepare("INSERT INTO timeline_events (project_id, title, description, type, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$projectId, $e[0], $e[1], $e[2], $e[3]]);
    }
    
    echo "Cliente e projeto de exemplo criados!\n";
} else {
    echo "Dados de exemplo já existem.\n";
}

echo "\n✅ Banco SQLite pronto em: $dbPath\n";
echo "Agora você pode rodar: php -S localhost:8000 -t public\n";
