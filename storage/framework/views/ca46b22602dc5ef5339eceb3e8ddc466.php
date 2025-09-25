

<?php $__env->startSection('content'); ?>
<script src="https://resource.trickle.so/vendor_lib/unpkg/react@18/umd/react.production.min.js"></script>
<script src="https://resource.trickle.so/vendor_lib/unpkg/react-dom@18/umd/react-dom.production.min.js"></script>
<script src="https://resource.trickle.so/vendor_lib/unpkg/@babel/standalone/babel.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;500;600;700&display=swap" rel="stylesheet">

<style type="text/tailwindcss">
@layer theme {
    :root {
        --primary-color: #10b981;
        --secondary-color: #f0fdf4;
        --accent-color: #059669;
        --text-primary: #111827;
        --text-secondary: #6b7280;
        --border-color: #e5e7eb;
        --background-light: #f9fafb;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
    }
}


     html, body, #app, .card, .stat-card, .modal, #previewModal,#printPreview {
    font-family: 'Noto Sans Lao', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }


@layer components {
    .btn-primary {
        @apply bg-[var(--primary-color)] hover:bg-[var(--accent-color)] text-white px-6 py-3 rounded-lg font-medium transition-colors;
    }
    .btn-secondary {
        @apply bg-white hover:bg-gray-50 text-[var(--text-primary)] border border-[var(--border-color)] px-6 py-3 rounded-lg font-medium transition-colors;
    }
    .card {
        @apply bg-white rounded-lg shadow-sm border border-[var(--border-color)] p-6;
    }
    .stat-card {
        @apply bg-white rounded-lg shadow-sm border border-[var(--border-color)] p-6 hover:shadow-md transition-shadow;
    }
    .input-field {
        @apply w-full px-4 py-3 border border-[var(--border-color)] rounded-lg focus:ring-2 focus:ring-[var(--primary-color)] focus:border-transparent;
    }
}
.lao-font {
  font-family: 'Noto Sans Lao', 'Inter', sans-serif !important;
}
@media print {
  * {
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
    color-adjust: exact !important; /* for older browsers */
  }

  table th,
  table td {
    background-color: inherit !important;
  }


       body * { visibility: hidden; }
    #previewModal, #previewModal * { visibility: visible; }
    #printPreview, #closePreview { display: none !important; }
     #previewModal {
        width: 100%;
        height: auto;
        max-width: 794px; /* A4 width */
        margin: 0 auto;
        background-color: white !important;
    }

    #previewModal table th,
    #previewModal table td {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        background-color: inherit !important;
        color: inherit !important;
    }

    /* Hide floating buttons */
    #printPreview, #closePreview {
        display: none !important;
    }
}

</style>
<div class="container mx-auto px-4 py-10">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Transaction Debug Logs</h2>

    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full border-collapse bg-white text-sm">
            <thead class="bg-[var(--primary-color)] text-white">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">From Vault</th>
                    <th class="px-4 py-3 text-left">To Vault</th>
                    <th class="px-4 py-3 text-right">Amount</th>
                    <th class="px-4 py-3 text-right">From Before</th>
                    <th class="px-4 py-3 text-right">From After</th>
                    <th class="px-4 py-3 text-right">To Before</th>
                    <th class="px-4 py-3 text-right">To After</th>
                    <th class="px-4 py-3 text-left">User</th>
                    <th class="px-4 py-3 text-center">Duplicate?</th>
                    <th class="px-4 py-3 text-center">Negative?</th>
                    <th class="px-4 py-3 text-left">Created</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3"><?php echo e($log->id); ?></td>
                    <td class="px-4 py-3"><?php echo e($log->from_vault_id); ?></td>
                    <td class="px-4 py-3"><?php echo e($log->to_vault_id); ?></td>
                    <td class="px-4 py-3 text-right font-medium text-gray-700"><?php echo e(number_format($log->amount)); ?></td>
                    <td class="px-4 py-3 text-right"><?php echo e(number_format($log->balance_from_before)); ?></td>
                    <td class="px-4 py-3 text-right <?php echo e($log->balance_from_after < 0 ? 'text-red-600 font-bold' : ''); ?>">
                        <?php echo e(number_format($log->balance_from_after)); ?>

                    </td>
                    <td class="px-4 py-3 text-right"><?php echo e(number_format($log->balance_to_before)); ?></td>
                    <td class="px-4 py-3 text-right"><?php echo e(number_format($log->balance_to_after)); ?></td>
                    <td class="px-4 py-3"><?php echo e($log->user_id); ?></td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 text-xs rounded-full 
                            <?php echo e($log->is_duplicate ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700'); ?>">
                            <?php echo e($log->is_duplicate ? 'Yes' : 'No'); ?>

                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 text-xs rounded-full 
                            <?php echo e($log->is_negative ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'); ?>">
                            <?php echo e($log->is_negative ? 'Yes' : 'No'); ?>

                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-600"><?php echo e($log->created_at); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cash_center_v3\resources\views/vaults/debug_logs.blade.php ENDPATH**/ ?>