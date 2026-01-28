<?php
/**
 * Operon Cortex - Página Inicial / Login
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/layout.php';

// Se já logado, redirecionar
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
    redirect('dashboard.php');
}
if (isset($_SESSION['client_id'])) {
    redirect('client_dashboard.php');
}

// Processar login
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $loginType = $_POST['login_type'] ?? 'client';
    
    if ($loginType === 'admin') {
        // Login Admin
        if ($email === ADMIN_EMAIL && $password === ADMIN_PASS_DEFAULT) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['user_id'] = 1;
            redirect('dashboard.php');
        } else {
            $error = 'Email ou senha incorretos.';
        }
    } else {
        // Login Cliente
        $stmt = db()->prepare("SELECT * FROM clients WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $client = $stmt->fetch();
        
        if ($client && password_verify($password, $client['password_hash'])) {
            $_SESSION['client_id'] = $client['id'];
            $_SESSION['client_name'] = $client['name'];
            redirect('client_dashboard.php');
        } else {
            $error = 'Email ou senha incorretos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Operon Cortex</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md" x-data="{ loginType: 'client' }">
        <!-- Logo -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Operon Cortex</h1>
            <p class="text-indigo-300 text-sm">Sistema Nervoso Central</p>
        </div>
        
        <!-- Toggle -->
        <div class="flex bg-white/10 rounded-lg p-1 mb-6">
            <button @click="loginType = 'client'" 
                    :class="loginType === 'client' ? 'bg-white text-indigo-600' : 'text-white'"
                    class="flex-1 py-2 rounded-md text-sm font-medium transition-all">
                Cliente
            </button>
            <button @click="loginType = 'admin'" 
                    :class="loginType === 'admin' ? 'bg-white text-indigo-600' : 'text-white'"
                    class="flex-1 py-2 rounded-md text-sm font-medium transition-all">
                Administrador
            </button>
        </div>
        
        <!-- Form -->
        <form method="POST" class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20">
            <input type="hidden" name="login_type" :value="loginType">
            
            <?php if ($error): ?>
            <div class="mb-4 p-3 bg-red-500/20 border border-red-500/50 rounded-lg text-red-200 text-sm">
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-white/70 text-sm mb-1">Email</label>
                    <input type="email" name="email" required
                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           placeholder="seu@email.com">
                </div>
                
                <div>
                    <label class="block text-white/70 text-sm mb-1">Senha</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           placeholder="••••••••">
                </div>
                
                <button type="submit" 
                        class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors">
                    Entrar
                </button>
            </div>
        </form>
        
        <!-- Footer -->
        <p class="text-center text-white/40 text-xs mt-6">
            © 2026 Operon Agents. Todos os direitos reservados.
        </p>
    </div>
</body>
</html>
