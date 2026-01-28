
<div class="flex-1 flex flex-col items-center justify-center min-h-screen p-6 text-center fade-in">
    
    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-8 relative">
        <div class="absolute inset-0 rounded-full bg-slate-100 animate-ping opacity-75"></div>
        <svg class="w-10 h-10 text-slate-400 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
    </div>

    <h1 class="text-3xl font-bold text-slate-900 tracking-tight mb-3">Olá, <?= htmlspecialchars($client['name']) ?></h1>
    
    <div class="max-w-md mx-auto space-y-2">
        <p class="text-lg text-slate-600">Sua conexão com o Operon Córtex foi estabelecida.</p>
        <p class="text-slate-500">
            Neste momento, nossos arquitetos estão preparando a estrutura do seu projeto. 
            Em breve, sua timeline de progresso aparecerá aqui.
        </p>
    </div>

    <div class="mt-12 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
        <span class="text-xs font-semibold tracking-widest text-slate-400 uppercase">Monitorado por Operon</span>
    </div>

</div>
