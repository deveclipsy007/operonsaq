<div class="max-w-7xl mx-auto pb-20">
    
    <!-- Topbar -->
    <div class="mb-8 flex items-center justify-between px-2">
        <div>
            <a href="/admin/projects/show?id=<?= $project['id'] ?>" class="text-slate-400 dark:text-slate-500 hover:text-operon-deep dark:hover:text-operon-mist text-[10px] font-black uppercase tracking-[0.2em] flex items-center mb-2 transition-colors">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Voltar ao Dashboard
            </a>
            <h1 class="text-3xl font-black text-operon-deep dark:text-white tracking-tight">Logs Gerais & Auditoria</h1>
            <p class="text-slate-500 font-medium">Histórico completo de interações, valores e alterações.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- LEFT: Project Overview & Finance -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Snapshot Card -->
            <div class="bg-white dark:bg-[#15191D] border border-slate-100 dark:border-white/5 rounded-3xl p-6 shadow-premium relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-operon-mist/20 rounded-full blur-3xl -mr-10 -mt-10"></div>
                
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Snapshot Financeiro</h3>
                
                <div class="space-y-4 relative z-10">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Valor Total</p>
                        <p class="text-3xl font-black text-operon-deep dark:text-white">R$ <?= number_format((float)$project['project_value'], 2, ',', '.') ?></p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Status Pagto</p>
                            <p class="text-sm font-bold text-slate-700 dark:text-slate-300">
                                <?= $project['installments_paid'] ?>/<?= $project['installments'] ?> Parcelas
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Método</p>
                            <p class="text-sm font-bold text-slate-700 dark:text-slate-300"><?= $project['payment_method'] ?></p>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-50 dark:border-white/5">
                        <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Datas</p>
                        <div class="flex justify-between text-xs font-medium text-slate-600 dark:text-slate-400">
                            <span>Início: <?= date('d/m/Y', strtotime($project['start_date'])) ?></span>
                            <span>Prazo: <?= date('d/m/Y', strtotime($project['deadline'])) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Client Info -->
            <div class="bg-white dark:bg-[#15191D] border border-slate-100 dark:border-white/5 rounded-3xl p-6 shadow-sm">
                 <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Dados do Cliente</h3>
                 <div class="flex items-center gap-3 mb-4">
                     <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/10 flex items-center justify-center font-bold text-slate-500">
                         <?= strtoupper(substr($project['manager_name'] ?? 'C', 0, 1)) ?>
                     </div>
                     <div>
                         <p class="font-bold text-slate-800 dark:text-white"><?= $project['manager_name'] ?? 'Não informado' ?></p>
                         <p class="text-xs text-slate-500"><?= $project['manager_phone'] ?? '' ?></p>
                     </div>
                 </div>
                 <?php if($project['contract_url']): ?>
                    <a href="<?= $project['contract_url'] ?>" target="_blank" class="block w-full text-center py-2 bg-slate-50 dark:bg-white/5 text-slate-600 dark:text-slate-300 font-bold text-xs rounded-xl hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">
                        📄 Ver Contrato
                    </a>
                 <?php else: ?>
                    <div class="text-center py-2 bg-slate-50 text-slate-400 font-bold text-xs rounded-xl">Sem contrato</div>
                 <?php endif; ?>
            </div>

        </div>

        <!-- RIGHT: Timeline & Logs -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Filter Tabs (Visual Only for now) -->
            <div class="flex gap-2 border-b border-slate-100 dark:border-white/5 pb-2">
                <button class="px-4 py-2 text-xs font-black uppercase tracking-wider text-operon-deep border-b-2 border-operon-deep">Tudo</button>
                <button class="px-4 py-2 text-xs font-black uppercase tracking-wider text-slate-400 hover:text-slate-600">Eventos</button>
                <button class="px-4 py-2 text-xs font-black uppercase tracking-wider text-slate-400 hover:text-slate-600">Tickets</button>
                <button class="px-4 py-2 text-xs font-black uppercase tracking-wider text-slate-400 hover:text-slate-600">Feedback</button>
            </div>

            <div class="space-y-0 relative">
                <div class="absolute left-4 top-0 bottom-0 w-px bg-slate-200 dark:bg-white/10"></div>

                <!-- Iterate merged logs (Simulation: we just stack them) -->
                
                <!-- 1. Tickets (Recent first) -->
                <?php foreach($tickets as $ticket): ?>
                    <div class="relative pl-12 py-4 group">
                        <div class="absolute left-[11px] top-6 w-2.5 h-2.5 rounded-full bg-indigo-500 ring-4 ring-white dark:ring-[#0D1517]"></div>
                        <div class="bg-white dark:bg-[#15191D] p-4 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest">Ticket #<?= $ticket['id'] ?> • <?= $ticket['status'] ?></span>
                                <span class="text-[10px] text-slate-400"><?= date('d/m/Y H:i', strtotime($ticket['created_at'])) ?></span>
                            </div>
                            <h4 class="font-bold text-slate-800 dark:text-white text-sm"><?= htmlspecialchars($ticket['subject']) ?></h4>
                            <p class="text-xs text-slate-500 mt-1">Categoria: <?= $ticket['category'] ?? 'Geral' ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- 2. Events -->
                <?php foreach($events as $event): ?>
                    <div class="relative pl-12 py-4 group">
                        <?php 
                            $colorClass = match($event['type']) {
                                'MACRO' => 'bg-operon-deep',
                                'WARNING' => 'bg-amber-500',
                                default => 'bg-slate-300'
                            };
                        ?>
                        <div class="absolute left-[11px] top-6 w-2.5 h-2.5 rounded-full <?= $colorClass ?> ring-4 ring-white dark:ring-[#0D1517]"></div>
                        <div class="bg-white dark:bg-[#15191D] p-4 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm opacity-90 group-hover:opacity-100 transition-opacity">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Timeline • <?= $event['type'] ?></span>
                                <span class="text-[10px] text-slate-400"><?= date('d/m/Y H:i', strtotime($event['created_at'])) ?></span>
                            </div>
                            <h4 class="font-bold text-slate-800 dark:text-white text-sm"><?= htmlspecialchars($event['title']) ?></h4>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2"><?= htmlspecialchars($event['description']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <?php if(empty($tickets) && empty($events)): ?>
                    <p class="text-center text-slate-400 text-sm py-10">Nenhum registro encontrado.</p>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>
