<div class="max-w-7xl mx-auto px-4 md:px-8 py-10">
    <!-- Header -->
    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in-up">
        <div>
            <a href="/dashboard" class="text-[10px] font-black text-slate-400 dark:text-slate-500 hover:text-operon-deep dark:hover:text-operon-mist uppercase tracking-[0.2em] mb-3 inline-flex items-center gap-2 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                Regressar ao Córtex
            </a>
            <h1 class="text-3xl font-black text-operon-deep dark:text-white tracking-tight uppercase">Incubadora de Ideias</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium mt-1 tracking-tight">O ambiente para suas expansões e novas visões neurais.</p>
        </div>
        <div class="flex items-center gap-3">
             <div class="h-12 w-12 rounded-2xl bg-operon-mist/30 border border-operon-mist/50 flex items-center justify-center text-2xl shadow-sm text-operon-deep">
                💡
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Form -->
        <div class="lg:col-span-1">
            <div class="ios-card p-8 bg-white dark:bg-[#0D1517] sticky top-24 animate-fade-in border border-slate-100 dark:border-white/5 shadow-premium" style="animation-delay: 100ms">
                <div class="mb-8">
                    <h3 class="font-black text-operon-deep dark:text-white text-lg mb-3 tracking-tight">Nova Flash-Idea?</h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                        Colocamos todas as expansões em "Quarentena Neural" para proteger o fluxo rítmico do desenvolvimento atual. Nossa equipe processará cada entrada estrategicamente.
                    </p>
                </div>

                <form action="/client/projects/ideas/store" method="POST">
                    <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 ml-1">Assunto da Ideia</label>
                            <input type="text" name="title" required placeholder="Ex: Nova interface de métricas" 
                                class="w-full bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/10 rounded-xl text-operon-deep dark:text-white font-bold focus:outline-none focus:ring-4 focus:ring-operon-mist/30 focus:border-operon-mistDark dark:focus:border-operon-mist text-sm h-12 px-4 transition-all placeholder-slate-300 dark:placeholder-slate-600">
                        </div>
                        
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 ml-1">Detalhamento Neural</label>
                            <textarea name="description" rows="4" required placeholder="Como esta ideia expande o projeto?" 
                                class="w-full text-sm text-slate-600 dark:text-white bg-slate-50 dark:bg-white/5 rounded-xl border border-slate-100 dark:border-white/10 focus:outline-none focus:ring-4 focus:ring-operon-mist/30 focus:border-operon-mistDark dark:focus:border-operon-mist resize-none p-4 transition-all placeholder-slate-300 dark:placeholder-slate-600 font-medium"></textarea>
                        </div>

                        <button type="submit" class="w-full py-4 bg-operon-deep hover:bg-black text-white rounded-[18px] font-black text-[10px] uppercase tracking-[0.2em] shadow-premium transition-all transform hover:-translate-y-0.5 border border-white/5 active:scale-95">
                            Sincronizar Ideia
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: List -->
        <div class="lg:col-span-2 space-y-6 animate-fade-in" style="animation-delay: 200ms">
            <?php if(empty($ideas)): ?>
                <div class="flex flex-col items-center justify-center py-16 ios-card border-2 border-dashed border-operon-mist/50 text-slate-400 dark:text-slate-500 bg-white/50 dark:bg-white/5">
                    <span class="text-5xl mb-6 opacity-30 grayscale saturate-0">💡</span>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em]">O repositório neural está vazio.</p>
                </div>
            <?php else: ?>
                <?php foreach($ideas as $idea): ?>
                    <?php
                        $statusColors = match($idea['status']) {
                            'approved' => ['bg' => 'bg-emerald-50 dark:bg-emerald-400/10', 'text' => 'text-emerald-700 dark:text-emerald-400', 'border' => 'border-emerald-100 dark:border-emerald-400/20', 'label' => 'Validado'],
                            'review' => ['bg' => 'bg-operon-mist dark:bg-operon-mist/10', 'text' => 'text-operon-deep dark:text-operon-mist', 'border' => 'border-operon-mistDark/30 dark:border-white/10', 'label' => 'Em Sincronia'],
                            'rejected' => ['bg' => 'bg-rose-50 dark:bg-rose-400/10', 'text' => 'text-rose-700 dark:text-rose-400', 'border' => 'border-rose-100 dark:border-rose-400/20', 'label' => 'Arquivado'],
                            default => ['bg' => 'bg-slate-50 dark:bg-white/5', 'text' => 'text-slate-400 dark:text-slate-500', 'border' => 'border-slate-100 dark:border-white/10', 'label' => 'Processando']
                        };
                    ?>
                    <div class="ios-card bg-white dark:bg-[#0D1517] p-8 border hover:shadow-premium transition-all <?= $statusColors['border'] ?>">
                        <div class="flex items-start justify-between mb-4">
                            <span class="p-3 rounded-2xl text-3xl shadow-sm <?= $statusColors['bg'] ?> bg-opacity-40">
                                <?= match($idea['status']) { 'approved'=>'🚀', 'rejected'=>'📦', 'review'=>'🧐', default=>'✨' } ?>
                            </span>
                            <span class="text-[9px] font-black uppercase tracking-[0.2em] px-3 py-1.5 rounded-lg border shadow-sm <?= $statusColors['bg'] ?> <?= $statusColors['text'] ?> <?= $statusColors['border'] ?>">
                                <?= $statusColors['label'] ?>
                            </span>
                        </div>
                        <h3 class="font-black text-operon-deep dark:text-white text-lg mb-2 tracking-tight"><?= htmlspecialchars($idea['title']) ?></h3>
                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed font-medium"><?= nl2br(htmlspecialchars($idea['description'])) ?></p>
                        <div class="mt-6 pt-6 border-t border-slate-50 dark:border-white/5 text-[9px] font-black uppercase tracking-[0.3em] text-slate-300 dark:text-slate-600">
                            Registro Neural: <?= date('d/m/Y', strtotime($idea['created_at'])) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</div>
