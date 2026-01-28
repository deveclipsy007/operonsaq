<!DOCTYPE html>
<html lang="pt-BR" class="dark antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operon Login</title>
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Force dark mode
        document.documentElement.classList.add('dark');

        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        operon: {
                            deep: '#0A2F2F',
                            mist: '#D4DFD1',
                            mistDark: '#B9C7B4',
                            paper: '#0B0E11',
                            ink: '#E2E8F0',
                            slate: '#1F2937'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { 
            background-color: #0B0E11 !important; 
            font-family: 'Inter', sans-serif;
        }
        .card-glass {
            background: rgba(21, 25, 29, 0.65);
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 32px 64px rgba(0, 0, 0, 0.5);
        }
        .input-neural {
            background: rgba(21, 25, 29, 0.8);
            border-color: rgba(255, 255, 255, 0.1);
            color: #E2E8F0;
        }
        .input-neural:focus {
            border-color: #D4DFD1;
            box-shadow: 0 0 0 4px rgba(212, 223, 209, 0.15);
        }
        .input-neural::placeholder {
            color: #4B5563;
        }
    </style>
</head>
<body class="font-sans text-[#E2E8F0] bg-[#0B0E11] h-screen w-screen flex items-center justify-center overflow-hidden relative">

    <!-- Ambient Background -->
    <div class="absolute -top-[30%] -left-[10%] w-[70%] h-[70%] rounded-full bg-operon-mist/10 blur-[120px] animate-pulse-ring"></div>
    <div class="absolute -bottom-[20%] -right-[10%] w-[60%] h-[60%] rounded-full bg-operon-deep/20 blur-[100px] animate-pulse-ring" style="animation-delay: 1s;"></div>

    <!-- Login Card -->
    <div class="w-full max-w-sm p-10 bg-[#15191D]/80 backdrop-blur-2xl rounded-[32px] shadow-premium border border-white/10 relative z-10 animate-scale-in card-glass">
        
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-operon-deep text-operon-mist rounded-2xl mx-auto flex items-center justify-center shadow-premium mb-6 border border-white/10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h1 class="text-2xl font-black text-white tracking-tighter uppercase px-2">Operon Cortex</h1>
            <p class="text-[10px] text-slate-500 font-bold mt-2 uppercase tracking-[0.3em]">Interface Neural • Admin</p>
        </div>

        <?php if(isset($_GET['error'])): ?>
            <div class="mb-6 p-3 bg-rose-500/20 border border-rose-500/30 rounded-xl text-rose-400 text-xs font-bold text-center">
                Credenciais inválidas. Tente novamente.
            </div>
        <?php endif; ?>

        <form action="/admin/login" method="POST" class="space-y-5">
            
            <div class="space-y-1.5">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Sincronização</label>
                <input type="email" name="email" required placeholder="admin@operon.cortex" 
                    class="w-full bg-[#1F2937] border border-white/10 rounded-xl px-5 py-3.5 text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-operon-mist/30 focus:border-operon-mist transition-all font-bold text-sm input-neural">
            </div>

            <div class="space-y-1.5">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Chave de Acesso</label>
                <input type="password" name="password" required placeholder="••••••••" 
                    class="w-full bg-[#1F2937] border border-white/10 rounded-xl px-5 py-3.5 text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-operon-mist/30 focus:border-operon-mist transition-all font-bold text-sm input-neural">
            </div>

            <button type="submit" class="w-full bg-operon-deep hover:bg-operon-mist hover:text-operon-deep text-white font-black py-4 rounded-xl shadow-premium transition-all transform hover:-translate-y-0.5 active:scale-95 flex items-center justify-center group relative overflow-hidden border border-white/10 uppercase tracking-[0.2em] text-xs">
                <span class="relative z-10">Iniciar Sincronização</span>
            </button>

        </form>
        
        <div class="mt-10 text-center">
            <a href="#" class="text-[10px] font-black text-slate-500 uppercase tracking-widest hover:text-operon-mist transition-colors decoration-operon-mist underline-offset-4">Resetar Chave Neural</a>
        </div>
    </div>

    <!-- Footer -->
    <div class="absolute bottom-10 text-center w-full">
        <p class="text-[10px] text-slate-600 font-black uppercase tracking-[0.4em] opacity-40">Operon System • Deep Petrol Protocol • v2.0</p>
    </div>

</body>
</html>
