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
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">ສ້າງຄຳຮ້ອງຂໍ</h2>

    {{-- Display errors --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Display success --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('cash-requests.store') }}" method="POST">
        @csrf

        {{-- Vault --}}
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">ເລືອກ Vault</label>
            <select name="requester_vault_id" class="w-full border rounded-lg px-3 py-2" required>
            <option value="">-- ເລືອກ Vault --</option>
            @foreach($vaults->where('vault_type', 'MAIN') as $vault)
                <option value="{{ $vault->vault_id }}" {{ old('requester_vault_id') == $vault->vault_id ? 'selected' : '' }}>
                    {{ $vault->vault_name }}
                </option>
            @endforeach
        </select>

        </div>

        {{-- Amount --}}
               <div>
            <label for="amount" class="block text-gray-700 font-medium mb-2">ຈຳນວນເງິນ</label>
            <input type="number" step="0.01" name="amount" id="amount"
                value="{{ old('amount') }}"
                min="0.01" required
                class="input-field"
                onblur="this.value = parseFloat(this.value).toFixed(2)">
            </div>

        {{-- Amount in words --}}
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">ຈຳນວນເງິນເປັນຕົວໜັງສື</label>
            <input type="text" name="amount_in_words" value="{{ old('amount_in_words') }}" class="w-full border rounded-lg px-3 py-2" required>
        </div>

        {{-- Purpose --}}
       <div class="mb-4">
    <label class="block text-gray-700 mb-2">ຈຸດປະສົງ</label>
   <select name="purpose_code" class="w-full border rounded-lg px-3 py-2">
    <option value="">-- ເລືອກຈຸດປະສົງ --</option>
    @foreach($purposes as $purpose)
        <option value="{{ $purpose->purpose_code }}" {{ old('purpose_code') == $purpose->purpose_code ? 'selected' : '' }}>
            {{ $purpose->purpose_name }}
        </option>
    @endforeach
</select>

</div>


        {{-- Notes --}}
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">ຫມາຍເຫດ</label>
            <textarea name="notes" class="w-full border rounded-lg px-3 py-2">{{ old('notes') }}</textarea>
        </div>
{{-- Denominations --}}
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
            {{-- Dropdown for denomination --}}
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
    <a href="{{ url()->previous() }}" 
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
@endsection
