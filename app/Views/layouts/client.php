<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status do Projeto | Operon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        slate: { 50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1', 400: '#94a3b8', 500: '#64748b', 600: '#475569', 800: '#1e293b', 900: '#0f172a' },
                        primary: { 500: '#3b82f6', 600: '#2563eb' } // Blue for trust/calm
                    },
                    animation: { 'fade-in': 'fadeIn 0.6s ease-out forwards' },
                    keyframes: {
                        fadeIn: { from: { opacity: 0, transform: 'translateY(10px)' }, to: { opacity: 1, transform: 'translateY(0)' } }
                    }
                }
            }
        }
    </script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');</style>
</head>
<body class="bg-[#F2F2F7] text-slate-800 font-sans antialiased min-h-screen flex flex-col relative overflow-x-hidden selection:bg-indigo-500 selection:text-white">

    <!-- Ambient Background Mesh -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-400/20 rounded-full blur-[120px] animate-pulse" style="animation-duration: 4s;"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-indigo-400/20 rounded-full blur-[120px] animate-pulse" style="animation-duration: 6s; animation-delay: 1s;"></div>
        <div class="absolute top-[20%] right-[20%] w-[30%] h-[30%] bg-purple-400/20 rounded-full blur-[100px] animate-pulse" style="animation-duration: 5s; animation-delay: 2s;"></div>
    </div>

    <div class="relative z-10 flex-1 flex flex-col">
        <?= $content ?? '' ?>
    </div>

</body>
</html>
