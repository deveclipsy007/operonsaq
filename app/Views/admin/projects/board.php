<?php
// Organize projects by phase
$columns = [
    'discovery' => ['label' => 'Descoberta', 'color' => 'slate'],
    'design' => ['label' => 'Design', 'color' => 'purple'],
    'build' => ['label' => 'Desenvolvimento', 'color' => 'indigo'],
    'test' => ['label' => 'Testes', 'color' => 'amber'],
    'launch' => ['label' => 'Lançamento', 'color' => 'emerald']
];

$board = array_fill_keys(array_keys($columns), []);

foreach ($projects as $project) {
    $phase = $project['current_phase'] ?? 'discovery';
    if (isset($board[$phase])) {
        $board[$phase][] = $project;
    } else {
        $board['discovery'][] = $project; // Fallback
    }
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

<!-- Header -->
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-black tracking-tight text-operon-deep dark:text-white">Board Neural</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 font-medium tracking-tight">Fluxo de Trabalho Operon (Kanban).</p>
    </div>
    <div class="flex gap-3">
        <a href="/admin/projects/create" class="inline-flex items-center px-4 py-2 bg-operon-deep text-white rounded-xl text-sm font-bold hover:bg-black transition-all shadow-premium">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Novo Projeto
        </a>
    </div>
</div>

<!-- Board Container -->
<div class="flex overflow-x-auto pb-8 gap-6 min-h-[calc(100vh-200px)] items-start">
    
    <?php foreach ($columns as $key => $col): ?>
        <div class="w-80 flex-shrink-0 flex flex-col bg-operon-mist/20 dark:bg-[#15191D]/50 rounded-[20px] border border-operon-mist/30 dark:border-white/5 h-full max-h-full">
            
            <!-- Column Header -->
            <div class="p-5 flex items-center justify-between border-b border-operon-mist/30 dark:border-white/5">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-operon-deep dark:bg-operon-mist"></span>
                    <h3 class="font-black text-xs text-operon-deep dark:text-white uppercase tracking-[0.2em]"><?= $col['label'] ?></h3>
                </div>
                <span class="text-[10px] font-black text-operon-deep dark:text-white bg-white/50 dark:bg-white/5 px-2 py-0.5 rounded-md border border-operon-mist/50 dark:border-white/10">
                    <?= count($board[$key]) ?>
                </span>
            </div>
            
            <!-- Cards Container -->
            <div class="p-3 flex-1 overflow-y-auto space-y-3 min-h-[150px] sortable-col" data-phase="<?= $key ?>">
                <?php if (empty($board[$key])): ?>
                    <div class="h-24 border-2 border-dashed border-slate-200 dark:border-white/10 rounded-xl flex items-center justify-center text-slate-400 dark:text-slate-500 text-xs font-medium italic empty-placeholder pointer-events-none">
                        Vazio
                    </div>
                <?php else: ?>
                    <?php foreach ($board[$key] as $project): ?>
                        <div class="group bg-white dark:bg-[#15191D] p-4 rounded-xl border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-premium hover:border-operon-mist dark:hover:border-operon-mist/50 transition-all cursor-move relative" data-id="<?= $project['id'] ?>">
                            
                            <!-- Project Header -->
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                     <div class="h-9 w-9 rounded-lg bg-operon-mist dark:bg-operon-mist/10 text-operon-deep dark:text-operon-mist flex items-center justify-center font-black text-xs shadow-sm shadow-operon-mist/30">
                                        <?= strtoupper(substr($project['name'], 0, 2)) ?>
                                    </div>
                                    <div class="leading-tight">
                                        <h4 class="font-bold text-operon-deep dark:text-white text-sm truncate w-32" title="<?= $project['name'] ?>">
                                            <?= $project['name'] ?>
                                        </h4>
                                        <p class="text-[10px] text-slate-400 dark:text-slate-500 font-medium truncate w-32">
                                            <?= $project['client_name'] ?? 'Cliente' ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false" class="text-slate-300 dark:text-slate-500 hover:text-indigo-600 dark:hover:text-operon-mist transition-colors p-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>
                                    </button>
                                    <!-- Context Menu -->
                                    <div x-show="open" class="absolute right-0 top-6 z-20 w-32 bg-white dark:bg-[#1A1C22] rounded-lg shadow-xl border border-slate-100 dark:border-white/5 py-1" style="display: none;">
                                        <a href="/admin/projects/show?id=<?= $project['id'] ?>" class="block px-3 py-1.5 text-xs font-bold text-slate-600 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white">Ver Dashboard</a>
                                        <a href="/admin/projects/feedback?id=<?= $project['id'] ?>" class="block px-3 py-1.5 text-xs font-bold text-slate-600 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white">Feedback & Detalhes</a>
                                        <a href="/admin/projects/edit?id=<?= $project['id'] ?>" class="block px-3 py-1.5 text-xs font-bold text-slate-600 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white">Editar</a>
                                        
                                        <div class="h-px bg-slate-100 dark:bg-white/5 my-1"></div>
                                        
                                        <form action="/admin/projects/delete" method="POST" onsubmit="return confirm('ATENÇÃO: Isso apagará todo o projeto, timeline e histórico. Tem certeza?');">
                                            <input type="hidden" name="id" value="<?= $project['id'] ?>">
                                            <button type="submit" class="block w-full text-left px-3 py-1.5 text-xs font-bold text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10">Excluir</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Badge -->
                            <div class="mb-4">
                                <div class="bg-operon-mist/30 dark:bg-white/5 text-operon-deep dark:text-white px-2 py-1 rounded-md text-[10px] font-black inline-flex items-center gap-1 border border-operon-mist/50 dark:border-white/10">
                                    <span>💰</span>
                                    R$ <?= number_format($project['project_value'], 2, ',', '.') ?>
                                </div>
                            </div>

                            <!-- Footer Info -->
                            <div class="flex items-center justify-between pt-3 border-t border-slate-50 dark:border-white/5">
                                <!-- Manager -->
                                <div class="flex items-center gap-1.5" title="Gerente: <?= $project['manager_name'] ?? 'A definir' ?>">
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($project['manager_name'] ?? 'U') ?>&background=random&color=fff&size=20" class="w-5 h-5 rounded-full border border-white shadow-sm">
                                    <span class="text-[10px] font-medium text-slate-500 truncate max-w-[80px]">
                                        <?= explode(' ', $project['manager_name'] ?? 'A definir')[0] ?>
                                    </span>
                                </div>
                                
                                <!-- Status Pill -->
                                <div>
                                    <?php if($project['status'] === 'active'): ?>
                                        <span class="text-[10px] font-black text-operon-deep bg-operon-mist px-2 py-0.5 rounded-md uppercase tracking-wider border border-operon-mistDark/30">Ativo</span>
                                    <?php elseif($project['status'] === 'completed'): ?>
                                        <span class="text-[10px] font-black text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md uppercase tracking-wider border border-emerald-100">Concluído</span>
                                    <?php else: ?>
                                        <span class="text-[10px] font-black text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md uppercase tracking-wider border border-slate-200"><?= ucfirst($project['status']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- ACTIONS for Phase Move (Removed for Drag and Drop clarity) -->
                            <!-- <div class="absolute inset-0 ..."></div> -->

                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const columns = document.querySelectorAll('.sortable-col');
    
    columns.forEach(col => {
        new Sortable(col, {
            group: 'kanban', // set both lists to same group
            animation: 150,
            ghostClass: 'bg-indigo-50',
            dragClass: 'opacity-50',
            onEnd: function (evt) {
                const itemEl = evt.item;  // dragged HTMLElement
                const newPhase = evt.to.getAttribute('data-phase');
                const projectId = itemEl.getAttribute('data-id');
                const oldPhase = evt.from.getAttribute('data-phase');
                
                // Remove empty placeholder if dropping into a previously empty column
                const placeholder = evt.to.querySelector('.empty-placeholder');
                if(placeholder) placeholder.style.display = 'none';

                // If moved to same list, do nothing (unless sorting is implemented in DB, which is not yet)
                if(newPhase === oldPhase) return;

                // Update Phase AJAX
                let fd = new FormData();
                fd.append('project_id', projectId);
                fd.append('phase', newPhase);
                
                fetch('/admin/projects/updatePhase', {
                    method: 'POST',
                    body: fd,
                    headers: {'X-Requested-With': 'XMLHttpRequest'}
                })
                .then(r => r.json())
                .then(d => {
                    if(!d.success) {
                        alert('Erro ao mover card. Recarregando.');
                        location.reload();
                    }
                    // Success silently
                })
                .catch(e => {
                    console.error(e);
                    alert('Erro de conexão');
                    location.reload(); // Revert on error
                });
            }
        });
    });
});
</script>
