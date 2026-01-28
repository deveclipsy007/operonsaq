<?php
/**
 * Operon Cortex - Dashboard do Cliente
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/layout.php';

requireClient();

$clientId = $_SESSION['client_id'];

// Buscar cliente
$stmt = db()->prepare("SELECT * FROM clients WHERE id = ?");
$stmt->execute([$clientId]);
$client = $stmt->fetch();

// Buscar projeto ativo do cliente
$stmt = db()->prepare("SELECT * FROM projects WHERE client_id = ? AND status = 'active' ORDER BY created_at DESC LIMIT 1");
$stmt->execute([$clientId]);
$project = $stmt->fetch();

// Buscar eventos do projeto
$events = [];
$phases = [];
$kpis = ['progress' => 0, 'days_remaining' => 0, 'done_tasks' => 0, 'total_tasks' => 0];

if ($project) {
    $stmt = db()->prepare("SELECT * FROM timeline_events WHERE project_id = ? ORDER BY created_at DESC");
    $stmt->execute([$project['id']]);
    $events = $stmt->fetchAll();
    
    // Calcular KPIs
    $totalEvents = count($events);
    $doneEvents = count(array_filter($events, fn($e) => $e['status'] === 'done'));
    $kpis['progress'] = $totalEvents > 0 ? round(($doneEvents / $totalEvents) * 100) : 0;
    $kpis['done_tasks'] = $doneEvents;
    $kpis['total_tasks'] = $totalEvents;
    
    if ($project['deadline']) {
        $kpis['days_remaining'] = max(0, ceil((strtotime($project['deadline']) - time()) / 86400));
    }
    
    // Phases
    $allPhases = ['discovery' => 'Descoberta', 'design' => 'Design', 'build' => 'Desenvolvimento', 'test' => 'Testes', 'launch' => 'Lançamento'];
    $currentPhase = $project['current_phase'] ?? 'discovery';
    foreach ($allPhases as $key => $label) {
        $status = 'pending';
        if ($key === $currentPhase) $status = 'active';
        elseif (array_search($key, array_keys($allPhases)) < array_search($currentPhase, array_keys($allPhases))) $status = 'completed';
        $phases[] = ['id' => $key, 'name' => $label, 'status' => $status];
    }
}

ob_start();
?>

<div class="space-y-8">
    <!-- Welcome -->
    <div class="text-center py-8">
        <h1 class="text-3xl font-bold text-slate-800">Olá, <?= htmlspecialchars($client['name']) ?>! 👋</h1>
        <p class="text-slate-500 mt-2">Acompanhe o progresso do seu projeto</p>
    </div>
    
    <?php if (!$project): ?>
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-8 text-center">
        <div class="text-4xl mb-4">📋</div>
        <h2 class="text-lg font-semibold text-amber-800">Nenhum projeto ativo</h2>
        <p class="text-amber-600 mt-2">Aguarde o cadastro do seu projeto ou entre em contato conosco.</p>
    </div>
    <?php else: ?>
    
    <!-- Project Card -->
    <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-bold"><?= htmlspecialchars($project['name']) ?></h2>
                <p class="text-indigo-200 mt-1"><?= htmlspecialchars($project['description'] ?? 'Projeto em andamento') ?></p>
            </div>
            <span class="px-3 py-1 bg-white/20 rounded-full text-sm">Ativo</span>
        </div>
    </div>
    
    <!-- KPIs -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4 text-center">
            <div class="text-3xl font-bold text-indigo-600"><?= $kpis['progress'] ?>%</div>
            <div class="text-sm text-slate-500">Progresso</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center">
            <div class="text-3xl font-bold text-emerald-600"><?= $kpis['days_remaining'] ?></div>
            <div class="text-sm text-slate-500">Dias Restantes</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center">
            <div class="text-3xl font-bold text-amber-600"><?= $kpis['done_tasks'] ?>/<?= $kpis['total_tasks'] ?></div>
            <div class="text-sm text-slate-500">Tarefas</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center">
            <div class="text-3xl font-bold text-purple-600"><?= ucfirst($project['current_phase'] ?? 'discovery') ?></div>
            <div class="text-sm text-slate-500">Fase Atual</div>
        </div>
    </div>
    
    <!-- Phases -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-slate-800 mb-4">Fases do Projeto</h3>
        <div class="flex justify-between items-center overflow-x-auto pb-2">
            <?php foreach ($phases as $i => $phase): ?>
            <div class="flex items-center">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold
                        <?= $phase['status'] === 'completed' ? 'bg-emerald-500 text-white' : ($phase['status'] === 'active' ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-500') ?>">
                        <?= $phase['status'] === 'completed' ? '✓' : $i + 1 ?>
                    </div>
                    <span class="text-xs text-slate-500 mt-2 whitespace-nowrap"><?= $phase['name'] ?></span>
                </div>
                <?php if ($i < count($phases) - 1): ?>
                <div class="w-12 h-0.5 mx-2 <?= $phase['status'] === 'completed' ? 'bg-emerald-500' : 'bg-slate-200' ?>"></div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Timeline -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold text-slate-800">Timeline de Atualizações</h3>
        </div>
        <div class="divide-y max-h-[400px] overflow-y-auto">
            <?php if (empty($events)): ?>
            <div class="px-6 py-8 text-center text-slate-500">
                Nenhuma atualização ainda. Em breve você verá o progresso aqui!
            </div>
            <?php endif; ?>
            
            <?php foreach ($events as $event): ?>
            <div class="px-6 py-4 hover:bg-slate-50">
                <div class="flex items-start gap-4">
                    <div class="w-2 h-2 rounded-full mt-2 <?= $event['status'] === 'done' ? 'bg-emerald-500' : 'bg-slate-300' ?>"></div>
                    <div class="flex-1">
                        <div class="font-medium text-slate-800"><?= htmlspecialchars($event['title']) ?></div>
                        <?php if ($event['description']): ?>
                        <div class="text-sm text-slate-500 mt-1"><?= htmlspecialchars($event['description']) ?></div>
                        <?php endif; ?>
                        <div class="text-xs text-slate-400 mt-2"><?= date('d/m/Y H:i', strtotime($event['created_at'])) ?></div>
                    </div>
                    <span class="px-2 py-0.5 text-xs rounded-full <?= $event['type'] === 'MACRO' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600' ?>">
                        <?= $event['type'] ?>
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
renderClientLayout('Meu Projeto', $content, $client);
