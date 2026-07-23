<?php $__env->startSection('content'); ?>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Noto Sans Lao', sans-serif; }
    .denom-table { width:100%; border-collapse:collapse; margin:0 auto }
    .denom-table th, .denom-table td { border:1px solid #111; padding:6px; text-align:center }
    .denom-table thead th { background:#f6d365; font-weight:700 }
    .text-right { text-align:right }
    @media print {
        .no-print { display:none }
        .denom-table { font-size:12px }
    }
    .small { font-size:12px }
</style>

<div class="container mx-auto p-4">
    <div class="text-center mb-2">
        <h3 class="font-bold">ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</h3>
        <img src="/mnt/data/bcd0192d-8edd-4de6-a2b4-6e1a7cbfe3a0.png" alt="logo" style="height:48px; display:block; margin:6px auto">
        <h4 id="title" class="font-bold">ລາຍງານນັບທະນະບັດ (Denomination) — ສະກຸນ: ກີບ</h4>
        <p class="small">ປະຈຳວັນທີ: <?php echo e(date('d/m/Y')); ?></p>
    </div>

    <div class="mb-3 no-print flex gap-3 items-end">
        <select id="userSelect" class="border px-2 py-1 rounded">
            <option value="all">ທຸກຜູ້ໃຊ້</option>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($user->id); ?>"><?php echo e($user->full_name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <select id="period" class="border px-2 py-1 rounded">
            <option value="today">ມື້ນີ້</option>
            <option value="7days">7 ມື້</option>
            <option value="30days">30 ມື້</option>
            <option value="custom">ກຳນົດເອງ</option>
        </select>

        <input type="date" id="fromDate" class="border px-2 py-1 rounded hidden">
        <input type="date" id="toDate" class="border px-2 py-1 rounded hidden">

        <button id="loadReport" class="px-4 py-2 border rounded no-print">ໂຫຼດ</button>
        <button id="openPreview" class="px-4 py-2 bg-blue-600 text-white rounded no-print">ສະແດງ</button>
    </div>

    <table class="denom-table">
        <thead>
            <tr>
                <th>ລ/ດ</th>
                <th>ປະເພດເງິນ</th>
                <th>ຈຳນວນໃບ (ກັກຢູ່)</th>
                <th>ຈຳນວນໃບ (ຮັບມາ)</th>
                <th>ຈຳນວນໃບ (ຈ່າຍອອກ)</th>
                <th>ຈຳນວນໂດລ່າ</th>
                <th>ຍອດຍັງເຫຼືອ</th>
            </tr>
        </thead>
        <tbody id="denomBody">
            <tr><td colspan="7" class="small text-center">ບໍ່ມີຂໍ້ມູນ</td></tr>
        </tbody>
        <tfoot id="denomFoot"></tfoot>
    </table>

</div>

<!-- Preview modal simple -->
<div id="previewModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-start pt-8">
    <div class="bg-white p-4 rounded w-[90%] max-w-4xl overflow-auto">
        <button id="closePreview" class="float-right">&times;</button>
        <div id="previewArea"></div>
        <div class="mt-2 text-right">
            <button id="doPrint" class="px-3 py-1 border rounded">ພິມ</button>
        </div>
    </div>
</div>

<script>
const DENOMS = [100000,50000,20000,10000,5000,2000,1000,500];

function format(n){ return (Number(n)||0).toLocaleString(); }

function renderDenom(data){
    const body = document.getElementById('denomBody');
    const foot = document.getElementById('denomFoot');
    body.innerHTML=''; foot.innerHTML='';

    let totalKeep=0, totalReceive=0, totalPay=0, totalLeft=0;

    DENOMS.forEach((d,idx)=>{
        const keep = (data.keep && data.keep[d])||0;
        const receive = (data.receive && data.receive[d])||0;
        const pay = (data.pay && data.pay[d])||0;
        const denomTotal = d * (keep + receive - pay);
        const left = denomTotal; // depending on your logic

        totalKeep += d*keep;
        totalReceive += d*receive;
        totalPay += d*pay;
        totalLeft += left;

        const tr = `<tr>
            <td>${idx+1}</td>
            <td>${d.toLocaleString()}</td>
            <td class="text-right">${format(keep)}</td>
            <td class="text-right">${format(receive)}</td>
            <td class="text-right">${format(pay)}</td>
            <td class="text-right">${format(d)}</td>
            <td class="text-right">${format(left)}</td>
        </tr>`;
        body.insertAdjacentHTML('beforeend', tr);
    });

    foot.innerHTML = `
        <tr class="font-bold bg-gray-100">
            <td colspan="2" class="text-right">ລວມ</td>
            <td class="text-right">${format(totalKeep/1)}</td>
            <td class="text-right">${format(totalReceive/1)}</td>
            <td class="text-right">${format(totalPay/1)}</td>
            <td></td>
            <td class="text-right">${format(totalLeft)}</td>
        </tr>
    `;
}

async function loadReport(){
    const userId = document.getElementById('userSelect').value;
    const period = document.getElementById('period').value;
    let url = `<?php echo e(route('reports.denomination.data')); ?>`;
    url += `?period=${period}`;
    if(userId && userId!=='all') url += `&user_id=${userId}`;

    try{
        const res = await fetch(url, { credentials:'same-origin' });
        const json = await res.json();
        renderDenom(json);
    }catch(e){
        console.error(e);
        document.getElementById('denomBody').innerHTML = '<tr><td colspan="7">ຜິດພາດໃນການໂຫຼດ</td></tr>';
    }
}

document.getElementById('loadReport').addEventListener('click', loadReport);
document.getElementById('openPreview').addEventListener('click', ()=>{
    const preview = document.getElementById('previewModal');
    const html = document.querySelector('.container').innerHTML;
    document.getElementById('previewArea').innerHTML = html;
    preview.classList.remove('hidden');
});
document.getElementById('closePreview').addEventListener('click', ()=>document.getElementById('previewModal').classList.add('hidden'));
document.getElementById('doPrint').addEventListener('click', ()=>{
    const printWindow = window.open('','_blank');
    printWindow.document.write('<html><head><title>Print</title>');
    printWindow.document.write('<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;600&display=swap" rel="stylesheet">');
    printWindow.document.write('<style>body{font-family: "Noto Sans Lao", sans-serif;}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(document.getElementById('previewArea').innerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
});

// initial sample
renderDenom({
    keep: {100000:245,50000:50,20000:75,10000:52,5000:32,2000:20,1000:62,500:21},
    receive: {100000:100,50000:200},
    pay: {100000:15}
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cash_center_v3\resources\views/reports/denomination.blade.php ENDPATH**/ ?>