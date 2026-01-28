<!DOCTYPE html>
<html lang="pt-BR" class="antialiased bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesse seu Projeto</title>
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
</head>
<body class="font-sans text-slate-600 bg-white h-screen w-screen flex flex-col items-center justify-center relative overflow-hidden">

    <!-- Hero Content -->
    <div class="w-full max-w-lg px-6 z-10 text-center animate-slide-up">
        
        <div class="mb-10 inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-8 ring-1 ring-slate-900/5 shadow-sm">
            <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11.536 17 10 18.536l-1.414-1.414L6 20l-2-2 4.414-4.414A6 6 0 016 9a6 6 0 016-6z"></path></svg>
        </div>

        <h1 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight mb-4">
            Acompanhe seu <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Projeto</span>
        </h1>
        
        <p class="text-lg text-slate-500 mb-10 max-w-md mx-auto leading-relaxed">
            Digite o token de acesso exclusivo que você recebeu para visualizar o progresso em tempo real.
        </p>

        <!-- Token Input -->
        <form action="/client/auth" method="POST" class="relative max-w-sm mx-auto group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11.536 17 10 18.536l-1.414-1.414L6 20l-2-2 4.414-4.414A6 6 0 016 9a6 6 0 016-6z"></path></svg>
            </div>
            <input type="text" name="token" required placeholder="Cole seu Token (Ex: op_837...)" 
                class="block w-full pl-11 pr-32 py-4 border-2 border-slate-100 rounded-2xl text-lg font-bold text-slate-900 placeholder-slate-300 focus:outline-none focus:border-indigo-600 focus:ring-0 transition-colors shadow-sm text-center tracking-widest bg-slate-50 focus:bg-white">
            
            <button type="submit" class="absolute right-2 top-2 bottom-2 bg-slate-900 hover:bg-black text-white px-6 rounded-xl font-bold text-sm shadow-md transition-transform active:scale-95">
                Entrar
            </button>
        </form>

        <p class="mt-8 text-xs text-slate-400">
            Ambiente Seguro Operon Enclave™
        </p>

    </div>

</body>
</html>
