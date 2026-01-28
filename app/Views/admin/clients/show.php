
<!-- Client Header / Hero -->
<div class="mb-10">
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
        
        <!-- Profile Info -->
        <div class="flex items-center gap-6">
            <?php 
                // Generate Initials
                $parts = explode(' ', $client['name']);
                $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : substr($parts[0], 1, 1)));
            ?>
            <div class="w-20 h-20 rounded-[24px] bg-operon-mist text-operon-deep flex items-center justify-center font-black text-2xl shadow-premium border border-white/50">
                <?= $initials ?>
            </div>
            <div>
                <h1 class="text-3xl font-black text-operon-deep dark:text-white tracking-tight"><?= htmlspecialchars($client['name']) ?></h1>
                <div class="flex items-center gap-3 mt-2 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">
                    <span class="flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <?= htmlspecialchars($client['email']) ?>
                    </span>
                    <span class="w-1 h-1 rounded-full bg-operon-mist"></span>
                    <span>Desde <?= date('d/m/Y', strtotime($client['created_at'])) ?></span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-3">
            <a href="/admin/clients" class="bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-400 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider hover:bg-slate-50 dark:hover:bg-white/10 transition-all shadow-sm">
                Voltar
            </a>
        </div>
    </div>

</div>

<!-- Projects Section -->
<div class="mb-6 flex items-center justify-between mt-12">
    <h3 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Fluxo Neural (Projetos)</h3>
    <a href="/admin/projects/create?client_id=<?= $client['id'] ?>" class="text-[10px] font-black text-operon-deep dark:text-operon-mist uppercase tracking-widest hover:underline decoration-operon-mist underline-offset-4 flex items-center gap-1.5">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
        Novo Neurônio
    </a>
</div>

<?php if (empty($projects)): ?>
    <div class="card-apple p-12 text-center border-dashed">
        <div class="w-16 h-16 bg-slate-50 dark:bg-white/5 text-slate-400 dark:text-slate-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
        <h3 class="text-lg font-black text-operon-deep dark:text-white">Nenhum projeto iniciado</h3>
        <p class="text-slate-500 dark:text-slate-400 mb-6 font-medium">Este cliente ainda não possui projetos cadastrados.</p>
        <a href="/admin/projects/create?client_id=<?= $client['id'] ?>" class="inline-flex items-center bg-operon-deep hover:bg-black text-white px-8 py-3 rounded-xl font-black uppercase tracking-widest text-xs transition-all shadow-premium">
            Iniciar Projeto
        </a>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($projects as $project): ?>
            <div class="card-apple p-6 border-l-4 border-l-operon-deep hover:shadow-premium hover:border-operon-mist transition-all duration-300 group flex flex-col cursor-pointer relative bg-white dark:bg-[#15191D] dark:border-white/5 dark:hover:border-operon-mist"
                 onclick="window.location='/admin/projects/show?id=<?= $project['id'] ?>'">
                
                <div class="absolute top-4 right-4">
                     <?php if ($project['status'] === 'active'): ?>
                        <span class="text-[10px] font-black text-operon-deep bg-operon-mist px-2 py-0.5 rounded-md uppercase tracking-wider border border-operon-mistDark/30">
                            Ativo
                        </span>
                    <?php else: ?>
                         <span class="text-[10px] font-black text-slate-500 bg-slate-100 dark:bg-white/10 dark:text-slate-400 px-2 py-0.5 rounded-md uppercase tracking-wider border border-slate-200 dark:border-white/5">
                            <?= ucfirst($project['status']) ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="w-12 h-12 rounded-xl bg-operon-mist text-operon-deep flex items-center justify-center font-black text-xs mb-4 group-hover:bg-operon-deep group-hover:text-white dark:group-hover:bg-operon-mist dark:group-hover:text-operon-deep transition-all shadow-sm border border-operon-mistDark/30">
                    <?= strtoupper(substr($project['name'], 0, 2)) ?>
                </div>

                <h4 class="text-lg font-black text-operon-deep dark:text-white group-hover:text-black dark:group-hover:text-operon-mist transition-colors mb-2 tracking-tight">
                    <?= htmlspecialchars($project['name']) ?>
                </h4>
                
                <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mb-4 flex-1 font-medium leading-relaxed">
                    <?= htmlspecialchars($project['description'] ?? 'Sem descrição neural.') ?>
                </p>

                <div class="border-t border-slate-50 dark:border-white/5 pt-4 flex items-center justify-between text-[10px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-wider">
                    <span>Iniciado: <?= date('d/m/y', strtotime($project['created_at'])) ?></span>
                    <span class="group-hover:translate-x-1 transition-transform text-operon-deep dark:text-operon-mist flex items-center gap-1">
                        Gerenciar <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
