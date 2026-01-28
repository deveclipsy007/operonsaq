<?php
// Admin Project Feedback View
?>
<div class="px-8 py-8 animate-fade-in-up">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="/admin/projects" class="text-sm font-bold text-slate-400 hover:text-indigo-600 transition-colors mb-2 inline-block">← Voltar para Projetos</a>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Feedback & Detalhes do Cliente</h1>
            <p class="text-slate-500 font-medium">Histórico de interações e controle interno.</p>
        </div>
        <div class="flex gap-3">
             <a href="/admin/projects/show?id=<?= $project['id'] ?>" class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-bold shadow-sm hover:bg-indigo-700 hover:-translate-y-0.5 transition-all text-sm flex items-center gap-2">
                ✏️ Editar Conteúdo/Timeline
            </a>
            <div class="text-right">
                <span class="block text-xs font-bold text-slate-400 uppercase">Projeto</span>
                <span class="text-xl font-bold text-indigo-600"><?= htmlspecialchars($project['name']) ?></span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: General Info & Finance -->
        <div class="space-y-8">
            
            <!-- Deadline Card -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                 <div class="flex items-center gap-2 mb-4">
                    <span class="text-xl">⏳</span>
                    <h2 class="text-lg font-bold text-slate-800">Prazo & Tempo</h2>
                </div>
                <div class="space-y-4">
                    <div>
                         <?php if ($daysRemaining < 0): ?>
                             <span class="block text-xs font-bold text-rose-500 uppercase">Atrasado em</span>
                             <span class="text-3xl font-black text-rose-600"><?= abs($daysRemaining) ?> Dias</span>
                         <?php else: ?>
                             <span class="block text-xs font-bold text-emerald-500 uppercase">Restam</span>
                             <span class="text-3xl font-black text-slate-800"><?= $daysRemaining ?> Dias</span>
                         <?php endif; ?>
                    </div>
                     <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase">Prazo Final</span>
                        <span class="font-bold text-slate-700"><?= date('d/m/Y', strtotime($project['deadline'])) ?></span>
                    </div>
                </div>
            </div>

            <!-- Financial Card -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-xl">💰</span>
                    <h2 class="text-lg font-bold text-slate-800">Financeiro</h2>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase">Valor do Projeto</span>
                        <span class="text-2xl font-black text-emerald-600">R$ <?= number_format((float)($project['project_value'] ?? 0), 2, ',', '.') ?></span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase">Pagamento</span>
                            <span class="font-bold text-slate-700"><?= htmlspecialchars($project['payment_method']) ?></span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase">Parcelas</span>
                            <span class="font-bold text-slate-700"><?= htmlspecialchars($project['installments']) ?>x</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Client Info -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                 <div class="flex items-center gap-2 mb-4">
                    <span class="text-xl">👤</span>
                    <h2 class="text-lg font-bold text-slate-800">Cliente</h2>
                </div>
                <div class="space-y-3">
                     <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase">Nome</span>
                        <span class="font-bold text-slate-700"><?= htmlspecialchars($client['name'] ?? 'N/A') ?></span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase">Email</span>
                        <span class="font-bold text-slate-700"><?= htmlspecialchars($client['email'] ?? 'N/A') ?></span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Tasks & Feedback -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Internal Tasks List (Deliverables) -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">📋</span>
                        <h2 class="text-lg font-bold text-slate-800">Tarefas & Entregas</h2>
                    </div>
                    <!-- Helper link to full editor -->
                    <a href="/admin/projects/show?id=<?= $project['id'] ?>" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                        Gerenciar Timeline →
                    </a>
                </div>

                <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                    <?php 
                        // Filter only task events (not micros if desired, but user wants 'Deliverables')
                        // Let's show all for now, maybe grouped?
                        if(empty($events)): 
                    ?>
                        <p class="text-slate-400 text-center py-4 italic">Nenhuma entrega cadastrada.</p>
                    <?php else: ?>
                        <?php foreach($events as $evt): ?>
                            <div class="flex items-center justify-between p-3 rounded-lg border border-slate-100 bg-slate-50/50 hover:bg-white transition-all group">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full <?= $evt['status'] === 'done' ? 'bg-emerald-500' : 'bg-slate-300' ?>"></div>
                                    <div>
                                        <p class="font-bold text-slate-700 text-sm line-clamp-1 <?= $evt['status'] === 'done' ? 'line-through opacity-50' : '' ?>">
                                            <?= htmlspecialchars($evt['title']) ?>
                                        </p>
                                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">
                                            <?= htmlspecialchars($evt['type']) ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <?php if($evt['status'] === 'done'): ?>
                                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Concluído</span>
                                    <?php else: ?>
                                        <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">Pendente</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Active Poll Results -->
            <?php 
                $pollDataRef = json_decode($project['next_action_data'] ?? '{}', true);
                if (isset($pollDataRef['votes']) && !empty($pollDataRef['votes'])): 
                    $pVotes = $pollDataRef['votes'];
                    $pTotal = array_sum($pVotes);
            ?>
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-5">
                    <span class="text-6xl">📊</span>
                </div>
                <div class="flex items-center gap-2 mb-2 relative z-10">
                    <span class="text-xl">📊</span>
                    <h2 class="text-lg font-bold text-slate-800">Resultado da Enquete</h2>
                </div>
                <!-- Poll Title -->
                <p class="text-sm font-medium text-slate-500 mb-6 relative z-10">
                    "<?= htmlspecialchars($project['next_action']) ?>"
                </p>

                <div class="space-y-4 relative z-10">
                    <?php foreach ($pVotes as $opt => $count): ?>
                        <?php $percent = $pTotal > 0 ? round(($count / $pTotal) * 100) : 0; ?>
                        <div>
                            <div class="flex justify-between text-sm font-bold text-slate-700 mb-1">
                                <span><?= htmlspecialchars($opt) ?></span>
                                <span class="bg-slate-100 text-slate-600 px-2 rounded-md text-xs py-0.5"><?= $count ?> Votos</span>
                            </div>
                            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-teal-600 rounded-full relative" style="width: <?= $percent ?>%"></div>
                            </div>
                            <div class="text-right mt-1">
                                <span class="text-[10px] font-black text-teal-600"><?= $percent ?>%</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Feedback Log -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">💬</span>
                        <h2 class="text-lg font-bold text-slate-800">Histórico de Interações</h2>
                    </div>
                    <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-bold"><?= count($feedbacks) ?> Registros</span>
                </div>

                <?php if (empty($feedbacks)): ?>
                    <div class="text-center py-12 text-slate-400">
                        <p>Nenhum feedback registrado ainda.</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($feedbacks as $item): ?>
                            <?php 
                                $isAdmin = strpos($item['type'], 'admin') !== false || $item['type'] === 'status_change';
                                $isApproval = $item['type'] === 'approval';
                                
                                // Purple (Indigo) replaced with Teal for generic/user actions if needed, or keeping standard roles.
                                // User asked for "everything purple to petroleum green".
                                // Previously: bg-indigo-100 text-indigo-600 for default/client actions.
                                // Now: bg-teal-50 text-teal-700
                                $bg = $isApproval ? 'bg-emerald-100 text-emerald-600' : ($isAdmin ? 'bg-slate-100 text-slate-600' : 'bg-teal-50 text-teal-700');
                                
                                $icon = match($item['type']) {
                                    'approval' => '✓',
                                    'vote' => '📊',
                                    'admin_update' => '⚙️',
                                    'admin_event' => '📅',
                                    'status_change' => '🔄',
                                    'admin_next_action' => '⚡',
                                    default => '💬'
                                };

                                $title = match($item['type']) {
                                    'approval' => 'Aprovação Realizada',
                                    'vote' => 'Voto em Enquete',
                                    'admin_update' => 'Atualização Administrativa',
                                    'admin_event' => 'Novo Evento na Timeline',
                                    'status_change' => 'Mudança de Status',
                                    'admin_next_action' => 'Nova Próxima Ação',
                                    default => 'Log do Sistema'
                                };
                            ?>
                            <div class="flex items-start gap-4 p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-white hover:shadow-md transition-all">
                                <div class="h-10 w-10 rounded-full flex items-center justify-center text-lg shadow-sm border border-white shrink-0 <?= $bg ?>">
                                    <?= $icon ?>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <h3 class="font-bold text-slate-800">
                                            <?= $title ?>
                                        </h3>
                                        <span class="text-xs font-bold text-slate-400">
                                            <?= date('d/m/Y H:i', strtotime($item['created_at'])) ?>
                                        </span>
                                    </div>
                                    <p class="text-slate-600 text-sm mt-1">
                                        <?= htmlspecialchars($item['content']) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
