<?php

namespace App\Core;

use PDO;
use PDOException;
use Exception;

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $appEnv = getenv('APP_ENV') ?: 'development';
        $dbType = getenv('DB_TYPE');
        
        // PRODUÇÃO: MySQL é OBRIGATÓRIO
        if ($appEnv === 'production') {
            $this->connectMySQL();
            return;
        }
        
        // DESENVOLVIMENTO: Respeita DB_TYPE ou usa SQLite como padrão
        if ($dbType === 'mysql') {
            $this->connectMySQL();
        } else {
            $this->connectSQLite();
        }
    }

    private function connectMySQL(): void {
        $host = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASS');
        
        // Validação de credenciais obrigatórias
        $missing = [];
        if (empty($host)) $missing[] = 'DB_HOST';
        if (empty($dbname)) $missing[] = 'DB_NAME';
        if (empty($user)) $missing[] = 'DB_USER';
        if ($pass === false) $missing[] = 'DB_PASS';
        
        if (!empty($missing)) {
            $this->fail('Credenciais MySQL ausentes: ' . implode(', ', $missing) . 
                       '. Verifique se o arquivo .env existe e foi carregado.');
        }
        
        try {
            $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ];
            
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            $this->fail('Falha na conexão MySQL: ' . $e->getMessage());
        }
    }

    private function connectSQLite(): void {
        try {
            $dbPath = __DIR__ . '/../../database/operon.sqlite';
            $this->pdo = new PDO('sqlite:' . $dbPath);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->fail('Falha na conexão SQLite: ' . $e->getMessage());
        }
    }

    private function fail(string $message): void {
        $appEnv = getenv('APP_ENV') ?: 'development';
        if ($appEnv === 'production') {
            error_log('[Database] ' . $message);
            die('Erro de conexão com o banco de dados. Contate o administrador.');
        }
        die('[Database Error] ' . $message);
    }

    public static function getInstance(): PDO {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }

    /**
     * Diagnóstico: Retorna status da configuração atual
     */
    public static function diagnose(): array {
        return [
            'APP_ENV' => getenv('APP_ENV') ?: 'NOT SET',
            'DB_TYPE' => getenv('DB_TYPE') ?: 'NOT SET',
            'DB_HOST' => getenv('DB_HOST') ? 'SET' : 'NOT SET',
            'DB_NAME' => getenv('DB_NAME') ?: 'NOT SET',
            'DB_USER' => getenv('DB_USER') ? 'SET' : 'NOT SET',
            'DB_PASS' => getenv('DB_PASS') !== false ? 'SET' : 'NOT SET',
            'env_file_loaded' => getenv('APP_ENV') !== false,
        ];
    }
}
