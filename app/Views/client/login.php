<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso do Cliente | Operon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <script>
        // Simple Theme Detection
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
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
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #FBFBFC; }
        .ios-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(10, 47, 47, 0.05);
            border-radius: 32px;
            box-shadow: 0 20px 40px -12px rgba(10, 47, 47, 0.08);
        }
        .input-premium {
            background: #FBFBFC;
            border: 1px solid #EBEFF2;
            color: #0A2F2F;
            transition: all 0.2s ease;
        }
        .input-premium:focus {
            border-color: #B9C7B4;
            box-shadow: 0 0 0 4px rgba(212, 223, 209, 0.3);
            outline: none;
            background: white;
        }

        .dark body { background-color: #050B0C; }
        .dark .ios-card {
            background: rgba(13, 21, 23, 0.8);
            border-color: rgba(255, 255, 255, 0.05);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.4);
        }
        .dark .input-premium {
            background: #0D1517 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #E8F1F2 !important;
        }
        .dark .input-premium:focus {
            border-color: #D4DFD1 !important;
            box-shadow: 0 0 0 4px rgba(212, 223, 209, 0.1) !important;
        }
    </style>
</head>
<body class="h-screen w-full flex items-center justify-center relative overflow-hidden text-slate-300 dark:bg-[#050B0C] transition-colors duration-500">

    <!-- Cinematic Background -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-[-20%] left-[-10%] w-[60%] h-[60%] bg-operon-mist/40 rounded-full blur-[120px] animate-float"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-operon-deep/5 rounded-full blur-[100px] animate-pulse-slow"></div>
    </div>

    <!-- Login Container -->
    <div class="relative z-10 w-full max-w-sm p-10 ios-card animate-scale-in">
        
        <div class="text-center mb-10">
            <div class="w-20 h-20 bg-operon-deep text-operon-mist rounded-[24px] mx-auto flex items-center justify-center shadow-premium mb-8 border border-white/10">
                 <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            </div>
            <h1 class="text-3xl font-black text-operon-deep dark:text-white tracking-tighter uppercase mb-2">Operon V2</h1>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.3em]">Ambiente Neural de Gestão</p>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg text-sm mb-6 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span>Credenciais inválidas. Tente novamente.</span>
            </div>
        <?php endif; ?>

        <form action="/login" method="POST" class="space-y-6">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">E-mail de Sincronização</label>
                <input type="email" name="email" required placeholder="seu@email corporativo" 
                    class="w-full px-5 py-4 rounded-2xl input-premium text-sm font-bold placeholder-slate-300">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Chave de Acesso</label>
                <input type="password" name="password" required placeholder="••••••••" 
                    class="w-full px-5 py-4 rounded-2xl input-premium text-sm font-bold placeholder-slate-300">
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-operon-deep hover:bg-black text-white font-black py-4.5 rounded-[18px] shadow-premium transition-all transform hover:-translate-y-0.5 uppercase tracking-[0.2em] text-xs border border-white/5 active:scale-95">
                    Ativar Interface
                </button>
            </div>
        </form>

        <div class="mt-10 text-center">
            <a href="#" class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest hover:text-operon-deep dark:hover:text-operon-mist transition-colors decoration-operon-mist underline-offset-4">Esqueceu a chave? Contate o suporte.</a>
        </div>

    </div>

</body>
</html>
