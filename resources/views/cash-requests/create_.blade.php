{{-- resources/views/cash_requests/create.blade.php --}}
@extends('layouts.app')

 <script src="https://resource.trickle.so/vendor_lib/unpkg/react@18/umd/react.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/react-dom@18/umd/react-dom.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/@babel/standalone/babel.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    <link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;500;600;700&display=swap" rel="stylesheet">
     
@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow-lg border">
    <h2 class="text-center font-bold text-lg mb-4">ໃບຂໍເງິນສົດ</h2>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <p>ວັນທີ: .....................</p>
        </div>
        <div class="text-right">
            <p>ລົງວັນທີ: ............/........../..........</p>
        </div>
    </div>

    <div class="mb-4">
        <p>ຊື່ຜູ້ຂໍ: ....................................</p>
        <p>ພາລະກິດ: ....................................</p>
    </div>

    <table class="w-full border border-gray-300 mb-4 text-sm">
        <thead class="bg-yellow-200">
            <tr>
                <th class="border px-2 py-1 text-left">ລາຍລະອຽດ / Detail's</th>
                <th class="border px-2 py-1">ຈຳນວນ (₭)</th>
                <th class="border px-2 py-1">ເພີ່ມຈຳນວນ</th>
            </tr>
        </thead>
        <tbody>
            @php
                $denominations = [100000,50000,20000,10000,5000,2000,1000,500];
            @endphp
            @foreach($denominations as $denom)
            <tr>
                <td class="border px-2 py-1">..............................................</td>
                <td class="border px-2 py-1 text-right">{{ number_format($denom) }}</td>
                <td class="border px-2 py-1">
                    <input type="number" name="quantity[{{ $denom }}]" class="w-full border rounded px-2 py-1" min="0">
                </td>
            </tr>
            @endforeach
            <tr class="font-bold">
                <td class="border px-2 py-1 text-right" colspan="2">ລວມ / Total:</td>
                <td class="border px-2 py-1">
                    <input type="text" name="total" class="w-full border rounded px-2 py-1" readonly>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="flex justify-between mt-6 text-sm">
        <div>ຜູ້ຮັບ / Receiver</div>
        <div>ຜູ້ອອກໃບ / Issuer</div>
        <div>ຜູ້ອະນຸມັດ / Approver</div>
    </div>
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
@endsection
