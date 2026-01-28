<?php
/**
 * Operon Cortex - Criar Projeto
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/layout.php';

requireAdmin();

// Buscar clientes para dropdown
$clients = db()->query("SELECT id, name FROM clients ORDER BY name")->fetchAll();

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientId = $_POST['client_id'] ?? null;
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $startDate = $_POST['start_date'] ?? date('Y-m-d');
    $deadline = $_POST['deadline'] ?: null;
    $projectValue = $_POST['project_value'] ?? 0;
    $phasesCount = $_POST['phases_count'] ?? 5;
    
    if (empty($name)) {
        $error = 'O nome do projeto é obrigatório.';
    } else {
        $stmt = db()->prepare("
            INSERT INTO projects (client_id, name, description, start_date, deadline, project_value, phases_count, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'active')
        ");
        $stmt->execute([$clientId, $name, $description, $startDate, $deadline, $projectValue, $phasesCount]);
        
        flash('Projeto criado com sucesso!', 'success');
        redirect('projects.php');
    }
}

ob_start();
?>

<div class="max-w-2xl">
    <div class="mb-6">
        <a href="projects.php" class="text-slate-500 hover:text-white text-sm">← Voltar para Projetos</a>
    </div>
    
    <div class="bg-dark-card border border-dark-border rounded-xl p-6">
        <h1 class="text-xl font-bold mb-6">Novo Projeto</h1>
        
        <?php if ($error): ?>
        <div class="mb-4 p-3 bg-red-500/20 border border-red-500/50 rounded-lg text-red-400 text-sm">
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm text-slate-400 mb-1">Cliente</label>
                <select name="client_id" class="w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-white">
                    <option value="">Selecione um cliente</option>
                    <?php foreach ($clients as $client): ?>
                    <option value="<?= $client['id'] ?>"><?= htmlspecialchars($client['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label class="block text-sm text-slate-400 mb-1">Nome do Projeto *</label>
                <input type="text" name="name" required
                       class="w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-white focus:outline-none focus:border-indigo-500"
                       placeholder="Ex: Website Institucional">
            </div>
            
            <div>
                <label class="block text-sm text-slate-400 mb-1">Descrição</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-white focus:outline-none focus:border-indigo-500"
                          placeholder="Descreva o projeto..."></textarea>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Data de Início</label>
                    <input type="date" name="start_date" value="<?= date('Y-m-d') ?>"
                           class="w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-white">
                </div>
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Prazo</label>
                    <input type="date" name="deadline"
                           class="w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-white">
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Valor (R$)</label>
                    <input type="number" name="project_value" step="0.01" value="0"
                           class="w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-white">
                </div>
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Número de Fases</label>
                    <input type="number" name="phases_count" value="5" min="1" max="10"
                           class="w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-white">
                </div>
            </div>
            
            <div class="pt-4">
                <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg font-medium">
                    Criar Projeto
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
renderAdminLayout('Novo Projeto', $content, 'projects');
