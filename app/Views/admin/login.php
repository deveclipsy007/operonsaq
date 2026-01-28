<!DOCTYPE html>
<html lang="pt-BR" class="antialiased bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operon Login</title>
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Simple Theme Detection
        if (localStorage.getItem('admin_theme') === 'dark' || (!('admin_theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        operon: {
                            deep: '#0A2F2F',
                            mist: '#D4DFD1',
                            mistDark: '#B9C7B4',
                            paper: '#FBFBFC',
                            ink: '#1A1C1E',
                            slate: '#EBEFF2'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .dark body { background-color: #0B0E11; }
        .dark .card-glass {
            background: rgba(21, 25, 29, 0.45);
            border-color: rgba(255, 255, 255, 0.05);
            box-shadow: 0 32px 64px rgba(0, 0, 0, 0.4);
        }
        .dark .input-neural {
            background: rgba(21, 25, 29, 0.6);
            border-color: rgba(255, 255, 255, 0.1);
            color: #E2E8F0;
        }
        .dark .input-neural:focus {
            border-color: #D4DFD1;
            box-shadow: 0 0 0 4px rgba(212, 223, 209, 0.1);
        }
    </style>
</head>
<body class="font-sans text-slate-600 bg-[#F5F5F7] dark:bg-[#0B0E11] h-screen w-screen flex items-center justify-center overflow-hidden relative transition-colors duration-500">

    <!-- Ambient Background -->
    <div class="absolute -top-[30%] -left-[10%] w-[70%] h-[70%] rounded-full bg-operon-mist/20 blur-[120px] animate-pulse-ring"></div>
    <div class="absolute -bottom-[20%] -right-[10%] w-[60%] h-[60%] rounded-full bg-operon-deep/5 blur-[100px] animate-pulse-ring" style="animation-delay: 1s;"></div>

    <!-- Login Card -->
    <div class="w-full max-w-sm p-10 bg-white/40 dark:bg-[#15191D]/40 backdrop-blur-2xl rounded-[32px] shadow-premium border border-white/60 dark:border-white/5 relative z-10 animate-scale-in card-glass">
        
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-operon-deep text-operon-mist rounded-2xl mx-auto flex items-center justify-center shadow-premium mb-6 border border-white/10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h1 class="text-2xl font-black text-operon-deep dark:text-white tracking-tighter uppercase px-2">Operon Cortex</h1>
            <p class="text-[10px] text-slate-500 dark:text-slate-400 font-bold mt-2 uppercase tracking-[0.3em]">Interface Neural • Admin</p>
        </div>

        <form action="/admin/login" method="POST" class="space-y-5">
            
            <div class="space-y-1.5">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Sincronização</label>
                <input type="email" name="email" required placeholder="admin@operon.cortex" 
                    class="w-full bg-white/60 dark:bg-black/20 border border-operon-mist dark:border-white/10 rounded-xl px-5 py-3.5 text-operon-deep dark:text-operon-mist placeholder-slate-300 dark:placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-operon-mist/50 focus:border-operon-mistDark transition-all font-bold text-sm input-neural">
            </div>

            <div class="space-y-1.5">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Chave de Acesso</label>
                <input type="password" name="password" required placeholder="••••••••" 
                    class="w-full bg-white/60 dark:bg-black/20 border border-operon-mist dark:border-white/10 rounded-xl px-5 py-3.5 text-operon-deep dark:text-operon-mist placeholder-slate-300 dark:placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-operon-mist/50 focus:border-operon-mistDark transition-all font-bold text-sm input-neural">
            </div>

            <button type="submit" class="w-full bg-operon-deep dark:bg-operon-deep hover:bg-black dark:hover:bg-operon-mist dark:hover:text-operon-deep text-white font-black py-4 rounded-xl shadow-premium transition-all transform hover:-translate-y-0.5 active:scale-95 flex items-center justify-center group relative overflow-hidden border border-white/5 uppercase tracking-[0.2em] text-xs">
                <span class="relative z-10">Iniciar Sincronização</span>
            </button>

        </form>
        
        <div class="mt-10 text-center">
            <a href="#" class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest hover:text-operon-deep dark:hover:text-operon-mist transition-colors decoration-operon-mist underline-offset-4">Resetar Chave Neural</a>
        </div>
    </div>

    <!-- Footer -->
    <div class="absolute bottom-10 text-center w-full">
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.4em] opacity-40">Operon System • Deep Petrol Protocol • v2.0</p>
    </div>

</body>
</html>
