


 <script src="https://resource.trickle.so/vendor_lib/unpkg/react@18/umd/react.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/react-dom@18/umd/react-dom.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/@babel/standalone/babel.min.js"></script>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.jsx']); ?>
    <link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;500;600;700&display=swap" rel="stylesheet">
     
<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">ສ້າງຄຳຮ້ອງຂໍ</h2>

    
    <?php if($errors->any()): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    
    <?php if(session('success')): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('cash-requests.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">ເລືອກ Vault</label>
            <select name="requester_vault_id" class="w-full border rounded-lg px-3 py-2" required>
            <option value="">-- ເລືອກ Vault --</option>
            <?php $__currentLoopData = $vaults->where('vault_type', 'MAIN'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vault): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($vault->vault_id); ?>" <?php echo e(old('requester_vault_id') == $vault->vault_id ? 'selected' : ''); ?>>
                    <?php echo e($vault->vault_name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        </div>

        
               <div>
            <label for="amount" class="block text-gray-700 font-medium mb-2">ຈຳນວນເງິນ</label>
            <input type="number" step="0.01" name="amount" id="amount"
                value="<?php echo e(old('amount')); ?>"
                min="0.01" required
                class="input-field"
                onblur="this.value = parseFloat(this.value).toFixed(2)">
            </div>

        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">ຈຳນວນເງິນເປັນຕົວໜັງສື</label>
            <input type="text" name="amount_in_words" value="<?php echo e(old('amount_in_words')); ?>" class="w-full border rounded-lg px-3 py-2" required>
        </div>

        
       <div class="mb-4">
    <label class="block text-gray-700 mb-2">ຈຸດປະສົງ</label>
   <select name="purpose_code" class="w-full border rounded-lg px-3 py-2">
    <option value="">-- ເລືອກຈຸດປະສົງ --</option>
    <?php $__currentLoopData = $purposes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purpose): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($purpose->purpose_code); ?>" <?php echo e(old('purpose_code') == $purpose->purpose_code ? 'selected' : ''); ?>>
            <?php echo e($purpose->purpose_name); ?>

        </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>

</div>


        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">ຫມາຍເຫດ</label>
            <textarea name="notes" class="w-full border rounded-lg px-3 py-2"><?php echo e(old('notes')); ?></textarea>
        </div>

<h4 class="text-gray-700 font-semibold mb-2">ເງິນຕາມສະກຸນ</h4>
<table class="w-full mb-4 border rounded" id="denomination-table">
    <thead class="bg-gray-100">
        <tr>
            <th class="border px-2 py-1">ປະເພດໃບ</th>
            <th class="border px-2 py-1">ຈຳນວນເງິນ</th>
            <th class="border px-2 py-1">
                <button type="button" id="add-row" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded">+</button>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            
            <td class="border px-2 py-1">
                <select name="denomination[]" class="w-full border rounded px-2 py-1" required>
                    <option value="">-- ເລືອກ --</option>
                    <option value="500">500</option>
                    <option value="1000">1,000</option>
                    <option value="2000">2,000</option>
                    <option value="5000">5,000</option>
                    <option value="10000">10,000</option>
                    <option value="20000">20,000</option>
                    <option value="50000">50,000</option>
                    <option value="100000">100,000</option>
                </select>
            </td>
            <td class="border px-2 py-1">
                <input type="number" name="quantity[]" class="w-full border rounded px-2 py-1" required>
            </td>
            <td class="border px-2 py-1">
                <button type="button" class="remove-row bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">-</button>
               
            </td>
        </tr>
    </tbody>
</table>


        <div class="flex justify-end gap-3 mt-4">
    
    <button type="submit" 
        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold">
        ສ້າງຄຳຮ້ອງ
    </button>
    <a href="<?php echo e(url()->previous()); ?>" 
        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold">
        ກັບຄືນ
    </a>
</div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addRowBtn = document.getElementById('add-row');
    const tbody = document.querySelector('#denomination-table tbody');

    addRowBtn.addEventListener('click', function() {
        const newRow = tbody.querySelector('tr').cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => input.value = '');
        tbody.appendChild(newRow);
    });

    tbody.addEventListener('click', function(e) {
        if(e.target.classList.contains('remove-row')){
            if(tbody.rows.length > 1){
                e.target.closest('tr').remove();
            }
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cash_center_v3\resources\views/cash-requests/create.blade.php ENDPATH**/ ?>