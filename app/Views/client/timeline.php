
<div x-data="{ 
    density: 'standard', // compact, standard, micro
    viewMode: 'chronological', // phases, chronological
    showSidebar: false,
    showSuccessModal: <?= isset($_GET['ticket_created']) ? 'true' : 'false' ?>,
    showRatedSuccess: <?= isset($_GET['rated']) ? 'true' : 'false' ?>
}" 
x-init="if(showSuccessModal || showRatedSuccess) { window.history.replaceState({}, document.title, window.location.pathname); }"
class="pb-24">

    <!-- Success Modal -->
    <div x-show="showSuccessModal" 
         class="fixed inset-0 z-[100] flex items-center justify-center px-4"
         style="display: none;">
         
         <!-- Backdrop -->
         <div x-show="showSuccessModal"
              x-transition.opacity
              class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
              @click="showSuccessModal = false"></div>

         <!-- Modal Card -->
         <div x-show="showSuccessModal"
              x-transition:enter="ease-out duration-300"
              x-transition:enter-start="opacity-0 scale-95 translate-y-4"
              x-transition:enter-end="opacity-100 scale-100 translate-y-0"
              x-transition:leave="ease-in duration-200"
              x-transition:leave-start="opacity-100 scale-100 translate-y-0"
              x-transition:leave-end="opacity-0 scale-95 translate-y-4"
              class="relative bg-white dark:bg-[#0D1517] dark:border dark:border-white/10 rounded-3xl p-8 max-w-md w-full shadow-2xl text-center overflow-hidden">
              
              <div class="w-16 h-16 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
              </div>

              <h3 class="text-2xl font-bold text-slate-800 mb-2"><?= \App\Core\I18n::t('support.success_title') ?></h3>
              
              <div class="space-y-4 text-slate-600 text-sm leading-relaxed">
                  <p><?= \App\Core\I18n::t('support.success_message') ?></p>
                  <p class="font-medium bg-slate-50 p-4 rounded-xl border border-slate-100">
                      <?= \App\Core\I18n::t('support.response_time') ?>
                  </p>
              </div>

              <button @click="showSuccessModal = false" class="mt-8 w-full bg-slate-900 text-white font-bold py-3.5 rounded-xl hover:bg-black transition-all">
                  <?= \App\Core\I18n::t('action.understood') ?>
              </button>
         </div>
    </div>

    <!-- Project Cover Image -->
    <?php if (!empty($project['cover_url'])): ?>
        <div class="h-36 sm:h-48 md:h-64 w-full bg-cover bg-center relative -mb-12 sm:-mb-16 md:-mb-20" style="background-image: url('<?= $project['cover_url'] ?>')">
            <div class="absolute inset-0 bg-gradient-to-t from-[#F4F7F2] to-transparent"></div>
        </div>
    <?php endif; ?>

    <!-- Top Navigation / Hero -->
    <header class="pt-6 sm:pt-8 pb-6 sm:pb-8 px-4 sm:px-6 md:px-8 max-w-7xl mx-auto relative z-10">
        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6 sm:gap-8">
            
            <!-- Project Identity -->
            <div class="flex-1 space-y-4 sm:space-y-0">


                <div class="flex items-center gap-4 mb-2">
                    <div class="w-14 h-14 bg-operon-deep text-operon-mist rounded-2xl flex items-center justify-center font-black text-xl shadow-premium border border-white/10">
                        <?= strtoupper(substr($project['name'], 0, 2)) ?>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white leading-none"><?= htmlspecialchars($project['name']) ?></h1>
                        <p class="text-slate-500 dark:text-slate-400 font-medium mt-1"><?= \App\Core\I18n::t('general.contract') ?> #2024-<?= $project['id'] ?></p>
                        <div class="flex flex-wrap gap-4 mt-3">
                            <?php if(!empty($project['provisional_url'])): ?>
                                <a href="<?= $project['provisional_url'] ?>" target="_blank" class="inline-flex items-center gap-1.5 text-[11px] font-bold text-slate-400 hover:text-indigo-600 transition-colors uppercase tracking-wider bg-slate-100 hover:bg-indigo-50 px-2 py-1 rounded-md border border-slate-200 hover:border-indigo-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span> Provisório
                                </a>
                            <?php endif; ?>
                            <?php if(!empty($project['definitive_url'])): ?>
                                <a href="<?= $project['definitive_url'] ?>" target="_blank" class="inline-flex items-center gap-1.5 text-[11px] font-bold text-indigo-600 hover:text-indigo-700 transition-colors uppercase tracking-wider bg-indigo-50 px-2 py-1 rounded-md border border-indigo-100 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span> Sistema Ativo
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- NOTIFICATIONS SECTION -->
                <?php if(!empty($answeredTickets)): ?>
                    <div class="mt-8 mb-4 space-y-3">
                        <?php foreach($answeredTickets as $at): ?>
                            <a href="/client/support?open_ticket_id=<?= $at['id'] ?>" class="block group">
                                <div class="bg-operon-mist/20 border border-operon-mist/50 rounded-2xl p-5 flex items-center justify-between hover:shadow-premium hover:border-operon-mistDark/30 transition-all duration-300 transform hover:-translate-y-0.5">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-operon-mist/40 text-operon-deep w-12 h-12 rounded-xl flex items-center justify-center shrink-0 border border-operon-mist/50 animate-pulse">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-black text-operon-deep uppercase tracking-[0.2em] mb-1">Nova Resposta do Suporte</p>
                                            <p class="text-sm text-slate-700 font-bold tracking-tight">#<?= $at['id'] ?> - <?= htmlspecialchars($at['subject']) ?></p>
                                        </div>
                                    </div>
                                    <div class="text-operon-mistDark group-hover:text-operon-deep group-hover:translate-x-1 transition-all">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- KPI Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mt-8 sm:mt-10">
                    
                    <!-- Progress KPI -->
                    <div class="ios-card p-5 sm:p-6 flex flex-col justify-between min-h-[140px] sm:h-32 relative group overflow-hidden border border-white/40 bg-gradient-to-br from-white to-slate-50">
                         <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                            <svg class="w-12 h-12 text-operon-deep dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <div class="flex items-center gap-2 mb-2">
                             <div class="p-1.5 rounded-lg bg-operon-mist/30 dark:bg-white/10 text-operon-deep dark:text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-extrabold uppercase tracking-widest"><?= \App\Core\I18n::t('kpi.progress') ?></span>
                        </div>
                        <div class="relative z-10">
                            <span class="text-4xl font-black text-slate-800 dark:text-white tracking-tighter block mb-1"><?= $kpis['progress'] ?>%</span>
                            <div class="w-full h-1.5 bg-slate-100 dark:bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-operon-deep to-operon-mistDark rounded-full transition-all duration-1000 ease-out" style="width: <?= $kpis['progress'] ?>%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Days KPI -->
                    <div class="ios-card p-5 sm:p-6 flex flex-col justify-between min-h-[140px] sm:h-32 relative group overflow-hidden border border-white/40 bg-gradient-to-br from-white to-slate-50">
                        <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                             <svg class="w-12 h-12 text-operon-mistDark dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="flex items-center gap-2 mb-2">
                             <div class="p-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-extrabold uppercase tracking-widest"><?= \App\Core\I18n::t('kpi.days_remaining') ?></span>
                        </div>
                        <div class="relative z-10 flex items-baseline gap-1">
                            <span class="text-4xl font-black text-slate-800 dark:text-white tracking-tighter"><?= $kpis['days_remaining'] ?></span>
                            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider"><?= \App\Core\I18n::t('kpi.days') ?></span>
                        </div>
                    </div>

                    <!-- Tasks KPI -->
                    <div class="ios-card p-5 sm:p-6 flex flex-col justify-between min-h-[140px] sm:h-32 relative group overflow-hidden border border-white/40 bg-gradient-to-br from-white to-slate-50">
                         <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                           <svg class="w-12 h-12 text-slate-400 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <div class="flex items-center gap-2 mb-2">
                             <div class="p-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-extrabold uppercase tracking-widest"><?= \App\Core\I18n::t('kpi.tasks') ?></span>
                        </div>
                        <div class="relative z-10 flex items-baseline gap-1">
                            <span class="text-4xl font-black text-slate-800 dark:text-white tracking-tighter"><?= $kpis['done_tasks'] ?></span>
                            <span class="text-sm text-slate-400 font-medium">/ <?= $kpis['total_tasks'] ?></span>
                        </div>
                    </div>

                    <!-- Health KPI -->
                    <?php
                        $health = $kpis['health'] ?? 'on_track';
                        $healthConfig = match($health) {
                            'on_track' => ['text' => \App\Core\I18n::t('health.on_track'), 'color' => 'text-emerald-600 dark:text-emerald-400', 'bg' => 'bg-emerald-500', 'soft_bg' => 'bg-emerald-50 dark:bg-emerald-500/20'],
                            'at_risk' => ['text' => \App\Core\I18n::t('health.at_risk'), 'color' => 'text-amber-600 dark:text-amber-400', 'bg' => 'bg-amber-500', 'soft_bg' => 'bg-amber-50 dark:bg-amber-500/20'],
                            'off_track' => ['text' => \App\Core\I18n::t('health.off_track'), 'color' => 'text-red-600 dark:text-red-400', 'bg' => 'bg-red-500', 'soft_bg' => 'bg-red-50 dark:bg-red-500/20'],
                            default => ['text' => \App\Core\I18n::t('health.on_track'), 'color' => 'text-emerald-600 dark:text-emerald-400', 'bg' => 'bg-emerald-500', 'soft_bg' => 'bg-emerald-50 dark:bg-emerald-500/20']
                        };
                    ?>
                    <div class="ios-card p-5 sm:p-6 flex flex-col justify-between min-h-[140px] sm:h-32 relative group overflow-hidden border border-white/40 bg-gradient-to-br from-white to-slate-50">
                         <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                             <svg class="w-12 h-12 text-operon-deep dark:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div class="flex items-center gap-2 mb-2">
                             <div class="p-1.5 rounded-lg <?= $healthConfig['soft_bg'] ?> <?= $healthConfig['color'] ?>">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-extrabold uppercase tracking-widest"><?= \App\Core\I18n::t('kpi.health') ?></span>
                        </div>
                        <div class="relative z-10 flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full <?= $healthConfig['bg'] ?> animate-pulse shadow-[0_0_12px_rgba(var(--color-primary),0.5)]"></div>
                            <span class="text-2xl font-black <?= $healthConfig['color'] ?> tracking-tight"><?= $healthConfig['text'] ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Toggle (Mobile) & Actions -->
            <div class="flex gap-3">
                <div class="hidden md:block text-right">
                    <p class="text-sm text-slate-400 dark:text-slate-500 mb-1">Gerente do Projeto</p>
                    <div class="flex items-center gap-2 justify-end">
                        <div class="text-right">
                            <p class="text-sm font-bold text-slate-800 dark:text-white"><?= htmlspecialchars($project['manager_name'] ?? 'A definir') ?></p>
                            <?php if (!empty($project['manager_phone'])): ?>
                                <a href="https://wa.me/<?= preg_replace('/\D/', '', $project['manager_phone']) ?>" target="_blank" class="text-xs text-ios-blue hover:underline">Falar agora</a>
                            <?php endif; ?>
                        </div>
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($project['manager_name'] ?? 'U') ?>&background=000&color=fff" class="w-8 h-8 rounded-full">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Visual Progress Bar -->
    <div class="max-w-7xl mx-auto px-4 md:px-8 mb-20 mt-8">
        <div class="relative">
            <!-- Progress Line Background -->
            <div class="absolute top-1/2 left-0 w-full h-1 bg-slate-100 -z-10 rounded-full -translate-y-1/2"></div>
            
            <!-- Active Progress Line -->
            <?php 
                $totalPhases = count($phases);
                $activePhaseIndex = 0;
                foreach($phases as $index => $phase) {
                    if($phase['status'] === 'active') {
                        $activePhaseIndex = $index;
                        break;
                    }
                }
                // Handle all completed case or calculate progress
                if ($phases[$totalPhases-1]['status'] === 'completed') {
                    $activePhaseIndex = $totalPhases - 1;
                } elseif ($activePhaseIndex === 0 && $phases[0]['status'] === 'completed') {
                    // Find first non-completed
                    foreach($phases as $i => $p) {
                         if($p['status'] !== 'completed') {
                             $activePhaseIndex = $i;
                             break;
                         }
                    }
                }

                $progressWidth = ($activePhaseIndex / max(1, $totalPhases - 1)) * 100;
            ?>
            <div class="absolute top-1/2 left-0 h-1 bg-operon-deep -z-10 rounded-full transition-all duration-1000 ease-out -translate-y-1/2" style="width: <?= $progressWidth ?>%; box-shadow: 0 0 12px rgba(10, 47, 47, 0.2);"></div>

            <!-- Steps Container -->
            <div class="flex justify-between w-full">
                <?php foreach ($phases as $index => $phase): ?>
                    <?php 
                        $status = $phase['status'];
                        $isActive = $status === 'active';
                        
                        $circleClass = match($status) {
                            'completed' => 'bg-operon-deep border-operon-deep text-operon-mist',
                            'active' => 'bg-white border-operon-deep text-operon-deep ring-4 ring-operon-mist shadow-apple scale-110',
                            default => 'bg-white border-slate-200 text-slate-300'
                        };
                        
                        $textClass = match($status) {
                            'completed' => 'text-operon-deep font-bold opacity-60',
                            'active' => 'text-operon-deep font-black',
                            default => 'text-slate-300 font-medium'
                        };

                        // Icons
                         $icon = match($status) {
                            'completed' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>',
                            'active' => '<div class="w-2.5 h-2.5 rounded-full bg-operon-deep animate-pulse"></div>',
                            default => '<div class="w-2 h-2 rounded-full bg-slate-200"></div>'
                        };
                    ?>
                    
                    <!-- Step Item -->
                    <div class="flex flex-col items-center relative group cursor-default">
                        <!-- Circle -->
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-full border-2 flex items-center justify-center z-10 transition-all duration-500 <?= $circleClass ?>">
                            <?= $icon ?>
                        </div>
                        
                        <!-- Label -->
                        <div class="absolute top-10 md:top-12 w-32 text-center transition-all duration-500">
                            <span class="text-[10px] md:text-xs uppercase tracking-wider <?= $textClass ?> block leading-tight">
                                <?= $phase['name'] ?>
                            </span>
                            <?php if($isActive): ?>
                                <span class="text-[9px] text-blue-500 font-semibold animate-pulse hidden md:block mt-1">Em Andamento</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 lg:gap-10">
        
        <!-- Timeline Column -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- NEXT ACTION WIDGET -->
            <?php if (!empty($project['next_action'])): ?>
                <?php
                    $actionType = $project['next_action_type'] ?? 'info';
                    $deadline = $project['next_action_deadline'];
                    $isLate = $deadline && strtotime($deadline) < time();
                    
                    $styles = match($actionType) {
                        'approval' => ['bg' => 'bg-operon-mist/20', 'border' => 'border-operon-mist', 'text' => 'text-operon-deep', 'icon' => '✍️', 'btn' => 'bg-operon-deep text-white hover:bg-black'],
                        'upload' => ['bg' => 'bg-operon-mist/20', 'border' => 'border-operon-mist', 'text' => 'text-operon-deep', 'icon' => '📤', 'btn' => 'bg-operon-deep text-white hover:bg-black'],
                        'payment' => ['bg' => 'bg-operon-mist/20', 'border' => 'border-operon-mist', 'text' => 'text-operon-deep', 'icon' => '💸', 'btn' => 'bg-operon-deep text-white hover:bg-black'],
                        'poll' => ['bg' => 'bg-operon-mist/20', 'border' => 'border-operon-mist', 'text' => 'text-operon-deep', 'icon' => '📊', 'btn' => 'bg-operon-deep text-white hover:bg-black'],
                        'completed' => ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'text' => 'text-emerald-800', 'icon' => '✅', 'btn' => 'hidden'],
                        default => ['bg' => 'bg-slate-50', 'border' => 'border-slate-100', 'text' => 'text-operon-deep', 'icon' => '👀', 'btn' => 'bg-operon-deep text-white hover:bg-black']
                    };
                ?>
                <div class="mb-8 relative z-20">
                    <div class="ios-card <?= $styles['bg'] ?> border-2 <?= $styles['border'] ?> p-6 shadow-md relative overflow-hidden animate-fade-in-up">
                        
                        <!-- Pulse Effect for urgency -->
                        <?php if($actionType !== 'info'): ?>
                            <div class="absolute top-0 right-0 p-3">
                                <span class="relative flex h-3 w-3">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full <?= str_replace('text-', 'bg-', $styles['text']) ?> opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 <?= str_replace('text-', 'bg-', $styles['text']) ?>"></span>
                                </span>
                            </div>
                        <?php endif; ?>

                        <div class="flex flex-col md:flex-row gap-6 items-start md:items-center">
                            <div class="h-14 w-14 rounded-2xl bg-white/50 backdrop-blur-sm flex items-center justify-center text-3xl shadow-sm border border-white/50">
                                <?= $styles['icon'] ?>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xs font-bold uppercase tracking-wider <?= $styles['text'] ?> opacity-70 mb-1">Sua Próxima Ação</h3>
                                <p class="text-xl font-black <?= $styles['text'] ?> dark:text-white leading-tight mb-2">
                                    <?= htmlspecialchars($project['next_action']) ?>
                                </p>
                                
                                <?php if ($deadline): ?>
                                    <div class="flex items-center gap-2 text-sm font-medium <?= $isLate ? 'text-red-600' : $styles['text'] ?>">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <?php if ($isLate): ?>
                                            <span>Atrasado (Era para: <?= date('d/m/Y', strtotime($deadline)) ?>)</span>
                                        <?php else: ?>
                                            <span>Prazo: <?= date('d/m/Y', strtotime($deadline)) ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Action Button (Mock) -->
                            <!-- Action Button -->
                            <?php 
                                $btnUrl = $project['next_action_link'] ?? null;
                                $btnText = 'Acessar';
                                
                                if($actionType === 'approval') { $btnText = 'Aprovar Agora'; $btnUrl = "/client/projects/approve?project_id=".$project['id']; }
                                if($actionType === 'upload') { $btnText = 'Enviar Arquivos'; $btnUrl = $btnUrl ?: "/client/projects/documents?id=".$project['id']; }
                                if($actionType === 'payment') { $btnText = 'Realizar Pagamento'; $btnUrl = $btnUrl ?: "/client/projects/finance?id=".$project['id']; }
                            ?>

                            <?php 
                                // POLL RENDERING
                                if($actionType === 'poll'): 
                                    $pollData = json_decode($project['next_action_data'] ?? '{}', true);
                                    $options = $pollData['options'] ?? [];
                                    $votes = $pollData['votes'] ?? [];
                                    // Simple Logic: Since we don't have user specific tracking in 'votes', we can't show "You voted X".
                                    // Just show buttons. If client_id is in stored votes we could show results, but for now simple buttons.
                                ?>
                                    <div class="w-full md:w-auto flex flex-col gap-2">
                                        <?php foreach($options as $opt): ?>
                                            <form action="/client/projects/vote" method="POST">
                                                <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                                <input type="hidden" name="option" value="<?= htmlspecialchars($opt) ?>">
                                                <button type="submit" class="w-full text-left px-4 py-2 rounded-lg bg-white border border-indigo-100 hover:border-indigo-300 hover:bg-indigo-50 transition-all text-sm font-bold text-indigo-900 flex justify-between items-center group">
                                                    <span><?= htmlspecialchars($opt) ?></span>
                                                    <span class="opacity-0 group-hover:opacity-100 transition-opacity">👈</span>
                                                </button>
                                            </form>
                                        <?php endforeach; ?>
                                        <p class="text-[10px] text-center text-indigo-400 font-medium">Clique para votar</p>
                                    </div>

                            <?php elseif($actionType === 'completed'): ?>
                                <div class="px-6 py-3 rounded-xl font-bold text-green-700 bg-green-200/50 flex items-center gap-2">
                                    <span>Concluído! 🎉</span>
                                </div>

                            <?php elseif($btnUrl): ?>
                                <a href="<?= htmlspecialchars($btnUrl) ?>" target="_blank" class="px-6 py-3 rounded-xl font-bold text-white shadow-lg transform hover:-translate-y-0.5 transition-all <?= $styles['btn'] ?>">
                                    <?= $btnText ?>
                                </a>
                            <?php elseif($actionType !== 'info'): ?>
                                <button class="px-6 py-3 rounded-xl font-bold text-white shadow-lg transform hover:-translate-y-0.5 transition-all <?= $styles['btn'] ?>">
                                    <?= $btnText ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Controls -->
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-slate-800 dark:text-white"><?= \App\Core\I18n::t('nav.timeline') ?></h2>
                
                <!-- Density Switcher -->
                <div class="bg-slate-200 dark:bg-white/5 p-1 rounded-lg flex text-xs font-semibold">
                    <button @click="density = 'compact'" 
                            :class="density === 'compact' ? 'bg-white dark:bg-white/10 shadow-sm text-slate-900 dark:text-white' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200'"
                            class="px-3 py-1.5 rounded-md transition-all"><?= \App\Core\I18n::t('density.compact', [], 'Compacto') ?></button>
                    <button @click="density = 'standard'" 
                            :class="density === 'standard' ? 'bg-white dark:bg-white/10 shadow-sm text-slate-900 dark:text-white' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200'"
                            class="px-3 py-1.5 rounded-md transition-all"><?= \App\Core\I18n::t('density.standard', [], 'Padrão') ?></button>
                </div>
            </div>

            <!-- Events List -->
            <div class="space-y-6 relative border-l-2 border-operon-mist/50 ml-4 md:ml-6 pl-6 md:pl-8 pb-10">
                
                <?php foreach ($events as $event): ?>
                    <?php 
                        $isMacro = $event['type'] === 'MACRO';
                        $isCheckpoint = $event['type'] === 'CHECKPOINT';
                        $icon = match($event['type']) {
                            'MACRO' => '⭐',
                            'MEETING' => '📅',
                            'DEPLOY' => '🚀',
                            'CHECKPOINT' => '✅',
                            default => '✨'
                        };
                        $meta = json_decode($event['metadata'] ?? '{}', true);
                    ?>

                    <!-- Timeline Dot -->
                    <div class="absolute -left-[9px] w-4 h-4 rounded-full border-2 border-white <?= $isMacro ? 'bg-operon-deep text-operon-mist w-6 h-6 -left-[13px] flex items-center justify-center text-[10px] shadow-sm' : 'bg-slate-300' ?>">
                        <?= $isMacro ? '★' : '' ?>
                    </div>

                    <!-- POLYMORPHIC BLOCK RENDERER -->
                    <?php if ($event['type'] === 'WARNING'): ?>
                        <!-- ⚠️ WARNING BLOCK -->
                        <?php 
                            $style = $meta['style'] ?? 'info';
                            $colors = match($style) {
                                'danger' => ['bg' => 'bg-red-50', 'border' => 'border-red-100', 'text' => 'text-red-800', 'icon' => '🚨'],
                                'warning' => ['bg' => 'bg-amber-50', 'border' => 'border-amber-100', 'text' => 'text-amber-800', 'icon' => '⚠️'],
                                default => ['bg' => 'bg-blue-50', 'border' => 'border-blue-100', 'text' => 'text-blue-800', 'icon' => 'ℹ️']
                            };
                        ?>
                        <div class="ios-card p-4 <?= $colors['bg'] ?> border-2 <?= $colors['border'] ?> flex gap-4 animate-fade-in">
                            <div class="text-2xl"><?= $colors['icon'] ?></div>
                            <div>
                                <h3 class="font-bold <?= $colors['text'] ?> text-lg"><?= htmlspecialchars($event['title']) ?></h3>
                                <p class="text-sm <?= $colors['text'] ?> opacity-90 mt-1"><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                            </div>
                        </div>

                    <?php elseif ($event['type'] === 'DOCUMENT'): ?>
                        <!-- 📄 DOCUMENT BLOCK -->
                         <div class="ios-card p-4 flex items-center gap-4 hover:shadow-lg transition-shadow border-l-4 border-operon-deep animate-fade-in group cursor-pointer">
                             <div class="w-12 h-12 bg-operon-mist dark:bg-operon-deep/50 rounded-lg flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">📄</div>
                            <div class="flex-1">
                                <h3 class="font-bold text-slate-800 dark:text-white"><?= htmlspecialchars($event['title']) ?></h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400"><?= htmlspecialchars($event['description']) ?></p>
                            </div>
                            <?php if (!empty($meta['images'][0])): ?>
                                <a href="<?= $meta['images'][0] ?>" download class="px-4 py-2 bg-slate-100 dark:bg-white/10 hover:bg-indigo-600 hover:text-white text-slate-600 dark:text-slate-300 rounded-lg text-xs font-bold transition-colors">
                                    <?= $meta['btn_label'] ?? \App\Core\I18n::t('action.download') ?> ↓
                                </a>
                            <?php else: ?>
                                <button class="px-4 py-2 bg-slate-100 text-slate-400 rounded-lg text-xs font-bold cursor-not-allowed"><?= \App\Core\I18n::t('general.no_file', [], 'Sem Arquivo') ?></button>
                            <?php endif; ?>
                        </div>

                    <?php elseif ($event['type'] === 'ARTICLE'): ?>
                        <!-- 📰 ARTICLE BLOCK -->
                        <div class="ios-card overflow-hidden animate-fade-in">
                            <?php if (!empty($meta['images'][0])): ?>
                                <div class="h-48 bg-cover bg-center" style="background-image: url('<?= $meta['images'][0] ?>')"></div>
                            <?php endif; ?>
                            <div class="p-6">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-[10px] bg-operon-mist text-operon-deep font-black px-2 py-0.5 rounded-full uppercase tracking-wider"><?= \App\Core\I18n::t('event.article') ?></span>
                                    <span class="text-[10px] text-slate-400"><?= date('d M Y', strtotime($event['created_at'])) ?></span>
                                </div>
                                 <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 leading-tight"><?= htmlspecialchars($event['title']) ?></h3>
                                <div class="prose prose-sm text-slate-600 dark:text-slate-300">
                                    <?= nl2br(htmlspecialchars($event['description'])) ?>
                                </div>
                            </div>
                        </div>

                    <?php elseif ($event['type'] === 'CHECKPOINT'): ?>
                        <!-- ✅ CHECKPOINT BLOCK -->
                        <?php $deadline = $meta['deadline'] ?? null; ?>
                        <?php 
                            $statusColor = 'border-operon-deep';
                            $bgColor = '';
                            $iconBg = 'bg-operon-mist dark:bg-operon-deep/50';
                            $icon = '📋';
                            $badgeClass = 'bg-amber-50 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400';
                            $statusText = \App\Core\I18n::t('event.status.pending');

                            if ($event['status'] === 'done') {
                                $statusColor = 'border-emerald-500';
                                $bgColor = 'bg-emerald-50/50 dark:bg-emerald-500/10';
                                $iconBg = 'bg-emerald-100 dark:bg-emerald-500/20';
                                $icon = '✅';
                                $badgeClass = 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400';
                                $statusText = \App\Core\I18n::t('event.status.done');
                            } elseif ($event['status'] === 'in_progress') {
                                $statusColor = 'border-indigo-500';
                                $bgColor = 'bg-indigo-50/50 dark:bg-indigo-500/10';
                                $iconBg = 'bg-indigo-100 dark:bg-indigo-500/20';
                                $icon = '🚧';
                                $badgeClass = 'bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400';
                                $statusText = \App\Core\I18n::t('event.status.in_progress');
                            }
                        ?>
                        <div class="ios-card p-4 flex items-center gap-4 hover:shadow-lg transition-shadow border-l-4 <?= $statusColor ?> <?= $bgColor ?> animate-fade-in group">
                            <div class="w-12 h-12 <?= $iconBg ?> rounded-lg flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                                <?= $icon ?>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold <?= $event['status'] === 'done' ? 'text-emerald-700 dark:text-emerald-400 line-through' : 'text-slate-800 dark:text-white' ?>"><?= htmlspecialchars($event['title']) ?></h3>
                                
                                <?php if (!empty($event['description']) && $event['description'] !== 'Checkpoint de entrega'): ?>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                        <?= htmlspecialchars($event['description']) ?>
                                    </p>
                                <?php endif; ?>

                                <div class="flex items-center gap-2 mt-2">
                                    <?php if ($deadline): ?>
                                        <span class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1 font-medium">
                                            <svg class="w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <?= date('d/m/Y', strtotime($deadline)) ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider <?= $badgeClass ?>">
                                        <?= $statusText ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- STANDARD TIMELINE CARD (Micro/Macro) -->
                        <div class="ios-card p-0 overflow-hidden group transition-all duration-300 hover:-translate-y-1 hover:shadow-md animate-fade-in">
                        
                        <!-- Header (Visible in all densities) -->
                        <div class="p-5 flex items-start gap-4 cursor-pointer" @click="density = (density === 'micro' ? 'standard' : 'micro')">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                        <?= date('d M • H:i', strtotime($event['created_at'])) ?>
                                    </span>
                                    <?php if ($isMacro): ?>
                                        <span class="px-2 py-0.5 rounded-full bg-operon-mist text-operon-deep text-[10px] font-black uppercase tracking-wider"><?= \App\Core\I18n::t('event.macro_label') ?></span>
                                    <?php endif; ?>
                                </div>
                                 <h3 class="text-lg font-black text-operon-deep dark:text-white leading-tight">
                                    <?= htmlspecialchars($event['title']) ?>
                                </h3>
                                
                                <!-- Standard+ Density Description -->
                                <div x-show="density !== 'compact'" class="mt-2 text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                                    <?= nl2br(htmlspecialchars($event['description'])) ?>
                                </div>
                            </div>
                        </div>

                        <!-- Expanded Content (Micro Density / Click) -->
                        <div x-show="density === 'micro'" class="px-5 pb-5 border-t border-slate-50 dark:border-white/5 pt-4 bg-slate-50/50 dark:bg-white/5">
                            
                            <!-- Tags -->
                            <?php if (!empty($meta['tags'])): ?>
                                <div class="flex gap-2 mb-4">
                                    <?php foreach ($meta['tags'] as $tag): ?>
                                        <span class="px-2 py-1 bg-white border border-slate-200 rounded text-xs font-semibold text-slate-600">
                                            #<?= htmlspecialchars($tag) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Images Gallery Mock -->
                            <?php if (!empty($meta['images'])): ?>
                                <div class="grid grid-cols-4 gap-2 mb-4">
                                    <?php foreach ($meta['images'] as $img): ?>
                                        <div class="aspect-square rounded-lg bg-cover bg-center shadow-sm border border-white" style="background-image: url('<?= $img ?>')"></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Technical Details Box -->
                            <div class="bg-white dark:bg-white/5 rounded-lg p-3 border border-slate-200 dark:border-white/10 text-xs text-slate-500 dark:text-slate-400">
                                <strong class="block text-slate-700 dark:text-white mb-1">Detalhes Técnicos:</strong>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Status: Completado em <?= date('d/m/Y') ?></li>
                                    <li>Responsável: Equipe Operon</li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <!-- Future/Empty State -->
                <div class="relative pl-8 pt-4 opacity-50 hover:opacity-100 transition-opacity">
                    <div class="absolute -left-[5px] w-3 h-3 rounded-full bg-slate-200 border-2 border-white"></div>
                    <p class="text-sm font-medium text-slate-500 italic"><?= \App\Core\I18n::t('timeline.next_update', [], 'Próxima atualização prevista para breve...') ?></p>
                </div>

            </div>
        </div>

        <!-- Right Widgets Column (Desktop & Mobile) -->
        <div class="col-span-1 lg:col-span-4 space-y-6">
            
            <!-- Executive Summary (Finance) - Discrete Version -->
            <div class="ios-card bg-white p-6 shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="space-y-6">
                    <!-- Head -->
                     <div class="flex items-center justify-between">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 flex items-center gap-2">
                             <div class="w-2 h-2 rounded-full bg-operon-mist"></div>
                             <?= \App\Core\I18n::t('finance.title', [], 'Financeiro') ?>
                        </h3>
                        <span class="text-[10px] font-bold text-operon-deep bg-operon-mist px-2 py-1 rounded-md uppercase tracking-wider"><?= $project['payment_method'] ?></span>
                    </div>

                    <!-- Money -->
                    <div>
                        <p class="text-xs text-slate-400 dark:text-slate-500 font-medium mb-1"><?= \App\Core\I18n::t('finance.total_investment', [], 'Investimento Total') ?></p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-xs text-slate-400 dark:text-slate-500 font-medium">R$</span>
                            <span class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white"><?= number_format((float)($project['project_value'] ?? 0), 2, ',', '.') ?></span>
                        </div>
                    </div>

                    <!-- Progress -->
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <p class="text-xs font-medium text-slate-600 dark:text-slate-300">
                                <?= $project['installments_paid'] ?? 0 ?><span class="text-slate-400 dark:text-slate-500">/<?= $project['installments'] ?> <?= \App\Core\I18n::t('finance.paid', [], 'Pago') ?></span>
                            </p>
                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">
                                <?= round((($project['installments_paid'] ?? 0) / max(1, $project['installments'])) * 100) ?>%
                            </span>
                        </div>
                        <!-- Bar -->
                        <div class="w-full h-1.5 bg-slate-50 rounded-full overflow-hidden">
                            <div class="h-full bg-operon-deep rounded-full" style="width: <?= round((($project['installments_paid'] ?? 0) / max(1, $project['installments'])) * 100) ?>%"></div>
                        </div>
                    </div>

                    <!-- Footer Details -->
                    <div class="pt-4 border-t border-slate-50 dark:border-white/5 flex justify-between items-center text-xs">
                         <div class="text-slate-400 dark:text-slate-500">
                             <span class="font-bold text-slate-700 dark:text-white block"><?= $project['phases_count'] ?></span>
                             Fases
                         </div>
                         <div class="text-right text-slate-400 dark:text-slate-500">
                             <span class="font-bold text-slate-700 dark:text-white block">R$ <?= number_format((float)($project['project_value'] ?? 0) * (1 - ((int)($project['installments_paid'] ?? 0) / max(1, (int)($project['installments'] ?? 1)))), 2, ',', '.') ?></span>
                             Restante
                         </div>
                    </div>
                </div>
            </div>

            <!-- Project Satisfaction Rating -->
            <div class="ios-card p-8 bg-white text-operon-deep relative overflow-hidden group shadow-premium border border-slate-100" x-data="{ rating: 0, hoverRating: 0, submitted: <?= isset($_GET['rated']) ? 'true' : 'false' ?> }">
                <!-- Background Pattern (Subtle) -->
                <div class="absolute -right-6 -bottom-6 opacity-[0.03] group-hover:opacity-[0.07] group-hover:rotate-12 transition-all duration-700 text-operon-deep">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                </div>

                <div x-show="!submitted">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-1.5 rounded-full bg-operon-mistDark animate-pulse"></div>
                        <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Feedback Neural</h3>
                    </div>
                    
                    <h4 class="text-xl font-black text-operon-deep dark:text-white mb-6 leading-tight tracking-tight"><?= \App\Core\I18n::t('rating.title') ?></h4>
                    
                    <form action="/client/projects/rate" method="POST" class="space-y-6">
                        <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                        <input type="hidden" name="rating" :value="rating">
                        
                        <!-- Stars Interface -->
                        <div class="flex items-center justify-between gap-1 p-1 bg-slate-50/50 rounded-[20px] border border-slate-100/50">
                            <template x-for="i in 5" :key="i">
                                <button type="button" 
                                    @mouseenter="hoverRating = i" 
                                    @mouseleave="hoverRating = 0" 
                                    @click="rating = i"
                                    class="relative flex-1 aspect-square flex items-center justify-center transition-all duration-300 focus:outline-none rounded-2xl group/star"
                                    :class="i <= (hoverRating || rating) ? 'bg-amber-400/10' : 'bg-white hover:bg-slate-100 shadow-sm'">
                                    
                                    <!-- Star Glow Background (Active only) -->
                                    <div x-show="i <= (hoverRating || rating)" x-transition.opacity class="absolute inset-0 bg-amber-400/5 rounded-2xl blur-md"></div>
                                    
                                    <svg class="w-8 h-8 fill-current transition-all duration-300" 
                                        :class="i <= (hoverRating || rating) ? 'text-amber-400 scale-110 drop-shadow-[0_0_8px_rgba(251,191,36,0.2)]' : 'text-slate-200'" 
                                        viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                </button>
                            </template>
                        </div>

                        <!-- Feedback and Submit -->
                        <div x-show="rating > 0" x-transition:enter="duration-300 ease-out" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-4">
                            <div class="relative">
                                <textarea name="feedback" placeholder="<?= \App\Core\I18n::t('rating.placeholder') ?>" class="w-full bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/10 rounded-[20px] px-5 py-4 text-xs placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-operon-mist/30 focus:border-operon-mistDark focus:bg-white dark:focus:bg-white/10 resize-none h-28 text-operon-deep dark:text-white font-medium transition-all shadow-inner"></textarea>
                                <div class="absolute right-4 bottom-4 text-[9px] font-black uppercase tracking-widest text-slate-300 dark:text-slate-500"><?= \App\Core\I18n::t('rating.optional') ?></div>
                            </div>
                            <button type="submit" class="w-full bg-operon-deep hover:bg-black text-white font-black py-4.5 rounded-[18px] text-[10px] transition-all shadow-premium active:scale-95 uppercase tracking-[0.2em] border border-white/5">
                                <?= \App\Core\I18n::t('rating.submit') ?>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Success State -->
                <div x-show="submitted" x-transition class="text-center py-8 space-y-4">
                    <div class="relative inline-block">
                        <div class="w-16 h-16 bg-operon-mist/30 text-operon-deep rounded-[24px] flex items-center justify-center mx-auto mb-2 border border-operon-mist shadow-sm">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-white animate-ping"></div>
                    </div>
                    <div>
                        <h4 class="font-black text-operon-deep dark:text-white text-lg uppercase tracking-tight"><?= \App\Core\I18n::t('rating.success_title') ?></h4>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 leading-relaxed font-black uppercase tracking-widest mt-1"><?= \App\Core\I18n::t('rating.success_message') ?></p>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="ios-card p-5">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3"><?= \App\Core\I18n::t('links.title') ?></h3>
                <nav class="space-y-2">
                    <?php if(!empty($project['github_url'])): ?>
                    <a href="<?= $project['github_url'] ?>" target="_blank" class="flex items-center p-2 rounded-lg hover:bg-slate-50 transition-colors text-sm font-medium text-slate-700">
                        <span class="w-6 text-center mr-2">💻</span> <?= \App\Core\I18n::t('links.repo') ?>
                    </a>
                    <?php endif; ?>
                    <a href="/client/projects/documents?id=<?= $project['id'] ?>" class="flex items-center p-2 rounded-lg hover:bg-slate-50 transition-colors text-sm font-medium text-slate-700">
                        <span class="w-6 text-center mr-2">📜</span> <?= \App\Core\I18n::t('links.documents') ?>
                    </a>
                </nav>
            </div>

            <!-- Ideas Bank Promo -->
            <a href="/client/projects/ideas?id=<?= $project['id'] ?>" class="block ios-card p-5 group hover:border-amber-200 transition-all border border-transparent">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-xl bg-amber-50 dark:bg-amber-400/10 text-amber-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                        💡
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 dark:text-white text-sm"><?= \App\Core\I18n::t('ideas.title') ?></h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400"><?= \App\Core\I18n::t('ideas.promo') ?></p>
                    </div>
                </div>
            </a>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle Phase Click
        window.togglePhase = function(event) {
            // ... existing logic if any ...
        }

        // Check for approval success
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('approved')) {
            confetti({
                particleCount: 150,
                spread: 70,
                origin: { y: 0.6 },
                colors: ['#10B981', '#34D399', '#FBBF24', '#F472B6']
            });
            
            // Clean URL
            window.history.replaceState({}, document.title, window.location.pathname + window.location.search.replace(/[?&]approved=1/, ''));
        }
    });
</script>
