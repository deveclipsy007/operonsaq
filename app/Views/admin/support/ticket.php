<div class="px-8 py-8 h-[calc(100vh-2rem)] flex flex-col">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-8 shrink-0">
        <div>
            <a href="/admin/support" class="text-[10px] font-black text-slate-400 dark:text-slate-500 hover:text-operon-deep dark:hover:text-white uppercase tracking-widest mb-2 inline-block transition-colors">← Voltar para Central</a>
            <h1 class="text-2xl font-black text-operon-deep dark:text-white tracking-tight">Ticket #<?= $ticket['id'] ?>: <?= htmlspecialchars($ticket['subject']) ?></h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider mt-1">
                <span class="text-operon-deep dark:text-slate-200"><?= htmlspecialchars($ticket['client_name']) ?></span> 
                <span class="mx-2 text-slate-200 dark:text-slate-600">•</span> 
                <span class="text-slate-400 dark:text-slate-500"><?= htmlspecialchars($ticket['project_name']) ?></span>
            </p>
        </div>
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 bg-operon-mist dark:bg-operon-mist/20 text-operon-deep dark:text-operon-mist border border-operon-mistDark/30 dark:border-white/10 rounded-md text-[10px] font-black uppercase tracking-wider shadow-sm">
                    <?= $ticket['status'] ?>
                </span>
                <?php if(($ticket['priority'] ?? 'normal') === 'alta'): ?>
                    <span class="px-3 py-1 bg-rose-600 text-white rounded-md text-[10px] font-black uppercase tracking-widest shadow-sm">
                        Urgente
                    </span>
                <?php endif; ?>
                <span class="px-3 py-1 bg-white dark:bg-[#15191D] border border-slate-200 dark:border-white/10 text-slate-500 dark:text-slate-400 rounded-md text-[10px] font-black uppercase tracking-widest shadow-sm">
                     <?= ucfirst($ticket['category'] ?? 'geral') ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Chat Area -->
    <div class="flex-1 bg-white dark:bg-[#15191D] rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm overflow-hidden flex flex-col">
        
        <!-- Attachments Banner -->
        <?php if(!empty($attachments)): ?>
            <div class="bg-operon-mist/10 dark:bg-white/5 px-6 py-4 border-b border-operon-mist/30 dark:border-white/10 flex items-center gap-4 overflow-x-auto">
                <span class="text-[10px] font-black text-operon-deep dark:text-white uppercase tracking-[0.2em] shrink-0">Anexos Neural:</span>
                <?php foreach($attachments as $att): ?>
                    <a href="<?= $att['file_path'] ?>" target="_blank" class="flex items-center gap-2 bg-white dark:bg-[#1A1C22] px-4 py-2 rounded-xl border border-operon-mist dark:border-white/10 text-[10px] font-black text-operon-deep dark:text-slate-300 hover:bg-operon-deep hover:text-white transition-all shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        <?= htmlspecialchars($att['file_name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Messages List -->
        <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-slate-50 dark:bg-[#0B0E11]/50" id="chat-messages">
            <?php if(empty($messages)): ?>
                <div class="text-center py-12 text-slate-400 dark:text-slate-600 italic">
                    Início da conversa.
                </div>
            <?php else: ?>
                <?php foreach($messages as $msg): ?>
                    <?php $isAdmin = $msg['sender_type'] === 'admin'; ?>
                    <div class="flex w-full <?= $isAdmin ? 'justify-end' : 'justify-start' ?>">
                        <div class="max-w-[75%] <?= $isAdmin ? 'bg-operon-deep dark:bg-operon-deep text-white rounded-l-2xl rounded-tr-2xl shadow-premium' : 'bg-white dark:bg-[#1A1C22] border border-operon-mist dark:border-white/10 text-slate-700 dark:text-slate-300 rounded-r-2xl rounded-tl-2xl shadow-sm' ?> p-5 transition-all">
                            <?php if($isAdmin): ?>
                                <p class="text-[13px] leading-relaxed font-medium"><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
                            <?php else: ?>
                                <!-- Allow HTML for Client (Trix) -->
                                <div class="text-[13px] leading-relaxed prose prose-sm max-w-none prose-slate dark:prose-invert">
                                    <?= $msg['message'] ?>
                                </div>
                            <?php endif; ?>
                            <div class="mt-2 text-[9px] font-black uppercase tracking-widest <?= $isAdmin ? 'text-operon-mist/50 text-right' : 'text-slate-400 dark:text-slate-500' ?>">
                                <?= date('d/m • H:i', strtotime($msg['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Reply Box -->
        <div class="p-6 bg-white dark:bg-[#15191D] border-t border-slate-100 dark:border-white/5 shrink-0">
            <form action="/admin/support/reply" method="POST" class="flex gap-4">
                <input type="hidden" name="ticket_id" value="<?= $ticket['id'] ?>">
                <textarea name="message" rows="2" placeholder="Digite sua resposta neural..." class="flex-1 bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/10 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-operon-mist dark:focus:ring-white/10 focus:bg-white dark:focus:bg-[#1A1C22] resize-none text-slate-700 dark:text-white text-sm font-medium transition-all placeholder-slate-400 dark:placeholder-slate-600" required></textarea>
                <button type="submit" class="bg-operon-deep dark:bg-operon-deep hover:bg-black dark:hover:bg-operon-deep/90 text-white rounded-2xl px-8 font-black shadow-premium hover:-translate-y-0.5 transition-all flex items-center gap-2 uppercase tracking-widest text-xs border border-white/5">
                    <span>Enviar</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
        </div>

    </div>

</div>

<script>
    // Scroll to bottom
    const chat = document.getElementById('chat-messages');
    chat.scrollTop = chat.scrollHeight;
</script>
