
<div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
    <div>
        <h2 class="text-3xl font-black text-operon-deep dark:text-white tracking-tight">Rede Neural</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-1 flex items-center font-medium tracking-tight">
            <span class="w-2 h-2 rounded-full bg-operon-mist mr-2 animate-pulse"></span>
            <?= count($clients) ?> Conexões Estabelecidas
        </p>
    </div>
    <a href="/admin/clients/create" class="bg-operon-deep hover:bg-black dark:hover:bg-operon-deep/90 text-white px-6 py-3 rounded-xl font-bold shadow-premium transition-all transform hover:-translate-y-0.5 flex items-center justify-center group border border-white/5 uppercase tracking-widest text-xs">
        <svg class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
        Expandir Rede
    </a>
</div>

<?php if (empty($clients)): ?>
    <div class="card-apple dark:bg-[#15191D] p-16 text-center border-dashed border-2 border-operon-mist dark:border-white/10 dark:bg-white/5">
        <div class="w-20 h-20 bg-operon-mist/30 dark:bg-white/5 text-operon-deep dark:text-operon-mist rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-operon-mist/50 dark:border-white/10">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <h3 class="text-xl font-black text-operon-deep dark:text-white">Nenhum neurônio na rede</h3>
        <p class="text-slate-500 dark:text-slate-400 mt-2 mb-8 max-w-sm mx-auto font-medium tracking-tight">Sua base está offline. Comece adicionando o primeiro cliente para estabelecer a comunicação.</p>
        <a href="/admin/clients/create" class="inline-flex items-center text-operon-deep dark:text-operon-mist font-black uppercase tracking-widest text-xs hover:underline decoration-operon-mist underline-offset-4 transition-colors">
            Estabelecer conexão &rarr;
        </a>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <?php foreach ($clients as $client): ?>
            <?php 
                // Generate Initials
                $parts = explode(' ', $client['name']);
                $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : substr($parts[0], 1, 1)));
            ?>
            <div class="card-apple dark:bg-[#15191D] p-6 hover:shadow-premium hover:border-operon-mist transition-all duration-300 group flex flex-col h-full border border-slate-100 dark:border-white/5">
                
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <a href="/admin/clients/show?id=<?= $client['id'] ?>" class="w-12 h-12 rounded-2xl bg-operon-mist dark:bg-operon-mist/10 text-operon-deep dark:text-operon-mist flex items-center justify-center font-black text-lg shadow-sm group-hover:scale-105 transition-transform border border-operon-mistDark/30 dark:border-white/10">
                            <?= $initials ?>
                        </a>
                        <div>
                            <a href="/admin/clients/show?id=<?= $client['id'] ?>" class="text-lg font-black text-operon-deep dark:text-white line-clamp-1 hover:text-black dark:hover:text-operon-mist transition-colors tracking-tight">
                                <?= htmlspecialchars($client['name']) ?>
                            </a>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Desde <?= date('M Y', strtotime($client['created_at'])) ?></p>
                        </div>
                    </div>
                    <!-- Delete (Secure) -->
                    <form action="/admin/clients/delete" method="POST" onsubmit="return confirm('ATENÇÃO: Isso excluirá permanentemente o cliente e todos os seus projetos. Tem certeza?');">
                        <input type="hidden" name="id" value="<?= $client['id'] ?>">
                        <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors p-2" title="Excluir Cliente">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>

                <div class="space-y-4 mb-6 flex-1 text-slate-600 dark:text-slate-400">
                    <div class="flex items-center text-sm">
                        <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span class="truncate"><?= htmlspecialchars($client['email']) ?></span>
                    </div>
                    
                    <div class="bg-operon-mist/10 dark:bg-white/5 rounded-xl p-4 border border-operon-mist/30 dark:border-white/10">
                        <p class="text-[10px] uppercase font-black text-slate-400 dark:text-slate-500 tracking-widest mb-2">Token Neural</p>
                        <div class="flex items-center gap-2">
                             <code class="text-[10px] font-mono font-bold text-operon-deep dark:text-operon-mist bg-white/50 dark:bg-black/20 px-2 py-1 rounded border border-operon-mist/50 dark:border-white/10 truncate flex-1">
                                 <?= htmlspecialchars($client['access_token']) ?>
                             </code>
                             <button onclick="navigator.clipboard.writeText('<?= htmlspecialchars($client['access_token']) ?>')" class="text-slate-400 hover:text-operon-deep dark:hover:text-operon-mist transition-colors" title="Copiar">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                             </button>
                        </div>
                    </div>
                </div>

                <a href="/admin/clients/show?id=<?= $client['id'] ?>" class="w-full block text-center bg-operon-mist dark:bg-operon-mist/10 text-operon-deep dark:text-operon-mist font-black py-3 rounded-xl hover:bg-operon-mistDark dark:hover:bg-operon-mist/20 transition-all text-[10px] uppercase tracking-widest border border-operon-mistDark/30 dark:border-white/10">
                    Acessar Córtex do Cliente
                </a>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
