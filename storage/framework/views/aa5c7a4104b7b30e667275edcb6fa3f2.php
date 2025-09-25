
<script src="https://resource.trickle.so/vendor_lib/unpkg/react@18/umd/react.production.min.js"></script>
<script src="https://resource.trickle.so/vendor_lib/unpkg/react-dom@18/umd/react-dom.production.min.js"></script>
<script src="https://resource.trickle.so/vendor_lib/unpkg/@babel/standalone/babel.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- PDF export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<!-- Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<!-- Word export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>


<style type="text/tailwindcss">
@layer theme {
    :root {
        --primary-color: #10b981;
        --secondary-color: #f0fdf4;
        --accent-color: #059669;
        --text-primary: #111827;
        --text-secondary: #6b7280;
        --border-color: #e5e7eb;
        --background-light: #f9faf0;
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

<?php $__env->startSection('content'); ?>
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">ການເຄື່ອນໄຫວລ່າສຸດ</h2>

    
    <?php if(session('success')): ?>
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded shadow">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded shadow">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ເລກທີ</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ຈາກ</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ຫາ</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ຈຳນວນ</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ຈຸດປະສົງ</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ສະຖານະ</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ສ້າງວັນທີ</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-2 text-sm text-gray-700"><?php echo e($movement->movement_id); ?></td>
                    <td class="px-4 py-2 text-sm text-gray-700"><?php echo e($movement->fromVault->vault_name ?? '-'); ?></td>
                    <td class="px-4 py-2 text-sm text-gray-700"><?php echo e($movement->toVault->vault_name ?? '-'); ?></td>

                    <td class="px-4 py-2 text-sm text-gray-700">
                        ₭<?php echo e(number_format($movement->amount_cents , 2, '.', ',')); ?>

                    </td>

                     <td class="px-4 py-2 text-sm text-gray-700"><?php echo e($movement->purpose->purpose_name ?? '-'); ?></td>

                    <td class="px-4 py-2 text-sm">
                        <?php if($movement->status === 'POSTED'): ?>
                            <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">ລົງບັນທຶກ</span>
                        <?php elseif($movement->status === 'DRAFT'): ?>
                            <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">ແບບຮ່າງ</span>
                        <?php else: ?>
                            <span class="text-gray-500"><?php echo e($movement->status); ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-500"><?php echo e($movement->created_at->format('Y-m-d H:i')); ?></td>
                    <td class="px-4 py-2 text-sm space-x-2">
                        <?php if($movement->status === 'DRAFT' && in_array(auth()->user()->role_id, [1,3,5])): ?>
                            <button
                                type="button"
                                class="bg-blue-300 hover:bg-yellow-300 text-white px-3 py-1 rounded transition-all text-sm preview-btn"
                                data-id="<?php echo e($movement->movement_id); ?>"
                                data-from="<?php echo e($movement->fromVault->vault_name ?? '-'); ?>"
                                data-to="<?php echo e($movement->toVault->vault_name ?? '-'); ?>"
                                data-amount="<?php echo e(number_format($movement->amount_cents , 2)); ?>"
                                data-amount_in_words="<?php echo e($movement->amount_in_words); ?>"
                                data-purpose="<?php echo e($movement->purpose->purpose_name ?? '-'); ?>"
                                data-created="<?php echo e($movement->created_at->format('d/m/Y')); ?>"
                                data-created_by="<?php echo e($movement->createdByUser->full_name ?? '-'); ?>"
                                data-details='<?php echo json_encode($movement->details ?? [], 15, 512) ?>'
                            >
                                ເບິ່ງ
                            </button>

                            <form action="<?php echo e(route('vault-movements.postMovement', $movement->movement_id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded transition-all text-sm">ບັນທຶກ</button>
                            </form>

                            <!-- Delete button -->
                            <form action="<?php echo e(route('vault-movements.destroy', $movement->movement_id)); ?>" method="POST" class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this movement?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition-all text-sm">
                                    ລຶບ
                                </button>
                            </form>
                        <?php else: ?>
                            <span class="text-gray-400">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-6">ບໍ່ມີການເຄື່ອນໄຫວ</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div class="mt-4">
        <?php echo e($movements->links()); ?>

    </div>
</div>

<!-- Preview Modal -->
<!-- Preview Modal -->
<div id="previewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-[9999] lao-font">
    <div class="bg-white shadow-lg mx-auto relative a4-size flex flex-col">

        <!-- Action Buttons (not exported) -->
        <div class="absolute top-2 right-2 flex gap-2 z-50">
            <button id="printPreview" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm shadow">ພິມ</button>
            <button id="exportPDF" class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1 rounded text-sm shadow">PDF</button>
            <button id="closePreview" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm shadow">&times;</button>
            
            
        </div>

        <!-- Export Content -->
        <div id="exportContent" class="flex-1 relative p-6 flex flex-col">

            <!-- Watermark -->
            <img src="<?php echo e(asset('assets/image/logo.png')); ?>"
                 class="absolute bottom-20 left-1/2 -translate-x-1/2 w-80% h-auto opacity-15 pointer-events-none select-none"
                 alt="Watermark">

            <!-- Header -->
            <br><div class="text-center mb-4 z-10">
                <h2 class="text-sm lao-font">
                    ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ<br>
                    ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ<br>
                    -----===000===-----
                </h2>

                <!-- Logo + Info -->
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <img src="<?php echo e(asset('assets/image/logo_t.png')); ?>" alt="Logo" class="h-20 w-auto">
                    </div>
                    <div class="text-right lao-font text-sm">
                        <p class="bg-white px-2 py-1 inline-block">ເລກທີ: <span id="preview-id"></span> / ມຖງ.ບກ</p><br>
                        <p class="bg-white px-2 py-1 inline-block mt-1">ວັນທີ: <span id="preview-created"></span></p>
                    </div>
                </div>

                <p class="lao-font text-center mt-2 font-bold underline">ໃບຖອນເງິນສົດ</p>
                <p class="lao-font">
                    <strong>(ຈາກ:</strong> <span id="preview-from" class="mr-2"></span><strong>ຫາ:</strong> <span id="preview-to"></span><strong>)</strong>
                </p>
                <p class=" mr-2 text-left">ຄັ້ງທິ:...<span></span>...</p>
                <p class=" mr-2 text-left">ພະນັກງານ:...<span id="preview-created-by"></span>...</p>
            </div>

            <!-- Info Boxes + Table -->
            <div class="flex gap-6 lao-font mb-4">

                <!-- Left Box -->
                <div class="border border-gray-400 p-5 bg-white w-2/3 text-left text-sm flex-1 justify-center ">
                    <div class="grid grid-cols-1 gap-10">
                        <p><span class="mr-2 font-bold">•</span>ຊື່ຜູ້ຖອນ:... <span id="preview-created-by"></span></p>
                        <p><span class="mr-2 font-bold">•</span>ສັງກັດຢູ່ພະແນກ:... <span></span></p>
                        <p><span class="mr-2 font-bold">•</span>ຈຸດປະສົງຂອງການຖອນ:... <span id="preview-purpose"></span></p>
                        <p><span class="mr-2 font-bold">•</span>ຈຳນວນເງິນທີ່ຖອນ:... <span id="preview-amount"></span></p>
                        <p class="bg-white mb-16"> <span class="mr-2 text-1xl font-bold">•</span>ຈຳນວນເງິນເປັນໂຕໜັງສື... <span id="preview-amount-words">...</span> </p>
                    </div>
                </div>

                                <!-- Right Table (smaller width) -->
            <div class="overflow-x-auto w-1/3 flex-3  ">
                <table class="w-full table-auto border border-gray-400 text-sm  ">
                    <thead>
                        <tr class="bg-yellow-200 text-center font-bold ">
                            <th class="border border-black px-2 py-3" colspan="2">ລາຍລະອຽດ / Detail’s</th>
                        </tr>
                        <tr class="text-center">
                            <th class="bg-green-200 border border-black px-2 py-3 whitespace-nowrap">ປະເພດໃບ</th>
                            <th class="bg-orange-100 border border-black px-2 py-3 whitespace-nowrap">ຈຳນວນເງິນ</th>
                        </tr>
                    </thead>
                    <tbody id="preview-details" class="text-center [&>tr]:h-9">
                        <!-- JS will populate rows here -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="border px-2 py-2 font-bold text-right">ລວມ/Total:</td>
                            <td class="border px-2 py-2 text-right" id="preview-total" >0</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            </div>

            <!-- Signatures -->
            <div class="mt-8 flex justify-center text-center space-x-20 lao-font text-sm">
                <div class="flex flex-col items-center">
                    <div>ຫົວໜ້າພະແນກບໍລິການ</div>
                    <div class="mt-20 w-40 border-t "></div>
                </div>
                <div class="flex flex-col items-center">
                    <div>ຜູ້ມອບ/ນາຍຄັງ</div>
                    <div class="mt-20 w-40 border-t "></div>
                </div>
                <div class="flex flex-col items-center">
                    <div>ຜູ້ເບີກຖອນ/ຜູ້ຮັບ</div>
                    <div class="mt-20 w-40 border-t "></div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex-shrink-0 flex flex-col items-center w-full text-xs text-blue-400 mt-auto">
                <div class="w-full border-t-2 border-blue-200 mb-2"></div>
                <div class="text-center">
                    ຖະໜົນ ຕັດໃໝ່ ໜອງບົວທອງ, ບ້ານ ໜອງບົວທອງໃຕ້, ເມືອງ ສີໂຄດຕະບອງ, ນະຄອນຫຼວງວຽງຈັນ, ໂທ: 021 361000; ສາຍດ່ວນ: 1438 <br>
                    Nongbouathong New Rd, Nongbouathongtai Village, Sikhottabong District Vientiane Capital, tel: 021 361000; Call Center: 1438
                </div>
            </div>

        </div>
    </div>
</div>

<style>
.a4-size {
    width: 794px;   /* 210mm */
    height: 1123px; /* 297mm */
    max-width: 95%;
    max-height: 95%;
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
    background: white;
    position: relative;
}

#exportContent {
    flex: 1;
    position: relative; /* for watermark absolute */
    display: flex;
    flex-direction: column;
}
@media print {
    /* Hide buttons and input boxes */
    #previewModal button,
    #previewModal .qty-btn,
    #previewModal input[type="number"] {
        display: none !important;
    }

    /* Make table look clean */
    #previewModal table, 
    #previewModal table th, 
    /* #previewModal table td {
        background-color: transparent !important;
        color: none !important;
        border-color: none !important;
    } */
}


</style>


<script>
    let originalAmount = 0;
   document.getElementById('printPreview').addEventListener('click', function () {
    const modal = document.getElementById('previewModal');
    const originalContent = document.body.innerHTML;

    // Clone modal for printing
    const modalClone = modal.cloneNode(true);
    modalClone.classList.remove('hidden');

    // Remove buttons from clone
    const buttons = modalClone.querySelectorAll('#printPreview, #closePreview');
    buttons.forEach(btn => btn.remove());

    document.body.innerHTML = modalClone.outerHTML;

    window.print();

    // Restore original body
    document.body.innerHTML = originalContent;
    location.reload(); // reload to restore JS bindings
});

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('previewModal');
    const closeBtn = document.getElementById('closePreview');
   function openPreview(data){
    const modal = document.getElementById('previewModal');
    originalAmount = Number(data.amount.replace(/,/g,'')) || 0;
    document.getElementById('preview-id').textContent = data.id;
    document.getElementById('preview-from').textContent = data.from;
    document.getElementById('preview-to').textContent = data.to;
    document.getElementById('preview-amount').textContent = data.amount;
    document.getElementById('preview-amount-words').textContent = data.amount_in_words;
    document.getElementById('preview-created').textContent = data.created;
    document.getElementById('preview-purpose').textContent = data.purpose;
    document.getElementById('preview-created-by').textContent = data.created_by;

    const tbody = document.getElementById('preview-details');
    tbody.innerHTML = '';
    const denominations = [100000,50000,20000,10000,5000,1000,500];
    denominations.forEach(denom=>{
        const item = (data.details||[]).find(d=>Number(d.denomination)===denom);
        const qty = item? Number(item.quantity):0;
        const tr = document.createElement('tr');
        tr.innerHTML = `<td class="border px-2 py-1">${denom.toLocaleString()}</td>
            <td class="border px-2 py-1 flex justify-center items-center gap-2">
                <button class="qty-btn" data-action="decrease">-</button>
                <input type="number" value="${qty}" min="0" class="w-14 text-center border rounded"/>
                <button class="qty-btn" data-action="increase">+</button>
            </td>`;
        tbody.appendChild(tr);
    });

    updateDenomTotal();
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

    // Preview button click
    document.querySelectorAll('.preview-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const details = JSON.parse(btn.dataset.details || '[]');
            openPreview({
                id: btn.dataset.id,
                from: btn.dataset.from,
                to: btn.dataset.to,
                amount: btn.dataset.amount,
                amount_in_words: btn.dataset.amount_in_words,

                created: btn.dataset.created,
                purpose: btn.dataset.purpose || '-',
                status: btn.dataset.status || '-',
                created_by: btn.dataset.created_by || '-',
                details: details
            });
        });
    });

    // Close modal
    closeBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    // Close modal on background click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });
});
// Quantity button click handling
document.getElementById('preview-details').addEventListener('click', function(e) {
    if (e.target.classList.contains('qty-btn')) {
        const input = e.target.parentElement.querySelector('input');
        let value = Number(input.value);
        if (e.target.dataset.action === 'increase') value++;
        if (e.target.dataset.action === 'decrease' && value > 0) value--;
        input.value = value;
        updateDenomTotal();
    }
});

document.getElementById('preview-details').addEventListener('input', function(e) {
    if (e.target.tagName === 'INPUT') {
        if (Number(e.target.value) < 0) e.target.value = 0;
        updateDenomTotal();
    }
});



// Recalculate total function
function updateDenomTotal() {
    let total = 0;
    const rows = document.querySelectorAll('#preview-details tr');

    rows.forEach(row => {
        const denom = Number(row.cells[0].textContent.replace(/,/g, ''));
        const input = row.querySelector('input');
        let qty = input ? Number(input.value) : 0;
        let lineTotal = denom * qty;

        // Check if adding this line exceeds original amount
        if (total + lineTotal > originalAmount) {
            qty = Math.floor((originalAmount - total) / denom);
            lineTotal = denom * qty;
            if (input) input.value = qty; // update input
        }

        total += lineTotal;
    });

    document.getElementById('preview-total').textContent = `₭${total.toLocaleString()}`;
}


// for export
function prepareForExport() {
    const rows = document.querySelectorAll('#preview-details tr');
    rows.forEach(row => {
        const input = row.querySelector('input[type="number"]');
        if (input) {
            // Replace input with span showing the value
            const span = document.createElement('span');
            span.textContent = input.value;
            span.style.display = 'inline-block';
            span.style.textAlign = 'center';
            input.parentElement.replaceChild(span, input);
        }

        // Remove +/- buttons
        row.querySelectorAll('.qty-btn').forEach(btn => btn.remove());
    });
}

// After export, reload modal to restore inputs
function restoreModal() {
    location.reload();
}

// Export PDF
document.getElementById('exportPDF').addEventListener('click', async () => {
    prepareForExport();

    const { jsPDF } = window.jspdf;
    const content = document.getElementById('exportContent');
    const canvas = await html2canvas(content, { scale: 2 });
    const imgData = canvas.toDataURL('image/png');

    const pdf = new jsPDF({ orientation: 'portrait', unit: 'pt', format: 'a4' });
    const imgProps = pdf.getImageProperties(imgData);
    const pdfWidth = pdf.internal.pageSize.getWidth();
    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

    pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
    pdf.save(`VaultMovement_${document.getElementById('preview-id').textContent}.pdf`);

    restoreModal();
});

// Export Word
document.getElementById('exportWord').addEventListener('click', () => {
    prepareForExport();

    const content = document.getElementById('exportContent').innerHTML;
    const blob = new Blob(['<html><head><meta charset="UTF-8"></head><body>' + content + '</body></html>'], {
        type: 'application/msword'
    });
    saveAs(blob, `VaultMovement_${document.getElementById('preview-id').textContent}.doc`);

    restoreModal();
});

// Export Excel
document.getElementById('exportExcel').addEventListener('click', () => {
    prepareForExport();

    const table = document.querySelector('#exportContent #preview-details');
    const wb = XLSX.utils.table_to_book(table, { sheet: 'Sheet1' });
    XLSX.writeFile(wb, `VaultMovement_${document.getElementById('preview-id').textContent}.xlsx`);

    restoreModal();
});

// Print
document.getElementById('printPreview').addEventListener('click', function () {
    prepareForExport();
    window.print();
    restoreModal();
});

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cash_center_v3\resources\views/vault-movements/index.blade.php ENDPATH**/ ?>