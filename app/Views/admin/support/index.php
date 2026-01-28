<div class="px-8 py-8 animate-fade-in-up">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-black text-operon-deep dark:text-white tracking-tight">Central de Processamento</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium tracking-tight">Gerenciamento neural de tickets e fluxos de ideias.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Tickets Column -->
        <div class="space-y-6">
            <h2 class="text-xs font-black text-operon-deep dark:text-operon-mist uppercase tracking-[0.2em] flex items-center gap-2">
                <span class="p-2 bg-operon-mist dark:bg-operon-mist/10 text-operon-deep dark:text-operon-mist rounded-xl border border-operon-mistDark/30 dark:border-white/10">🎫</span>
                Tickets Operon
            </h2>

            <?php if(empty($tickets)): ?>
                <div class="bg-white dark:bg-[#15191D] p-8 rounded-2xl border border-dashed border-slate-200 dark:border-white/10 text-center text-slate-400 dark:text-slate-500">
                    Nenhum ticket aberto.
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach($tickets as $t): ?>
                        <a href="/admin/support/ticket?id=<?= $t['id'] ?>" class="block ios-card p-5 border-l-4 border-l-operon-deep hover:shadow-premium hover:border-operon-mist transition-all group border border-slate-100">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-black text-operon-deep group-hover:text-black transition-colors tracking-tight"><?= htmlspecialchars($t['subject']) ?></h3>
                                <?php if($t['status'] === 'open'): ?>
                                    <span class="px-2 py-0.5 rounded-md bg-rose-50 text-rose-600 text-[10px] font-black uppercase tracking-wider border border-rose-100">Aberto</span>
                                <?php else: ?>
                                    <span class="px-2 py-0.5 rounded-md bg-operon-mist text-operon-deep text-[10px] font-black uppercase tracking-wider border border-operon-mistDark/30"><?= $t['status'] ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="flex justify-between items-end text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <span class="text-operon-deep dark:text-slate-300"><?= htmlspecialchars($t['client_name']) ?></span>
                                    <span class="text-slate-200 dark:text-slate-700">•</span>
                                    <span class="text-slate-400 dark:text-slate-500"><?= htmlspecialchars($t['project_name']) ?></span>
                                </div>
                                <span class="bg-slate-50 dark:bg-white/5 px-1.5 py-0.5 rounded border border-slate-100 dark:border-white/5"><?= date('d/m H:i', strtotime($t['updated_at'])) ?></span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Ideas Column -->
        <div class="space-y-6">
            <h2 class="text-xs font-black text-operon-deep dark:text-operon-mist uppercase tracking-[0.2em] flex items-center gap-2">
                <span class="p-2 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 rounded-xl border border-amber-100 dark:border-amber-500/10">💡</span>
                Banco de Ideias
            </h2>

             <?php if(empty($ideas)): ?>
                <div class="bg-white dark:bg-[#15191D] p-8 rounded-2xl border border-dashed border-slate-200 dark:border-white/10 text-center text-slate-400 dark:text-slate-500 font-medium text-xs">
                    Nenhuma ideia enviada.
                </div>
            <?php else: ?>
                <div class="space-y-3">
                     <?php foreach($ideas as $idea): ?>
                        <div class="ios-card p-5 bg-white dark:bg-[#15191D] border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-premium transition-all">
                            <h3 class="font-black text-operon-deep dark:text-white mb-2 tracking-tight"><?= htmlspecialchars($idea['title']) ?></h3>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mb-4 font-medium leading-relaxed truncate-2-lines"><?= nl2br(htmlspecialchars($idea['description'])) ?></p>
                            
                            <div class="flex justify-between items-center text-[10px] border-t border-slate-50 dark:border-white/5 pt-4 font-black uppercase tracking-wider">
                                <span class="text-operon-deep dark:text-slate-300 bg-operon-mist/30 dark:bg-white/5 px-2 py-1 rounded-md border border-operon-mist/50 dark:border-white/10">
                                    <?= htmlspecialchars($idea['project_name']) ?>
                                </span>
                                <span class="text-slate-400 dark:text-slate-500"><?= date('d/m/Y', strtotime($idea['created_at'])) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Feedback / Satisfaction Column -->
        <div class="space-y-6">
            <h2 class="text-xs font-black text-operon-deep dark:text-operon-mist uppercase tracking-[0.2em] flex items-center gap-2">
                <span class="p-2 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-xl border border-emerald-100 dark:border-emerald-500/10">⭐️</span>
                Satisfação Neural
            </h2>

             <?php if(empty($feedbacks)): ?>
                <div class="bg-white dark:bg-[#15191D] p-8 rounded-2xl border border-dashed border-slate-200 dark:border-white/10 text-center text-slate-400 dark:text-slate-500 font-medium text-xs">
                    Sem avaliações ainda.
                </div>
            <?php else: ?>
                <div class="space-y-3">
                     <?php foreach($feedbacks as $fb): ?>
                        <?php 
                            $data = json_decode($fb['content'], true);
                            $rating = $data['rating'] ?? 0;
                            $comment = $data['feedback'] ?? '';
                        ?>
                        <div class="ios-card p-5 bg-white dark:bg-[#15191D] border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-premium transition-all">
                            <div class="flex justify-between items-center mb-3">
                                <div class="flex gap-0.5">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <span class="<?= $i <= $rating ? 'text-amber-400' : 'text-slate-100 dark:text-slate-700' ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                                <span class="text-[9px] font-black uppercase tracking-widest text-slate-300 dark:text-slate-600"><?= date('d/m/Y', strtotime($fb['created_at'])) ?></span>
                            </div>
                            
                            <?php if($comment): ?>
                                <p class="text-xs text-slate-600 dark:text-slate-400 mb-4 font-medium leading-relaxed italic border-l-2 border-operon-mist dark:border-operon-mist/20 pl-3">
                                    "<?= htmlspecialchars($comment) ?>"
                                </p>
                            <?php endif; ?>
                            
                            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-wider text-operon-deep dark:text-slate-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-operon-mistDark"></span>
                                <?= htmlspecialchars($fb['project_name']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>
