<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operon Córtex</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        slate: { 50: '#f8fafc', 500: '#64748b', 800: '#1e293b', 900: '#0f172a' },
                        indigo: { 600: '#4f46e5', 700: '#4338ca' },
                        emerald: { 500: '#10b981', 600: '#059669' }
                    }
                }
            }
        }
    </script>
    <style>
        .fade-in { animation: fadeIn 0.4s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased h-screen flex overflow-hidden">

    <!-- Sidebar (The Brain Stem) -->
    <aside class="w-64 bg-slate-900 text-white flex-shrink-0 flex flex-col transition-all duration-300">
        <div class="h-16 flex items-center px-6 border-b border-slate-800">
            <h1 class="text-xl font-bold tracking-tight text-white">Operon<span class="text-indigo-400">Córtex</span></h1>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="/admin" class="flex items-center px-4 py-3 bg-indigo-600/10 text-indigo-400 rounded-lg transition-colors hover:bg-indigo-600/20">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Projetos
            </a>
            
            <a href="/admin/clients" class="flex items-center px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Clientes
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800">
            <a href="/logout" class="flex items-center text-slate-400 hover:text-white transition-colors text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Desconectar
            </a>
        </div>
    </aside>

    <!-- Main Synapse Area -->
    <main class="flex-1 flex flex-col overflow-y-auto bg-slate-50">
        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-10 shadow-sm">
            <div class="text-sm font-medium text-slate-500">
                Homeostase do Sistema: <span class="text-emerald-600">Estável</span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-slate-600">Operador</span>
                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">OP</div>
            </div>
        </header>

        <!-- Content Injection System -->
        <div class="p-8 max-w-7xl mx-auto w-full fade-in">
            <?= $content ?? '' ?>
        </div>
    </main>

</body>
</html>
