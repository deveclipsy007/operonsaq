<div class="px-4 py-12 animate-fade-in flex flex-col items-center justify-center min-h-[80vh] relative">
    
    <!-- Navigation -->
    <div class="w-full max-w-2xl mb-8">
        <a href="/dashboard" class="inline-flex items-center gap-3 text-[10px] font-black text-slate-400 hover:text-operon-deep dark:hover:text-operon-mist uppercase tracking-widest transition-all group">
            <div class="w-10 h-10 rounded-2xl bg-white dark:bg-white/5 shadow-premium flex items-center justify-center group-hover:bg-operon-mist transition-all border border-slate-100 dark:border-white/10">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
            </div>
            <?= \App\Core\I18n::t('general.back_to_cortex') ?>
        </a>
    </div>

    <!-- Main Card -->
    <div class="w-full max-w-2xl ios-card p-10 md:p-14 border border-slate-100 dark:border-white/5 shadow-premium">
        
        <div class="text-center mb-12">
            <h1 class="text-3xl font-black text-operon-deep dark:text-white tracking-tight uppercase"><?= \App\Core\I18n::t('support.title') ?></h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium mt-2 tracking-tight"><?= \App\Core\I18n::t('support.subtitle') ?></p>
        </div>

        <?php if(isset($_GET['error'])): ?>
            <div class="mb-8 bg-rose-50 border border-rose-100 text-rose-600 p-4 rounded-2xl text-center text-sm font-medium">
                Não foi possível enviar sua solicitação. Tente novamente.
            </div>
        <?php endif; ?>

        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

        <form action="/client/support/store" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ category: 'manutencao', priority: 'normal' }">
            
            <input type="hidden" name="project_id" value="<?= $project['id'] ?? '' ?>">

            <!-- Segmented Control: Category -->
            <div class="space-y-3">
                <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1"><?= \App\Core\I18n::t('support.category') ?></label>
                <div class="bg-operon-mist/20 dark:bg-white/5 p-1.5 rounded-2xl flex relative border border-operon-mist/50 dark:border-white/10">
                    <label class="flex-1 text-center cursor-pointer relative z-10">
                        <input type="radio" name="category" value="manutencao" class="sr-only peer" checked @click="category = 'manutencao'">
                        <div class="py-3 text-[10px] font-black uppercase tracking-widest rounded-xl text-slate-500 dark:text-slate-400 peer-checked:bg-white dark:peer-checked:bg-white/10 peer-checked:text-operon-deep dark:peer-checked:text-white peer-checked:shadow-premium transition-all">Manutenção</div>
                    </label>
                    <label class="flex-1 text-center cursor-pointer relative z-10">
                        <input type="radio" name="category" value="alteracao" class="sr-only peer" @click="category = 'alteracao'">
                        <div class="py-3 text-[10px] font-black uppercase tracking-widest rounded-xl text-slate-500 dark:text-slate-400 peer-checked:bg-white dark:peer-checked:bg-white/10 peer-checked:text-operon-deep dark:peer-checked:text-white peer-checked:shadow-premium transition-all">Alteração</div>
                    </label>
                    <label class="flex-1 text-center cursor-pointer relative z-10">
                        <input type="radio" name="category" value="duvida" class="sr-only peer" @click="category = 'duvida'">
                        <div class="py-3 text-[10px] font-black uppercase tracking-widest rounded-xl text-slate-500 dark:text-slate-400 peer-checked:bg-white dark:peer-checked:bg-white/10 peer-checked:text-operon-deep dark:peer-checked:text-white peer-checked:shadow-premium transition-all">Dúvida</div>
                    </label>
                     <label class="flex-1 text-center cursor-pointer relative z-10">
                        <input type="radio" name="category" value="outro" class="sr-only peer" @click="category = 'outro'">
                        <div class="py-3 text-[10px] font-black uppercase tracking-widest rounded-xl text-slate-500 dark:text-slate-400 peer-checked:bg-white dark:peer-checked:bg-white/10 peer-checked:text-operon-deep dark:peer-checked:text-white peer-checked:shadow-premium transition-all"><?= \App\Core\I18n::t('action.other', [], 'Outro') ?></div>
                    </label>
                </div>
            </div>

            <!-- Segmented Control: Priority -->
             <div class="space-y-3">
                <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1"><?= \App\Core\I18n::t('support.priority') ?></label>
                <div class="flex gap-6">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="radio" name="priority" value="normal" class="sr-only peer" checked>
                            <div class="w-6 h-6 rounded-full border-2 border-operon-mist dark:border-white/10 peer-checked:border-operon-deep dark:peer-checked:border-operon-mist peer-checked:bg-operon-deep dark:peer-checked:bg-operon-mist transition-all after:content-[''] after:absolute after:top-1.5 after:left-1.5 after:w-2 after:h-2 after:bg-white dark:after:bg-[#0D1517] after:rounded-full after:opacity-0 peer-checked:after:opacity-100 shadow-sm"></div>
                        </div>
                        <span class="text-[10px] font-black text-slate-500 dark:text-slate-400 group-hover:text-operon-deep dark:group-hover:text-operon-mist uppercase tracking-widest transition-colors">Fluxo Normal</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="radio" name="priority" value="alta" class="sr-only peer">
                            <div class="w-6 h-6 rounded-full border-2 border-operon-mist dark:border-white/10 peer-checked:border-rose-600 peer-checked:bg-rose-600 transition-all after:content-[''] after:absolute after:top-1.5 after:left-1.5 after:w-2 after:h-2 after:bg-white after:rounded-full after:opacity-0 peer-checked:after:opacity-100 shadow-sm"></div>
                        </div>
                        <span class="text-[10px] font-black text-slate-500 dark:text-slate-400 group-hover:text-rose-600 uppercase tracking-widest transition-colors">Alta Prioridade</span>
                    </label>
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-3">
                <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1"><?= \App\Core\I18n::t('support.report') ?></label>
                <input id="description" type="hidden" name="description" required>
                <trix-editor input="description" class="trix-content bg-white dark:bg-white/5 border border-operon-mist dark:border-white/10 rounded-2xl px-5 py-5 text-operon-deep dark:text-white min-h-[160px] focus:outline-none focus:ring-4 focus:ring-operon-mist/30 focus:border-operon-mistDark transition-all text-sm leading-relaxed font-medium shadow-sm"></trix-editor>
            </div>

            <!-- Attachments -->
             <div class="space-y-3">
                <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1"><?= \App\Core\I18n::t('support.attachments') ?></label>
                <div class="relative">
                    <input type="file" name="attachments[]" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" 
                        class="block w-full text-[10px] font-black uppercase text-slate-400 dark:text-slate-500
                        file:mr-4 file:py-3 file:px-6
                        file:rounded-xl file:border-0
                        file:text-[10px] file:font-black file:uppercase file:tracking-widest
                        file:bg-operon-mist file:text-operon-deep
                        hover:file:bg-operon-mistDark
                        cursor-pointer border border-operon-mist dark:border-white/10 rounded-2xl bg-white dark:bg-white/5 shadow-sm transition-all
                      "/>
                </div>
                <p class="text-[9px] text-slate-400 dark:text-slate-500 ml-1 font-bold uppercase tracking-wider">Máximo de 5MB por arquivo. PDF, Imagens e Docs.</p>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full bg-operon-deep hover:bg-black text-white font-black py-5 rounded-[20px] shadow-premium transition-all active:scale-[0.98] flex items-center justify-center gap-3 uppercase tracking-[0.2em] text-xs border border-white/5">
                <?= \App\Core\I18n::t('support.submit', [], 'Transmitir Solicitação') ?>
            </button>

        </form>
    </div>

    <!-- History List -->
    <div class="w-full max-w-2xl mt-12 mb-12" 
        x-data="{ activeTicket: null, showModal: false }"
        <?php 
            $openId = $_GET['open_ticket_id'] ?? null;
            if($openId && !empty($tickets)) {
                $targetTicket = null;
                foreach($tickets as $t) {
                    if($t['id'] == $openId) {
                        $targetTicket = $t;
                        break;
                    }
                }
                if ($targetTicket) {
                    $msgs = $targetTicket['messages'] ?? [];
                    $json = json_encode([
                        'id' => $targetTicket['id'],
                        'subject' => $targetTicket['subject'],
                        'status' => $targetTicket['status'],
                        'priority' => $targetTicket['priority'],
                        'created_at' => date('d/m/Y H:i', strtotime($targetTicket['created_at'])),
                        'messages' => $msgs,
                        'attachments' => $targetTicket['attachments'] ?? []
                    ]);
                    echo "x-init='activeTicket = " . htmlspecialchars($json, ENT_QUOTES, 'UTF-8') . "; showModal = true; window.history.replaceState({}, document.title, window.location.pathname);'";
                }
            }
        ?>
    >
        <h2 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.3em] mb-8 px-2 flex items-center gap-3">
            <span class="w-2 h-2 rounded-full bg-operon-mist animate-pulse"></span>
            <?= \App\Core\I18n::t('support.your_tickets') ?>
        </h2>

        <?php if (empty($tickets)): ?>
            <div class="text-center py-8 bg-white/50 border border-slate-200/50 rounded-2xl border-dashed">
                <p class="text-sm text-slate-400"><?= \App\Core\I18n::t('support.no_tickets') ?></p>
            </div>
        <?php else: ?>
            <div class="space-y-3">
                <?php foreach($tickets as $t): ?>
                    <?php 
                        // Check for Admin Reply
                        $msgs = $t['messages'] ?? [];
                        $hasAdminReply = false;
                        foreach($msgs as $m) {
                            if($m['sender_type'] === 'admin') {
                                $hasAdminReply = true;
                                break;
                            }
                        }
                    ?>
                     <div 
                        <?php if($hasAdminReply): ?>
                            @click="activeTicket = <?= htmlspecialchars(json_encode([
                                'id' => $t['id'],
                                'subject' => $t['subject'],
                                'status' => $t['status'],
                                'priority' => $t['priority'],
                                'created_at' => date('d/m/Y H:i', strtotime($t['created_at'])),
                                'messages' => $msgs,
                                'attachments' => $t['attachments'] ?? []
                            ])) ?>; showModal = true"
                            class="ios-card bg-white dark:bg-[#0D1517] p-6 border border-slate-100 dark:border-white/5 shadow-premium flex items-center justify-between hover:scale-[1.01] transition-all duration-300 cursor-pointer group hover:border-operon-mist"
                        <?php else: ?>
                            class="ios-card bg-slate-50/50 dark:bg-white/5 p-6 border border-slate-100 dark:border-white/5 flex items-center justify-between opacity-80 cursor-default"
                        <?php endif; ?>
                    >
                        <div class="flex-1 min-w-0 pr-6">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="bg-operon-mist text-operon-deep text-[10px] font-black px-2 py-0.5 rounded-md border border-operon-mistDark/30">#<?= $t['id'] ?></span>
                                <h3 class="font-black text-operon-deep dark:text-white text-sm truncate <?= $hasAdminReply ? 'group-hover:text-black dark:group-hover:text-operon-mist transition-colors' : '' ?>">
                                    <?= htmlspecialchars($t['subject']) ?>
                                </h3>
                                <?php if(!$hasAdminReply): ?>
                                    <span class="text-[9px] bg-slate-100 text-slate-400 px-2 py-0.5 rounded-md font-black uppercase tracking-wider">Aguardando</span>
                                <?php endif; ?>
                            </div>
                            <div class="flex items-center gap-2 text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                                <span><?= date('d/m/Y', strtotime($t['created_at'])) ?></span>
                                <span class="text-slate-200">•</span>
                                <span class="text-slate-400"><?= $t['priority'] === 'alta' ? 'Urgent' : 'Normal' ?></span>
                            </div>
                        </div>
                        <div class="shrink-0 text-right">
                             <?php
                                $statusColors = [
                                    'open' => 'bg-operon-mist text-operon-deep border-operon-mistDark/30',
                                    'in_progress' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'resolved' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'closed' => 'bg-slate-100 text-slate-500 border-slate-200'
                                ];
                                $statusLabel = [
                                    'open' => 'Em Análise',
                                    'in_progress' => 'Andamento',
                                    'resolved' => 'Finalizado',
                                    'closed' => 'Encerrado'
                                ];
                                $st = $t['status'] ?? 'open';
                            ?>
                            <span class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-[0.1em] border shadow-sm transition-all <?= $statusColors[$st] ?? $statusColors['open'] ?>">
                                <?= $statusLabel[$st] ?? $st ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

                <div x-show="showModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-8"
                    class="relative bg-white dark:bg-[#0D1517] rounded-[40px] w-full max-w-2xl shadow-premium overflow-hidden flex flex-col h-[85vh] border border-slate-100 dark:border-white/5">
                    
                    <!-- Header -->
                    <div class="px-8 py-6 border-b border-slate-50 dark:border-white/5 flex items-center justify-between bg-white/80 dark:bg-[#0D1517]/80 backdrop-blur-xl z-20">
                        <div class="flex items-center gap-5">
                            <span class="bg-operon-mist text-operon-deep text-[10px] font-black px-3 py-1 rounded-lg border border-operon-mistDark/30 shadow-sm" x-text="'#' + activeTicket.id"></span>
                             <div class="flex flex-col">
                                <h3 class="text-sm font-black text-operon-deep dark:text-white truncate max-w-[220px]" x-text="activeTicket.subject"></h3>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span class="text-[9px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest" x-text="activeTicket.status === 'open' ? 'Sincronizando' : 'Em Atendimento'"></span>
                                </div>
                             </div>
                        </div>
                        <button @click="showModal = false" class="text-slate-300 hover:text-operon-deep dark:hover:text-operon-mist transition-all p-2 bg-slate-50 dark:bg-white/5 hover:bg-operon-mist dark:hover:bg-white/10 rounded-2xl border border-slate-100 dark:border-white/10">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Chat Body -->
                    <div class="flex-1 overflow-y-auto p-8 space-y-8 bg-slate-50/50 dark:bg-black/20" id="chat-container">
                        <!-- Messages Loop -->
                        <template x-for="msg in activeTicket.messages" :key="msg.id">
                            <div class="flex w-full" :class="msg.sender_type === 'client' ? 'justify-end' : 'justify-start'">
                                <div class="max-w-[85%] relative group">
                                    
                                    <!-- Sender Label (Left Only) -->
                                    <div x-show="msg.sender_type !== 'client'" class="text-[9px] font-black text-operon-deep uppercase tracking-[0.2em] mb-2 ml-1 flex items-center gap-1.5">
                                        Support Squad
                                        <!-- Verified Badge -->
                                        <svg class="w-3.5 h-3.5 text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
 
                                    <!-- Bubble -->
                                    <div class="px-5 py-4 shadow-sm text-sm leading-relaxed transition-all" 
                                         :class="msg.sender_type === 'client' ? 'bg-operon-deep text-white rounded-[24px] rounded-tr-sm border border-white/5' : 'bg-white dark:bg-white/5 border border-slate-100 dark:border-white/10 text-slate-700 dark:text-slate-200 rounded-[24px] rounded-tl-sm shadow-premium'">
                                        <div x-html="msg.message" class="prose prose-sm max-w-none font-medium" :class="msg.sender_type === 'client' ? 'prose-invert' : 'dark:prose-invert'"></div>
                                    </div>
                                    <!-- Meta -->
                                    <div class="mt-2 text-[8px] font-black uppercase tracking-widest opacity-40 px-1" 
                                         :class="msg.sender_type === 'client' ? 'text-right' : 'text-left'"
                                         x-text="new Date(msg.created_at).toLocaleDateString() + ' • ' + new Date(msg.created_at).toLocaleTimeString().slice(0,5)">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    
                    <!-- Reply Footer -->
                    <div class="p-6 bg-white dark:bg-[#0D1517] border-t border-slate-50 dark:border-white/5 shrink-0">
                        <form action="/client/support/reply" method="POST" class="relative flex items-end gap-3">
                            <input type="hidden" name="ticket_id" :value="activeTicket.id">
                            <textarea name="message" required rows="1" placeholder="Escreva sua resposta neural..." class="w-full bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/10 rounded-2xl px-5 py-4 text-operon-deep dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-operon-mist/30 focus:border-operon-mistDark dark:focus:border-operon-mist transition-all resize-none text-sm font-medium leading-relaxed max-h-32 shadow-sm" style="min-height: 56px;"></textarea>
                            <button type="submit" class="bg-operon-deep hover:bg-black dark:hover:bg-operon-mist dark:hover:text-operon-deep text-white rounded-2xl p-4 shadow-premium transition-all active:scale-95 flex-shrink-0 border border-white/5">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </template>
    </div>

    <!-- Info Footer -->
    <div class="mt-4 text-center max-w-md mx-auto mb-8">
        <p class="text-xs text-slate-400 leading-relaxed">
            Nossa equipe técnica analisa solicitações de segunda a sexta, das 9h às 18h. Para emergências fora do horário, o tempo de resposta pode ser maior.
        </p>
    </div>

</div>
