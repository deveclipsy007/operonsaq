<?php
/**
 * Operon Cortex - Conexão com Banco de Dados
 * Singleton pattern para conexão MySQL/SQLite
 */

require_once __DIR__ . '/config.php';

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        try {
            if (DB_TYPE === 'mysql') {
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
                ];
                $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            } else {
                // SQLite fallback para desenvolvimento
                $dbPath = __DIR__ . '/operon.sqlite';
                $this->pdo = new PDO('sqlite:' . $dbPath);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            if (APP_ENV === 'production') {
                die("Erro de conexão com o banco de dados.");
            } else {
                die("Database Error: " . $e->getMessage());
            }
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}

// Função helper para queries rápidas
function db() {
    return Database::getInstance();
}
