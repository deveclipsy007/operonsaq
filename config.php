<?php
/**
 * Operon Cortex - Configuração Central
 * Todas as configurações do sistema em um só lugar
 */

// ============================================
// AMBIENTE
// ============================================
define('APP_ENV', 'production'); // 'development' ou 'production'
define('APP_NAME', 'Operon Cortex');
define('APP_TIMEZONE', 'America/Sao_Paulo');

date_default_timezone_set(APP_TIMEZONE);

// ============================================
// BANCO DE DADOS (MySQL - Hostinger)
// ============================================
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'u854567422_operonsaq');
define('DB_USER', 'u854567422_hello');
define('DB_PASS', 'Escher007.');
define('DB_CHARSET', 'utf8mb4');

// ============================================
// SEGURANÇA
// ============================================
define('ADMIN_EMAIL', 'admin@operon.com');
define('ADMIN_PASS_DEFAULT', 'admin123'); // Trocar após primeiro login!

// ============================================
// ERROS
// ============================================
if (APP_ENV === 'production') {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
} else {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// ============================================
// SESSÃO
// ============================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
