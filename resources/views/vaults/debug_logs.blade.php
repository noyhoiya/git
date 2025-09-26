@extends('layouts.app')

@section('content')
<script src="https://resource.trickle.so/vendor_lib/unpkg/react@18/umd/react.production.min.js"></script>
<script src="https://resource.trickle.so/vendor_lib/unpkg/react-dom@18/umd/react-dom.production.min.js"></script>
<script src="https://resource.trickle.so/vendor_lib/unpkg/@babel/standalone/babel.min.js"></script>
@vite(['resources/css/app.css', 'resources/js/app.jsx'])
<link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;500;600;700&display=swap" rel="stylesheet">


<div class="container mx-auto px-4 py-10">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Transaction Debug Logs</h2>

    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full border-collapse bg-white text-sm">
            <thead class="bg-[var(--primary-color)] text-white">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">From Vault</th>
                    <th class="px-4 py-3 text-left">To Vault</th>
                    <th class="px-4 py-3 text-right">Amount</th>
                    <th class="px-4 py-3 text-right">From Before</th>
                    <th class="px-4 py-3 text-right">From After</th>
                    <th class="px-4 py-3 text-right">To Before</th>
                    <th class="px-4 py-3 text-right">To After</th>
                    <th class="px-4 py-3 text-left">User</th>
                    <th class="px-4 py-3 text-center">Duplicate?</th>
                    <th class="px-4 py-3 text-center">Negative?</th>
                    <th class="px-4 py-3 text-left">Created</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($logs as $log)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">{{ $log->id }}</td>
                    <td class="px-4 py-3">{{ $log->from_vault_id }}</td>
                    <td class="px-4 py-3">{{ $log->to_vault_id }}</td>
                    <td class="px-4 py-3 text-right font-medium text-gray-700">{{ number_format($log->amount) }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($log->balance_from_before) }}</td>
                    <td class="px-4 py-3 text-right {{ $log->balance_from_after < 0 ? 'text-red-600 font-bold' : '' }}">
                        {{ number_format($log->balance_from_after) }}
                    </td>
                    <td class="px-4 py-3 text-right">{{ number_format($log->balance_to_before) }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($log->balance_to_after) }}</td>
                    <td class="px-4 py-3">{{ $log->user_id }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $log->is_duplicate ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                            {{ $log->is_duplicate ? 'Yes' : 'No' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $log->is_negative ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                            {{ $log->is_negative ? 'Yes' : 'No' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $log->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection