<!DOCTYPE html>
<html lang="pt-BR" class="antialiased bg-[#FBFBFC]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operon Cortex - Inteligência em Projetos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Always enforce light mode for Client Interface
        document.documentElement.classList.remove('dark');
        localStorage.removeItem('client_theme'); 

        tailwind.config = {
            darkMode: 'class', // Kept for config consistency, but class will never be added
            theme: {
                extend: {
                    colors: {
                        // Operon V2 Core Palette
                        operon: {
                            deep: '#0A2F2F',    // Petrol Profundo
                            mist: '#D4DFD1',    // Oliva Suave
                            mistDark: '#B9C7B4',
                            paper: '#FBFBFC',   // Fundo Premium
                            ink: '#1A1C1E',     // Texto
                            slate: '#EBEFF2'    // Bordas
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
            --operon-ink: #1A1C1E;
        }
        
        /* Dark Mode Basis */
        /* Dark Mode Basis */
        /* Dark Mode CSS removed/disabled for client */
        
        body { background-color: #FBFBFC; color: #1A1C1E; transition: background-color 0.3s ease, color 0.3s ease; }
        .ios-card { @apply bg-white rounded-[20px] border border-slate-100 shadow-apple transition-all duration-300; }
        .animate-fade-in { animation: fadeIn 0.6s cubic-bezier(0.22, 1, 0.36, 1); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Custom Scrollbar Premium */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #CBD5E1; }
    </style>
    <link href="/assets/css/style.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-sans text-operon-ink bg-operon-paper transition-colors duration-300 relative">
    <!-- Neural Background Canvas -->
    <canvas id="neural-bg" class="fixed inset-0 pointer-events-none z-0"></canvas>

    <!-- Simple Header -->
    <header class="bg-white/80 backdrop-blur-xl border-b border-slate-100 sticky top-0 z-50 shadow-sm transition-colors duration-300">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-operon-deep flex items-center justify-center text-operon-mist shadow-premium border border-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-black text-operon-deep uppercase tracking-widest leading-none">Operon Cortex</span>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1"><?= \App\Core\I18n::t('nav.sync_interface') ?></span>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <!-- Theme Toggle -->
                <!-- Theme Toggle Removed -->

                <a href="/client/support" class="text-[9px] font-black text-slate-400 hover:text-operon-deep uppercase tracking-[0.2em] transition-all flex items-center gap-2 bg-slate-50 hover:bg-operon-mist/30 px-4 py-2.5 rounded-xl border border-slate-100 hover:border-operon-mist">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke_width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <?= \App\Core\I18n::t('nav.neural_support') ?>
            </a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in">
        <?php require $viewPath; ?>
    </main>

    <script>
        class NeuralNetwork {
            constructor(canvasId) {
                this.canvas = document.getElementById(canvasId);
                this.ctx = this.canvas.getContext('2d');
                this.points = [];
                this.maxPoints = 80;
                this.distance = 200;
                this.resize();
                this.init();
                window.addEventListener('resize', () => this.resize());
            }

            resize() {
                this.canvas.width = window.innerWidth;
                this.canvas.height = window.innerHeight;
            }

            init() {
                for (let i = 0; i < this.maxPoints; i++) {
                    this.points.push({
                        x: Math.random() * this.canvas.width,
                        y: Math.random() * this.canvas.height,
                        vx: (Math.random() - 0.5) * 0.4,
                        vy: (Math.random() - 0.5) * 0.4,
                        r: Math.random() * 1.5 + 1
                    });
                }
            }

            draw() {
                this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                this.ctx.fillStyle = 'rgba(10, 47, 47, 0.15)';
                this.ctx.strokeStyle = 'rgba(10, 47, 47, 0.1)';

                for (let i = 0; i < this.points.length; i++) {
                    let p1 = this.points[i];
                    p1.x += p1.vx;
                    p1.y += p1.vy;

                    if (p1.x < 0 || p1.x > this.canvas.width) p1.vx *= -1;
                    if (p1.y < 0 || p1.y > this.canvas.height) p1.vy *= -1;

                    this.ctx.beginPath();
                    this.ctx.arc(p1.x, p1.y, p1.r, 0, Math.PI * 2);
                    this.ctx.fill();

                    for (let j = i + 1; j < this.points.length; j++) {
                        let p2 = this.points[j];
                        let dist = Math.hypot(p1.x - p2.x, p1.y - p2.y);

                        if (dist < this.distance) {
                            this.ctx.lineWidth = (1 - dist / this.distance) * 0.8;
                            this.ctx.beginPath();
                            this.ctx.moveTo(p1.x, p1.y);
                            this.ctx.lineTo(p2.x, p2.y);
                            this.ctx.stroke();
                        }
                    }
                }
                requestAnimationFrame(() => this.draw());
            }
        }

        // Run when DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            const nn = new NeuralNetwork('neural-bg');
            nn.draw();
        });
    </script>
</body>
</html>
