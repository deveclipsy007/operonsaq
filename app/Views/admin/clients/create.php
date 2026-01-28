
<div class="max-w-2xl mx-auto pt-10">
    
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-black text-operon-deep tracking-tight">Nova Conexão Neural</h2>
        <p class="text-slate-500 mt-2 font-medium tracking-tight">Estabelecendo um novo neurônio no ecossistema Operon.</p>
    </div>

    <div class="ios-card shadow-premium border border-slate-100 overflow-hidden relative group">
        <!-- Decorative Top Bar -->
        <div class="h-1.5 bg-operon-deep"></div>

        <form action="/admin/clients/store" method="POST" class="p-8 space-y-6 relative z-10">
            
            <!-- Name Input -->
            <div class="group">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 transition-colors group-focus-within:text-operon-deep">Nome da Empresa / Cliente</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-operon-deep transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <input type="text" name="name" required placeholder="Ex: Corporação Neural" 
                        class="block w-full pl-11 pr-4 py-4 border border-operon-mist rounded-xl leading-5 bg-white text-operon-deep font-bold placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-operon-mist focus:border-operon-mistDark transition-all shadow-sm text-sm">
                </div>
            </div>

            <!-- Email Input -->
            <div class="group">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 transition-colors group-focus-within:text-operon-deep">E-mail de Sincronização</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-operon-deep transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                    </div>
                    <input type="email" name="email" required placeholder="contato@empresa.com" 
                        class="block w-full pl-11 pr-4 py-4 border border-operon-mist rounded-xl leading-5 bg-white text-operon-deep font-bold placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-operon-mist focus:border-operon-mistDark transition-all shadow-sm text-sm">
                </div>
            </div>

            <!-- Password Input -->
            <div class="group">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 transition-colors group-focus-within:text-operon-deep">Chave de Segurança</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-operon-deep transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <input type="password" name="password" required placeholder="Defina uma chave complexa" 
                        class="block w-full pl-11 pr-4 py-4 border border-operon-mist rounded-xl leading-5 bg-white text-operon-deep font-bold placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-operon-mist focus:border-operon-mistDark transition-all shadow-sm text-sm">
                </div>
                <p class="text-[10px] text-slate-400 mt-2 font-medium tracking-tight">*O cliente usará estas credenciais para acessar seu Córtex individual.</p>
            </div>

            <div class="flex items-center space-x-4 pt-4">
                <a href="/admin/clients" class="flex-1 text-center py-4 px-4 border border-operon-mist rounded-xl text-slate-400 font-black uppercase tracking-widest text-[10px] hover:bg-slate-50 transition-all">
                    Abortar
                </a>
                <button type="submit" class="flex-[2] bg-operon-deep hover:bg-black text-white font-black py-4 px-4 rounded-xl shadow-premium transition-all transform hover:-translate-y-0.5 flex items-center justify-center border border-white/5 uppercase tracking-[0.2em] text-[10px]">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Ativar Conexão
                </button>
            </div>

        </form>
    </div>
</div>
