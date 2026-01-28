<div class="max-w-4xl mx-auto pt-6">
    
    <!-- Breadcrumb -->
    <a href="/admin" class="flex items-center text-sm text-slate-400 hover:text-indigo-600 mb-6 transition-colors">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        Voltar ao Dashboard
    </a>

    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Gestão Financeira</h1>
            <p class="mt-2 text-slate-500 dark:text-slate-400">Projeto: <strong class="text-indigo-600 dark:text-indigo-400"><?= htmlspecialchars($project['name']) ?></strong></p>
        </div>
        <div class="h-10 w-10 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg flex items-center justify-center text-indigo-600 dark:text-indigo-400">
             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <form action="/admin/projects/finance/update" method="POST" class="space-y-6">
        <input type="hidden" name="id" value="<?= $project['id'] ?>">

        <!-- Main Card -->
        <div class="bg-white dark:bg-[#15191D] rounded-2xl shadow-xl border border-slate-100 dark:border-white/5 overflow-hidden">
            <div class="h-2 bg-gradient-to-r from-emerald-400 to-indigo-500"></div>
            
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Left: Value & Method -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Valor Total do Projeto (R$)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-slate-400 dark:text-slate-500">R$</span>
                            <input type="number" step="0.01" name="project_value" value="<?= $project['project_value']?>" class="block w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl text-lg font-semibold text-slate-900 dark:text-white focus:bg-white dark:focus:bg-[#1A1C22] focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Forma de Pagamento</label>
                        <div class="relative">
                            <select name="payment_method" class="block w-full pl-4 pr-10 py-3 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl text-slate-700 dark:text-white focus:bg-white dark:focus:bg-[#1A1C22] focus:ring-2 focus:ring-indigo-500 outline-none appearance-none transition-all cursor-pointer">
                                <option value="Pix" class="dark:bg-[#1A1C22]" <?= $project['payment_method'] === 'Pix' ? 'selected' : '' ?>>Pix</option>
                                <option value="Boleto" class="dark:bg-[#1A1C22]" <?= $project['payment_method'] === 'Boleto' ? 'selected' : '' ?>>Boleto Bancário</option>
                                <option value="Cartão de Crédito" class="dark:bg-[#1A1C22]" <?= $project['payment_method'] === 'Cartão de Crédito' ? 'selected' : '' ?>>Cartão de Crédito</option>
                                <option value="Transferência" class="dark:bg-[#1A1C22]" <?= $project['payment_method'] === 'Transferência' ? 'selected' : '' ?>>Transferência Bancária</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Installments -->
                <div class="space-y-6 bg-slate-50 dark:bg-white/5 p-6 rounded-xl border border-slate-100 dark:border-white/5">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Controle de Parcelas</h3>
                    
                    <div>
                        <div class="flex justify-between items-center mb-2">
                             <label class="block text-sm font-bold text-slate-700 dark:text-slate-200">Parcelas Totais</label>
                             <span class="text-xs text-slate-400 dark:text-slate-500 bg-white dark:bg-white/5 px-2 py-1 rounded border dark:border-white/10">Divisão do valor</span>
                        </div>
                        <input type="number" name="installments" id="totalInstallments" value="<?= $project['installments']?>" min="1" class="block w-full px-4 py-2 bg-white dark:bg-[#15191D] border border-slate-200 dark:border-white/10 rounded-lg dark:text-white focus:ring-indigo-500 outline-none">
                    </div>

                    <div class="pt-4 border-t border-slate-200 dark:border-white/10">
                        <div class="flex justify-between items-center mb-2">
                             <label class="block text-sm font-bold text-emerald-700 dark:text-emerald-400">Parcelas Já Pagas</label>
                             <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/40 px-2 py-1 rounded-full">
                                <span id="paidLabel"><?= $project['installments_paid'] ?? 0 ?></span> / <span id="totalLabel"><?= $project['installments'] ?></span>
                             </span>
                        </div>
                        <input type="range" name="installments_paid" id="paidSlider" value="<?= $project['installments_paid'] ?? 0 ?>" min="0" max="<?= $project['installments'] ?>" 
                               class="w-full h-2 bg-slate-200 dark:bg-white/10 rounded-lg appearance-none cursor-pointer accent-emerald-500">
                        <div class="text-center mt-2">
                            <span id="paidVal" class="text-3xl font-bold text-emerald-600"><?= $project['installments_paid'] ?? 0 ?></span>
                            <span class="text-sm text-emerald-500 font-medium">Parcelas confirmadas</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer Actions -->
            <div class="bg-slate-50 dark:bg-white/5 px-8 py-5 border-t border-slate-100 dark:border-white/5 flex items-center justify-between">
                <a href="/admin/projects/edit?id=<?= $project['id'] ?>" class="text-sm text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-white font-medium">
                    Editar outras informações
                </a>
                <button type="submit" class="bg-slate-900 hover:bg-black dark:bg-operon-deep dark:hover:bg-operon-deep/90 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Salvar Dados Financeiros
                </button>
            </div>
        </div>

        <?php if(isset($_GET['success'])): ?>
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-2 animate-fade-in">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p>Dados financeiros atualizados com sucesso!</p>
            </div>
        <?php endif; ?>

    </form>
</div>

<script>
    const totalInput = document.getElementById('totalInstallments');
    const paidSlider = document.getElementById('paidSlider');
    const totalLabel = document.getElementById('totalLabel');
    const paidLabel = document.getElementById('paidLabel');
    const paidVal = document.getElementById('paidVal');

    // Update Slider Max when Total changes
    totalInput.addEventListener('input', function() {
        const val = parseInt(this.value) || 1;
        totalLabel.innerText = val;
        paidSlider.max = val;
        
        // If slider value > new max, clamp it
        if (parseInt(paidSlider.value) > val) {
            paidSlider.value = val;
            updatePaidDisplay();
        }
    });

    // Update Labels when Slider changes
    paidSlider.addEventListener('input', updatePaidDisplay);

    function updatePaidDisplay() {
        paidLabel.innerText = paidSlider.value;
        paidVal.innerText = paidSlider.value;
    }
</script>
