

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
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">ຈັດການຜູ້ໃຊ້</h2>

    <!-- Add New User Button -->
    <div class="mb-6">
        <a href="<?php echo e(route('users.create')); ?>" class="btn-primary">
            + ເພີ່ມຜູ້ໃຊ້ໃໝ່
        </a>
    </div>

    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Users Table -->
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ລະຫັດ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ຊື່ຜູ້ໃຊ້</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ຜູ້ໃຊ້</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ສິດ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ສະຖານະ</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">ແກ້ໄຂ</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($user->user_id); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($user->full_name); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($user->username); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($user->role?->role_name); ?></td>
                    <td class="px-6 py-4 text-sm">
                        <?php if($user->is_active): ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                ໃຊ້ງານ
                            </span>
                        <?php else: ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                ປິດການໃຊ້ງານ
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-center text-sm space-x-2">
                        <a href="<?php echo e(route('users.edit', $user)); ?>" class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-sm font-medium">
                            ແກ້ໄຂ
                        </a>
                        <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Delete this user?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium">
                                ລົບ
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cash_center_v3\resources\views/users/index.blade.php ENDPATH**/ ?>