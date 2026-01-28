
<!-- Alpine Data Context -->
<div x-data="eventEditor()" class="min-h-screen pb-20">

    <!-- Topbar -->
    <div class="mb-8 flex items-center justify-between px-2">
        <div>
            <a href="/admin" class="text-slate-400 dark:text-slate-500 hover:text-operon-deep dark:hover:text-operon-mist text-[10px] font-black uppercase tracking-[0.2em] flex items-center mb-2 transition-colors">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Dashboard
            </a>
            <h1 class="text-3xl font-black text-operon-deep dark:text-white tracking-tight"><?= htmlspecialchars($project['name']) ?></h1>
        </div>
        
        <?php if (!empty($project['cover_url'])): ?>
            <div class="absolute top-0 right-0 w-full h-32 -z-10 opacity-20 overflow-hidden rounded-b-[3rem]">
                <img src="<?= $project['cover_url'] ?>" class="w-full h-full object-cover blur-sm">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-50 dark:to-[#0F1216]"></div>
            </div>
        <?php endif; ?>
        
        <!-- Header Controls -->
        <div class="flex items-center gap-3" x-data="{ open: false }">
            
            <!-- Logs Button -->
            <a href="/admin/projects/logs?id=<?= $project['id'] ?>" 
               class="group flex items-center gap-2 pl-2 pr-4 py-2 bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl text-slate-600 dark:text-slate-200 font-bold text-sm shadow-sm hover:border-indigo-300 hover:ring-2 hover:ring-indigo-100/50 hover:text-indigo-600 transition-all">
                <div class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-white/5 group-hover:bg-indigo-50 group-hover:text-indigo-600 flex items-center justify-center text-slate-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <span>Logs</span>
            </a>

            <!-- Config Button (Settings) -->
            <a href="/admin/projects/edit?id=<?= $project['id'] ?>" 
               class="group flex items-center gap-2 pl-2 pr-4 py-2 bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl text-slate-600 dark:text-slate-200 font-bold text-sm shadow-sm hover:border-operon-mist hover:ring-2 hover:ring-operon-mist/20 hover:text-operon-deep transition-all">
                <div class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-white/5 group-hover:bg-operon-mist group-hover:text-operon-deep flex items-center justify-center text-slate-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <span>Ajustes</span>
            </a>

            <!-- Checkpoints Button -->
            <a href="/admin/projects/checkpoints?id=<?= $project['id'] ?>" 
               class="group flex items-center gap-2 pl-2 pr-4 py-2 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20 rounded-xl text-emerald-700 dark:text-emerald-400 font-bold text-sm shadow-sm hover:border-emerald-300 hover:ring-2 hover:ring-emerald-200/50 transition-all">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-500/20 group-hover:bg-emerald-200 dark:group-hover:bg-emerald-500/30 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span>Checkpoints</span>
            </a>

            <!-- Template Launcher (Primary) -->
            <div class="relative">
                <button @click="open = !open" 
                    class="flex items-center gap-2 pl-3 pr-4 py-2 bg-operon-deep hover:bg-black text-white rounded-xl font-bold text-sm shadow-premium hover:-translate-y-0.5 transition-all group border border-white/5">
                    <span class="text-lg group-hover:rotate-12 transition-transform">🚀</span>
                    <span>Lançar Neural</span>
                    <svg class="w-4 h-4 text-white/30 ml-1 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <!-- Dropdown Menu -->
                <div x-show="open" @click.away="open = false" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="transform opacity-0 scale-95 -translate-y-2"
                     x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                     class="absolute right-0 mt-3 w-80 bg-white dark:bg-[#1A1C22] rounded-2xl shadow-2xl border border-slate-100 dark:border-white/10 z-50 overflow-hidden ring-1 ring-black ring-opacity-5">
                    
                    <div class="bg-slate-50 dark:bg-white/5 px-4 py-2 border-b border-slate-100 dark:border-white/5">
                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Escolha um atalho</span>
                    </div>

                    <div class="max-h-[300px] overflow-y-auto">
                        <template x-for="template in templates">
                            <button @click="loadTemplate(template); open = false" class="w-full text-left px-4 py-3 hover:bg-slate-50 dark:hover:bg-white/5 border-b border-slate-50 dark:border-white/5 last:border-0 transition-colors group">
                                <span class="block font-bold text-slate-800 dark:text-slate-200 group-hover:text-operon-deep dark:group-hover:text-white transition-colors" x-text="template.name"></span>
                                <span class="block text-xs text-slate-500 dark:text-slate-500 mt-0.5" x-text="template.desc_preview"></span>
                            </button>
                        </template>
                    </div>
                    
                    <div class="bg-slate-50/50 dark:bg-white/5 p-2 text-center">
                        <a href="#" class="text-[10px] font-bold text-slate-400 hover:text-operon-mist transition-colors">Gerenciar Templates</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- LEFT: Editor Form (Cockpit) -->
        <div class="lg:col-span-12 xl:col-span-5 relative z-20">
            <div class="card-apple sticky top-24 p-0">
                
                <!-- Header with iOS Segmented Control -->
                <div class="p-3 border-b border-slate-50 dark:border-white/5 bg-white/50 dark:bg-white/5 backdrop-blur-sm rounded-t-2xl z-10 relative">
                    <div class="flex p-1 bg-operon-mist/20 dark:bg-white/5 rounded-xl border border-operon-mist/50 dark:border-white/10">
                        
                        <!-- Timeline -->
                        <button type="button" @click="form.type = 'MICRO'" 
                            :class="['MICRO', 'MACRO'].includes(form.type) ? 'bg-white dark:bg-white/10 text-operon-deep dark:text-white shadow-sm border border-operon-mist dark:border-white/20' : 'text-slate-400 dark:text-slate-500 hover:text-operon-deep dark:hover:text-slate-300'" 
                            class="flex-1 py-2.5 rounded-lg text-[10px] font-black uppercase tracking-wider transition-all duration-200 flex items-center justify-center gap-1.5 focus:outline-none">
                            <svg class="w-3.5 h-3.5" :class="['MICRO', 'MACRO'].includes(form.type) ? 'text-operon-deep dark:text-white' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Timeline
                        </button>

                        <!-- Warning -->
                        <button type="button" @click="form.type = 'WARNING'" 
                            :class="form.type === 'WARNING' ? 'bg-white dark:bg-white/10 text-operon-deep dark:text-white shadow-sm border border-operon-mist dark:border-white/20' : 'text-slate-400 dark:text-slate-500 hover:text-operon-deep dark:hover:text-slate-300'" 
                            class="flex-1 py-2.5 rounded-lg text-[10px] font-black uppercase tracking-wider transition-all duration-200 flex items-center justify-center gap-1.5 focus:outline-none">
                            <svg class="w-3.5 h-3.5" :class="form.type === 'WARNING' ? 'text-amber-500' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            Aviso
                        </button>

                        <!-- Doc -->
                        <button type="button" @click="form.type = 'DOCUMENT'" 
                            :class="form.type === 'DOCUMENT' ? 'bg-white dark:bg-white/10 text-operon-deep dark:text-white shadow-sm border border-operon-mist dark:border-white/20' : 'text-slate-400 dark:text-slate-500 hover:text-operon-deep dark:hover:text-slate-300'" 
                            class="flex-1 py-2.5 rounded-lg text-[10px] font-black uppercase tracking-wider transition-all duration-200 flex items-center justify-center gap-1.5 focus:outline-none">
                            <svg class="w-3.5 h-3.5" :class="form.type === 'DOCUMENT' ? 'text-operon-deep dark:text-white' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            Doc
                        </button>

                        <!-- Article -->
                        <button type="button" @click="form.type = 'ARTICLE'" 
                            :class="form.type === 'ARTICLE' ? 'bg-white dark:bg-white/10 text-operon-deep dark:text-white shadow-sm border border-operon-mist dark:border-white/20' : 'text-slate-400 dark:text-slate-500 hover:text-operon-deep dark:hover:text-slate-300'" 
                            class="flex-1 py-2.5 rounded-lg text-[10px] font-black uppercase tracking-wider transition-all duration-200 flex items-center justify-center gap-1.5 focus:outline-none">
                            <svg class="w-3.5 h-3.5" :class="form.type === 'ARTICLE' ? 'text-operon-deep dark:text-white' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                            Artigo
                        </button>

                        <!-- Action -->
                        <button type="button" @click="form.type = 'NEXT_ACTION'" 
                            :class="form.type === 'NEXT_ACTION' ? 'bg-white dark:bg-white/10 text-operon-deep dark:text-white shadow-sm border border-operon-mist dark:border-white/20' : 'text-slate-400 dark:text-slate-500 hover:text-operon-deep dark:hover:text-slate-300'" 
                            class="flex-1 py-2.5 rounded-lg text-[10px] font-black uppercase tracking-wider transition-all duration-200 flex items-center justify-center gap-1.5 focus:outline-none">
                            <svg class="w-3.5 h-3.5" :class="form.type === 'NEXT_ACTION' ? 'text-operon-deep dark:text-white' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            Ação
                        </button>

                    </div>
                </div>

                <form :action="form.type === 'NEXT_ACTION' ? '/admin/projects/update_next_action' : '/admin/projects/events/store'" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                    <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                    <input type="hidden" name="type" :value="form.type"> <!-- Persist Type -->
                    
                    <!-- NEXT ACTION FIELDS -->
                    <div x-show="form.type === 'NEXT_ACTION'" class="space-y-4">
                        <div class="group">
                             <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase mb-1">Ação Esperada (Cliente)</label>
                             <input type="text" name="next_action" value="<?= htmlspecialchars($project['next_action'] ?? '') ?>" 
                                :required="form.type === 'NEXT_ACTION'" placeholder="Ex: Aprovar Layout da Home" 
                                class="w-full text-lg font-bold border-0 border-b-2 border-slate-100 dark:border-white/10 focus:border-operon-mist focus:ring-0 px-0 bg-transparent placeholder-slate-300 transition-colors text-slate-800 dark:text-white">
                        </div>
                        
                        <!-- Link Input (Optional) -->
                        <div class="group">
                             <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase mb-1">Link da Ação (Opcional)</label>
                             <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">🔗</span>
                                <input type="url" name="next_action_link" value="<?= htmlspecialchars($project['next_action_link'] ?? '') ?>" placeholder="https://..." 
                                    class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-lg text-slate-800 dark:text-white font-medium focus:ring-2 focus:ring-operon-mist/20 text-sm h-12 pl-10 pr-3">
                             </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                 <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase mb-1">Prazo</label>
                                 <input type="date" name="next_action_deadline" value="<?= htmlspecialchars($project['next_action_deadline'] ?? '') ?>" 
                                    class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-lg text-slate-800 dark:text-white font-bold focus:ring-2 focus:ring-operon-mist/20 text-sm h-12 px-3">
                            </div>
                            <div>
                                 <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase mb-1">Tipo</label>
                                 <select x-model="form.next_action_type" name="next_action_type" class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-lg text-slate-800 dark:text-white font-bold focus:ring-2 focus:ring-operon-mist/20 text-sm h-12 px-3">
                                     <option value="info" <?= ($project['next_action_type'] ?? '') == 'info' ? 'selected' : '' ?>>Informativo</option>
                                     <option value="approval" <?= ($project['next_action_type'] ?? '') == 'approval' ? 'selected' : '' ?>>Aprovação</option>
                                     <option value="upload" <?= ($project['next_action_type'] ?? '') == 'upload' ? 'selected' : '' ?>>Envio de Arquivo</option>
                                     <option value="payment" <?= ($project['next_action_type'] ?? '') == 'payment' ? 'selected' : '' ?>>Pagamento</option>
                                     <option value="poll" <?= ($project['next_action_type'] ?? '') == 'poll' ? 'selected' : '' ?>>Enquete 📊</option>
                                 </select>
                            </div>
                        </div>

                         <div x-show="form.next_action_type === 'poll'" class="group">
                             <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Opções da Enquete (Uma por linha)</label>
                             <?php 
                                $pollData = json_decode($project['next_action_data'] ?? '{}', true);
                                $currentOptions = isset($pollData['options']) ? implode("\n", $pollData['options']) : '';
                                $votes = $pollData['votes'] ?? [];
                                $totalVotes = array_sum($votes);
                             ?>
                             <textarea name="poll_options" rows="3" placeholder="Opção A&#10;Opção B&#10;Opção C" 
                                class="w-full text-sm text-slate-600 bg-slate-50 rounded-lg border-0 focus:ring-2 focus:ring-indigo-100 resize-none p-4 transition-shadow mb-2"><?= htmlspecialchars($currentOptions) ?></textarea>
                             
                             <!-- Vote Results Display Removed (Moved to Feedback) -->
                             <?php if (!empty($votes)): ?>
                                <div class="bg-indigo-50 dark:bg-indigo-500/10 p-3 rounded-lg mt-2 flex items-center justify-between">
                                    <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400">📊 Resultados visíveis em Feedback</span>
                                    <a href="/admin/projects/feedback?id=<?= $project['id'] ?>" class="text-[10px] font-black uppercase tracking-wider text-indigo-500 hover:text-indigo-700 underline">Ver Resultados →</a>
                                </div>
                             <?php endif; ?>
                        </div>
                    </div>

                    <!-- STANDARD EVENT FIELDS (Hidden when NEXT_ACTION) -->
                    <div x-show="form.type !== 'NEXT_ACTION'" class="space-y-6">
                        <!-- Dynamic Title Input -->
                        <div class="group">
                            <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase mb-1" x-text="typeLabels[form.type] ? typeLabels[form.type].title : 'Título'">Título</label>
                            <input type="text" x-model="form.title" name="title" :required="form.type !== 'NEXT_ACTION'" 
                                class="w-full text-lg font-bold border-0 border-b-2 border-slate-100 dark:border-white/10 focus:border-operon-mist focus:ring-0 px-0 bg-transparent placeholder-slate-300 transition-colors text-slate-800 dark:text-white">
                        </div>
                        
                        <!-- Dynamic Description/Context -->
                        <div class="group">
                             <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase mb-1" x-text="typeLabels[form.type] ? typeLabels[form.type].desc : 'Conteúdo'">Conteúdo</label>
                            <textarea x-model="form.description" name="description" rows="4" 
                                class="w-full text-sm text-slate-600 dark:text-slate-300 bg-slate-50 dark:bg-white/5 rounded-lg border-0 focus:ring-2 focus:ring-operon-mist/20 resize-none p-4 transition-shadow" 
                                placeholder="Escreva aqui..."></textarea>
                        </div>
                    </div>

                    <!-- CONDITIONAL FIELDS -->

                    <!-- 1. Timeline Controls -->
                    <div x-show="['MICRO', 'MACRO'].includes(form.type)" class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                 <label class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase">Impacto</label>
                                 <div class="flex bg-slate-100 dark:bg-white/5 p-1 rounded-lg">
                                     <button type="button" @click="form.type = 'MICRO'" :class="form.type === 'MICRO' ? 'bg-white dark:bg-white/10 text-emerald-600 dark:text-emerald-400 shadow-sm' : 'text-slate-400'" class="flex-1 py-1.5 text-xs font-bold rounded-md transition-all">Micro</button>
                                     <button type="button" @click="form.type = 'MACRO'" :class="form.type === 'MACRO' ? 'bg-white dark:bg-white/10 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-slate-400'" class="flex-1 py-1.5 text-xs font-bold rounded-md transition-all">Macro</button>
                                 </div>
                            </div>
                             <div class="space-y-2">
                                 <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</label>
                                 <select name="status" x-model="form.status" class="w-full text-xs font-bold rounded-xl border-operon-mist bg-white h-10 shadow-sm focus:ring-operon-mist focus:border-operon-deep">
                                     <option value="done">✅ Concluído</option>
                                     <option value="in_progress">🔵 Em Progresso</option>
                                     <option value="pending">🟡 Pendente</option>
                                 </select>
                            </div>
                        </div>
                        <div class="bg-operon-mist/10 p-4 rounded-xl border border-operon-mist/30" x-show="form.status === 'in_progress'">
                            <label class="flex justify-between text-[10px] font-black text-operon-deep uppercase tracking-widest mb-3"><span>Progresso</span><span x-text="form.progress + '%'"></span></label>
                            <input type="range" name="progress_percent" x-model="form.progress" class="w-full h-1.5 bg-operon-mist rounded-full appearance-none cursor-pointer accent-operon-deep shadow-inner">
                        </div>
                    </div>

                    <!-- 2. Warning Controls -->
                    <div x-show="form.type === 'WARNING'" class="space-y-4">
                        <label class="block text-xs font-bold text-slate-400 uppercase">Nível do Alerta</label>
                        <div class="flex gap-2">
                             <button type="button" @click="form.style = 'info'" :class="form.style === 'info' ? 'ring-2 ring-operon-deep' : 'opacity-60'" class="flex-1 bg-operon-mist text-operon-deep py-2 rounded-xl text-xs font-black uppercase tracking-wider">ℹ️ Info</button>
                             <button type="button" @click="form.style = 'warning'" :class="form.style === 'warning' ? 'ring-2 ring-amber-500' : 'opacity-60'" class="flex-1 bg-amber-100 text-amber-700 py-2 rounded-xl text-xs font-black uppercase tracking-wider">⚠️ Atenção</button>
                             <button type="button" @click="form.style = 'danger'" :class="form.style === 'danger' ? 'ring-2 ring-red-500' : 'opacity-60'" class="flex-1 bg-red-100 text-red-700 py-2 rounded-xl text-xs font-black uppercase tracking-wider">🚨 Crítico</button>
                        </div>
                        <input type="hidden" name="style" :value="form.style">
                    </div>

                    <!-- 3. Document/Article Controls -->
                    <div x-show="['DOCUMENT', 'ARTICLE'].includes(form.type)" class="space-y-4">
                        <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:border-indigo-400 transition-colors cursor-pointer relative bg-slate-50">
                            <input type="file" name="images[]" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <svg class="mx-auto h-8 w-8 text-slate-300" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            <p class="mt-2 text-xs text-slate-500 font-medium" x-text="form.type === 'DOCUMENT' ? 'Upload do Arquivo (PDF/Doc)' : 'Imagem de Capa'"></p>
                        </div>
                        <div x-show="form.type === 'DOCUMENT'">
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Texto do Botão</label>
                            <input type="text" name="btn_label" placeholder="Baixar Arquivo" class="input-field text-xs">
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="is_pinned" x-model="form.is_pinned" class="rounded text-indigo-600 focus:ring-indigo-500 border-slate-300">
                            <span class="text-xs font-bold text-slate-500">📌 Fixar</span>
                        </label>
                        <button type="submit" class="bg-slate-900 hover:bg-black text-white px-6 py-2.5 rounded-lg font-bold shadow-lg transition-all transform hover:-translate-y-0.5 text-sm flex items-center gap-2">
                            <span x-text="form.type === 'NEXT_ACTION' ? 'Salvar Ação' : 'Adicionar Bloco'">Adicionar Bloco</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <!-- RIGHT: Timeline "God Mode" -->
        <div class="hidden lg:block lg:col-span-12 xl:col-span-7 pl-8">
            <div class="sticky top-24">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Visão Real (Cliente)</h3>
                    </div>
                </div>

                <!-- ADMIN TIMELINE RENDERER (Based on Client V2) -->
                <div class="bg-[#1A1C22] rounded-3xl p-6 border border-white/10 shadow-inner h-[800px] overflow-y-auto custom-scrollbar">
                    
                    <!-- KPI Header -->
                    <div class="grid grid-cols-4 gap-2 mb-6">
                        <div class="bg-[#15191D] p-3 rounded-xl shadow-sm border border-white/10">
                            <p class="text-[10px] uppercase font-bold text-slate-400">Progresso</p>
                            <p class="text-xl font-bold text-white"><?= $kpis['progress'] ?>%</p>
                        </div>
                        <div class="bg-[#15191D] p-3 rounded-xl shadow-sm border border-white/10">
                             <p class="text-[10px] uppercase font-bold text-slate-400">Prazo</p>
                             <p class="text-xl font-bold text-white"><?= $kpis['days_remaining'] ?>d</p>
                        </div>
                        <div class="bg-[#15191D] p-3 rounded-xl shadow-sm border border-white/10">
                             <p class="text-[10px] uppercase font-bold text-slate-400">Entregas</p>
                             <p class="text-xl font-bold text-white"><?= $kpis['done_tasks'] ?>/<?= $kpis['total_tasks'] ?></p>
                        </div>
                        <div class="bg-[#15191D] p-3 rounded-xl shadow-sm border border-white/10">
                             <p class="text-[10px] uppercase font-bold text-slate-400">Saúde</p>
                             <?php
                                $healthLabel = match($kpis['health']) {
                                    'on_track' => '<span class="text-emerald-500">Ok</span>',
                                    'at_risk' => '<span class="text-amber-500">Atenção</span>',
                                    'off_track' => '<span class="text-red-500">Crítico</span>',
                                    default => '<span class="text-emerald-500">Ok</span>'
                                };
                             ?>
                             <p class="text-lg font-bold"><?= $healthLabel ?></p>
                        </div>
                    </div>

                    <!-- Progress Phases -->
                    <div class="relative py-4 mb-12">
                        <!-- Progress Line Background -->
                        <div class="absolute top-1/2 left-0 w-full h-1 bg-slate-200 dark:bg-white/5 -z-10 rounded-full -translate-y-1/2"></div>
                        
                        <!-- Active Progress Line -->
                        <?php 
                            $totalPhases = count($phases);
                            $activePhaseIndex = 0;
                            foreach($phases as $index => $phase) {
                                if($phase['status'] === 'active') {
                                    $activePhaseIndex = $index;
                                    break;
                                }
                            }
                            if ($phases[$totalPhases-1]['status'] === 'completed') {
                                $activePhaseIndex = $totalPhases - 1;
                            } elseif ($activePhaseIndex === 0 && $phases[0]['status'] === 'completed') {
                                foreach($phases as $i => $p) {
                                     if($p['status'] !== 'completed') {
                                         $activePhaseIndex = $i;
                                         break;
                                     }
                                }
                            }
                            $progressWidth = ($activePhaseIndex / max(1, $totalPhases - 1)) * 100;
                        ?>
                        <div class="absolute top-1/2 left-0 h-1 bg-operon-deep -z-10 rounded-full transition-all duration-1000 ease-out -translate-y-1/2 shadow-[0_0_12px_rgba(10,47,47,0.2)]" style="width: <?= $progressWidth ?>%"></div>

                        <!-- Steps Container -->
                        <div class="flex justify-between w-full">
                            <?php foreach ($phases as $index => $phase): ?>
                                <?php 
                                    $status = $phase['status'];
                                    $circleClass = match($status) {
                                        'completed' => 'bg-emerald-500 border-emerald-500 text-white',
                                        'active' => 'bg-white dark:bg-[#1A1C22] border-operon-deep dark:border-operon-mist text-operon-deep dark:text-operon-mist ring-2 ring-operon-mist dark:ring-operon-mist/20',
                                        default => 'bg-white dark:bg-[#1A1C22] border-slate-300 dark:border-white/10 text-slate-300'
                                    };
                                    $textClass = match($status) {
                                        'completed' => 'text-emerald-700 dark:text-emerald-400 font-bold',
                                        'active' => 'text-operon-deep dark:text-white font-black',
                                        default => 'text-slate-400 dark:text-slate-500 font-medium'
                                    };
                                     $icon = match($status) {
                                        'completed' => '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>',
                                        'active' => '<div class="w-2 h-2 rounded-full bg-operon-deep dark:bg-operon-mist animate-pulse"></div>',
                                        default => '<div class="w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-white/10"></div>'
                                    };
                                ?>
                                <div class="flex flex-col items-center relative group cursor-pointer" @click="updatePhase('<?= $phase['id'] ?>')">
                                    <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center z-10 bg-white dark:bg-[#1A1C22] hover:scale-125 transition-transform duration-300 <?= $circleClass ?>">
                                        <?= $icon ?>
                                    </div>
                                    <div class="absolute top-8 w-24 text-center">
                                        <span class="text-[9px] uppercase tracking-wider <?= $textClass ?> block group-hover:text-indigo-600 transition-colors">
                                            <?= $phase['name'] ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Timeline Events -->
                    <div class="relative pl-6 border-l-2 border-slate-200 dark:border-white/5 space-y-6">
                        <?php foreach ($events as $event): ?>
                            <?php 
                                $isMacro = $event['type'] === 'MACRO';
                                $meta = json_decode($event['metadata'] ?? '{}', true);
                            ?>
                            <!-- POLYMORPHIC BLOCK PREVIEW -->
                            <?php if ($event['type'] === 'WARNING'): ?>
                                <?php $style = $meta['style'] ?? 'info'; $colors = match($style) { 'danger' => 'bg-red-50 dark:bg-red-500/10 text-red-800 dark:text-red-400', 'warning' => 'bg-amber-50 dark:bg-amber-500/10 text-amber-800 dark:text-amber-400', default => 'bg-blue-50 dark:bg-blue-500/10 text-blue-800 dark:text-blue-400' }; ?>
                                <div class="relative group cursor-pointer" @click="form.type='WARNING'; form.title='<?= addslashes($event['title']) ?>'; form.description=`<?= addslashes($event['description']) ?>`; form.style='<?= $style ?>'">
                                    <div class="absolute -left-[31px] top-4 w-4 h-4 rounded-full border-2 border-[#F5F5F7] dark:border-[#0F1216] bg-amber-500 w-6 h-6 -left-[35px] flex items-center justify-center text-white text-[10px]">⚠️</div>
                                    <div class="ios-card p-4 <?= $colors ?> border border-slate-100 dark:border-white/5 mb-4 shadow-sm relative">
                                        <div class="flex justify-between items-start">
                                            <h3 class="font-bold text-sm"><?= htmlspecialchars($event['title']) ?></h3>
                                            <form action="/admin/projects/events/delete" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este aviso?');" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                                <input type="hidden" name="id" value="<?= $event['id'] ?>">
                                                <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                        <p class="text-xs opacity-90"><?= htmlspecialchars($event['description']) ?></p>
                                    </div>
                                </div>

                            <?php elseif ($event['type'] === 'DOCUMENT'): ?>
                                 <div class="relative group cursor-pointer" @click="form.type='DOCUMENT'; form.title='<?= addslashes($event['title']) ?>'; form.description=`<?= addslashes($event['description']) ?>`; form.btn_label='<?= $meta['btn_label'] ?? '' ?>'">
                                    <div class="absolute -left-[31px] top-4 w-4 h-4 rounded-full border-2 border-[#F5F5F7] dark:border-[#0F1216] bg-blue-500 w-6 h-6 -left-[35px] flex items-center justify-center text-white text-[10px]">📄</div>
                                    <div class="ios-card p-4 flex items-center gap-3 border border-slate-100 dark:border-white/5 hover:border-operon-mist dark:hover:border-operon-mist/50 transition-colors mb-4 shadow-sm relative">
                                        <div class="w-10 h-10 bg-slate-100 dark:bg-white/5 rounded flex items-center justify-center text-xl">📄</div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start">
                                                <h3 class="font-bold text-slate-800 dark:text-white text-sm"><?= htmlspecialchars($event['title']) ?></h3>
                                                <form action="/admin/projects/events/delete" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este documento?');" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <input type="hidden" name="id" value="<?= $event['id'] ?>">
                                                    <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                            <p class="text-[10px] text-slate-500 dark:text-slate-400"><?= htmlspecialchars($event['description']) ?></p>
                                        </div>
                                    </div>
                                </div>

                            <?php elseif ($event['type'] === 'ARTICLE'): ?>
                                <div class="relative group cursor-pointer" @click="form.type='ARTICLE'; form.title='<?= addslashes($event['title']) ?>'; form.description=`<?= addslashes($event['description']) ?>`">
                                    <div class="absolute -left-[31px] top-4 w-4 h-4 rounded-full border-2 border-[#F5F5F7] dark:border-[#0F1216] bg-indigo-500 w-6 h-6 -left-[35px] flex items-center justify-center text-white text-[10px]">📰</div>
                                    <div class="ios-card overflow-hidden border border-slate-100 dark:border-white/5 mb-4 shadow-sm relative group">
                                        <?php if (!empty($meta['images'][0])): ?>
                                            <div class="h-32 bg-cover bg-center" style="background-image: url('<?= $meta['images'][0] ?>')"></div>
                                        <?php endif; ?>
                                        <div class="p-4">
                                            <div class="flex justify-between items-start mb-1">
                                                <h3 class="font-bold text-slate-800 dark:text-white text-sm"><?= htmlspecialchars($event['title']) ?></h3>
                                                <form action="/admin/projects/events/delete" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este artigo?');" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <input type="hidden" name="id" value="<?= $event['id'] ?>">
                                                    <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                            <p class="text-[10px] text-slate-500 dark:text-slate-400 line-clamp-2"><?= htmlspecialchars($event['description']) ?></p>
                                        </div>
                                    </div>
                                </div>

                            <?php elseif ($event['type'] === 'CHECKPOINT'): ?>
                                <!-- ✅ CHECKPOINT PREVIEW -->
                                <?php $deadline = $meta['deadline'] ?? null; ?>
                                <div class="relative group cursor-pointer">
                                    <div class="absolute -left-[31px] top-4 w-6 h-6 rounded-full border-2 border-[#F5F5F7] dark:border-[#0F1216] <?= $event['status'] === 'done' ? 'bg-emerald-500' : 'bg-amber-500' ?> -left-[35px] flex items-center justify-center text-white text-[10px]">✓</div>
                                    <div class="ios-card p-4 flex items-center gap-4 border border-slate-100 dark:border-white/5 mb-4 <?= $event['status'] === 'done' ? 'bg-emerald-50/50 dark:bg-emerald-500/10' : '' ?>">
                                        <div class="w-10 h-10 <?= $event['status'] === 'done' ? 'bg-emerald-100 dark:bg-emerald-500/20' : 'bg-amber-100 dark:bg-amber-500/20' ?> rounded-lg flex items-center justify-center text-lg">
                                            <?= $event['status'] === 'done' ? '✅' : '📋' ?>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-bold text-sm <?= $event['status'] === 'done' ? 'text-emerald-700 dark:text-emerald-400 line-through' : 'text-slate-800 dark:text-white' ?>"><?= htmlspecialchars($event['title']) ?></h3>
                                            <?php if ($deadline): ?>
                                                <p class="text-[10px] text-slate-400">Prazo: <?= date('d/m/Y', strtotime($deadline)) ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase <?= $event['status'] === 'done' ? 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600' : 'bg-amber-100 dark:bg-amber-500/20 text-amber-600' ?>">
                                            <?= $event['status'] === 'done' ? 'Concluído' : 'Pendente' ?>
                                        </span>
                                        <form action="/admin/projects/checkpoints/toggle" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                            <input type="hidden" name="id" value="<?= $event['id'] ?>">
                                            <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                            <button type="submit" class="p-2 bg-slate-100 dark:bg-white/10 hover:bg-emerald-100 dark:hover:bg-emerald-500/20 rounded-lg transition-colors" title="Toggle Status">
                                                <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            </button>
                                        </form>
                                        <form action="/admin/projects/checkpoints/delete" method="POST" onsubmit="return confirm('Excluir checkpoint?');" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                            <input type="hidden" name="id" value="<?= $event['id'] ?>">
                                            <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                            <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            <?php else: ?>
                                <!-- EXISTING STANDARD PREVIEW -->
                                <div class="relative group cursor-pointer hover:scale-[1.01] transition-transform" 
                                    @click="form.title = '<?= addslashes($event['title']) ?>'; form.description = `<?= addslashes($event['description']) ?>`; form.type = '<?= $event['type'] ?>'; form.status = '<?= $event['status'] ?>';">
                                    
                                    <div class="absolute -left-[31px] top-4 w-4 h-4 rounded-full border-2 border-[#F5F5F7] dark:border-[#0F1216] <?= $isMacro ? 'bg-operon-deep dark:bg-operon-mist w-6 h-6 -left-[35px] flex items-center justify-center text-white dark:text-operon-deep text-[10px] shadow-sm' : 'bg-slate-300 dark:bg-white/10' ?>">
                                        <?= $isMacro ? '★' : '' ?>
                                    </div>

                                    <div class="bg-white dark:bg-[#15191D] rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-white/5 group-hover:border-operon-mist dark:group-hover:border-operon-mist/50 transition-colors relative overflow-hidden">
                                        <div class="flex justify-between items-start mb-2">
                                            <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]"><?= date('d M', strtotime($event['created_at'])) ?></span>
                                            <div class="flex gap-3 opacity-0 group-hover:opacity-100 transition-opacity items-center">
                                                <button class="text-[10px] text-operon-deep dark:text-operon-mist font-black uppercase tracking-wider hover:underline" @click.stop="populateForm(<?= htmlspecialchars(json_encode($event)) ?>)">Editar</button>
                                                <form action="/admin/projects/events/delete" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este bloco?');">
                                                    <input type="hidden" name="id" value="<?= $event['id'] ?>">
                                                    <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <h4 class="text-base font-black text-operon-deep dark:text-white leading-tight mb-2"><?= htmlspecialchars($event['title']) ?></h4>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2"><?= htmlspecialchars($event['description']) ?></p>
                                        
                                        <?php if (!empty($meta['tags'])): ?>
                                            <div class="flex gap-1 mt-3">
                                                <?php foreach ($meta['tags'] as $tag): ?>
                                                    <span class="px-2 py-0.5 bg-operon-mist/50 text-operon-deep rounded text-[9px] font-black uppercase tracking-wider"><?= htmlspecialchars($tag) ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        
                        <!-- Future State -->
                         <div class="relative pl-6 pt-4 opacity-50">
                            <div class="absolute -left-[5px] w-3 h-3 rounded-full bg-slate-200 dark:bg-white/10 border-2 border-[#F5F5F7] dark:border-[#0F1216]"></div>
                            <p class="text-xs font-medium text-slate-400 dark:text-slate-500 italic">Futuro...</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function eventEditor() {
        return {
            form: {
                title: '',
                description: '',
                type: 'MICRO', 
                status: 'done',
                progress: 50,
                tags: '',
                is_pinned: false,
                notify: false,
                style: 'info', // for warnings
                btn_label: '' // for docs
            },
            typeLabels: {
                'MICRO': { title: 'Título do Evento', desc: 'Descrição Técnica' },
                'MACRO': { title: 'Título do Marco', desc: 'Descrição do Marco' },
                'WARNING': { title: 'Título do Aviso', desc: 'Mensagem do Alerta' },
                'DOCUMENT': { title: 'Nome do Arquivo', desc: 'Descrição do Documento' },
                'ARTICLE': { title: 'Manchete do Artigo', desc: 'Conteúdo do Texto' }
            },
            templates: [
                { name: '🚀 Início de Desenvolvimento', desc_preview: 'Macro: Início oficial', data: { title: 'Dada a Largada 🚀', description: 'Ambiente de desenvolvimento configurado e repositório iniciado. O projeto agora respira!', type: 'MACRO', tags: 'init, setup' } },
                { name: '⚠️ Aviso de Manutenção', desc_preview: 'Aviso: Indisponibilidade', data: { title: 'Manutenção Programada', description: 'O sistema ficará instável neste final de semana para upgrades.', type: 'WARNING', style: 'warning' } },
                { name: '📄 Contrato Assinado', desc_preview: 'Doc: Upload contrato', data: { title: 'Contrato de Prestação', description: 'Cópia digital do contrato assinado.', type: 'DOCUMENT', btn_label: 'Baixar PDF' } },
                { name: '✅ Deploy em Staging', desc_preview: 'Macro: Versão teste', data: { title: 'Versão de Testes Disponível', description: 'O ambiente de homologação foi atualizado. Você já pode acessar para validar as novas funcionalidades.', type: 'MACRO', status: 'done', notify: true, tags: 'deploy, staging' } }
            ],
            charCount: 0,
            init() {
                this.$watch('form.description', value => this.charCount = value.length);
            },
            loadTemplate(t) {
                this.form = { ...this.form, ...t.data };
            },
            populateForm(event) {
                // Populate form for editing (simple version - just fills values, doesn't set ID for update yet)
                // Note: To fully support Update, we'd need a hidden event_id input and update logic in controller.
                // For now, this acts as "Copy to Editor" or "Draft from".
                this.form.title = event.title;
                this.form.description = event.description;
                this.form.type = event.type;
                this.form.status = event.status;
                
                try {
                    const meta = JSON.parse(event.metadata || '{}');
                    this.form.style = meta.style || 'info';
                    this.form.btn_label = meta.btn_label || '';
                    if (meta.progress_percent) this.form.progress = meta.progress_percent;
                    if (meta.is_pinned) this.form.is_pinned = meta.is_pinned;
                } catch(e) {}
                
                // Scroll to top
                window.scrollTo({ top: 0, behavior: 'smooth' });
            },
            updatePhase(phaseId) {
                if(!confirm('Mudar fase do projeto para: ' + phaseId + '?')) return;
                
                let formData = new FormData();
                formData.append('project_id', '<?= $project['id'] ?>');
                formData.append('phase', phaseId);
                
                fetch('/admin/projects/updatePhase', { 
                     method: 'POST',
                     body: formData,
                     headers: {'X-Requested-With': 'XMLHttpRequest'}
                })
                .then(r => r.json())
                .then(data => {
                    if(data.success) location.reload();
                    else alert('Erro ao atualizar fase. Verifique o console.');
                })
                .catch(e => {
                    console.error(e);
                    alert('Erro de conexão');
                });
            }
        }
    }
</script>
