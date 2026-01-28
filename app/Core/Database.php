<?php

namespace App\Core;

use PDO;
use PDOException;
use Exception;

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        // Forçamos o recarregamento das variáveis para garantir que pegamos o .env mais recente
        $appEnv = getenv('APP_ENV');
        $dbType = getenv('DB_TYPE');

        // VALIDAÇÃO CRÍTICA: Se não houver APP_ENV, o .env provavelmente não carregou
        if (!$appEnv) {
            $this->fail("O arquivo .env não foi carregado corretamente ou está vazio. Sem ele, o sistema não sabe como conectar ao MySQL.");
        }

        // BLOQUEIO DE SEGURANÇA: Se estiver em produção, MySQL é obrigatório.
        if ($appEnv === 'production' && $dbType !== 'mysql') {
            $this->fail("ERRO DE CONFIGURAÇÃO: Em modo de produção (APP_ENV=production), o DB_TYPE deve ser obrigatoriamente 'mysql'. O sistema detectou '$dbType' ou nada.");
        }

        if ($dbType === 'mysql') {
            $this->connectMySQL();
        } elseif ($dbType === 'sqlite' && $appEnv !== 'production') {
            $this->connectSQLite();
        } else {
            $this->fail("Tipo de banco de dados '$dbType' inválido para o ambiente '$appEnv'.");
        }
    }

    private function connectMySQL(): void {
        $host = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASS');

        if (!$host || !$dbname || !$user) {
            $this->fail("Credenciais MySQL incompletas no .env (Host: $host, DB: $dbname, User: $user).");
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
            $this->fail("Falha na conexão MySQL: " . $e->getMessage());
        }
    }

    private function connectSQLite(): void {
        try {
            $dbPath = __DIR__ . '/../../database/operon.sqlite';
            if (!file_exists($dbPath)) {
                $this->fail("Arquivo de banco de dados SQLite não encontrado em: $dbPath");
            }
            $this->pdo = new PDO('sqlite:' . $dbPath);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->fail("Falha na conexão SQLite: " . $e->getMessage());
        }
    }

    private function fail(string $message): void {
        $appEnv = getenv('APP_ENV') ?: 'production';
        
        // Log interno sempre ocorre
        error_log("[Database Error] " . $message);

        // Se for produção, mostramos mensagem genérica amigável
        if ($appEnv === 'production') {
            die("<div style='font-family:sans-serif; padding:50px; text-align:center;'>
                <h1 style='color:#e11d48;'>Erro de Conexão</h1>
                <p>Não foi possível conectar ao banco de dados. Por favor, verifique as configurações do servidor.</p>
                <p style='color:#64748b; font-size:0.8rem;'>Dica para o Desenvolvedor: Verifique o arquivo .env</p>
            </div>");
        }

        // Se for desenvolvimento, mostramos o erro real na tela
        die("<div style='font-family:monospace; background:#fff1f2; color:#be123c; border:2px solid #fb7185; padding:20px; border-radius:8px;'>
            <h2 style='margin-top:0;'>🛑 Database Connection Error</h2>
            <p><strong>Message:</strong> $message</p>
            <p style='font-size:0.9rem; color:#4b5563;'>Nota: Este erro detalhado só aparece por que APP_ENV não é 'production'.</p>
        </div>");
    }

    public static function getInstance(): PDO {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }

    public static function diagnose(): array {
        return [
            'APP_ENV' => getenv('APP_ENV'),
            'DB_TYPE' => getenv('DB_TYPE'),
            'DB_HOST' => getenv('DB_HOST') ? 'DEFINIDO' : 'NÃO DEFINIDO',
            'DB_NAME' => getenv('DB_NAME') ?: 'NÃO DEFINIDO',
            'PDO_LOADED' => extension_loaded('pdo_mysql'),
        ];
    }
}
