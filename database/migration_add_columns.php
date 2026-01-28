<?php

$dbPath = __DIR__ . '/operon.sqlite';
$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Iniciando migração de colunas...\n";

$columnsToAdd = [
    'provisional_url' => 'TEXT',
    'definitive_url' => 'TEXT',
    'featured_message' => 'TEXT'
];

foreach ($columnsToAdd as $column => $type) {
    try {
        $pdo->exec("ALTER TABLE projects ADD COLUMN $column $type");
        echo "Coluna '$column' adicionada com sucesso.\n";
    } catch (PDOException $e) {
        // SQLite throws error if column exists (usually "duplicate column name")
        // We can ignore it if it already exists, or print a message
        if (strpos($e->getMessage(), 'duplicate column name') !== false) {
            echo "Coluna '$column' já existe.\n";
        } else {
            echo "Erro ao adicionar '$column': " . $e->getMessage() . "\n";
        }
    }
}

echo "Migração concluída!\n";
