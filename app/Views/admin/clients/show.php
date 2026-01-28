
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
                <h1 class="text-3xl font-black text-operon-deep tracking-tight"><?= htmlspecialchars($client['name']) ?></h1>
                <div class="flex items-center gap-3 mt-2 text-slate-500 text-xs font-bold uppercase tracking-wider">
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
            <a href="/admin/clients" class="btn btn-secondary text-sm">
                Voltar
            </a>
            <a href="/status?token=<?= $client['access_token'] ?>" target="_blank" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Visão do Cliente
            </a>
        </div>
    </div>

    <!-- Access Token Card -->
    <div class="mt-8 bg-operon-deep rounded-[24px] p-8 text-white overflow-hidden relative group shadow-premium border border-white/5">
        <div class="absolute right-0 top-0 p-4 opacity-[0.03]">
            <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h3 class="text-[10px] font-black text-operon-mist uppercase tracking-[0.25em] mb-2">Credencial de Acesso Neural</h3>
                <p class="text-white/60 text-sm font-medium tracking-tight">Este token permite acesso exclusivo e seguro à interface do sistema.</p>
            </div>
            <div class="flex items-center gap-2 w-full md:w-auto">
                <code class="bg-white/5 border border-white/10 rounded-xl px-4 py-3 font-mono text-operon-mist text-xs flex-1 md:flex-none">
                    <?= htmlspecialchars($client['access_token']) ?>
                </code>
                <button onclick="navigator.clipboard.writeText('<?= htmlspecialchars($client['access_token']) ?>')" class="p-3 bg-operon-mist hover:bg-white rounded-xl transition-all text-operon-deep shadow-lg active:scale-95" title="Copiar Token">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Projects Section -->
<div class="mb-6 flex items-center justify-between mt-12">
    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Fluxo Neural (Projetos)</h3>
    <a href="/admin/projects/create?client_id=<?= $client['id'] ?>" class="text-[10px] font-black text-operon-deep uppercase tracking-widest hover:underline decoration-operon-mist underline-offset-4 flex items-center gap-1.5">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
        Novo Neurônio
    </a>
</div>

<?php if (empty($projects)): ?>
    <div class="bg-white rounded-2xl p-12 text-center border border-slate-200 border-dashed">
        <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
        <h3 class="text-lg font-medium text-slate-900">Nenhum projeto iniciado</h3>
        <p class="text-slate-500 mb-6">Este cliente ainda não possui projetos cadastrados.</p>
        <a href="/admin/projects/create?client_id=<?= $client['id'] ?>" class="btn btn-primary text-sm shadow-indigo-200 shadow-lg">
            Iniciar Projeto
        </a>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($projects as $project): ?>
            <div class="ios-card p-6 border-l-4 border-l-operon-deep hover:shadow-premium hover:border-operon-mist transition-all duration-300 group flex flex-col cursor-pointer relative"
                 onclick="window.location='/admin/projects/show?id=<?= $project['id'] ?>'">
                
                <div class="absolute top-4 right-4">
                     <?php if ($project['status'] === 'active'): ?>
                        <span class="text-[10px] font-black text-operon-deep bg-operon-mist px-2 py-0.5 rounded-md uppercase tracking-wider border border-operon-mistDark/30">
                            Ativo
                        </span>
                    <?php else: ?>
                         <span class="text-[10px] font-black text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md uppercase tracking-wider border border-slate-200">
                            <?= ucfirst($project['status']) ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="w-12 h-12 rounded-xl bg-operon-mist text-operon-deep flex items-center justify-center font-black text-xs mb-4 group-hover:bg-operon-deep group-hover:text-white transition-all shadow-sm border border-operon-mistDark/30">
                    <?= strtoupper(substr($project['name'], 0, 2)) ?>
                </div>

                <h4 class="text-lg font-black text-operon-deep group-hover:text-black transition-colors mb-2 tracking-tight">
                    <?= htmlspecialchars($project['name']) ?>
                </h4>
                
                <p class="text-xs text-slate-500 line-clamp-2 mb-4 flex-1 font-medium leading-relaxed">
                    <?= htmlspecialchars($project['description'] ?? 'Sem descrição neural.') ?>
                </p>

                <div class="border-t border-slate-50 pt-4 flex items-center justify-between text-[10px] text-slate-400 font-black uppercase tracking-wider">
                    <span>Iniciado: <?= date('d/m/y', strtotime($project['created_at'])) ?></span>
                    <span class="group-hover:translate-x-1 transition-transform text-operon-deep flex items-center gap-1">
                        Gerenciar <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
