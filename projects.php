<?php
/**
 * Operon Cortex - Lista de Projetos (Board)
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/layout.php';

requireAdmin();

// Processar ações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? null;
    
    if ($action === 'delete' && $id) {
        // Deletar projeto e dados relacionados
        db()->prepare("DELETE FROM timeline_events WHERE project_id = ?")->execute([$id]);
        db()->prepare("DELETE FROM project_feedback WHERE project_id = ?")->execute([$id]);
        db()->prepare("DELETE FROM projects WHERE id = ?")->execute([$id]);
        flash('Projeto excluído com sucesso.', 'success');
        redirect('projects.php');
    }
    
    if ($action === 'update_status' && $id) {
        $status = $_POST['status'] ?? 'active';
        db()->prepare("UPDATE projects SET status = ? WHERE id = ?")->execute([$status, $id]);
        flash('Status atualizado.', 'success');
        redirect('projects.php');
    }
}

// Buscar projetos agrupados por status
$projects = db()->query("
    SELECT p.*, c.name as client_name 
    FROM projects p 
    LEFT JOIN clients c ON p.client_id = c.id 
    WHERE p.status != 'archived'
    ORDER BY p.created_at DESC
")->fetchAll();

$columns = [
    'active' => ['label' => 'Em Andamento', 'color' => 'emerald', 'projects' => []],
    'paused' => ['label' => 'Pausados', 'color' => 'amber', 'projects' => []],
    'completed' => ['label' => 'Concluídos', 'color' => 'indigo', 'projects' => []]
];

foreach ($projects as $project) {
    $status = $project['status'] ?? 'active';
    if (isset($columns[$status])) {
        $columns[$status]['projects'][] = $project;
    }
}

ob_start();
?>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Projetos</h1>
            <p class="text-slate-500">Board Neural - Gerencie todos os projetos</p>
        </div>
        <a href="project_create.php" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-sm font-medium">
            + Novo Projeto
        </a>
    </div>
    
    <!-- Kanban Board -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php foreach ($columns as $status => $column): ?>
        <div class="bg-dark-card border border-dark-border rounded-xl overflow-hidden">
            <div class="px-4 py-3 border-b border-dark-border flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-<?= $column['color'] ?>-500"></span>
                <span class="font-medium"><?= $column['label'] ?></span>
                <span class="ml-auto text-xs text-slate-500"><?= count($column['projects']) ?></span>
            </div>
            
            <div class="p-3 space-y-3 min-h-[200px]">
                <?php if (empty($column['projects'])): ?>
                <div class="text-center text-slate-500 text-sm py-8">
                    Nenhum projeto
                </div>
                <?php endif; ?>
                
                <?php foreach ($column['projects'] as $project): ?>
                <div class="bg-dark-bg border border-dark-border rounded-lg p-4 hover:border-indigo-500/50 transition-colors" 
                     x-data="{ open: false }">
                    <div class="flex justify-between items-start">
                        <a href="project_show.php?id=<?= $project['id'] ?>" class="font-medium hover:text-indigo-400">
                            <?= htmlspecialchars($project['name']) ?>
                        </a>
                        <div class="relative">
                            <button @click="open = !open" class="text-slate-500 hover:text-white">⋮</button>
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 top-6 bg-dark-card border border-dark-border rounded-lg shadow-lg py-1 w-32 z-10">
                                <a href="project_show.php?id=<?= $project['id'] ?>" class="block px-3 py-1.5 text-sm hover:bg-white/5">Ver</a>
                                <a href="project_edit.php?id=<?= $project['id'] ?>" class="block px-3 py-1.5 text-sm hover:bg-white/5">Editar</a>
                                <form method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $project['id'] ?>">
                                    <button type="submit" class="w-full text-left px-3 py-1.5 text-sm text-red-400 hover:bg-red-500/10">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="text-sm text-slate-500 mt-1"><?= htmlspecialchars($project['client_name'] ?? 'Sem cliente') ?></div>
                    <?php if ($project['deadline']): ?>
                    <div class="text-xs text-slate-600 mt-2">📅 <?= date('d/m/Y', strtotime($project['deadline'])) ?></div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
renderAdminLayout('Projetos', $content, 'projects');
