<?php
session_start();

// Load Environment Variables from .env file
// Tenta múltiplos caminhos para compatibilidade com diferentes estruturas de deploy
$possibleEnvPaths = [
    __DIR__ . '/../.env',           // Estrutura padrão: public/index.php -> raiz/.env
    __DIR__ . '/.env',              // Caso .env esteja na pasta public
    dirname(__DIR__) . '/.env',     // Alternativa: um nível acima
];

$envLoaded = false;
foreach ($possibleEnvPaths as $envFile) {
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            if (strpos($line, '=') === false) continue;
            list($name, $value) = explode('=', $line, 2);
            putenv(trim($name) . '=' . trim($value));
        }
        $envLoaded = true;
        break;
    }
}

// Log de erro se .env não for encontrado (útil para debug em produção)
if (!$envLoaded) {
    error_log('[Operon Cortex] CRITICAL: .env file not found. Searched paths: ' . implode(', ', $possibleEnvPaths));
}

// Error Reporting based on Environment
if (getenv('APP_ENV') === 'production') {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
} else {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

use App\Controllers\AdminController;
use App\Controllers\ClientController;
use App\Controllers\SupportController;

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Core\Router;
use App\Core\Database;

// Initialize Router
$router = new Router();

// Test Route
$router->get('/', function() {
    echo <<<HTML
    <!DOCTYPE html>
    <html lang='pt-BR'>
    <head>
        <meta charset='UTF-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            slate: { 50: '#f8fafc', 500: '#64748b', 800: '#1e293b' },
                            indigo: { 600: '#4f46e5' },
                            emerald: { 500: '#10b981', 600: '#059669' }
                        },
                        animation: { 'fade-in': 'fadeIn 0.5s ease-out forwards' },
                        keyframes: {
                            fadeIn: {
                                '0%': { opacity: '0', transform: 'translateY(10px)' },
                                '100%': { opacity: '1', transform: 'translateY(0)' }
                            }
                        }
                    }
                }
            }
        </script>
    </head>
    <body class='bg-slate-50 flex items-center justify-center h-screen'>
        <div class='text-center fade-in'>
            <h1 class='text-4xl font-bold text-indigo-600 mb-2'>Operon Cortex</h1>
            <p class='text-slate-500'>Sistema Nervoso Central Ativo.</p>
            <div class='mt-4 p-2 bg-emerald-100 text-emerald-700 rounded text-xs inline-block'>
                Status: Homeostase
            </div>
            <div class='mt-8'>
                <a href='/admin' class='text-indigo-600 hover:text-indigo-800 underline'>Acessar Painel Admin</a>
            </div>
        </div>
    </body>
    </html>
HTML;
});

// Database Connection Test Route
$router->get('/test-db', function() {
    try {
        $db = Database::getInstance();
        echo "Conexão com Banco de Dados: <strong style='color:green'>SUCESSO</strong>";
    } catch (Exception $e) {
        echo "Conexão com Banco de Dados: <strong style='color:red'>ERRO</strong> - " . $e->getMessage();
    }
});


// Admin Route
$router->get('/admin', [AdminController::class, 'index']);
$router->get('/admin/dashboard', [AdminController::class, 'index']);
$router->get('/admin/projects', [AdminController::class, 'projects']);
$router->get('/admin/projects/create', [AdminController::class, 'create']);
$router->post('/admin/projects/store', [AdminController::class, 'store']);
$router->get('/admin/projects/edit', [AdminController::class, 'edit']);
$router->post('/admin/projects/update', [AdminController::class, 'update']);
$router->get('/admin/projects/show', [AdminController::class, 'show']);
$router->get('/admin/projects/finance', [AdminController::class, 'finance']);
$router->post('/admin/projects/finance/update', [AdminController::class, 'updateFinance']);
$router->get('/admin/projects/feedback', [AdminController::class, 'feedback']);
$router->post('/admin/projects/updatePhase', [AdminController::class, 'updatePhase']);
$router->post('/admin/projects/updateStatus', [AdminController::class, 'updateStatus']);
$router->post('/admin/projects/events/store', [AdminController::class, 'storeEvent']);
$router->post('/admin/projects/update_next_action', [AdminController::class, 'updateNextAction']);
$router->post('/admin/projects/events/delete', [AdminController::class, 'deleteEvent']);
$router->get('/admin/projects/checkpoints', [AdminController::class, 'checkpoints']);
$router->post('/admin/projects/checkpoints/store', [AdminController::class, 'storeCheckpoint']);
$router->post('/admin/projects/checkpoints/toggle', [AdminController::class, 'toggleCheckpoint']);
$router->post('/admin/projects/checkpoints/delete', [AdminController::class, 'deleteCheckpoint']);
$router->get('/admin/clients', [AdminController::class, 'clients']);
$router->get('/admin/clients/create', [AdminController::class, 'createClient']);
$router->post('/admin/clients/store', [AdminController::class, 'storeClient']);
$router->get('/admin/clients/show', [AdminController::class, 'showClient']);
$router->post('/admin/clients/delete', [AdminController::class, 'deleteClient']);
$router->post('/admin/projects/delete', [AdminController::class, 'deleteProject']);
$router->get('/admin/support', [SupportController::class, 'index']);
$router->get('/admin/support/ticket', [SupportController::class, 'ticket']);
$router->post('/admin/support/reply', [SupportController::class, 'reply']);
$router->get('/admin/projects/logs', [AdminController::class, 'logs']);

// Admin Auth
$router->get('/admin/login', [AdminController::class, 'login']);
$router->post('/admin/login', [AdminController::class, 'authenticate']);
$router->get('/admin/logout', [AdminController::class, 'logout']);

// Client Auth & Dashboard
$router->get('/login', [ClientController::class, 'login']);
$router->post('/login', [ClientController::class, 'authenticate']);
$router->get('/logout', [ClientController::class, 'logout']);
$router->get('/dashboard', [ClientController::class, 'dashboard']);
$router->get('/client/projects/documents', [ClientController::class, 'documents']);
$router->get('/client/projects/ideas', [ClientController::class, 'ideas']);
$router->post('/client/projects/ideas/store', [ClientController::class, 'storeIdea']);
$router->post('/client/projects/vote', [ClientController::class, 'vote']);
$router->post('/client/projects/rate', [ClientController::class, 'rateProject']);
$router->get('/client/projects/approve', [ClientController::class, 'approve']);
$router->get('/client/support', [ClientController::class, 'support']);
$router->post('/client/support/store', [ClientController::class, 'storeTicket']);
$router->get('/', [ClientController::class, 'index']);

// Dispatch
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
