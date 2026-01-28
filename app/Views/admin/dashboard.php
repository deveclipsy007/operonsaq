<!-- Page Header -->
<div class="mb-8 flex items-end justify-between">
    <div>
        <h1 class="text-3xl font-black tracking-tight text-operon-deep dark:text-white">Dashboard</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 font-medium tracking-tight">Homeostase Neural do Sistema Operon.</p>
    </div>
    <div class="flex gap-3">
        <a href="/admin/clients/create" class="inline-flex items-center px-4 py-2 bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl text-sm font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-white/10 transition-all">
            <svg class="mr-2 h-4 w-4 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" /></svg>
            Novo Cliente
        </a>
        <a href="/admin/projects/create" class="inline-flex items-center px-4 py-2 bg-operon-deep text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-black transition-all shadow-premium border border-white/5">
            <svg class="mr-2 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Novo Projeto
        </a>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-10">
    <!-- Stat 1 -->
    <div class="card-apple p-6 border-l-4 border-l-operon-deep relative overflow-hidden group">
        <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity text-operon-deep dark:text-white">
            <svg class="h-16 w-16" fill="currentColor" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
        </div>
        <dt class="truncate text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500">Total de Projetos</dt>
        <dd class="mt-2 text-3xl font-black tracking-tight text-operon-deep dark:text-white"><?= count($projects) ?></dd>
    </div>

    <!-- Stat 2 -->
    <div class="card-apple p-6 border-l-4 border-l-operon-mistDark relative overflow-hidden group">
        <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity text-operon-mistDark dark:text-operon-mist">
            <svg class="h-16 w-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
        </div>
        <dt class="truncate text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500">Projetos Ativos</dt>
        <dd class="mt-2 text-3xl font-black tracking-tight text-operon-deep dark:text-white">
            <?= count(array_filter($projects, fn($p) => $p['status'] === 'active')) ?>
        </dd>
    </div>

    <!-- Stat 3 (Mock) -->
    <div class="card-apple p-6 border-l-4 border-l-slate-200 dark:border-l-white/10 relative overflow-hidden group">
        <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity text-slate-400 dark:text-slate-500">
            <svg class="h-16 w-16" fill="currentColor" viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
        </div>
        <dt class="truncate text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500">Horas Neural</dt>
        <dd class="mt-2 text-3xl font-black tracking-tight text-operon-deep dark:text-white">128h</dd>
    </div>
</div>

<!-- Projects Table -->
<div class="card-apple overflow-hidden">
    <div class="border-b border-slate-100 dark:border-white/5 bg-white dark:bg-white/5 px-6 py-5 flex items-center justify-between">
        <h3 class="text-base font-semibold leading-6 text-slate-900 dark:text-white">Projetos Recentes</h3>
        <div class="flex items-center gap-2">
            <input type="text" placeholder="Buscar..." class="text-xs bg-slate-50 dark:bg-white/5 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-white/10 rounded-md py-1.5 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50/50 dark:bg-white/5 text-slate-500 dark:text-slate-400">
                <tr>
                    <th scope="col" class="px-6 py-3 font-semibold">Projeto</th>
                    <th scope="col" class="px-6 py-3 font-semibold">Cliente</th>
                    <th scope="col" class="px-6 py-3 font-semibold">Status</th>
                    <th scope="col" class="px-6 py-3 font-semibold">Configuração</th>
                    <th scope="col" class="px-6 py-3 font-semibold text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-white/5 bg-white dark:bg-transparent">
                <?php if (empty($projects)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            Nenhum projeto encontrado.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($projects as $project): ?>
                    <tr class="group hover:bg-slate-50 dark:hover:bg-white/5 transition-all text-operon-deep dark:text-slate-200">
                        <td class="px-6 py-5 font-bold">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-xl bg-operon-mist dark:bg-operon-mist/10 text-operon-deep dark:text-operon-mist flex items-center justify-center font-black text-xs shadow-sm shadow-operon-mist/50">
                                    <?= strtoupper(substr($project['name'], 0, 2)) ?>
                                </div>
                                <a href="/admin/projects/show?id=<?= $project['id'] ?>" class="hover:underline decoration-operon-mist underline-offset-4">
                                    <?= htmlspecialchars($project['name']) ?>
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400">
                            <?= htmlspecialchars($project['client_name']) ?>
                        </td>
                            <td class="px-6 py-4" x-data="{ 
                                loading: false,
                                currentStatus: '<?= $project['status'] ?>',
                                async changeStatus(newStatus) {
                                    if(this.loading) return;
                                    if(!confirm('Alterar status para ' + newStatus + '?')) return;
                                    
                                    this.loading = true;
                                    let fd = new FormData();
                                    fd.append('project_id', '<?= $project['id'] ?>');
                                    fd.append('status', newStatus);
                                    
                                    try {
                                        let r = await fetch('/admin/projects/updateStatus', {
                                            method: 'POST',
                                            body: fd,
                                            headers: {'X-Requested-With': 'XMLHttpRequest'}
                                        });
                                        let data = await r.json();
                                        if(data.success) {
                                            this.currentStatus = newStatus;
                                            // Optional: reload page to update stats
                                            if(newStatus !== 'active') location.reload(); 
                                        } else {
                                            alert('Erro ao atualizar');
                                        }
                                    } catch(e) {
                                        console.error(e);
                                        alert('Erro de conexão');
                                    } finally {
                                        this.loading = false;
                                    }
                                }
                            }">
                                <div class="relative inline-block text-left" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false" type="button" 
                                        class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1 text-[10px] font-black uppercase tracking-wider cursor-pointer transition-all border"
                                        :class="{
                                            'bg-operon-mist text-operon-deep border-operon-mistDark/30': currentStatus === 'active',
                                            'bg-slate-50 text-slate-500 border-slate-200': currentStatus === 'archived',
                                            'bg-emerald-50 text-emerald-700 border-emerald-100': currentStatus === 'completed',
                                            'opacity-50 cursor-wait': loading
                                        }">
                                        <span x-text="currentStatus === 'active' ? 'Ativo' : (currentStatus === 'completed' ? 'Concluído' : 'Arquivado')"></span>
                                        <svg class="h-3 w-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                                    </button>

                                    <!-- Dropdown -->
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="absolute left-0 z-10 mt-2 w-32 origin-top-left rounded-md bg-white dark:bg-[#1A1C22] shadow-lg ring-1 ring-black ring-opacity-5 dark:ring-white/10 focus:outline-none" 
                                         style="display: none;">
                                        <div class="py-1">
                                            <a href="#" @click.prevent="changeStatus('active'); open = false" class="block px-4 py-2 text-xs text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-white/5">🟢 Ativo</a>
                                            <a href="#" @click.prevent="changeStatus('completed'); open = false" class="block px-4 py-2 text-xs text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-white/5">✅ Concluído</a>
                                            <a href="#" @click.prevent="changeStatus('archived'); open = false" class="block px-4 py-2 text-xs text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-white/5">📦 Arquivado</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400">
                            <span class="capitalize"><?= $project['thalamic_setting'] ?></span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                <a href="/admin/projects/finance?id=<?= $project['id'] ?>" class="h-8 px-3 bg-operon-mist text-operon-deep rounded-lg text-xs font-bold flex items-center gap-1 hover:bg-operon-mistDark transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065\"></path><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15 12a3 3 0 11-6 0 3 3 0 016 0z\"></path></svg>
                                    Backstage
                                </a>
                                <a href="/admin/projects/show?id=<?= $project['id'] ?>" class="h-8 px-3 bg-operon-deep text-white rounded-lg text-xs font-bold flex items-center hover:bg-black transition-colors">
                                    Gerenciar
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
