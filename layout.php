<?php
/**
 * Operon Cortex - Layout Base (Admin)
 * Template HTML principal para páginas administrativas
 */

function renderAdminLayout($title, $content, $activeMenu = '') {
    $flashMessage = $_SESSION['flash_message'] ?? null;
    $flashType = $_SESSION['flash_type'] ?? 'info';
    unset($_SESSION['flash_message'], $_SESSION['flash_type']);
?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> | Operon Cortex</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            bg: '#0F1117',
                            card: '#1A1C22',
                            border: '#2A2D35'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .gradient-text { 
            background: linear-gradient(135deg, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-dark-bg text-white min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 min-h-screen bg-dark-card border-r border-dark-border p-4 fixed">
            <div class="mb-8">
                <h1 class="text-xl font-bold gradient-text">Operon Cortex</h1>
                <p class="text-xs text-slate-500">Sistema Nervoso Central</p>
            </div>
            
            <nav class="space-y-2">
                <a href="dashboard.php" class="flex items-center gap-3 px-3 py-2 rounded-lg <?= $activeMenu === 'dashboard' ? 'bg-indigo-600/20 text-indigo-400' : 'text-slate-400 hover:bg-white/5' ?>">
                    <span>📊</span> Dashboard
                </a>
                <a href="projects.php" class="flex items-center gap-3 px-3 py-2 rounded-lg <?= $activeMenu === 'projects' ? 'bg-indigo-600/20 text-indigo-400' : 'text-slate-400 hover:bg-white/5' ?>">
                    <span>🧠</span> Projetos
                </a>
                <a href="clients.php" class="flex items-center gap-3 px-3 py-2 rounded-lg <?= $activeMenu === 'clients' ? 'bg-indigo-600/20 text-indigo-400' : 'text-slate-400 hover:bg-white/5' ?>">
                    <span>👥</span> Clientes
                </a>
                <a href="support.php" class="flex items-center gap-3 px-3 py-2 rounded-lg <?= $activeMenu === 'support' ? 'bg-indigo-600/20 text-indigo-400' : 'text-slate-400 hover:bg-white/5' ?>">
                    <span>🎫</span> Suporte
                </a>
            </nav>
            
            <div class="absolute bottom-4 left-4 right-4">
                <a href="logout.php" class="flex items-center gap-2 text-sm text-slate-500 hover:text-red-400">
                    <span>🚪</span> Sair
                </a>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="ml-64 flex-1 p-8">
            <?php if ($flashMessage): ?>
            <div class="mb-4 p-4 rounded-lg <?= $flashType === 'success' ? 'bg-emerald-500/20 text-emerald-400' : ($flashType === 'error' ? 'bg-red-500/20 text-red-400' : 'bg-blue-500/20 text-blue-400') ?>">
                <?= htmlspecialchars($flashMessage) ?>
            </div>
            <?php endif; ?>
            
            <?= $content ?>
        </main>
    </div>
</body>
</html>
<?php
}

/**
 * Layout para área do cliente
 */
function renderClientLayout($title, $content, $client = null) {
    $flashMessage = $_SESSION['flash_message'] ?? null;
    $flashType = $_SESSION['flash_type'] ?? 'info';
    unset($_SESSION['flash_message'], $_SESSION['flash_type']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> | Portal do Cliente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-indigo-600">Operon Cortex</h1>
            <?php if ($client): ?>
            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-600">Olá, <?= htmlspecialchars($client['name']) ?></span>
                <a href="logout.php" class="text-sm text-red-500 hover:text-red-700">Sair</a>
            </div>
            <?php endif; ?>
        </div>
    </header>
    
    <!-- Main -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <?php if ($flashMessage): ?>
        <div class="mb-4 p-4 rounded-lg <?= $flashType === 'success' ? 'bg-emerald-100 text-emerald-700' : ($flashType === 'error' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') ?>">
            <?= htmlspecialchars($flashMessage) ?>
        </div>
        <?php endif; ?>
        
        <?= $content ?>
    </main>
</body>
</html>
<?php
}

/**
 * Helper para flash messages
 */
function flash($message, $type = 'info') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

/**
 * Helper para redirecionamento
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Helper para verificar autenticação admin
 */
function requireAdmin() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        redirect('login.php');
    }
}

/**
 * Helper para verificar autenticação cliente
 */
function requireClient() {
    if (!isset($_SESSION['client_id'])) {
        redirect('login.php');
    }
}
