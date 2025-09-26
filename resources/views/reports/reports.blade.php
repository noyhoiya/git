@extends('layouts.app')
@section('content')
<!-- Tailwind and other scripts -->
<script src="https://resource.trickle.so/vendor_lib/unpkg/react@18/umd/react.production.min.js"></script>
<script src="https://resource.trickle.so/vendor_lib/unpkg/react-dom@18/umd/react-dom.production.min.js"></script>
<script src="https://resource.trickle.so/vendor_lib/unpkg/@babel/standalone/babel.min.js"></script>
@vite(['resources/css/app.css', 'resources/js/app.jsx'])
<link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;500;600;700&display=swap" rel="stylesheet">



<div class="container py-4">
     <!-- Header Section -->
    <div id="reportHeader" class="text-center mb-6">
        <h4 class="text-lg  mt-1">ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ<br>ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ</h4>
         <img src="{{ asset('assets/image/logo_r.png') }}" alt="SSB Logo" class="h-10 w-auto block">


        <h2 class="text-lg font-bold mt-2">(Teller2)</h2>
        <p class="text-sm">ວັນທີ: {{ date('d/m/Y') }}</p>
    </div>

    <!-- Period Selection & Custom Dates -->
    <div class="flex gap-4 mb-3 items-end">
        <div>
            <label for="period" class="form-label">ເລືອກໄລຍະເວລາ</label>
            <select id="period" class="form-select w-48">
                <option value="7days">7 ມື້ລ່າສຸດ</option>
                <option value="30days">30 ມື້ລ່າສຸດ</option>
                <option value="custom">ກຳນົດເອງ</option>
            </select>
        </div>

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

        <button id="loadReport" class="btn btn-primary h-10">ເບິ່ງລາຍງານ</button>
        <button id="printPreview" class="btn btn-secondary h-10">ເບິ່ງກ່ອນພິມ</button>
    </div>

    <!-- Report Table -->
    <table class="table table-bordered w-full border-collapse">
        <thead class="bg-gray-100">
            <tr>
                <th>ຈາກ</th>
                <th>ຫາ</th>
                <th>ຈູດປະສົງ</th>
                <th>ຈຳນວນ</th>
                <th>ສະຖານະ</th>
                <th>ຜູ້ສ້າງ</th>
                <th>ວັນທີ</th>
            </tr>
        </thead>
        <tbody id="reportTable">
            <tr><td colspan="6" class="text-center py-2">ບໍ່ມີລາຍການ</td></tr>
        </tbody>
    </table>
</div>

<!-- Print Preview Modal -->
<div id="previewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-start pt-10 z-50">
    <div class="bg-white rounded-lg w-[90%] max-w-6xl p-6 relative shadow-lg">
        <button id="closePreview" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
     
        <div class="text-center mb-6">
        <h4  class="text-lg  mt-1">ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ<br>ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ</h4>
         <img src="{{ asset('assets/image/logo_r.png') }}" alt="SSB Logo" class="h-12 w-auto block">


        <h2 class="text-lg font-bold mt-2">(Teller2)</h2>
        <p class="text-sm">ວັນທີ: {{ date('d/m/Y') }}</p>
        <div id="previewContent" class="overflow-x-auto max-h-[70vh]"></div>
        <button id="doPrint" class="btn btn-primary mt-4">ພິມ</button>
    </div>
</div>

<script>
const periodSelect = document.getElementById('period');
const customDates = document.getElementById('customDates');

// Show/hide custom date inputs
periodSelect.addEventListener('change', function() {
    if (this.value === 'custom') {
        customDates.classList.remove('hidden');
    } else {
        customDates.classList.add('hidden');
    }
});

// Load Report via AJAX
document.getElementById('loadReport').addEventListener('click', function() {
    const period = periodSelect.value;
    const from = document.getElementById('fromDate').value;
    const to = document.getElementById('toDate').value;

    let url = `{{ route('reports.cashFlow') }}?period=${period}`;
    if (period === 'custom') {
        url += `&from=${from}&to=${to}`;
    }

    fetch(url, { credentials: 'same-origin' })
        .then(res => res.json())
        .then(data => {
            const tableBody = document.getElementById('reportTable');
            tableBody.innerHTML = '';

            if (!data.length) {
                tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-2">No data available</td></tr>';
                return;
            }

            data.forEach(item => {
                tableBody.innerHTML += `
                    <tr>
                        <td>${item.from_vault?.vault_name ?? '-'}</td>
                        <td>${item.to_vault?.vault_name ?? '-'}</td>
                        <td>${item.purpose?.purpose_name ?? '-'}</td>


                        <td>${item.amount_cents ? (item.amount_cents/100).toLocaleString() : 0} ₭</td>
                        <td>${item.status}</td>
                        <td>${item.created_by_user?.full_name ?? '-'}</td>
                        <td>${item.created_at ? new Date(item.created_at).toLocaleString() : '-'}</td>
                    </tr>
                `;
            });
        })
        .catch(err => {
            console.error(err);
            document.getElementById('reportTable').innerHTML = '<tr><td colspan="6" class="text-center py-2 text-red-500">Error loading data</td></tr>';
        });
});

// Print Preview Modal
document.getElementById('printPreview').addEventListener('click', function() {
    const tableContent = document.getElementById('reportTable').innerHTML;
    const headers = document.querySelector('table thead').innerHTML;

    document.getElementById('previewContent').innerHTML = `
        <table class="table table-bordered w-full border-collapse">
            <thead class="bg-yellow-300">${headers}</thead>
            
            <tbody>${tableContent}</tbody>
        </table>
    `;
    document.getElementById('previewModal').classList.remove('hidden');
});

document.getElementById('closePreview').addEventListener('click', function() {
    document.getElementById('previewModal').classList.add('hidden');
});

document.getElementById('doPrint').addEventListener('click', function() {
    const headerHTML = document.getElementById('reportHeader').innerHTML; // now works
    const tableContent = document.getElementById('reportTable').innerHTML;
    const headers = document.querySelector('table thead').innerHTML;

    const printWindow = window.open('', '', 'width=900,height=600');
    printWindow.document.write(`
        <html>
        <head>
            <title>Cash Flow Report</title>
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
            <style>
                table { border-collapse: collapse; width: 100%; }
                th, td { border: 1px solid #e5e7eb; padding: 0.5rem; text-align: left; }
                thead { background-color: #f3f4f6; }
            </style>
        </head>
        <body class="p-6">
            <div>${headerHTML}</div>
            <table class="mt-4">
                <thead>${headers}</thead>
                <tbody>${tableContent}</tbody>
            </table>
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
});

</script>
@endsection