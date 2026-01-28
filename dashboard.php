<?php
/**
 * Operon Cortex - Dashboard Admin
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/layout.php';

requireAdmin();

// Buscar estatísticas
$stats = [
    'total_clients' => db()->query("SELECT COUNT(*) FROM clients")->fetchColumn(),
    'total_projects' => db()->query("SELECT COUNT(*) FROM projects")->fetchColumn(),
    'active_projects' => db()->query("SELECT COUNT(*) FROM projects WHERE status = 'active'")->fetchColumn(),
    'open_tickets' => db()->query("SELECT COUNT(*) FROM tickets WHERE status = 'open'")->fetchColumn() ?: 0
];

// Buscar projetos recentes
$recentProjects = db()->query("
    SELECT p.*, c.name as client_name 
    FROM projects p 
    LEFT JOIN clients c ON p.client_id = c.id 
    ORDER BY p.created_at DESC 
    LIMIT 5
")->fetchAll();

ob_start();
?>

<div class="space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <p class="text-slate-500">Visão geral do sistema</p>
        </div>
        <a href="project_create.php" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-sm font-medium">
            + Novo Projeto
        </a>
    </div>
    
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-dark-card border border-dark-border rounded-xl p-6">
            <div class="text-3xl font-bold text-indigo-400"><?= $stats['total_clients'] ?></div>
            <div class="text-sm text-slate-500">Clientes</div>
        </div>
        <div class="bg-dark-card border border-dark-border rounded-xl p-6">
            <div class="text-3xl font-bold text-emerald-400"><?= $stats['total_projects'] ?></div>
            <div class="text-sm text-slate-500">Projetos</div>
        </div>
        <div class="bg-dark-card border border-dark-border rounded-xl p-6">
            <div class="text-3xl font-bold text-amber-400"><?= $stats['active_projects'] ?></div>
            <div class="text-sm text-slate-500">Em Andamento</div>
        </div>
        <div class="bg-dark-card border border-dark-border rounded-xl p-6">
            <div class="text-3xl font-bold text-rose-400"><?= $stats['open_tickets'] ?></div>
            <div class="text-sm text-slate-500">Tickets Abertos</div>
        </div>
    </div>
    
    <!-- Recent Projects -->
    <div class="bg-dark-card border border-dark-border rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-dark-border">
            <h2 class="font-semibold">Projetos Recentes</h2>
        </div>
        <div class="divide-y divide-dark-border">
            <?php if (empty($recentProjects)): ?>
            <div class="px-6 py-8 text-center text-slate-500">
                Nenhum projeto encontrado. <a href="project_create.php" class="text-indigo-400 hover:underline">Criar primeiro projeto</a>
            </div>
            <?php else: ?>
            <?php foreach ($recentProjects as $project): ?>
            <a href="project_show.php?id=<?= $project['id'] ?>" class="block px-6 py-4 hover:bg-white/5 transition-colors">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="font-medium"><?= htmlspecialchars($project['name']) ?></div>
                        <div class="text-sm text-slate-500"><?= htmlspecialchars($project['client_name'] ?? 'Sem cliente') ?></div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-2 py-1 text-xs rounded-full <?= $project['status'] === 'active' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-slate-500/20 text-slate-400' ?>">
                            <?= ucfirst($project['status']) ?>
                        </span>
                        <span class="text-slate-500 text-sm">→</span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
renderAdminLayout('Dashboard', $content, 'dashboard');
