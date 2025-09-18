
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
<div class="max-w-6xl mx-auto p-8">
    <h2 class="text-2xl font-bold mb-6">ລາຍການຄຳຮ້ອງຂໍ</h2>

    <a href="<?php echo e(route('cash-requests.create')); ?>" 
       class="btn-primary inline-block mb-6">
       ສ້າງຄຳຮ້ອງໃໝ່
    </a>

    <div class="overflow-x-auto bg-white rounded-lg shadow ">
        <table class="w-full border-collapse ">
            <thead>
                <tr class="bg-gray-200 text-left text-sm font-semibold text-gray-700">
                    <th class="px-4 py-3 border">ID</th>
                    <th class="px-4 py-3 border">Vault</th>
                    <th class="px-4 py-3 border">User</th>
                    <th class="px-4 py-3 border">Amount</th>
                    <th class="px-4 py-3 border">Purpose</th>
                    <th class="px-4 py-3 border">Status</th>
                    <th class="px-4 py-3 border">Created At</th>
                    <th class="px-4 py-3 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                <?php $__currentLoopData = $cashRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $statusLabels = [
                            'PENDING' => 'ລໍຖ້າອະນຸມັດ',
                            'APPROVED' => 'ອະນຸມັດແລ້ວ',
                            'REJECTED' => 'ປະຕິເສດແລ້ວ',
                        ];
                    ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border"><?php echo e($request->request_id); ?></td>
                        <td class="px-4 py-2 border"><?php echo e($request->requesterVault->vault_name ?? '-'); ?></td>
                        <td class="px-4 py-2 border"><?php echo e($request->requesterUser->full_name ?? '-'); ?></td>
                        <td class="px-4 py-2 border font-semibold"><?php echo e(number_format($request->amount)); ?> ₭</td>
                        <td class="px-4 py-2 border"><?php echo e($request->purpose->purpose_name ?? $request->purpose_text); ?></td>
                        <td class="px-4 py-2 border">
                            <?php if($request->status == 'PENDING'): ?>
                                <span class="px-2 py-1 text-xs font-medium rounded bg-yellow-100 text-yellow-700">
                                    <?php echo e($statusLabels[$request->status]); ?>

                                </span>
                            <?php elseif($request->status == 'APPROVED'): ?>
                                <span class="px-2 py-1 text-xs font-medium rounded bg-green-100 text-green-700">
                                    <?php echo e($statusLabels[$request->status]); ?>

                                </span>
                            <?php elseif($request->status == 'REJECTED'): ?>
                                <span class="px-2 py-1 text-xs font-medium rounded bg-red-100 text-red-700">
                                    <?php echo e($statusLabels[$request->status]); ?>

                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2 border"><?php echo e($request->created_at->format('Y-m-d H:i')); ?></td>
                        <td class="px-4 py-2 border text-center">
                            <?php if($request->isPending() && in_array(auth()->user()->role_id, [1,3,5])): ?>
                                <form action="<?php echo e(route('cash-requests.approve', $request->request_id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">
                                        ອະນຸມັດ
                                    </button>
                                </form>
                                    
                                <form action="<?php echo e(route('cash-requests.reject', $request->request_id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                        ປະຕິເສດ
                                    </button>
                                </form>
                            <?php else: ?>
                                <?php if($request->status == 'APPROVED'): ?>
                                    <span class="text-green-600 font-semibold">✔</span>
                                <?php elseif($request->status == 'REJECTED'): ?>
                                    <span class="text-red-600 font-semibold">✘</span>
                                <?php else: ?>
                                    <span class="text-gray-500">⏳</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cash_center_v3\resources\views/cash-requests/index.blade.php ENDPATH**/ ?>