

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
<div class="container mx-auto py-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900">ຄັງເງິນ</h1>
        <a href="<?php echo e(route('vaults.create')); ?>" 
           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow transition-colors duration-200">
            ເພີ່ມຄັງເງິນໃໝ່
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded mb-6">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">ລະຫັດ</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">ຊື່</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">ປະເພດ</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">ເງິນສົດ</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">ໃຊ້ງານ</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php $__currentLoopData = $vaults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vault): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 text-gray-700"><?php echo e($vault->vault_id); ?></td>
                    <td class="px-6 py-4 font-semibold text-gray-900"><?php echo e($vault->vault_name); ?></td>
                    <td class="px-6 py-4 text-gray-700"><?php echo e($vault->vault_type); ?></td>
                    <td class="px-6 py-4 text-gray-700"><?php echo e(number_format($vault->current_balance, 2)); ?></td>
                    <td class="px-6 py-4">
                        <?php if($vault->is_active): ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        <?php else: ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Inactive
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="<?php echo e(route('vaults.show', $vault)); ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded shadow text-sm transition-colors duration-150">ເບິ່ງ</a>
                        <a href="<?php echo e(route('vaults.edit', $vault)); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded shadow text-sm transition-colors duration-150">ແກ້ໄຂ</a>
                        <form action="<?php echo e(route('vaults.destroy', $vault)); ?>" method="POST" onsubmit="return confirm('Are you sure?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow text-sm transition-colors duration-150">ລົບ</button>
                        </form>
                    </td>
                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cash_center_v3\resources\views/vaults/index.blade.php ENDPATH**/ ?>