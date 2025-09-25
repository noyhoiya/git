

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

    @layer base {
        body {
            font-family: 'Noto Sans Lao', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-primary);
        }
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
    </style>
<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-md mt-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">ລາຍລະອຽດການເຄື່ອນໄຫວກອງເງິນ</h2>

    <!-- Movement Info -->
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <p class="text-gray-600 font-medium">ປະເພດເຄື່ອນໄຫວ:</p>
            <p class="text-gray-800"><?php echo e($vaultMovement->type); ?></p>
        </div>
        <div>
            <p class="text-gray-600 font-medium">ສູນເງິນຈາກ:</p>
            <p class="text-gray-800"><?php echo e($vaultMovement->fromVault->vault_name); ?></p>
        </div>
        <div>
            <p class="text-gray-600 font-medium">ສູນເງິນໄປ:</p>
            <p class="text-gray-800"><?php echo e($vaultMovement->toVault->vault_name); ?></p>
        </div>
        <div>
            <p class="text-gray-600 font-medium">ເງິນລວມ (₭):</p>
            <p class="text-gray-800"><?php echo e(number_format($vaultMovement->amount, 0)); ?></p>
        </div>
        <div>
            <p class="text-gray-600 font-medium">ຈຸດປະສົງ:</p>
            <p class="text-gray-800"><?php echo e($vaultMovement->purpose_text ?? $vaultMovement->purpose->purpose_name ?? '-'); ?></p>
        </div>
        <div>
            <p class="text-gray-600 font-medium">ສະຖານະ:</p>
            <p class="text-gray-800"><?php echo e($vaultMovement->status); ?></p>
        </div>
        <div>
            <p class="text-gray-600 font-medium">ຜູ້ສ້າງເຄື່ອນໄຫວ:</p>
            <p class="text-gray-800"><?php echo e($vaultMovement->createdByUser->name ?? '-'); ?></p>
        </div>
        <div>
            <p class="text-gray-600 font-medium">ວັນທີ່ສ້າງ:</p>
            <p class="text-gray-800"><?php echo e($vaultMovement->created_at->format('d/m/Y H:i')); ?></p>
        </div>
    </div>

    <!-- Denominations Table -->
    <div class="overflow-x-auto mb-6">
        <table class="w-full border border-gray-200 rounded-lg text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 border-b">ສິ່ງເງິນ</th>
                    <th class="px-4 py-2 border-b">ຈຳນວນ</th>
                    <th class="px-4 py-2 border-b">ລາຄາລວມ (₭)</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $vaultMovement->denominations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $denom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b"><?php echo e(number_format($denom->denomination, 0)); ?></td>
                    <td class="px-4 py-2 border-b"><?php echo e($denom->quantity); ?></td>
                    <td class="px-4 py-2 border-b"><?php echo e(number_format($denom->total_value, 0)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr class="font-bold bg-gray-100">
                    <td class="px-4 py-2 border-b" colspan="2">ລວມທັງໝົດ</td>
                    <td class="px-4 py-2 border-b">
                        <?php echo e(number_format($vaultMovement->denominations->sum(fn($d) => $d->total_value), 0)); ?>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Back Button -->
    <a href="<?php echo e(url()->previous()); ?>" 
       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold">
        ກັບຄືນ
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cash_center_v3\resources\views/vault-movements/show.blade.php ENDPATH**/ ?>