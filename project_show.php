<?php
/**
 * Operon Cortex - Visualizar Projeto
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/layout.php';

requireAdmin();

$id = $_GET['id'] ?? null;
if (!$id) {
    redirect('projects.php');
}

// Buscar projeto
$stmt = db()->prepare("SELECT p.*, c.name as client_name, c.email as client_email FROM projects p LEFT JOIN clients c ON p.client_id = c.id WHERE p.id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    flash('Projeto não encontrado.', 'error');
    redirect('projects.php');
}

// Buscar eventos da timeline
$events = db()->prepare("SELECT * FROM timeline_events WHERE project_id = ? ORDER BY created_at DESC");
$events->execute([$id]);
$events = $events->fetchAll();

// Processar novo evento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_event') {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $type = $_POST['type'] ?? 'MICRO';
        $status = $_POST['status'] ?? 'done';
        
        if ($title) {
            $stmt = db()->prepare("INSERT INTO timeline_events (project_id, title, description, type, status, completed_at) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$id, $title, $description, $type, $status, $status === 'done' ? date('Y-m-d H:i:s') : null]);
            flash('Evento adicionado!', 'success');
            redirect("project_show.php?id=$id");
        }
    }
    
    if ($_POST['action'] === 'delete_event') {
        $eventId = $_POST['event_id'] ?? null;
        if ($eventId) {
            db()->prepare("DELETE FROM timeline_events WHERE id = ? AND project_id = ?")->execute([$eventId, $id]);
            flash('Evento removido.', 'success');
            redirect("project_show.php?id=$id");
        }
    }
    
    if ($_POST['action'] === 'update_phase') {
        $phase = $_POST['phase'] ?? 'discovery';
        db()->prepare("UPDATE projects SET current_phase = ? WHERE id = ?")->execute([$phase, $id]);
        flash('Fase atualizada!', 'success');
        redirect("project_show.php?id=$id");
    }
}

// Calcular KPIs
$totalEvents = count($events);
$doneEvents = count(array_filter($events, fn($e) => $e['status'] === 'done'));
$progress = $totalEvents > 0 ? round(($doneEvents / $totalEvents) * 100) : 0;

$phases = ['discovery' => 'Descoberta', 'design' => 'Design', 'build' => 'Desenvolvimento', 'test' => 'Testes', 'launch' => 'Lançamento'];
$currentPhase = $project['current_phase'] ?? 'discovery';

ob_start();
?>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <a href="projects.php" class="text-slate-500 hover:text-white text-sm">← Voltar para Projetos</a>
            <h1 class="text-2xl font-bold mt-2"><?= htmlspecialchars($project['name']) ?></h1>
            <p class="text-slate-500"><?= htmlspecialchars($project['client_name'] ?? 'Sem cliente') ?></p>
        </div>
        <div class="flex gap-2">
            <a href="project_edit.php?id=<?= $id ?>" class="px-4 py-2 bg-dark-card border border-dark-border rounded-lg text-sm hover:border-indigo-500">
                Editar
            </a>
        </div>
    </div>
    
    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-dark-card border border-dark-border rounded-xl p-4">
            <div class="text-2xl font-bold text-indigo-400"><?= $progress ?>%</div>
            <div class="text-sm text-slate-500">Progresso</div>
        </div>
        <div class="bg-dark-card border border-dark-border rounded-xl p-4">
            <div class="text-2xl font-bold text-emerald-400"><?= $doneEvents ?>/<?= $totalEvents ?></div>
            <div class="text-sm text-slate-500">Tarefas</div>
        </div>
        <div class="bg-dark-card border border-dark-border rounded-xl p-4">
            <div class="text-2xl font-bold text-amber-400">R$ <?= number_format($project['project_value'] ?? 0, 2, ',', '.') ?></div>
            <div class="text-sm text-slate-500">Valor</div>
        </div>
        <div class="bg-dark-card border border-dark-border rounded-xl p-4">
            <div class="text-2xl font-bold <?= $project['status'] === 'active' ? 'text-emerald-400' : 'text-slate-400' ?>">
                <?= ucfirst($project['status']) ?>
            </div>
            <div class="text-sm text-slate-500">Status</div>
        </div>
    </div>
    
    <!-- Phases -->
    <div class="bg-dark-card border border-dark-border rounded-xl p-6">
        <h2 class="font-semibold mb-4">Fases do Projeto</h2>
        <form method="POST" class="flex flex-wrap gap-2">
            <input type="hidden" name="action" value="update_phase">
            <?php foreach ($phases as $key => $label): 
                $isCurrent = $key === $currentPhase;
                $isPast = array_search($key, array_keys($phases)) < array_search($currentPhase, array_keys($phases));
            ?>
            <button type="submit" name="phase" value="<?= $key ?>"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                    <?= $isCurrent ? 'bg-indigo-600 text-white' : ($isPast ? 'bg-emerald-500/20 text-emerald-400' : 'bg-dark-bg text-slate-500 hover:bg-white/5') ?>">
                <?= $label ?>
            </button>
            <?php endforeach; ?>
        </form>
    </div>
    
    <!-- Timeline -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Events List -->
        <div class="lg:col-span-2 bg-dark-card border border-dark-border rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-dark-border">
                <h2 class="font-semibold">Timeline de Eventos</h2>
            </div>
            <div class="divide-y divide-dark-border max-h-[500px] overflow-y-auto">
                <?php if (empty($events)): ?>
                <div class="px-6 py-8 text-center text-slate-500">
                    Nenhum evento ainda. Adicione o primeiro!
                </div>
                <?php endif; ?>
                
                <?php foreach ($events as $event): ?>
                <div class="px-6 py-4 hover:bg-white/5">
                    <div class="flex justify-between items-start">
                        <div class="flex items-start gap-3">
                            <span class="px-2 py-0.5 text-xs rounded-full <?= $event['type'] === 'MACRO' ? 'bg-purple-500/20 text-purple-400' : 'bg-blue-500/20 text-blue-400' ?>">
                                <?= $event['type'] ?>
                            </span>
                            <div>
                                <div class="font-medium"><?= htmlspecialchars($event['title']) ?></div>
                                <?php if ($event['description']): ?>
                                <div class="text-sm text-slate-500 mt-1"><?= htmlspecialchars($event['description']) ?></div>
                                <?php endif; ?>
                                <div class="text-xs text-slate-600 mt-2"><?= date('d/m/Y H:i', strtotime($event['created_at'])) ?></div>
                            </div>
                        </div>
                        <form method="POST" onsubmit="return confirm('Remover este evento?');">
                            <input type="hidden" name="action" value="delete_event">
                            <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                            <button type="submit" class="text-slate-500 hover:text-red-400 text-sm">✕</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Add Event Form -->
        <div class="bg-dark-card border border-dark-border rounded-xl p-6">
            <h2 class="font-semibold mb-4">Adicionar Evento</h2>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="add_event">
                
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Título</label>
                    <input type="text" name="title" required
                           class="w-full px-3 py-2 bg-dark-bg border border-dark-border rounded-lg text-white text-sm">
                </div>
                
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Descrição</label>
                    <textarea name="description" rows="2"
                              class="w-full px-3 py-2 bg-dark-bg border border-dark-border rounded-lg text-white text-sm"></textarea>
                </div>
                
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm text-slate-400 mb-1">Tipo</label>
                        <select name="type" class="w-full px-3 py-2 bg-dark-bg border border-dark-border rounded-lg text-white text-sm">
                            <option value="MICRO">Micro</option>
                            <option value="MACRO">Macro</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2 bg-dark-bg border border-dark-border rounded-lg text-white text-sm">
                            <option value="done">Concluído</option>
                            <option value="in_progress">Em Progresso</option>
                            <option value="pending">Pendente</option>
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-sm font-medium">
                    Adicionar Evento
                </button>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
renderAdminLayout($project['name'], $content, 'projects');
