<!DOCTYPE html>
<html lang="pt-BR" class="antialiased bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operon Cortex</title>
    <?php
    // Determine CSS Path based on execution context
    $cssPath = '/assets/css/style.css';
    if (file_exists(__DIR__ . '/../../public/assets/css/style.css') && !file_exists($_SERVER['DOCUMENT_ROOT'] . '/assets/css/style.css')) {
        $cssPath = '/public/assets/css/style.css';
    }
    ?>
    <link href="<?= $cssPath ?>?v=<?= time() ?>" rel="stylesheet">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CRITICAL CSS FALLBACK */
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .bg-operon-deep { background-color: #0A2F2F !important; }
        .text-operon-deep { color: #0A2F2F !important; }
        .bg-operon-mist { background-color: #D4DFD1 !important; }
        .text-white { color: #ffffff !important; }
        .rounded-xl { border-radius: 0.75rem !important; }
        .flex { display: flex; }
        .hidden { display: none; }
        .lg\:hidden { display: none; }
        @media (min-width: 1024px) {
            .lg\:block { display: block; }
            .lg\:flex { display: flex; }
            .lg\:hidden { display: none !important; }
        }
        /* Ensure layout structure even if Tailwind fails */
        aside { width: 16rem; }
        header { height: 5rem; }
    </style>
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
                        },
                        slate: { 50: '#f8fafc', 500: '#64748b', 800: '#1e293b' },
                        indigo: { 50: '#eef2ff', 500: '#6366f1', 600: '#4f46e5' }
                    },
                    fontFamily: {
                        sans: ['Inter', 'SF Pro Display', '-apple-system', 'sans-serif'],
                    },
                    boxShadow: {
                        'apple': '0 4px 12px rgba(10, 47, 47, 0.04)',
                        'premium': '0 8px 32px rgba(10, 47, 47, 0.06)',
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --operon-deep: #0A2F2F;
            --operon-mist: #D4DFD1;
            --operon-paper: #FBFBFC;
        }
        
        /* Dark Mode Basis */
        /* Dark Mode Basis */
        body { background-color: #FBFBFC; color: #1A1C1E; transition: background-color 0.3s ease, color 0.3s ease; }
        .card-apple { 
            background-color: #ffffff; 
            border-radius: 20px; 
            border: 1px solid #EBEFF2; 
            box-shadow: 0 4px 12px rgba(10, 47, 47, 0.04);
            transition: all 0.3s ease;
        }

        /* Dark Mode Basis */
        .dark body { background-color: #0B0E11; color: #E2E8F0; }
        .dark .card-apple { background-color: #15191D; border-color: rgba(255,255,255,0.05); box-shadow: 0 4px 24px rgba(0,0,0,0.2); }
        .dark .sidebar-item-active { background-color: rgba(212, 223, 209, 0.05); color: #D4DFD1; }
        .dark .sidebar-item-active { background-color: rgba(212, 223, 209, 0.05); color: #D4DFD1; }
        
        .animate-fade-in { animation: fadeIn 0.6s cubic-bezier(0.22, 1, 0.36, 1); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Custom Scrollbar Premium */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #1F2937; }
    </style>
</head>
<body x-data="{ sidebarOpen: false }" class="font-sans text-slate-600 dark:text-[#E2E8F0] transition-colors duration-300">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         style="display: none;"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-slate-900/80 z-40 lg:hidden glass backdrop-blur-sm"></div>

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 bg-operon-deep dark:bg-[#0B0E11] border-r border-white/5 w-64 transition-all duration-300 z-50 transform lg:translate-x-0" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <div class="h-20 flex items-center px-6 border-b border-white/5">
            <div class="flex items-center gap-3 font-bold text-white text-xl tracking-tight">
                <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-operon-mist shadow-lg backdrop-blur-md border border-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span>Operon</span>
            </div>
        </div>

        <nav class="p-4 space-y-2">
            <a href="/admin/dashboard" class="flex items-center gap-3 px-3 py-3 text-sm font-semibold rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all group">
                <svg class="w-5 h-5 opacity-50 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>
            <a href="/admin/projects" class="flex items-center gap-3 px-3 py-3 text-sm font-semibold rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all group">
                <svg class="w-5 h-5 opacity-50 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                Projetos
            </a>
            <a href="/admin/clients" class="flex items-center gap-3 px-3 py-3 text-sm font-semibold rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all group">
                <svg class="w-5 h-5 opacity-50 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Clientes
            </a>
            <a href="/admin/support" class="flex items-center gap-3 px-3 py-3 text-sm font-semibold rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all group">
                <svg class="w-5 h-5 opacity-50 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Suporte & Ideias
            </a>
        </nav>

        <!-- User Profile -->
        <div class="absolute bottom-0 left-0 w-full p-4 bg-black/20 border-t border-white/5">
            <div class="flex items-center gap-3">
                <img class="w-9 h-9 rounded-full ring-2 ring-white/10" src="https://ui-avatars.com/api/?name=Admin+User&background=0A2F2F&color=fff" alt="Admin">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-white truncate">Admin User</p>
                    <p class="text-xs text-white/40 truncate font-medium underline decoration-operon-mist/30">Versão 2.0</p>
                </div>
                <a href="/admin/logout" class="text-white/40 hover:text-white transition-colors" title="Sair">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="lg:ml-64 min-h-screen flex flex-col">
        <!-- Topbar -->
        <header class="h-20 bg-white/70 dark:bg-[#0B0E11]/70 backdrop-blur-xl border-b border-slate-100 dark:border-white/5 flex items-center justify-between px-8 sticky top-0 z-40 transition-colors">
            <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <div class="flex-1"></div>
            <div class="flex items-center gap-4">
                <!-- Theme Toggle -->
                <button onclick="toggleTheme()" class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/10 flex items-center justify-center text-slate-400 hover:text-operon-deep dark:hover:text-operon-mist transition-all">
                    <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>

                <script>
                    function toggleTheme() {
                        if (document.documentElement.classList.contains('dark')) {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('admin_theme', 'light');
                        } else {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('admin_theme', 'dark');
                        }
                    }
                </script>

                <div class="h-10 w-10 rounded-xl bg-operon-mist/30 flex items-center justify-center text-operon-deep font-black text-sm border border-operon-mist">
                    A
                </div>
            </div>
        </header>

        <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto animate-fade-in">
                <?php require $viewPath; ?>
            </div>
        </main>
    </div>

</body>
</html>
