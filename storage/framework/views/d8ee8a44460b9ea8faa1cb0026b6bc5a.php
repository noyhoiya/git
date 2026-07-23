
<?php $__env->startSection('content'); ?>
<!-- Tailwind and other scripts -->
<script src="https://resource.trickle.so/vendor_lib/unpkg/react@18/umd/react.production.min.js"></script>
<script src="https://resource.trickle.so/vendor_lib/unpkg/react-dom@18/umd/react-dom.production.min.js"></script>
<script src="https://resource.trickle.so/vendor_lib/unpkg/@babel/standalone/babel.min.js"></script>
<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.jsx']); ?>
<link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;500;600;700&display=swap" rel="stylesheet">

<div class="container py-4">
    <!-- Header Section -->
    <div id="reportHeader" class="text-center mb-6">
        <h4 class="text-lg mt-1">
        </h4>
        <!-- <img src="<?php echo e(asset('assets/image/logo_r.png')); ?>" alt="SSB Logo" class="h-10 w-auto block"> -->
        <!-- 🔹 ID added -->
        <!-- 🔹 ID added -->
        <h2 class="text-lg font-bold mt-2"><span id="tellerTitle">ທຸກຜູ້ໃຊ້</span>(ກີບ)</h2>

        <p class="text-sm">ປະຈຳວັນທີ: <?php echo e(date('d/m/Y')); ?></p>
    </div>

    <!-- User & Period Selection -->
    <div class="flex gap-4 mb-3 items-end">

        <!-- User Select -->
        <div>
            <label for="userSelect" class="form-label">ເລືອກຜູ້ໃຊ້</label>
            <select id="userSelect" class="form-select w-48">
                <option value="all">ທຸກຜູ້ໃຊ້</option>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->full_name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- Period Select -->
        <div>
            <label for="period" class="form-label">ເລືອກໄລຍະເວລາ</label>
            <select id="period" class="form-select w-48">
            <option value="today">ມື້ນີ້</option>
            <option value="7days">7 ມື້ຜ່ານມາ</option>
            <option value="30days">30 ມື້ຜ່ານມາ</option>
            <option value="custom">ກຳນົດເອງ</option>
            </select>
        </div>

        <!-- Custom Dates -->
        <div id="customDates" class="hidden flex gap-2">
            <div>
                <label for="fromDate" class="form-label">ແຕ່ວັນທີ</label>
                <input type="date" id="fromDate" class="form-input border px-2 py-1 rounded">
            </div>
            <div>
                <label for="toDate" class="form-label">ຫາວັນທີ</label>
                <input type="date" id="toDate" class="form-input border px-2 py-1 rounded">
            </div>
        </div>

        <!-- Buttons -->
        <button id="loadReport" 
    class="flex items-center gap-2 px-4 py-2 rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-color">
    
    <!-- Reload Icon -->
    <svg id="reloadIcon" xmlns="http://www.w3.org/2000/svg" 
         fill="none" viewBox="0 0 24 24" 
         stroke-width="2" stroke="currentColor" 
         class="w-5 h-5">
      <path stroke-linecap="round" stroke-linejoin="round" 
            d="M16.023 9.348h4.992V4.356m0 0l-2.829 2.829A9.003 9.003 0 003.75 12c0 4.97 4.03 9 
               9 9a9.003 9.003 0 008.485-6.172m-1.462-3.181A9.003 9.003 0 0112 21" />
    </svg>

    ຣີໂຫຼດລາຍງານ
</button>

<script>
document.getElementById('loadReport').addEventListener('click', () => {
    const icon = document.getElementById('reloadIcon');
    icon.classList.add('animate-spin');

    // ຫຸ້ນຫມຸນ 2 ວິນາທີແລ້ວຢຸດ
    setTimeout(() => {
        icon.classList.remove('animate-spin');
    }, 2000);
});

</script>



        <button id="printPreview" class="btn btn-primary h-10 rounded-full">ສະແດງ</button>
    </div>

    <!-- Report Table -->
    <table class="table table-bordered w-full border-collapse border-black justify-center text-center">
        <thead class="bg-yellow-300 ">
            <tr>
                <th>ລຳດັບ</th>
                <th>ຈາກ</th>
                <th>ຫາ</th>
                <th>ເນື້ອໃນລາຍການ</th>
                <th>ໜີ້(ຮັບ)</th>
                <th>ມີ(ຈ່າຍ)</th>
                <th>ຍອດເຫຼືອໜີ້</th>
            </tr>
        </thead>
        <tbody id="reportTable">
            <tr><td colspan="8" class="text-center py-1">ບໍ່ມີລາຍການ</td></tr>
        </tbody>
    </table>
</div>

<!-- Print Preview Modal -->
<div id="previewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-start pt-10 z-50 text-sm ">
    <div class="bg-white rounded-lg w-[90%] max-w-6xl p-6 relative shadow-lg">
        <button id="closePreview" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
        <div class="text-center mb-6">
            <h4 class=" mt-1 text-sm ">
                ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ<br>
                ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ
            </h4>
            <img src="<?php echo e(asset('assets/image/logo_r.png')); ?>" alt="SSB Logo" class="h-12 w-auto block">
            <!-- 🔹 ID added -->
            <!-- Print Preview Modal -->
            <h2 class="text-lg font-bold mt-2"><span id="previewTellerTitle">ທຸກຜູ້ໃຊ້</span>(ກີບ)</h2>

            <p class="text-sm">ປະຈຳວັນທີ: <?php echo e(date('d/m/Y')); ?></p>
            <div id="previewContent" class="overflow-x-auto max-h-[70vh]"></div>
            <button id="doPrint" class="btn btn-primary mt-4">ພິມ</button>
        </div>
    </div>
</div>

<script>
const periodSelect = document.getElementById('period');
const customDates = document.getElementById('customDates');
const userSelect = document.getElementById('userSelect');
const loadReportBtn = document.getElementById('loadReport');
const tellerTitle = document.getElementById('tellerTitle');
const previewTellerTitle = document.getElementById('previewTellerTitle');

// Show/hide custom date inputs
periodSelect.addEventListener('change', function() {
    customDates.classList.toggle('hidden', this.value !== 'custom');
});

// Update header title when user changes
userSelect.addEventListener('change', function() {
    const selectedText = userSelect.options[userSelect.selectedIndex].text;
    tellerTitle.textContent = userSelect.value === "all" ? "ທຸກຜູ້ໃຊ້" : selectedText;
    previewTellerTitle.textContent = userSelect.value === "all" ? "ທຸກຜູ້ໃຊ້" : selectedText;
    loadReport(); // auto-refresh
});
// open modal example
function openPreview() {
  document.getElementById('previewModal').classList.remove('hidden');
}

// close modal
document.getElementById('closePreview').addEventListener('click', function() {
  document.getElementById('previewModal').classList.add('hidden');
});

// optional: click outside to close
document.getElementById('previewModal').addEventListener('click', function(e) {
  if (e.target === this) this.classList.add('hidden');
});

function loadReport() {
    const period = periodSelect.value;
    const from = document.getElementById('fromDate').value;
    const to = document.getElementById('toDate').value;
    const userId = userSelect.value;
    const tableBody = document.getElementById('reportTable');

    // Show loading message
    tableBody.innerHTML = '<tr><td colspan="8" class="text-center py-1">ກຳລັງໂຫຼດ...</td></tr>';

    // Build URL
    let url = `<?php echo e(route('reports.cashFlow')); ?>?period=${period}`;
    if (period === 'custom' && from && to) url += `&from=${from}&to=${to}`;
    if (userId && userId !== 'all') url += `&user_id=${userId}`;

    fetch(url, { credentials: 'same-origin' })
        .then(res => res.json())
        .then(data => {
            tableBody.innerHTML = '';

            const transactions = data.transactions || [];
            const lastTotal = parseFloat(data.previous_total || 0);

            // If no transactions found
            if (!transactions.length) {
                tableBody.innerHTML = `
                    <tr><td colspan="8" class="text-center py-1">ບໍ່ມີລາຍການ</td></tr>
                    <tr class="font-bold bg-gray-100">
                        <td colspan="6" class="text-right">ຍອດຍົກມາ</td>
                        <td class="text-right">${lastTotal.toLocaleString()}</td>
                    </tr>
                `;
                tableBody.dataset.lastTotal = lastTotal;
                tableBody.dataset.finalTotal = lastTotal;
                return;
            }

            // Totals
            let totalWithdraw = 0;
            let totalHandover = 0;
            let currentBalance = lastTotal;
            let rows = '';

            // Add row for previous total
            rows += `
                <tr class=" font-bold bg-gray-50 text-gray-700 underline">
                    <td colspan="3"></td>
                    <td colspan="" class="text-right">ຍອດຍົກມາແຕ່ມື້ກ່ອນ</td>
                    <td colspan="1"></td>
                    <td colspan="1"></td>
                    <td class="text-right  ">${lastTotal.toLocaleString()}</td>

                </tr>
            `;

            // Loop through transactions
            transactions.forEach((item, index) => {
                const withdrawAmount = item.type === 'WITHDRAWAL' ? parseFloat(item.amount_cents) : 0;
                const handoverAmount = item.type === 'HANDOVER' ? parseFloat(item.amount_cents) : 0;

                totalWithdraw += withdrawAmount;
                totalHandover += handoverAmount;

                // Balance calculation (from start of period)
                currentBalance = lastTotal + totalWithdraw - totalHandover;
                totalBalance = lastTotal + currentBalance ;

                rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.from_vault?.vault_name ?? '-'}</td>
                        <td>${item.to_vault?.vault_name ?? '-'}</td>
                        <td>${item.purpose?.purpose_name ?? '-'}</td>
                        <td class="text-right">${withdrawAmount.toLocaleString()}</td>
                        <td class="text-right">${handoverAmount.toLocaleString()}</td>
                        <td class="text-right">${currentBalance.toLocaleString()}</td>
                    </tr>
                `;
            });

            // Summary row
            rows += `
                <tr class="font-bold bg-gray-100">
                    <td colspan="3"></td>
                    <td class="text-right">ລວມຍອດການເຄື່ອນໄຫວ</td>
                    <td class="text-right">${totalWithdraw.toLocaleString()}</td>
                    <td class="text-right">${totalHandover.toLocaleString()}</td>
                    <td class="text-right">${currentBalance.toLocaleString()}</td>
                </tr>
            `;

            tableBody.innerHTML = rows;
            tableBody.dataset.lastTotal = lastTotal;
            tableBody.dataset.finalTotal = currentBalance;
        })
        .catch(err => {
            console.error(err);
            tableBody.innerHTML = '<tr><td colspan="8" class="text-center py-1 text-red-500">ຜິດພາດໃນການໂຫຼດຂໍ້ມູນ</td></tr>';
        });
}

// Event listeners
loadReportBtn.addEventListener('click', loadReport);
periodSelect.addEventListener('change', loadReport);

// 🔹 Print Preview Section
document.getElementById('printPreview').addEventListener('click', function() {
    const table = document.getElementById('reportTable');
    const headers = document.querySelector('table thead').innerHTML;

    const lastTotal = parseFloat(table.dataset.lastTotal || 0);
    const finalTotal = parseFloat(table.dataset.finalTotal || 0);

    let tableContent = table.innerHTML;
    tableContent += `
        <tr class="font-bold text-sm bg-gray-100">
            <td colspan="3"></td>
            <td colspan="3" class="text-right">ລວມຍອດຍົກມາແຕ່ມື້ກ່ອນ</td>\
            <td class="text-right">${lastTotal.toLocaleString()}</td>
        </tr>
        <tr class="font-bold text-sm bg-gray-100">
            <td colspan="3"></td>
            <td colspan="3" class="text-right">ລວມເຫຼືອທ້າຍ</td>
            <td class="text-right">${finalTotal.toLocaleString()}</td>
        </tr>
    `;

    document.getElementById('previewContent').innerHTML = `
        <table class="table table-bordered w-full border-collapse">
            <thead class="bg-yellow-300">${headers}</thead>
            <tbody>${tableContent}</tbody>
        </table>
    `;

    document.getElementById('previewModal').classList.remove('hidden');
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cash_center_v3\resources\views/reports/reports.blade.php ENDPATH**/ ?>