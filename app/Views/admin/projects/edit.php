
<div class="max-w-4xl mx-auto" x-data="{ 
    thalamic: '<?= $project['thalamic_setting'] ?>',
    view: 'cms', // 'cms' or 'info'
    fileName: null
}">
    
    <!-- Header with Toggle -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-black text-operon-deep dark:text-white tracking-tight">Córtex do Projeto</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1 font-medium tracking-tight">Ajuste fino das diretrizes e parâmetros neurais.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- View Toggle -->
            <div class="bg-operon-mist/20 dark:bg-white/5 p-1 rounded-xl flex items-center border border-operon-mist/50 dark:border-white/10">
                <button type="button" @click="view = 'cms'" 
                    :class="view === 'cms' ? 'bg-white dark:bg-[#15191D] text-operon-deep dark:text-white shadow-sm border border-operon-mist dark:border-white/10' : 'text-slate-400 dark:text-slate-500 hover:text-operon-deep dark:hover:text-operon-mist'"
                    class="px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-wider transition-all flex items-center gap-2">
                    <span class="text-lg">🎨</span> Interface
                </button>
                <button type="button" @click="view = 'info'" 
                    :class="view === 'info' ? 'bg-white dark:bg-[#15191D] text-operon-deep dark:text-white shadow-sm border border-operon-mist dark:border-white/10' : 'text-slate-400 dark:text-slate-500 hover:text-operon-deep dark:hover:text-operon-mist'"
                    class="px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-wider transition-all flex items-center gap-2">
                    <span class="text-lg">💰</span> Finanças
                </button>
            </div>

            <div class="h-8 w-px bg-slate-200 dark:bg-white/10 mx-1"></div>

            <a href="/admin/projects/show?id=<?= $project['id'] ?>" class="group flex items-center px-4 py-2 bg-white dark:bg-[#15191D] border border-slate-200 dark:border-white/10 rounded-lg text-slate-600 dark:text-slate-400 text-xs font-bold uppercase tracking-wider hover:bg-slate-50 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white transition-all shadow-sm">
                <svg class="w-3 h-3 mr-2 text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Ver Projeto
            </a>
        </div>
    </div>

    <!-- Main Form -->
    <form action="/admin/projects/update" method="POST" enctype="multipart/form-data" class="card-apple dark:bg-[#15191D] dark:border-white/5 p-8 space-y-8 animate-fade-in relative overflow-visible">
        <input type="hidden" name="id" value="<?= $project['id'] ?>">
        
        <!-- Decorative Background Blur -->
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <!-- VIEW: CMS (Template) -->
        <div x-show="view === 'cms'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
            
            <div class="mb-6 flex items-center gap-2 text-operon-deep dark:text-operon-deep bg-operon-mist dark:bg-operon-mist w-fit px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-operon-mistDark/30">
                <span>🎨</span> Configuração do Córtex
            </div>

            <!-- Client & Name -->
            <div class="space-y-6">
                <!-- Status -->
                <div class="group">
                     <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Status do Projeto</label>
                     <select name="status" class="w-full bg-white dark:bg-white/5 border border-operon-mist dark:border-white/10 rounded-xl text-operon-deep dark:text-white font-bold focus:ring-2 focus:ring-operon-mist/50 text-sm h-12 px-4 shadow-sm">
                        <option value="active" <?= $project['status'] === 'active' ? 'selected' : '' ?>>🟢 Ativo</option>
                        <option value="completed" <?= $project['status'] === 'completed' ? 'selected' : '' ?>>✅ Concluído</option>
                        <option value="archived" <?= $project['status'] === 'archived' ? 'selected' : '' ?>>📦 Arquivado</option>
                     </select>
                </div>

                <div class="group">
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Cliente</label>
                    <div class="relative">
                        <select name="client_id" required class="w-full bg-slate-50 dark:bg-white/5 border-0 border-b-2 border-slate-200 dark:border-white/10 focus:border-indigo-500 focus:ring-0 text-slate-800 dark:text-white font-bold text-lg py-2 pl-3 pr-10 transition-colors cursor-pointer appearance-none rounded-t-lg">
                            <?php foreach ($clients as $client): ?>
                                <option value="<?= $client['id'] ?>" <?= $client['id'] == $project['client_id'] ? 'selected' : '' ?>><?= htmlspecialchars($client['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 group-focus-within:text-operon-deep dark:group-focus-within:text-operon-mist transition-colors">Nome do Projeto</label>
                    <input type="text" name="name" required value="<?= htmlspecialchars($project['name']) ?>"
                        class="w-full text-3xl font-black border-0 border-b-2 border-slate-100 dark:border-white/10 focus:border-operon-deep dark:focus:border-operon-mist focus:ring-0 px-0 bg-transparent placeholder-slate-200 dark:placeholder-slate-700 transition-colors text-operon-deep dark:text-white tracking-tight">
                </div>

                <div class="group">
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1 group-focus-within:text-indigo-500 dark:group-focus-within:text-operon-mist transition-colors">Descrição</label>
                    <textarea name="description" rows="3" 
                        class="w-full text-sm text-slate-600 dark:text-slate-300 bg-slate-50 dark:bg-white/5 rounded-lg border-0 focus:ring-2 focus:ring-indigo-100 dark:focus:ring-white/10 resize-none p-4 transition-shadow placeholder-slate-300 dark:placeholder-slate-600 font-medium" 
                        placeholder="Descreva o escopo e objetivos principais..."><?= htmlspecialchars($project['description']) ?></textarea>
                </div>

                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 group-focus-within:text-operon-deep dark:group-focus-within:text-operon-mist transition-colors">Mensagem de Destaque (Cortex Top)</label>
                    <input type="text" name="featured_message" value="<?= htmlspecialchars($project['featured_message'] ?? '') ?>"
                        class="w-full text-lg font-bold border-0 border-b border-slate-100 dark:border-white/10 focus:border-operon-deep dark:focus:border-operon-mist focus:ring-0 px-0 bg-transparent placeholder-slate-200 dark:placeholder-slate-700 transition-colors text-operon-deep dark:text-operon-mist tracking-tight"
                        placeholder="Ex: 🎉 Lançamento do Dashboard em 2 dias!">
                </div>

                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 group-focus-within:text-operon-deep dark:group-focus-within:text-operon-mist transition-colors">
                        🌍 Idioma da Interface do Cliente
                    </label>
                    <select name="locale" class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-lg text-slate-800 dark:text-white font-bold focus:ring-2 focus:ring-operon-mist/20 text-sm h-12 px-3">
                        <option value="pt-BR" <?= ($project['locale'] ?? 'pt-BR') === 'pt-BR' ? 'selected' : '' ?>>🇧🇷 Português (Brasil)</option>
                        <option value="en-US" <?= ($project['locale'] ?? '') === 'en-US' ? 'selected' : '' ?>>🇺🇸 English (US)</option>
                        <option value="es-ES" <?= ($project['locale'] ?? '') === 'es-ES' ? 'selected' : '' ?>>🇪🇸 Español</option>
                    </select>
                    <p class="text-[10px] text-slate-400 mt-1">Define o idioma exibido no dashboard do cliente</p>
                </div>
            </div>

            <hr class="border-slate-100 my-8">

            <!-- Visual Thalamic Setting -->
            <div>
                <label class="flex items-center gap-2 mb-4">
                    <span class="w-2 h-2 rounded-full bg-operon-deep dark:bg-operon-mist animate-pulse"></span>
                    <span class="text-[10px] font-black text-operon-deep dark:text-white uppercase tracking-[0.2em]">Sincronização Neural (Talâmo)</span>
                </label>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Macro -->
                    <label class="cursor-pointer relative">
                        <input type="radio" name="thalamic_setting" value="macro" x-model="thalamic" class="peer sr-only">
                        <div class="p-5 rounded-[20px] border-2 border-slate-50 dark:border-white/5 bg-white dark:bg-[#1A1C22] hover:border-operon-mist peer-checked:border-operon-deep dark:peer-checked:border-operon-mist peer-checked:bg-operon-mist/10 dark:peer-checked:bg-operon-mist/5 transition-all h-full flex flex-col items-center text-center group shadow-sm">
                            <div class="w-12 h-12 rounded-xl bg-slate-50 dark:bg-white/5 text-2xl flex items-center justify-center mb-4 group-hover:bg-operon-mist transition-colors group-hover:scale-110">🔭</div>
                            <span class="block text-sm font-black text-operon-deep dark:text-white mb-2">Macro</span>
                            <span class="block text-[10px] text-slate-500 dark:text-slate-400 font-medium leading-relaxed">Foco apenas em grandes entregas e marcos estratégicos.</span>
                        </div>
                    </label>
                    <!-- Hybrid -->
                    <label class="cursor-pointer relative">
                        <input type="radio" name="thalamic_setting" value="hybrid" x-model="thalamic" class="peer sr-only">
                        <div class="p-5 rounded-[20px] border-2 border-slate-50 dark:border-white/5 bg-white dark:bg-[#1A1C22] hover:border-operon-mist peer-checked:border-operon-deep dark:peer-checked:border-operon-mist peer-checked:bg-operon-mist/10 dark:peer-checked:bg-operon-mist/5 transition-all h-full flex flex-col items-center text-center group shadow-sm">
                            <div class="w-12 h-12 rounded-xl bg-slate-50 dark:bg-white/5 text-2xl flex items-center justify-center mb-4 group-hover:bg-operon-mist transition-colors group-hover:scale-110">⚖️</div>
                            <span class="block text-sm font-black text-operon-deep dark:text-white mb-2">Híbrido</span>
                            <span class="block text-[10px] text-slate-500 dark:text-slate-400 font-medium leading-relaxed">Equilíbrio neural ideal entre técnica e visão de negócio.</span>
                        </div>
                    </label>
                    <!-- Micro -->
                    <label class="cursor-pointer relative">
                        <input type="radio" name="thalamic_setting" value="micro" x-model="thalamic" class="peer sr-only">
                        <div class="p-5 rounded-[20px] border-2 border-slate-50 dark:border-white/5 bg-white dark:bg-[#1A1C22] hover:border-operon-mist peer-checked:border-operon-deep dark:peer-checked:border-operon-mist peer-checked:bg-operon-mist/10 dark:peer-checked:bg-operon-mist/5 transition-all h-full flex flex-col items-center text-center group shadow-sm">
                            <div class="w-12 h-12 rounded-xl bg-slate-50 dark:bg-white/5 text-2xl flex items-center justify-center mb-4 group-hover:bg-operon-mist transition-colors group-hover:scale-110">🔬</div>
                            <span class="block text-sm font-black text-operon-deep dark:text-white mb-2">Micro</span>
                            <span class="block text-[10px] text-slate-500 dark:text-slate-400 font-medium leading-relaxed">Transparência total. Cada pulso técnico é visível ao cliente.</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-2 gap-6 pt-6">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Início</label>
                    <input type="date" name="start_date" value="<?= $project['start_date'] ?>" 
                        class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-lg text-slate-800 dark:text-white font-bold focus:ring-2 focus:ring-indigo-100 dark:focus:ring-white/10 text-sm h-12 px-3">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Deadline Estimado</label>
                    <input type="date" name="deadline" value="<?= $project['deadline'] ?>"
                        class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-lg text-slate-800 dark:text-white font-bold focus:ring-2 focus:ring-indigo-100 dark:focus:ring-white/10 text-sm h-12 px-3">
                </div>
            </div>

        </div>

        <!-- VIEW: INFO (Financial & Contract) -->
        <div x-show="view === 'info'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0" style="display: none;">
            


            <!-- KPIs & Performance -->
            <div class="mb-6 flex items-center gap-2 text-operon-deep bg-operon-mist w-fit px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-operon-mistDark/30">
                <span>⚡</span> Performance Neural (KPIs)
            </div>

            <div class="space-y-6 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                


            <!-- Health Status -->
                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Saúde do Projeto</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3" x-data="{ health: '<?= $project['health_status'] ?? 'on_track' ?>' }">
                        <!-- On Track -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="health_status" value="on_track" x-model="health" class="peer sr-only">
                            <div class="p-3 rounded-xl border-2 border-slate-50 bg-white hover:border-emerald-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 transition-all flex items-center justify-center gap-2 font-black text-xs uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Ok
                            </div>
                        </label>
                        <!-- At Risk -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="health_status" value="at_risk" x-model="health" class="peer sr-only">
                            <div class="p-3 rounded-xl border-2 border-slate-50 bg-white hover:border-amber-200 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-700 transition-all flex items-center justify-center gap-2 font-black text-xs uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Atenção
                            </div>
                        </label>
                        <!-- Off Track -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="health_status" value="off_track" x-model="health" class="peer sr-only">
                            <div class="p-3 rounded-xl border-2 border-slate-50 bg-white hover:border-red-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 transition-all flex items-center justify-center gap-2 font-black text-xs uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Crítico
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Custom Progress -->
                <div class="group" x-data="{ progress: '<?= $project['custom_progress'] ?? '' ?>' }">
                    <label class="flex justify-between text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">
                        <span>Progresso Neural (%)</span>
                        <span x-text="progress ? progress + '%' : 'Automático'" class="text-operon-deep"></span>
                    </label>
                    <div class="flex items-center gap-4">
                        <input type="range" x-model="progress" min="0" max="100" class="w-full h-1.5 bg-operon-mist rounded-full appearance-none cursor-pointer accent-operon-deep">
                        <input type="number" name="custom_progress" x-model="progress" placeholder="Auto" class="w-20 bg-white border border-operon-mist rounded-xl text-center font-black text-xs h-10 focus:ring-2 focus:ring-operon-mist/50 placeholder-slate-300 shadow-sm">
                    </div>
                </div>

                <!-- Deliveries -->
                <div class="group">
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Entregas (Completed / Total)</label>
                    <div class="flex items-center gap-2">
                        <input type="number" name="custom_completed_items" value="<?= $project['custom_completed_items'] ?>" placeholder="Feito" class="flex-1 bg-white border border-slate-200 rounded-lg font-bold text-sm h-10 px-3 focus:ring-2 focus:ring-indigo-100">
                        <span class="text-slate-300 font-bold">/</span>
                        <input type="number" name="custom_total_items" value="<?= $project['custom_total_items'] ?>" placeholder="Total" class="flex-1 bg-white border border-slate-200 rounded-lg font-bold text-sm h-10 px-3 focus:ring-2 focus:ring-indigo-100">
                    </div>
                     <p class="text-[10px] text-slate-400 mt-1 font-medium">*Deixe em branco para calcular automaticamente.</p>
                </div>

            </div>

            <hr class="border-slate-100 my-8">

            <!-- Contract Upload -->
            <div class="group">
                <label class="block text-xs font-bold text-slate-400 uppercase mb-3">Contrato Assinado (.pdf)</label>
                
                <?php if (!empty($project['contract_url'])): ?>
                    <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-100 p-3 rounded-lg mb-4">
                        <div class="bg-emerald-100 p-2 rounded text-emerald-600">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-emerald-800">Contrato Ativo</p>
                            <a href="<?= $project['contract_url'] ?>" target="_blank" class="text-[10px] text-emerald-600 underline hover:text-emerald-800">Visualizar Documento Atual</a>
                        </div>
                    </div>
                <?php endif; ?>

                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-200 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 hover:border-emerald-300 transition-all group">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <div x-show="!fileName">
                            <svg class="w-8 h-8 mb-3 text-slate-400 group-hover:text-emerald-500 transition-colors mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <p class="mb-2 text-sm text-slate-500"><span class="font-semibold">Clique para trocar</span> o contrato</p>
                        </div>
                        <div x-show="fileName" class="text-center">
                             <svg class="w-8 h-8 mb-3 text-emerald-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                             <p class="text-sm font-bold text-emerald-600" x-text="fileName"></p>
                        </div>
                    </div>
                    <input type="file" name="contract_file" class="hidden" @change="fileName = $event.target.files[0].name" accept=".pdf" />
                </label>
            </div>

            <div class="mt-6 group">
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1 group-focus-within:text-emerald-500 transition-colors">Gerente do Projeto</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="manager_name" value="<?= htmlspecialchars($project['manager_name'] ?? '') ?>" placeholder="Nome do Gerente" 
                        class="w-full bg-slate-50 border-0 rounded-lg text-slate-800 font-bold focus:ring-2 focus:ring-emerald-100 text-sm h-12 px-3">
                    <input type="text" name="manager_phone" value="<?= htmlspecialchars($project['manager_phone'] ?? '') ?>" placeholder="WhatsApp (ex: 5511999999999)" 
                        class="w-full bg-slate-50 border-0 rounded-lg text-slate-800 font-bold focus:ring-2 focus:ring-emerald-100 text-sm h-12 px-3">
                </div>
            </div>

            <div class="mt-6 group">
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1 group-focus-within:text-emerald-500 transition-colors">Links Externos</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                     <input type="url" name="github_url" value="<?= htmlspecialchars($project['github_url'] ?? '') ?>" placeholder="Repositório GitHub" 
                        class="w-full bg-slate-50 border-0 rounded-lg text-slate-800 font-bold focus:ring-2 focus:ring-emerald-100 text-sm h-12 px-3">
                     <input type="url" name="provisional_url" value="<?= htmlspecialchars($project['provisional_url'] ?? '') ?>" placeholder="Domínio Provisório" 
                        class="w-full bg-slate-50 border-0 rounded-lg text-slate-800 font-bold focus:ring-2 focus:ring-emerald-100 text-sm h-12 px-3">
                     <input type="url" name="definitive_url" value="<?= htmlspecialchars($project['definitive_url'] ?? '') ?>" placeholder="Domínio Definitivo" 
                        class="w-full bg-slate-50 border-0 rounded-lg text-slate-800 font-bold focus:ring-2 focus:ring-emerald-100 text-sm h-12 px-3">
                </div>
            </div>

            <div class="mt-6 group">
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1 group-focus-within:text-emerald-500 transition-colors">Anotações Gerais</label>
                <textarea name="notes" rows="4" 
                    class="w-full text-sm text-slate-600 bg-slate-50 rounded-lg border-0 focus:ring-2 focus:ring-emerald-100 resize-none p-4 transition-shadow placeholder-slate-300 font-medium" 
                    placeholder="Observações internas sobre o projeto, cliente ou negociação..."><?= htmlspecialchars($project['notes']) ?></textarea>
            </div>

        </div>


        <div class="pt-4 px-2">
            <button type="submit" class="w-full bg-operon-deep hover:bg-black text-white font-black py-4 rounded-xl shadow-premium hover:-translate-y-0.5 transition-all flex items-center justify-center gap-3 text-sm uppercase tracking-[0.2em] border border-white/5">
                <span>💾</span>
                Sincronizar Parâmetros
            </button>
        </div>

    </form>
</div>
