<?php
/**
 * Operon Cortex - Lista de Clientes
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/layout.php';

requireAdmin();

// Processar ações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? null;
    
    if ($action === 'delete' && $id) {
        // Deletar cliente e projetos relacionados
        $projects = db()->prepare("SELECT id FROM projects WHERE client_id = ?");
        $projects->execute([$id]);
        foreach ($projects->fetchAll() as $p) {
            db()->prepare("DELETE FROM timeline_events WHERE project_id = ?")->execute([$p['id']]);
            db()->prepare("DELETE FROM project_feedback WHERE project_id = ?")->execute([$p['id']]);
        }
        db()->prepare("DELETE FROM projects WHERE client_id = ?")->execute([$id]);
        db()->prepare("DELETE FROM clients WHERE id = ?")->execute([$id]);
        flash('Cliente e seus projetos foram excluídos.', 'success');
        redirect('clients.php');
    }
}

// Buscar clientes
$clients = db()->query("
    SELECT c.*, COUNT(p.id) as project_count 
    FROM clients c 
    LEFT JOIN projects p ON c.id = p.client_id 
    GROUP BY c.id 
    ORDER BY c.created_at DESC
")->fetchAll();

ob_start();
?>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Clientes</h1>
            <p class="text-slate-500">Rede Neural - Todos os clientes cadastrados</p>
        </div>
        <a href="client_create.php" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-sm font-medium">
            + Novo Cliente
        </a>
    </div>
    
    <!-- Grid de Clientes -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php if (empty($clients)): ?>
        <div class="col-span-full bg-dark-card border border-dark-border rounded-xl p-8 text-center text-slate-500">
            Nenhum cliente cadastrado. <a href="client_create.php" class="text-indigo-400 hover:underline">Criar primeiro cliente</a>
        </div>
        <?php endif; ?>
        
        <?php foreach ($clients as $client): ?>
        <div class="bg-dark-card border border-dark-border rounded-xl p-6 hover:border-indigo-500/50 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-lg font-bold">
                    <?= strtoupper(substr($client['name'], 0, 1)) ?>
                </div>
                <form method="POST" onsubmit="return confirm('ATENÇÃO: Isso excluirá o cliente E todos os projetos dele. Continuar?');">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $client['id'] ?>">
                    <button type="submit" class="text-slate-500 hover:text-red-400 text-sm">🗑️</button>
                </form>
            </div>
            
            <h3 class="font-semibold text-lg mb-1"><?= htmlspecialchars($client['name']) ?></h3>
            <p class="text-sm text-slate-500 mb-4"><?= htmlspecialchars($client['email']) ?></p>
            
            <div class="flex items-center justify-between text-sm">
                <span class="text-slate-500"><?= $client['project_count'] ?> projeto(s)</span>
                <a href="client_show.php?id=<?= $client['id'] ?>" class="text-indigo-400 hover:text-indigo-300">Ver detalhes →</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
renderAdminLayout('Clientes', $content, 'clients');
