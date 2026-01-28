<!DOCTYPE html>
<html lang="pt-BR" class="dark antialiased">
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
    <script>
        // Force dark mode always
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
                        },
                        slate: { 50: '#1F2937', 100: '#374151', 200: '#4B5563', 300: '#6B7280', 400: '#9CA3AF', 500: '#D1D5DB', 600: '#E5E7EB', 700: '#F3F4F6', 800: '#F9FAFB' },
                        indigo: { 50: '#1e1b4b', 500: '#6366f1', 600: '#4f46e5' }
                    },
                    fontFamily: {
                        sans: ['Inter', 'SF Pro Display', '-apple-system', 'sans-serif'],
                    },
                    boxShadow: {
                        'apple': '0 4px 24px rgba(0,0,0,0.3)',
                        'premium': '0 8px 32px rgba(0,0,0,0.4)',
                    }
                }
            }
        }
    </script>
<style>
        :root {
            --operon-deep: #0A2F2F;
            --operon-mist: #D4DFD1;
            --operon-paper: #0B0E11;
            --operon-card: #15191D;
            --operon-border: rgba(255,255,255,0.08);
        }
        
        /* CRITICAL CSS - Dark Mode Only */
        html, body { 
            background-color: #0B0E11 !important; 
            color: #E2E8F0 !important; 
            font-family: 'Inter', sans-serif;
        }
        
        .card-apple, .ios-card { 
            background-color: #15191D !important; 
            border-radius: 20px; 
            border: 1px solid rgba(255,255,255,0.08) !important; 
            box-shadow: 0 4px 24px rgba(0,0,0,0.3);
        }
        
        .bg-white { background-color: #15191D !important; }
        .bg-slate-50, .bg-slate-100 { background-color: #1F2937 !important; }
        .bg-gray-50, .bg-gray-100 { background-color: #1F2937 !important; }
        
        .text-slate-600, .text-slate-700, .text-slate-800, .text-slate-900 { color: #E2E8F0 !important; }
        .text-gray-600, .text-gray-700, .text-gray-800, .text-gray-900 { color: #E2E8F0 !important; }
        .text-operon-deep { color: #D4DFD1 !important; }
        
        .border-slate-100, .border-slate-200, .border-gray-100, .border-gray-200 { 
            border-color: rgba(255,255,255,0.08) !important; 
        }
        
        /* Form Inputs */
        input, textarea, select {
            background-color: #1F2937 !important;
            border-color: rgba(255,255,255,0.1) !important;
            color: #E2E8F0 !important;
        }
        input::placeholder, textarea::placeholder {
            color: #6B7280 !important;
        }
        input:focus, textarea:focus, select:focus {
            border-color: #D4DFD1 !important;
            outline: none;
            box-shadow: 0 0 0 3px rgba(212, 223, 209, 0.2) !important;
        }
        
        /* Tables */
        table { background-color: #15191D !important; }
        thead { background-color: #1F2937 !important; }
        th, td { border-color: rgba(255,255,255,0.08) !important; color: #E2E8F0 !important; }
        tr:hover { background-color: rgba(255,255,255,0.03) !important; }
        
        /* Buttons */
        .btn-primary, button[type="submit"] {
            background-color: #0A2F2F !important;
            color: #D4DFD1 !important;
            border: 1px solid rgba(212, 223, 209, 0.2) !important;
        }
        .btn-primary:hover, button[type="submit"]:hover {
            background-color: #0D3D3D !important;
        }
        
        /* Sidebar */
        .sidebar-item-active { 
            background-color: rgba(212, 223, 209, 0.1) !important; 
            color: #D4DFD1 !important; 
        }
        
        /* Animations */
        .animate-fade-in { animation: fadeIn 0.6s cubic-bezier(0.22, 1, 0.36, 1); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #374151; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #4B5563; }
        
        /* Modal Backdrop */
        .modal-backdrop { background-color: rgba(0,0,0,0.8) !important; }
        
        /* Fix specific white backgrounds */
        [class*="bg-white"], [style*="background: white"], [style*="background-color: white"],
        [style*="background:#fff"], [style*="background-color:#fff"] {
            background-color: #15191D !important;
        }
        
        /* Ensure all text is readable */
        p, span, div, label, h1, h2, h3, h4, h5, h6, a, li {
            color: inherit;
        }
        
        /* Fix badges and tags */
        .bg-emerald-50 { background-color: rgba(16, 185, 129, 0.15) !important; }
        .bg-amber-50 { background-color: rgba(245, 158, 11, 0.15) !important; }
        .bg-rose-50 { background-color: rgba(244, 63, 94, 0.15) !important; }
        .bg-blue-50 { background-color: rgba(59, 130, 246, 0.15) !important; }
        .bg-indigo-50 { background-color: rgba(99, 102, 241, 0.15) !important; }
        
        /* Operon Mist backgrounds */
        .bg-operon-mist { background-color: rgba(212, 223, 209, 0.15) !important; }
        .bg-operon-mist\/30 { background-color: rgba(212, 223, 209, 0.1) !important; }
        
        /* ===== MOBILE RESPONSIVENESS ===== */
        
        /* Mobile First - Base */
        @media (max-width: 768px) {
            /* Header ajustado */
            header.h-20 {
                height: 60px !important;
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            /* Main content com menos padding */
            main {
                padding: 1rem !important;
            }
            
            /* Cards responsivos */
            .card-apple, .ios-card {
                border-radius: 16px !important;
                padding: 1rem !important;
            }
            
            /* Títulos menores */
            h1 {
                font-size: 1.5rem !important;
                line-height: 1.2 !important;
            }
            h2 {
                font-size: 1.25rem !important;
            }
            h3 {
                font-size: 1rem !important;
            }
            
            /* Grid responsivo - 1 coluna em mobile */
            .grid-cols-2, .grid-cols-3, .grid-cols-4 {
                grid-template-columns: 1fr !important;
            }
            
            /* Stat cards - 2 colunas em mobile */
            .grid.gap-6.sm\\:grid-cols-2.lg\\:grid-cols-4 {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 0.75rem !important;
            }
            
            /* Botões full width */
            button, .btn, a.btn {
                width: 100%;
                justify-content: center;
            }
            
            /* Forms responsivos */
            input, textarea, select {
                font-size: 16px !important; /* Previne zoom no iOS */
            }
            
            /* Tabelas scrolláveis */
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            
            /* Flexbox em coluna */
            .flex.items-center.justify-between {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start !important;
            }
            
            /* Spacing menor */
            .gap-6 { gap: 1rem !important; }
            .gap-8 { gap: 1.25rem !important; }
            .mb-10 { margin-bottom: 1.5rem !important; }
            .py-8 { padding-top: 1rem !important; padding-bottom: 1rem !important; }
            .px-8 { padding-left: 1rem !important; padding-right: 1rem !important; }
            
            /* Sidebar mobile */
            aside {
                width: 280px !important;
            }
            
            /* Footer padding */
            .p-4 {
                padding: 0.75rem !important;
            }
        }
        
        /* Small phones */
        @media (max-width: 380px) {
            h1 {
                font-size: 1.25rem !important;
            }
            
            .grid.gap-6.sm\\:grid-cols-2.lg\\:grid-cols-4 {
                grid-template-columns: 1fr !important;
            }
            
            .text-3xl { font-size: 1.5rem !important; }
            .text-2xl { font-size: 1.25rem !important; }
            .text-xl { font-size: 1rem !important; }
        }
        
        /* Tablet landscape */
        @media (min-width: 769px) and (max-width: 1024px) {
            main {
                padding: 1.5rem !important;
            }
            
            .grid-cols-4 {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }
        
        /* Sidebar closed on mobile by default */
        @media (max-width: 1023px) {
            aside:not(.translate-x-0) {
                transform: translateX(-100%);
            }
        }
        
        /* Touch friendly elements */
        @media (pointer: coarse) {
            button, a, input, select, textarea {
                min-height: 44px;
            }
            
            nav a {
                padding: 0.875rem 1rem !important;
            }
        }
    </style>
</head>
<body x-data="{ sidebarOpen: false }" class="font-sans text-[#E2E8F0] bg-[#0B0E11]">

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
         class="fixed inset-0 bg-black/80 z-40 lg:hidden backdrop-blur-sm"></div>

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 bg-[#0A2F2F] border-r border-white/5 w-64 transition-all duration-300 z-50 transform lg:translate-x-0" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
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
                <svg class="w-5 h-5 opacity-50 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Suporte & Ideias
            </a>
        </nav>

        <!-- User Profile -->
        <div class="absolute bottom-0 left-0 w-full p-4 bg-black/20 border-t border-white/5">
            <div class="flex items-center gap-3">
                <img class="w-9 h-9 rounded-full ring-2 ring-white/10" src="https://ui-avatars.com/api/?name=Admin+User&background=0A2F2F&color=fff" alt="Admin">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-white truncate">Admin User</p>
                    <p class="text-xs text-white/40 truncate font-medium">Versão 2.0</p>
                </div>
                <a href="/admin/logout" class="text-white/40 hover:text-white transition-colors" title="Sair">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="lg:ml-64 min-h-screen flex flex-col bg-[#0B0E11]">
        <!-- Topbar -->
        <header class="h-20 bg-[#0B0E11] backdrop-blur-xl border-b border-white/5 flex items-center justify-between px-8 relative z-40">
            <button @click="sidebarOpen = true" class="lg:hidden p-2 text-[#9CA3AF]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <div class="flex-1"></div>
            <div class="flex items-center gap-4">
                <!-- Admin Avatar -->
                <div class="h-10 w-10 rounded-xl bg-[#0A2F2F] flex items-center justify-center text-[#D4DFD1] font-black text-sm border border-[#D4DFD1]/20">
                    A
                </div>
            </div>
        </header>

        <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8 bg-[#0B0E11]">
            <div class="max-w-7xl mx-auto animate-fade-in">
                <?php require $viewPath; ?>
            </div>
        </main>
    </div>

</body>
</html>
