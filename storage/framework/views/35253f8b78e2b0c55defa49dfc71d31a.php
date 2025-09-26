<?php $__env->startSection('title', 'ໜ້າຫຼັກ - ສູນການເງິນ'); ?>
<script src="https://resource.trickle.so/vendor_lib/unpkg/react@18/umd/react.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/react-dom@18/umd/react-dom.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/@babel/standalone/babel.min.js"></script>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.jsx']); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;500;600;700&display=swap" rel="stylesheet">
    
<?php $__env->startSection('content'); ?>

<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">ໜ້າຫຼັກ</h1>
        <div class="flex space-x-4">
            <a href="/cash-requests/create" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                ສ້າງຄຳຂໍໃໝ່
            </a>
            <a href="/vault-movements/create" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                ການເຄື່ອນໄຫວໃໝ່
            </a>
             <a href="<?php echo e(route('reports')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                

                ລາຍງານ
            </a>
        </div>
    </div>
    
  <!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

   <!-- Vault Card -->
<a href="<?php echo e(route('vaults.index')); ?>" class="block">
    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">ຄັງເງິນ</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['total_vaults']); ?></p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                <div class="icon-vault text-xl text-green-600"></div>
            </div>
        </div>
    </div>
</a>


    <!-- Pending Requests Card -->
    <?php
        $isAllowed = in_array(optional(Auth::user())->role_id, [1,3,5]);
    ?>

    <div class="<?php echo e($isAllowed ? '' : 'opacity-50 cursor-not-allowed bg-gray-100'); ?> rounded-lg shadow">
        <?php if($isAllowed): ?>
            <a href="/cash-requests" class="block p-6 hover:shadow-lg transition-shadow">
        <?php else: ?>
            <div class="p-6">
        <?php endif; ?>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">ຄຳຂໍລໍຖ້າ</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['pending_requests']); ?></p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                    <div class="icon-clock text-xl text-yellow-600"></div>
                </div>
            </div>
        <?php if($isAllowed): ?>
            </a>
        <?php else: ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Recent Movements Card -->
    <div class="<?php echo e($isAllowed ? '' : 'opacity-50 cursor-not-allowed bg-gray-100'); ?> rounded-lg shadow">
        <?php if($isAllowed): ?>
            <a href="<?php echo e(route('vault-movements.index')); ?>" class="block p-6 hover:shadow-lg transition-shadow">
        <?php else: ?>
            <div class="p-6">
        <?php endif; ?>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600"><?php echo e($isAllowed ? 'ການເຄື່ອນໄຫວລໍຖ້າ' : 'ການເຄື່ອນໄຫວທັງໝົດ'); ?></p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['recent_movements']); ?></p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <div class="icon-arrow-right-left text-xl text-blue-600"></div>
                </div>
            </div>
        <?php if($isAllowed): ?>
            </a>
        <?php else: ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Users Card -->
    <div class="<?php echo e($isAllowed ? '' : 'opacity-50 cursor-not-allowed bg-gray-100'); ?> rounded-lg shadow">
        <?php if($isAllowed): ?>
            <a href="<?php echo e(route('users.index')); ?>" class="block p-6 hover:shadow-lg transition-shadow">
        <?php else: ?>
            <div class="p-6">
        <?php endif; ?>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">ຜູ້ໃຊ້ງານ</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['active_users']); ?></p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                    <div class="icon-users text-xl text-purple-600"></div>
                </div>
            </div>
        <?php if($isAllowed): ?>
            </a>
        <?php else: ?>
            </div>
        <?php endif; ?>
    </div>

</div>

    <!-- Recent Activity -->
    
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Latest Cash Requests Card -->
    <div class="bg-white rounded-lg shadow">
        <button type="button" 
            class="w-full px-6 py-4 text-left flex justify-between items-center font-semibold focus:outline-none"
            onclick="this.nextElementSibling.classList.toggle('hidden')">
            <span>ຄຳຂໍເງິນສົດລ່າສຸດ</span>
            <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div class="p-6 border-t hidden">
            <?php $__empty_1 = true; $__currentLoopData = $recentRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between py-3 border-b last:border-b-0">
                    <div>
                        <p class="font-medium"><?php echo e($request->requesterUser->full_name); ?></p>
                        <p class="text-sm text-gray-600">₭<?php echo e(number_format($request->amount_cents / 100, 2)); ?></p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full 
                        <?php if($request->status === 'PENDING'): ?> bg-yellow-100 text-yellow-800
                        <?php elseif($request->status === 'APPROVED'): ?> bg-green-100 text-green-800
                        <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                        <?php if($request->status === 'PENDING'): ?> ລໍຖ້າ
                        <?php elseif($request->status === 'APPROVED'): ?> ອະນຸມັດ
                        <?php elseif($request->status === 'REJECTED'): ?> ປະຕິເສດ
                        <?php else: ?> <?php echo e($request->status); ?> <?php endif; ?>
                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-500">ບໍ່ມີຄຳຂໍລ່າສຸດ</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Latest Movements Card -->
    <div class="bg-white rounded-lg shadow">
        <button type="button" 
            class="w-full px-6 py-4 text-left flex justify-between items-center font-semibold focus:outline-none"
            onclick="this.nextElementSibling.classList.toggle('hidden')">
            <span>ການເຄື່ອນໄຫວລ່າສຸດ</span>
            <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div class="p-6 border-t hidden">
            <?php $__empty_1 = true; $__currentLoopData = $recentMovements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between py-3 border-b last:border-b-0">
                    <div>
                        <p class="font-medium"><?php echo e($movement->fromVault->vault_name); ?> → <?php echo e($movement->toVault->vault_name); ?></p>
                        <p class="text-sm text-gray-600">₭<?php echo e(number_format($movement->amount_cents / 100, 2)); ?></p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                        <?php if($movement->status === 'POSTED'): ?> ລົງບັນທຶກ
                        <?php elseif($movement->status === 'DRAFT'): ?> ແບບຮ່າງ
                        <?php else: ?> <?php echo e($movement->status); ?> <?php endif; ?>
                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-500">ບໍ່ມີການເຄື່ອນໄຫວລ່າສຸດ</p>
            <?php endif; ?>
        </div>
    </div>

<div class="container mt-4">

    
    <?php if(session('cash_request_alert')): ?>
        <?php $request = session('cash_request_alert'); ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?php echo e($request->requesterUser->name); ?> requested <?php echo e(number_format($request->amount, 2)); ?>

            from <?php echo e($request->requesterVault->name ?? 'a vault'); ?>.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    
    <div class="row mb-4">
        <!-- your existing stats cards here -->
    </div>

    
    <!-- your existing tables here -->

</div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cash_center_v3\resources\views/dashboard.blade.php ENDPATH**/ ?>