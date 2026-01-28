<?php
/**
 * Operon Cortex - Suporte (Admin)
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/layout.php';

requireAdmin();

// Buscar tickets
$tickets = db()->query("
    SELECT t.*, p.name as project_name, c.name as client_name 
    FROM tickets t 
    LEFT JOIN projects p ON t.project_id = p.id 
    LEFT JOIN clients c ON p.client_id = c.id 
    ORDER BY t.updated_at DESC
")->fetchAll();

ob_start();
?>

<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold">Suporte</h1>
        <p class="text-slate-500">Central de tickets e atendimento</p>
    </div>
    
    <!-- Tickets -->
    <div class="bg-dark-card border border-dark-border rounded-xl overflow-hidden">
        <div class="divide-y divide-dark-border">
            <?php if (empty($tickets)): ?>
            <div class="px-6 py-8 text-center text-slate-500">
                Nenhum ticket aberto. 🎉
            </div>
            <?php endif; ?>
            
            <?php foreach ($tickets as $ticket): ?>
            <a href="ticket_show.php?id=<?= $ticket['id'] ?>" class="block px-6 py-4 hover:bg-white/5">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="font-medium"><?= htmlspecialchars($ticket['subject']) ?></div>
                        <div class="text-sm text-slate-500"><?= htmlspecialchars($ticket['client_name'] ?? 'Cliente') ?> - <?= htmlspecialchars($ticket['project_name'] ?? 'Projeto') ?></div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-2 py-1 text-xs rounded-full 
                            <?= $ticket['status'] === 'open' ? 'bg-amber-500/20 text-amber-400' : ($ticket['status'] === 'closed' ? 'bg-slate-500/20 text-slate-400' : 'bg-emerald-500/20 text-emerald-400') ?>">
                            <?= ucfirst($ticket['status']) ?>
                        </span>
                        <span class="text-slate-500 text-sm">→</span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
renderAdminLayout('Suporte', $content, 'support');
