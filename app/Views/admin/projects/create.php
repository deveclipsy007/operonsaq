

<div class="max-w-4xl mx-auto" x-data="{ 
    thalamic: 'hybrid',
    view: 'cms', // 'cms' or 'info'
    fileName: null
}">
    
    <!-- Header with Toggle -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-black text-operon-deep dark:text-white tracking-tight">Novo Neurônio</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1 font-medium tracking-tight">Iniciando uma nova jornada de desenvolvimento.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- View Toggle -->
            <div class="bg-operon-mist/20 dark:bg-white/5 p-1 rounded-xl flex items-center border border-operon-mist/50 dark:border-white/10">
                <button type="button" @click="view = 'cms'" 
                    :class="view === 'cms' ? 'bg-white dark:bg-white/10 text-operon-deep dark:text-white shadow-sm border border-operon-mist dark:border-white/10' : 'text-slate-400 dark:text-slate-500 hover:text-operon-deep dark:hover:text-operon-mist'"
                    class="px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-wider transition-all flex items-center gap-2">
                    <span class="text-lg">🎨</span> Interface
                </button>
                <button type="button" @click="view = 'info'" 
                    :class="view === 'info' ? 'bg-white dark:bg-white/10 text-operon-deep dark:text-white shadow-sm border border-operon-mist dark:border-white/10' : 'text-slate-400 dark:text-slate-500 hover:text-operon-deep dark:hover:text-operon-mist'"
                    class="px-4 py-2 rounded-lg text-[10px) font-black uppercase tracking-wider transition-all flex items-center gap-2">
                    <span class="text-lg">💰</span> Finanças
                </button>
            </div>

            <div class="h-8 w-px bg-slate-200 mx-1"></div>

            <a href="/admin" class="group flex items-center px-4 py-2 bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-lg text-slate-600 dark:text-slate-400 text-xs font-bold uppercase tracking-wider hover:bg-slate-50 dark:hover:bg-white/10 hover:text-indigo-600 dark:hover:text-white transition-all shadow-sm">
                <svg class="w-3 h-3 mr-2 text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Voltar
            </a>
        </div>
    </div>

    <!-- Main Form -->
    <form action="/admin/projects/store" method="POST" enctype="multipart/form-data" class="card-apple dark:border-white/5 p-8 space-y-8 animate-fade-in relative overflow-visible">
        
        <!-- Decorative Background Blur -->
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <!-- VIEW: CMS (Template) -->
        <div x-show="view === 'cms'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
            
            <div class="mb-6 flex items-center gap-2 text-operon-deep bg-operon-mist w-fit px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-operon-mistDark/30">
                <span>🎨</span> Configuração do Córtex
            </div>

            <!-- Client & Name -->
            <div class="space-y-6">
                <div class="group">
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Cliente</label>
                    <div class="relative">
                        <select name="client_id" required class="w-full bg-slate-50 dark:bg-white/5 border-0 border-b-2 border-slate-200 dark:border-white/10 focus:border-indigo-500 focus:ring-0 text-slate-800 dark:text-white font-bold text-lg py-2 pl-3 pr-10 transition-colors cursor-pointer appearance-none rounded-t-lg">
                            <option value="" disabled selected class="dark:bg-slate-900">Selecione um cliente...</option>
                            <?php foreach ($clients as $client): ?>
                                <option value="<?= $client['id'] ?>" class="dark:bg-slate-900"><?= htmlspecialchars($client['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 group-focus-within:text-operon-deep dark:group-focus-within:text-operon-mist transition-colors">Nome do Projeto</label>
                    <input type="text" name="name" required placeholder="Ex: Redesign Neural 2.0" 
                        class="w-full text-3xl font-black border-0 border-b-2 border-slate-100 dark:border-white/10 focus:border-operon-deep dark:focus:border-operon-mist focus:ring-0 px-0 bg-transparent placeholder-slate-200 dark:placeholder-white/5 transition-colors text-operon-deep dark:text-white tracking-tight">
                </div>

                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 group-focus-within:text-operon-deep dark:group-focus-within:text-operon-mist transition-colors">Descrição</label>
                    <textarea name="description" rows="3" 
                        class="w-full text-sm text-slate-600 dark:text-slate-400 bg-white dark:bg-white/5 border border-operon-mist dark:border-white/10 rounded-xl focus:ring-2 focus:ring-operon-mist/50 resize-none p-4 transition-shadow placeholder-slate-300 dark:placeholder-slate-600 font-medium shadow-sm" 
                        placeholder="Descreva o escopo e objetivos principais..."></textarea>
                </div>

                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 group-focus-within:text-operon-deep dark:group-focus-within:text-operon-mist transition-colors">Mensagem de Destaque (Cortex Top)</label>
                    <input type="text" name="featured_message" 
                        class="w-full text-lg font-bold border-0 border-b border-slate-100 dark:border-white/10 focus:border-operon-deep dark:focus:border-operon-mist focus:ring-0 px-0 bg-transparent placeholder-slate-200 dark:placeholder-white/5 transition-colors text-operon-deep dark:text-white tracking-tight"
                        placeholder="Ex: 🎉 Lançamento do Dashboard em 2 dias!">
                </div>
            </div>

            <hr class="border-slate-100 my-8">

            <!-- Visual Thalamic Setting -->
            <div>
                <label class="flex items-center gap-2 mb-4">
                    <span class="w-2 h-2 rounded-full bg-operon-deep dark:bg-operon-mist animate-pulse"></span>
                    <span class="text-[10px] font-black text-operon-deep dark:text-operon-mist uppercase tracking-[0.2em]">Sincronização Neural (Talâmo)</span>
                </label>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Macro -->
                    <label class="cursor-pointer relative">
                        <input type="radio" name="thalamic_setting" value="macro" x-model="thalamic" class="peer sr-only">
                        <div class="p-5 rounded-[20px] border-2 border-slate-50 dark:border-white/5 bg-white dark:bg-white/5 hover:border-operon-mist peer-checked:border-operon-deep dark:peer-checked:border-operon-mist peer-checked:bg-operon-mist/10 dark:peer-checked:bg-operon-mist/10 transition-all h-full flex flex-col items-center text-center group shadow-sm">
                            <div class="w-12 h-12 rounded-xl bg-slate-50 dark:bg-white/5 text-2xl flex items-center justify-center mb-4 group-hover:bg-operon-mist transition-colors group-hover:scale-110">🔭</div>
                            <span class="block text-sm font-black text-operon-deep dark:text-white mb-2">Macro</span>
                            <span class="block text-[10px] text-slate-500 dark:text-slate-400 font-medium leading-relaxed">Foco apenas em grandes entregas e marcos estratégicos.</span>
                        </div>
                    </label>
                    <!-- Hybrid -->
                    <label class="cursor-pointer relative">
                        <input type="radio" name="thalamic_setting" value="hybrid" x-model="thalamic" class="peer sr-only">
                        <div class="p-5 rounded-[20px] border-2 border-slate-50 dark:border-white/5 bg-white dark:bg-white/5 hover:border-operon-mist peer-checked:border-operon-deep dark:peer-checked:border-operon-mist peer-checked:bg-operon-mist/10 dark:peer-checked:bg-operon-mist/10 transition-all h-full flex flex-col items-center text-center group shadow-sm">
                            <div class="w-12 h-12 rounded-xl bg-slate-50 dark:bg-white/5 text-2xl flex items-center justify-center mb-4 group-hover:bg-operon-mist transition-colors group-hover:scale-110">⚖️</div>
                            <span class="block text-sm font-black text-operon-deep dark:text-white mb-2">Híbrido</span>
                            <span class="block text-[10px] text-slate-500 dark:text-slate-400 font-medium leading-relaxed">Equilíbrio neural ideal entre técnica e visão de negócio.</span>
                        </div>
                    </label>
                    <!-- Micro -->
                    <label class="cursor-pointer relative">
                        <input type="radio" name="thalamic_setting" value="micro" x-model="thalamic" class="peer sr-only">
                        <div class="p-5 rounded-[20px] border-2 border-slate-50 dark:border-white/5 bg-white dark:bg-white/5 hover:border-operon-mist peer-checked:border-operon-deep dark:peer-checked:border-operon-mist peer-checked:bg-operon-mist/10 dark:peer-checked:bg-operon-mist/10 transition-all h-full flex flex-col items-center text-center group shadow-sm">
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
                    <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase mb-1">Início</label>
                    <input type="date" name="start_date" value="<?= date('Y-m-d') ?>" 
                        class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-lg text-slate-800 dark:text-white font-bold focus:ring-2 focus:ring-indigo-100 dark:focus:ring-white/10 text-sm h-12 px-3">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase mb-1">Deadline Estimado</label>
                    <input type="date" name="deadline" 
                        class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-lg text-slate-800 dark:text-white font-bold focus:ring-2 focus:ring-indigo-100 dark:focus:ring-white/10 text-sm h-12 px-3">
                </div>
            </div>

        </div>

        <!-- VIEW: INFO (Financial & Contract) -->
        <div x-show="view === 'info'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0" style="display: none;">
            
            <div class="mb-6 flex items-center gap-2 text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 w-fit px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide border border-emerald-100 dark:border-emerald-500/20">
                <span>💼</span> Dados do Projeto
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Project Value -->
                <div class="group">
                    <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase mb-1 group-focus-within:text-emerald-500 transition-colors">Valor do Projeto (R$)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 font-bold">R$</span>
                        <input type="number" step="0.01" name="project_value" placeholder="0,00" 
                            class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-lg text-slate-800 dark:text-white font-bold focus:ring-2 focus:ring-emerald-100 dark:focus:ring-white/10 text-lg h-12 pl-10 pr-3">
                    </div>
                </div>

                <!-- Phases Count -->
                <div class="group">
                    <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase mb-1 group-focus-within:text-emerald-500 transition-colors">Número de Fases</label>
                    <input type="number" name="phases_count" placeholder="Ex: 5" 
                        class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-lg text-slate-800 dark:text-white font-bold focus:ring-2 focus:ring-emerald-100 dark:focus:ring-white/10 text-lg h-12 px-3">
                </div>

                <!-- Payment Method -->
                <div class="group">
                    <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase mb-1 group-focus-within:text-emerald-500 transition-colors">Forma de Pagamento</label>
                    <select name="payment_method" class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-lg text-slate-800 dark:text-white font-bold focus:ring-2 focus:ring-emerald-100 dark:focus:ring-white/10 text-sm h-12 px-3">
                        <option value="Pix" class="dark:bg-slate-900">Pix</option>
                        <option value="Cartão de Crédito" class="dark:bg-slate-900">Cartão de Crédito</option>
                        <option value="Boleto" class="dark:bg-slate-900">Boleto</option>
                        <option value="Transferência" class="dark:bg-slate-900">Transferência Bancária</option>
                    </select>
                </div>

                <!-- Installments -->
                <div class="group">
                    <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase mb-1 group-focus-within:text-emerald-500 transition-colors">Parcelas</label>
                    <input type="number" name="installments" value="1" min="1" 
                        class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-lg text-slate-800 dark:text-white font-bold focus:ring-2 focus:ring-emerald-100 dark:focus:ring-white/10 text-lg h-12 px-3">
                </div>

            </div>

            <hr class="border-slate-100 my-8">

            <!-- Contract Upload -->
            <div class="group">
                <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase mb-3">Contrato Assinado (.pdf)</label>
                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-200 dark:border-white/10 border-dashed rounded-xl cursor-pointer bg-slate-50 dark:bg-white/5 hover:bg-slate-100 dark:hover:bg-white/10 hover:border-emerald-300 transition-all group">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <div x-show="!fileName">
                            <svg class="w-8 h-8 mb-3 text-slate-400 group-hover:text-emerald-500 transition-colors mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <p class="mb-2 text-sm text-slate-500 dark:text-slate-400"><span class="font-semibold">Clique para enviar</span> o contrato</p>
                        </div>
                        <div x-show="fileName" class="text-center">
                             <svg class="w-8 h-8 mb-3 text-emerald-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                             <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400" x-text="fileName"></p>
                        </div>
                    </div>
                    <input type="file" name="contract_file" class="hidden" @change="fileName = $event.target.files[0].name" accept=".pdf" />
                </label>
            </div>

            <div class="mt-6 group">
                <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase mb-1 group-focus-within:text-emerald-500 transition-colors">Gerente do Projeto</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="manager_name" placeholder="Nome do Gerente" 
                        class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-lg text-slate-800 dark:text-white font-bold focus:ring-2 focus:ring-emerald-100 dark:focus:ring-white/10 text-sm h-12 px-3">
                    <input type="text" name="manager_phone" placeholder="WhatsApp (ex: 5511999999999)" 
                        class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-lg text-slate-800 dark:text-white font-bold focus:ring-2 focus:ring-emerald-100 dark:focus:ring-white/10 text-sm h-12 px-3">
                </div>
            </div>

            <div class="mt-6 group">
                <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase mb-1 group-focus-within:text-emerald-500 transition-colors">Links Externos</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                     <input type="url" name="github_url" placeholder="Repositório GitHub" 
                        class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-lg text-slate-800 dark:text-white font-bold focus:ring-2 focus:ring-emerald-100 dark:focus:ring-white/10 text-sm h-12 px-3">
                     <input type="url" name="provisional_url" placeholder="Domínio Provisório" 
                        class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-lg text-slate-800 dark:text-white font-bold focus:ring-2 focus:ring-emerald-100 dark:focus:ring-white/10 text-sm h-12 px-3">
                     <input type="url" name="definitive_url" placeholder="Domínio Definitivo" 
                        class="w-full bg-slate-50 dark:bg-white/5 border-0 rounded-lg text-slate-800 dark:text-white font-bold focus:ring-2 focus:ring-emerald-100 dark:focus:ring-white/10 text-sm h-12 px-3">
                </div>
            </div>

            <div class="mt-6 group">
                <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase mb-1 group-focus-within:text-emerald-500 transition-colors">Anotações Gerais</label>
                <textarea name="notes" rows="4" 
                    class="w-full text-sm text-slate-600 dark:text-slate-400 bg-slate-50 dark:bg-white/5 rounded-lg border-0 focus:ring-2 focus:ring-emerald-100 dark:focus:ring-white/10 resize-none p-4 transition-shadow placeholder-slate-300 dark:placeholder-slate-600 font-medium" 
                    placeholder="Observações internas sobre o projeto, cliente ou negociação..."></textarea>
            </div>

        </div>


        <div class="pt-4 px-2">
            <button type="submit" class="w-full bg-operon-deep shadow-premium hover:bg-black text-white font-black py-5 rounded-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-3 text-sm uppercase tracking-[0.2em] border border-white/5">
                <span class="text-xl">🚀</span>
                Lançar Missão Neural
            </button>
        </div>

    </form>
</div>


