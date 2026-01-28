<?php
/**
 * Operon Cortex - Criar Cliente
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/layout.php';

requireAdmin();

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Todos os campos são obrigatórios.';
    } else {
        // Verificar se email já existe
        $stmt = db()->prepare("SELECT id FROM clients WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Este email já está cadastrado.';
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $token = 'op_' . bin2hex(random_bytes(4));
            
            $stmt = db()->prepare("INSERT INTO clients (name, email, password_hash, access_token) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $passwordHash, $token]);
            
            flash('Cliente criado com sucesso!', 'success');
            redirect('clients.php');
        }
    }
}

ob_start();
?>

<div class="max-w-xl">
    <div class="mb-6">
        <a href="clients.php" class="text-slate-500 hover:text-white text-sm">← Voltar para Clientes</a>
    </div>
    
    <div class="bg-dark-card border border-dark-border rounded-xl p-6">
        <h1 class="text-xl font-bold mb-6">Novo Cliente</h1>
        
        <?php if ($error): ?>
        <div class="mb-4 p-3 bg-red-500/20 border border-red-500/50 rounded-lg text-red-400 text-sm">
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm text-slate-400 mb-1">Nome</label>
                <input type="text" name="name" required
                       class="w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-white focus:outline-none focus:border-indigo-500"
                       placeholder="Nome do cliente">
            </div>
            
            <div>
                <label class="block text-sm text-slate-400 mb-1">Email</label>
                <input type="email" name="email" required
                       class="w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-white focus:outline-none focus:border-indigo-500"
                       placeholder="email@exemplo.com">
            </div>
            
            <div>
                <label class="block text-sm text-slate-400 mb-1">Senha</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-white focus:outline-none focus:border-indigo-500"
                       placeholder="Senha de acesso">
            </div>
            
            <div class="pt-4">
                <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg font-medium">
                    Criar Cliente
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
renderAdminLayout('Novo Cliente', $content, 'clients');
