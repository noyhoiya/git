

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
        --primary-color: #10b981;        /* Main green */
        --secondary-color: #f0fdf4;      /* Light green background */
        --accent-color: #059669;         /* Darker green for hover */
        --text-primary: #111827;         /* Main text color */
        --text-secondary: #6b7280;       /* Secondary text color */
        --border-color: #e5e7eb;         /* Light border */
        --background-light: #f9fafb;     /* Light background */
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
    }
}

@layer base {
    body {
        font-family: 'Noto Sans Lao', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--text-primary);
        background-color: var(--background-light);
    }
    a {
        text-decoration: none;
    }
}

@layer components {
    /* Buttons */
    .btn-primary {
        @apply bg-[var(--primary-color)] hover:bg-[var(--accent-color)] text-white px-6 py-3 rounded-lg font-medium transition-colors;
    }

    .btn-secondary {
        @apply bg-white hover:bg-gray-50 text-[var(--text-primary)] border border-[var(--border-color)] px-6 py-3 rounded-lg font-medium transition-colors;
    }

    /* Cards */
    .card {
        @apply bg-white rounded-lg shadow-sm border border-[var(--border-color)] p-6;
    }

    .stat-card {
        @apply bg-white rounded-lg shadow-sm border border-[var(--border-color)] p-6 hover:shadow-md transition-shadow cursor-pointer;
    }

    .stat-card-disabled {
        @apply bg-gray-100 rounded-lg shadow-sm border border-[var(--border-color)] p-6 opacity-50 cursor-not-allowed;
    }

    /* Input Fields */
    .input-field {
        @apply w-full px-4 py-3 border border-[var(--border-color)] rounded-lg focus:ring-2 focus:ring-[var(--primary-color)] focus:border-transparent transition;
    }

    /* Labels */
    .form-label {
        @apply block text-sm font-medium text-[var(--text-secondary)] mb-1;
    }

    /* Badge Styles */
    .badge-success {
        @apply px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs font-medium;
    }
    .badge-warning {
        @apply px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-medium;
    }
    .badge-danger {
        @apply px-2 py-1 rounded-full bg-red-100 text-red-800 text-xs font-medium;
    }
}
</style>

<div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6"><?php echo e(isset($user) ? 'Edit User' : 'ເພີ່ມຜູ້ໃຊ້'); ?></h2>

    <?php if($errors->any()): ?>
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc list-inside">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(isset($user) ? route('users.update', $user) : route('users.store')); ?>" method="POST" class="space-y-4">
        <?php echo csrf_field(); ?>
        <?php if(isset($user)): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>

        <!-- Full Name -->
        <div>
            <label class="form-label">ຊື້ຜູ້ໃຊ້</label>
            <input type="text" name="full_name" class="input-field" value="<?php echo e(old('full_name', $user->full_name ?? '')); ?>" required>
        </div>

        <!-- Username -->
        <div>
            <label class="form-label">ຜູ້ໃຊ້</label>
            <input type="text" name="username" class="input-field" value="<?php echo e(old('username', $user->username ?? '')); ?>" required>
        </div>

        <!-- Password -->
        <div>
            <label class="form-label">ລະຫັດຜ່ານ <?php echo e(isset($user) ? '(Leave blank to keep current)' : ''); ?></label>
            <input type="password" name="password" class="input-field" <?php echo e(isset($user) ? '' : 'required'); ?>>
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="form-label">ຢືນຢັນລະຫັດຜ່ານ</label>
            <input type="password" name="password_confirmation" class="input-field" <?php echo e(isset($user) ? '' : 'required'); ?>>
        </div>

        <!-- Role -->
        <div>
            <label class="form-label">ສິດ</label>
            <select name="role_id" class="input-field" required>
                <option value="">Select Role</option>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($role->role_id); ?>" <?php echo e((old('role_id', $user->role_id ?? '') == $role->role_id) ? 'selected' : ''); ?>><?php echo e($role->role_name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- Status -->
        <div>
            <label class="form-label">ສະຖານະ</label>
            <select name="is_active" class="input-field" required>
                <option value="1" <?php echo e((old('is_active', $user->is_active ?? 1) == 1) ? 'selected' : ''); ?>>Active</option>
                <option value="0" <?php echo e((old('is_active', $user->is_active ?? 1) == 0) ? 'selected' : ''); ?>>Inactive</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="flex space-x-4 mt-4">
            <button type="submit" class="btn-primary"><?php echo e(isset($user) ? 'Update' : 'Create'); ?></button>
            <a href="<?php echo e(route('users.index')); ?>" class="btn-secondary">ຍົກເລີກ</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cash_center_v3\resources\views/users/edit.blade.php ENDPATH**/ ?>