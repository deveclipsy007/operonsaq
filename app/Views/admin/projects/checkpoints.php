<!-- Checkpoints - Simplified Task Management -->
<div class="mb-8 flex items-end justify-between">
    <div>
        <a href="/admin/projects/show?id=<?= $project['id'] ?>" class="text-sm text-slate-400 hover:text-operon-deep transition-colors mb-2 inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Voltar ao Projeto
        </a>
        <h1 class="text-3xl font-black tracking-tight text-operon-deep dark:text-white">Checkpoints de Entrega</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 font-medium"><?= htmlspecialchars($project['name']) ?></p>
    </div>
</div>

<!-- Progress Bar -->
<div class="card-apple p-6 mb-8" x-data="{ progress: <?= $progress ?> }">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-bold text-slate-600 dark:text-slate-300">Progresso do Projeto</h3>
        <span class="text-2xl font-black text-operon-deep dark:text-operon-mist" x-text="progress + '%'"><?= $progress ?>%</span>
    </div>
    <div class="h-3 bg-slate-100 dark:bg-white/10 rounded-full overflow-hidden">
        <div class="h-full bg-gradient-to-r from-operon-deep to-operon-mistDark rounded-full transition-all duration-500" 
             :style="'width: ' + progress + '%'"
             style="width: <?= $progress ?>%"></div>
    </div>
    <p class="text-xs text-slate-400 mt-2">
        Calculado automaticamente com base nos checkpoints concluídos
    </p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Checkpoints List -->
    <div class="lg:col-span-2">
        <div class="card-apple overflow-hidden">
            <div class="border-b border-slate-100 dark:border-white/5 bg-white dark:bg-white/5 px-6 py-4 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 dark:text-white">Lista de Entregas</h3>
                <span class="text-xs text-slate-400">
                    <?= count(array_filter($checkpoints, fn($c) => $c['status'] === 'done')) ?> / <?= count($checkpoints) ?> concluídos
                </span>
            </div>
            
            <div class="divide-y divide-slate-50 dark:divide-white/5" x-data="checkpointManager(<?= $project['id'] ?>)">
                <?php if (empty($checkpoints)): ?>
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-slate-100 dark:bg-white/5 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-slate-400 dark:text-slate-500 font-medium">Nenhum checkpoint cadastrado</p>
                        <p class="text-xs text-slate-300 dark:text-slate-600 mt-1">Adicione entregas no formulário ao lado</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($checkpoints as $checkpoint): ?>
                        <?php $meta = json_decode($checkpoint['metadata'] ?? '{}', true); ?>
                        <div class="p-4 hover:bg-slate-50/50 dark:hover:bg-white/5 transition-colors group flex items-center gap-4"
                             id="checkpoint-<?= $checkpoint['id'] ?>">
                            
                            <!-- Toggle Button -->
                            <button type="button" 
                                    @click="toggleCheckpoint(<?= $checkpoint['id'] ?>)"
                                    class="flex-shrink-0 w-8 h-8 rounded-full border-2 flex items-center justify-center transition-all hover:scale-110 cursor-pointer
                                           <?= $checkpoint['status'] === 'done' ? 'bg-emerald-500 border-emerald-500 text-white' : 
                                              ($checkpoint['status'] === 'in_progress' ? 'bg-indigo-500 border-indigo-500 text-white' : 'border-slate-200 dark:border-white/20 hover:border-emerald-400') ?>">
                                <?php if ($checkpoint['status'] === 'done'): ?>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                <?php elseif ($checkpoint['status'] === 'in_progress'): ?>
                                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                <?php endif; ?>
                            </button>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-slate-800 dark:text-white <?= $checkpoint['status'] === 'done' ? 'line-through opacity-60' : '' ?>">
                                    <?= htmlspecialchars($checkpoint['title']) ?>
                                </h4>
                                <?php if (!empty($checkpoint['description']) && $checkpoint['description'] !== 'Checkpoint de entrega'): ?>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-2">
                                        <?= htmlspecialchars($checkpoint['description']) ?>
                                    </p>
                                <?php endif; ?>
                                <?php if (!empty($meta['deadline'])): ?>
                                    <p class="text-[10px] text-slate-400 flex items-center gap-1 mt-1 font-bold uppercase tracking-wider">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Prazo: <?= date('d/m/Y', strtotime($meta['deadline'])) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Status Badge -->
                            <div class="flex-shrink-0">
                                <?php if ($checkpoint['status'] === 'done'): ?>
                                    <span class="px-2 py-1 bg-emerald-50 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold rounded-full uppercase tracking-wider">
                                        Concluído
                                    </span>
                                <?php elseif ($checkpoint['status'] === 'in_progress'): ?>
                                    <span class="px-2 py-1 bg-indigo-50 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 text-[10px] font-bold rounded-full uppercase tracking-wider">
                                        Em Andamento
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 py-1 bg-amber-50 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 text-[10px] font-bold rounded-full uppercase tracking-wider">
                                        Pendente
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Delete Button -->
                            <form action="/admin/projects/checkpoints/delete" method="POST" 
                                  onsubmit="return confirm('Excluir este checkpoint?');"
                                  class="opacity-0 group-hover:opacity-100 transition-opacity">
                                <input type="hidden" name="id" value="<?= $checkpoint['id'] ?>">
                                <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                <button type="submit" class="p-2 text-slate-300 hover:text-red-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Add Checkpoint Form -->
    <div class="lg:col-span-1">
        <div class="card-apple p-6 sticky top-6">
            <h3 class="font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                <span class="w-8 h-8 bg-operon-mist dark:bg-operon-deep/50 rounded-lg flex items-center justify-center text-operon-deep dark:text-operon-mist">
                    +
                </span>
                Novo Checkpoint
            </h3>
            
            <form action="/admin/projects/checkpoints/store" method="POST" class="space-y-4">
                <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                
                <div>
                    <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">
                        Título da Entrega *
                    </label>
                    <input type="text" name="title" required placeholder="Ex: Entrega do Layout" 
                           class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-xl text-slate-800 dark:text-white font-bold text-sm h-12 px-4 focus:ring-2 focus:ring-operon-mist/50 placeholder-slate-300 dark:placeholder-slate-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">
                        Descrição (Opcional)
                    </label>
                    <textarea name="description" placeholder="Descreva o que será entregue..." rows="3"
                           class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-xl text-slate-800 dark:text-white font-medium text-sm p-4 focus:ring-2 focus:ring-operon-mist/50 placeholder-slate-300 dark:placeholder-slate-600 resize-none"></textarea>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">
                        Prazo (Opcional)
                    </label>
                    <input type="date" name="deadline" 
                           class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-xl text-slate-800 dark:text-white font-bold text-sm h-12 px-4 focus:ring-2 focus:ring-operon-mist/50">
                </div>
                
                <button type="submit" 
                        class="w-full h-12 bg-operon-deep text-white rounded-xl font-bold text-sm hover:bg-black transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Adicionar Checkpoint
                </button>
            </form>
            
            <div class="mt-6 pt-6 border-t border-slate-100 dark:border-white/5">
                <p class="text-xs text-slate-400 dark:text-slate-500">
                    💡 <strong>Dica:</strong> Checkpoints aparecem automaticamente na timeline do cliente e o e-mail de notificação é enviado na hora!
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function checkpointManager(projectId) {
    return {
        async toggleCheckpoint(id) {
            const el = document.getElementById('checkpoint-' + id);
            if (!el) return;
            
            const formData = new FormData();
            formData.append('id', id);
            formData.append('project_id', projectId);
            
            try {
                const res = await fetch('/admin/projects/checkpoints/toggle', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                
                const data = await res.json();
                if (data.success) {
                    // Reload page to update UI
                    location.reload();
                }
            } catch (e) {
                console.error('Toggle failed:', e);
                alert('Erro ao atualizar checkpoint');
            }
        }
    }
}
</script>
