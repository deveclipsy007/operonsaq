<?php
// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) require $file;
});

// Load .env
putenv('APP_ENV=local');
putenv('DB_TYPE=sqlite');

use App\Core\Database;

try {
    $pdo = Database::getInstance();
    
    // Add cover_url column to projects table
    $pdo->exec("ALTER TABLE projects ADD COLUMN cover_url TEXT DEFAULT NULL");
    
    echo "Coluna 'cover_url' adicionada com sucesso!\n";
} catch (Exception $e) {
    echo "Erro ao adicionar coluna: " . $e->getMessage() . "\n";
}
