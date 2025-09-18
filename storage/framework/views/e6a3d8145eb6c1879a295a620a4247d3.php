

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
<div class="container mx-auto py-8 lao-font">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-900">ລາຍລະອຽດຄັງ</h1>

        <!-- Vault Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Vault Name -->
            <div>
                <p class="text-sm font-medium text-gray-600">ຄັງ</p>
                <p class="text-lg font-semibold text-gray-900"><?php echo e($vault->vault_name); ?></p>
            </div>

            <!-- Vault Type -->
            <div>
                <p class="text-sm font-medium text-gray-600">ປະເພດຄັງ</p>
                <p class="text-lg font-semibold text-gray-900"><?php echo e($vault->vault_type); ?></p>
            </div>

            <!-- Current Balance -->
            <div>
                <p class="text-sm font-medium text-gray-600">ຍອດເງິນ</p>
                <p class="text-lg font-semibold text-gray-900"><?php echo e(number_format($vault->current_balance, 2)); ?></p>
            </div>

            <!-- Active Status -->
            <div>
                <p class="text-sm font-medium text-gray-600">ສະຖານະ</p>
                <?php if($vault->is_active): ?>
                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold text-sm">Active</span>
                <?php else: ?>
                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 font-semibold text-sm">Inactive</span>
                <?php endif; ?>
            </div>

            <!-- Created At -->
            <div>
                <p class="text-sm font-medium text-gray-600">ສ້າງເມື່ອ</p>
                <p class="text-gray-700"><?php echo e($vault->created_at->format('d-m-Y H:i')); ?></p>
            </div>

            <!-- Updated At -->
            <div>
                <p class="text-sm font-medium text-gray-600">ແກ້ໄຂເມື່ອ</p>
                <p class="text-gray-700"><?php echo e($vault->updated_at->format('d-m-Y H:i')); ?></p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3">
            <a href="<?php echo e(route('vaults.index')); ?>" class="btn-secondary">ກັບຄືນ</a>
            <a href="<?php echo e(route('vaults.edit', $vault)); ?>" class="btn-primary">ແກ້ໄຂຄັງ</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cash_center_v3\resources\views/vaults/show.blade.php ENDPATH**/ ?>