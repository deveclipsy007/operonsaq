<?php
require_once __DIR__ . '/public/index.php'; // Bootstrap app to get DB connection

use App\Core\Database;

$pdo = Database::getInstance();

echo "Iniciando migração de tickets...\n";

// 1. Add category to tickets
try {
    $pdo->exec("ALTER TABLE tickets ADD COLUMN category VARCHAR(50) DEFAULT 'general'");
    echo "✅ Coluna 'category' adicionada em 'tickets'.\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column') !== false) {
        echo "ℹ️ Coluna 'category' já existe em 'tickets'.\n";
    } else {
        echo "❌ Erro ao adicionar 'category': " . $e->getMessage() . "\n";
    }
}

// 2. Add client_read to tickets
try {
    $pdo->exec("ALTER TABLE tickets ADD COLUMN client_read TINYINT(1) DEFAULT 1");
    echo "✅ Coluna 'client_read' adicionada em 'tickets'.\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column') !== false) {
        echo "ℹ️ Coluna 'client_read' já existe em 'tickets'.\n";
    } else {
        echo "❌ Erro ao adicionar 'client_read': " . $e->getMessage() . "\n";
    }
}

// 3. Add ticket_id to ticket_attachments if missing (critical fix)
try {
    // Attempt to add column directly. SQLite supports ADD COLUMN.
    $pdo->exec("ALTER TABLE ticket_attachments ADD COLUMN ticket_id INT NOT NULL DEFAULT 0");
    echo "✅ Coluna 'ticket_id' adicionada em 'ticket_attachments'.\n";
    
    // SQLite doesn't support adding FKs via ALTER TABLE comfortably in all versions, 
    // but we can try or skip since it's dev env. 
    // For Hostinger, the schema_mysql.sql is the source of truth.
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'duplicate column') !== false || strpos($e->getMessage(), 'Duplicate column') !== false) {
        echo "ℹ️ Coluna 'ticket_id' já existe em 'ticket_attachments'.\n";
    } else {
       echo "ℹ️ (ticket_attachments): " . $e->getMessage() . "\n";
    }
}

echo "Migração concluída.\n";
