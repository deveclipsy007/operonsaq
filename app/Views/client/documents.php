<div class="max-w-7xl mx-auto px-4 md:px-8 py-10">
    <!-- Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4 animate-fade-in-up">
        <div>
            <a href="/dashboard" class="text-sm font-bold text-slate-400 hover:text-indigo-600 transition-colors mb-2 inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                Voltar ao Dashboard
            </a>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Contratos e Documentos</h1>
            <p class="text-slate-500 font-medium mt-1">Repositório oficial de documentos do projeto.</p>
        </div>
        <div class="flex items-center gap-3">
             <div class="h-10 w-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-xl shadow-sm">
                📜
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-fade-in" style="animation-delay: 100ms">
        
        <!-- Contract Card -->
        <?php if (!empty($project['contract_url'])): ?>
        <div class="ios-card p-0 overflow-hidden group hover:shadow-lg transition-all border border-slate-100 bg-white">
            <div class="h-2 bg-indigo-500"></div>
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="h-12 w-12 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl">
                        📄
                    </div>
                     <span class="bg-indigo-50 text-indigo-700 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider">Oficial</span>
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-1">Contrato de Prestação de Serviços</h3>
                <p class="text-xs text-slate-500 mb-6 line-clamp-2">Documento assinado digitalmente referente ao desenvolvimento do projeto <?= htmlspecialchars($project['name']) ?>.</p>
                
                <a href="<?= $project['contract_url'] ?>" target="_blank" class="w-full flex items-center justify-center gap-2 py-3 bg-slate-50 hover:bg-slate-100 text-slate-700 rounded-xl font-bold text-sm transition-colors group-hover:bg-indigo-600 group-hover:text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Baixar Contrato
                </a>
            </div>
        </div>
        <?php else: ?>
             <div class="ios-card p-6 border-dashed border-2 border-slate-200 bg-white/5 flex flex-col items-center justify-center text-center opacity-75">
                <div class="h-12 w-12 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mb-3">
                    ❌
                </div>
                <h3 class="font-bold text-slate-500 mb-1">Nenhum contrato disponível</h3>
                <p class="text-xs text-slate-400">O contrato ainda não foi anexado a este projeto.</p>
             </div>
        <?php endif; ?>

        <!-- Invoice Placeholder 1 -->
        <div class="ios-card p-0 overflow-hidden group hover:shadow-lg transition-all border border-slate-100 bg-white">
             <div class="h-2 bg-slate-300 dark:bg-slate-700"></div>
             <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="h-12 w-12 rounded-lg bg-slate-50 text-slate-400 flex items-center justify-center text-2xl">
                        🧾
                    </div>
                     <span class="bg-slate-100 text-slate-500 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider">Vazio</span>
                </div>
                <h3 class="font-bold text-slate-700 text-lg mb-1">Nota Fiscal #001</h3>
                <p class="text-xs text-slate-500 mb-6">Nota fiscal referente à primeira parcela.</p>
                
                <button disabled class="w-full flex items-center justify-center gap-2 py-3 bg-slate-50 text-slate-300 rounded-xl font-bold text-sm cursor-not-allowed">
                    Indisponível
                </button>
            </div>
        </div>

        <!-- Add New Doc Placeholder -->
        <div class="rounded-2xl border-2 border-dashed border-slate-200 p-6 flex flex-col items-center justify-center text-center transition-colors hover:border-indigo-300 hover:bg-slate-50/50 cursor-help">
            <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                ?
            </div>
            <h3 class="font-bold text-slate-600 text-sm mb-1">Procurando outro documento?</h3>
            <p class="text-xs text-slate-400 max-w-[200px]">Entre em contato com o gerente do projeto para solicitar documentos adicionais.</p>
        </div>

    </div>
</div>
