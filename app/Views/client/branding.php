<div class="max-w-7xl mx-auto px-4 md:px-8 py-10">
    <!-- Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4 animate-fade-in-up">
        <div>
            <a href="/dashboard" class="text-sm font-bold text-slate-400 dark:text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors mb-2 inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                <?= \App\Core\I18n::t('nav.back_to_dashboard') ?>
            </a>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight"><?= \App\Core\I18n::t('branding.title') ?></h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium mt-1"><?= \App\Core\I18n::t('branding.subtitle') ?></p>
        </div>
        <div class="flex items-center gap-3">
             <div class="h-10 w-10 rounded-xl bg-indigo-50 dark:bg-indigo-400/10 border border-indigo-100 dark:border-indigo-400/20 flex items-center justify-center text-xl shadow-sm">
                🎨
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Brand Assets Column -->
        <div class="col-span-1 lg:col-span-2 space-y-8">
            
            <!-- Logo Assets -->
            <div class="ios-card p-6 animate-fade-in dark:bg-[#0D1517] dark:border-white/5" style="animation-delay: 100ms">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <span class="w-2 h-6 bg-indigo-500 rounded-full"></span> <?= \App\Core\I18n::t('branding.logotypes') ?>
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                     <!-- Asset Mock 1 -->
                     <div class="border border-slate-200 dark:border-white/10 rounded-xl p-4 flex flex-col items-center gap-3 hover:border-indigo-400 hover:shadow-md transition-all group bg-slate-50/50 dark:bg-white/5">
                         <div class="w-full h-32 flex items-center justify-center bg-white dark:bg-[#050B0C] rounded-lg border border-slate-100 dark:border-white/5 text-slate-300 dark:text-slate-600 font-black text-2xl uppercase tracking-widest relative overflow-hidden">
                             LOGO
                             <div class="absolute inset-0 bg-[url('https://placehold.co/400x200/png?text=LOGO')] bg-center bg-contain bg-no-repeat opacity-50"></div>
                         </div>
                         <div class="w-full flex items-center justify-between">
                             <div class="text-left">
                                 <p class="font-bold text-slate-700 dark:text-slate-200 text-sm">Versão Principal</p>
                                 <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase">PNG • SVG</p>
                             </div>
                             <button class="p-2 rounded-lg bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 hover:bg-indigo-50 dark:hover:bg-indigo-400/10 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors shadow-sm">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                             </button>
                         </div>
                     </div>
                     
                     <!-- Asset Mock 2 -->
                     <div class="border border-slate-200 dark:border-white/10 rounded-xl p-4 flex flex-col items-center gap-3 hover:border-indigo-400 hover:shadow-md transition-all group bg-slate-50/50 dark:bg-white/5">
                         <div class="w-full h-32 flex items-center justify-center bg-slate-900 rounded-lg border border-slate-800 text-white font-black text-2xl uppercase tracking-widest relative overflow-hidden">
                             LOGO
                             <div class="absolute inset-0 bg-[url('https://placehold.co/400x200/png?text=LOGO&color=white')] bg-center bg-contain bg-no-repeat opacity-50"></div>
                         </div>
                         <div class="w-full flex items-center justify-between">
                             <div class="text-left">
                                 <p class="font-bold text-slate-700 dark:text-slate-200 text-sm">Versão Negativa</p>
                                 <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase">PNG • SVG</p>
                             </div>
                             <button class="p-2 rounded-lg bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 hover:bg-indigo-50 dark:hover:bg-indigo-400/10 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors shadow-sm">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                             </button>
                         </div>
                     </div>
                </div>
            </div>

            <!-- Typography & Colors -->
            <div class="ios-card p-6 animate-fade-in dark:bg-[#0D1517] dark:border-white/5" style="animation-delay: 200ms">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <span class="w-2 h-6 bg-pink-500 rounded-full"></span> <?= \App\Core\I18n::t('branding.colors_typography', [], 'Cores e Tipografia') ?>
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Colors -->
                    <div>
                        <h4 class="text-xs font-bold uppercase text-slate-400 dark:text-slate-500 mb-3 tracking-wider">Paleta de Cores</h4>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-lg bg-indigo-600 shadow-sm border border-slate-100 dark:border-white/10"></div>
                                <div>
                                    <p class="font-bold text-slate-700 dark:text-slate-200 text-sm">Primary Blue</p>
                                    <p class="text-xs font-mono text-slate-400 dark:text-slate-500 text-select">#4F46E5</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-lg bg-slate-900 shadow-sm border border-slate-100 dark:border-white/10"></div>
                                <div>
                                    <p class="font-bold text-slate-700 dark:text-slate-200 text-sm">Dark Slate</p>
                                    <p class="text-xs font-mono text-slate-400 dark:text-slate-500 text-select">#0F172A</p>
                                </div>
                            </div>
                             <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-lg bg-emerald-500 shadow-sm border border-slate-100 dark:border-white/10"></div>
                                <div>
                                    <p class="font-bold text-slate-700 dark:text-slate-200 text-sm">Success Green</p>
                                    <p class="text-xs font-mono text-slate-400 dark:text-slate-500 text-select">#10B981</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Typography -->
                    <div>
                        <h4 class="text-xs font-bold uppercase text-slate-400 dark:text-slate-500 mb-3 tracking-wider">Tipografia Principal</h4>
                        <div class="space-y-4">
                            <div>
                                <p class="text-4xl font-bold text-slate-900 dark:text-white leading-none mb-1">Inter</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Google Fonts • Sans-Serif</p>
                            </div>
                            <div class="p-4 bg-slate-50 dark:bg-white/5 rounded-lg border border-slate-100 dark:border-white/10 text-slate-700 dark:text-slate-200 italic text-sm">
                                "O design é a inteligência tornada visível."
                            </div>
                             <a href="https://fonts.google.com/specimen/Inter" target="_blank" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline">Ver no Google Fonts -></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Sidebar Info -->
        <div class="col-span-1 space-y-6">
             <div class="ios-card p-6 border-l-4 border-indigo-500 animate-fade-in dark:bg-[#0D1517] dark:border-white/5" style="animation-delay: 300ms">
                 <h3 class="font-bold text-slate-900 dark:text-white mb-1">Manual da Marca</h3>
                 <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Diretrizes completas de uso da marca em PDF.</p>
                 <button class="w-full py-3 bg-slate-900 dark:bg-white text-white dark:text-[#050B0C] rounded-xl font-bold text-sm shadow-lg shadow-slate-200 dark:shadow-none transition-all transform hover:-translate-y-0.5">
                     Baixar PDF (4.2 MB)
                 </button>
             </div>
             
             <div class="p-6 rounded-2xl bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-center animate-fade-in" style="animation-delay: 400ms">
                 <div class="text-4xl mb-2">💡</div>
                 <h3 class="font-bold text-slate-700 dark:text-slate-200 mb-1">Precisa de algo mais?</h3>
                 <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-4">Se não encontrou o arquivo que precisa, solicite diretamente à equipe de design.</p>
                 <a href="#" class="text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:underline">Solicitar Arquivo</a>
             </div>
        </div>
    </div>
</div>
