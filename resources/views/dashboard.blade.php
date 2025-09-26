@extends('layouts.app')

@section('title', 'ໜ້າຫຼັກ - ສູນການເງິນ')
<script src="https://resource.trickle.so/vendor_lib/unpkg/react@18/umd/react.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/react-dom@18/umd/react-dom.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/@babel/standalone/babel.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;500;600;700&display=swap" rel="stylesheet">
    
@section('content')

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
             <a href="{{ route('reports') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                {{-- <a href="{{ route('reports') }}" class="nav-link">Reports</a> --}}

                ລາຍງານ
            </a>
        </div>
    </div>
    
  <!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

   <!-- Vault Card -->
<a href="{{ route('vaults.index') }}" class="block">
    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">ຄັງເງິນ</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_vaults'] }}</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                <div class="icon-vault text-xl text-green-600"></div>
            </div>
        </div>
    </div>
</a>


    <!-- Pending Requests Card -->
    @php
        $isAllowed = in_array(optional(Auth::user())->role_id, [1,3,5]);
    @endphp

    <div class="{{ $isAllowed ? '' : 'opacity-50 cursor-not-allowed bg-gray-100' }} rounded-lg shadow">
        @if($isAllowed)
            <a href="/cash-requests" class="block p-6 hover:shadow-lg transition-shadow">
        @else
            <div class="p-6">
        @endif
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">ຄຳຂໍລໍຖ້າ</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_requests'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                    <div class="icon-clock text-xl text-yellow-600"></div>
                </div>
            </div>
        @if($isAllowed)
            </a>
        @else
            </div>
        @endif
    </div>

    <!-- Recent Movements Card -->
    <div class="{{ $isAllowed ? '' : 'opacity-50 cursor-not-allowed bg-gray-100' }} rounded-lg shadow">
        @if($isAllowed)
            <a href="{{ route('vault-movements.index') }}" class="block p-6 hover:shadow-lg transition-shadow">
        @else
            <div class="p-6">
        @endif
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">{{ $isAllowed ? 'ການເຄື່ອນໄຫວລໍຖ້າ' : 'ການເຄື່ອນໄຫວທັງໝົດ' }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['recent_movements'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <div class="icon-arrow-right-left text-xl text-blue-600"></div>
                </div>
            </div>
        @if($isAllowed)
            </a>
        @else
            </div>
        @endif
    </div>

    <!-- Users Card -->
    <div class="{{ $isAllowed ? '' : 'opacity-50 cursor-not-allowed bg-gray-100' }} rounded-lg shadow">
        @if($isAllowed)
            <a href="{{ route('users.index') }}" class="block p-6 hover:shadow-lg transition-shadow">
        @else
            <div class="p-6">
        @endif
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">ຜູ້ໃຊ້ງານ</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_users'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                    <div class="icon-users text-xl text-purple-600"></div>
                </div>
            </div>
        @if($isAllowed)
            </a>
        @else
            </div>
        @endif
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
            @forelse($recentRequests as $request)
                <div class="flex items-center justify-between py-3 border-b last:border-b-0">
                    <div>
                        <p class="font-medium">{{ $request->requesterUser->full_name }}</p>
                        <p class="text-sm text-gray-600">₭{{ number_format($request->amount_cents / 100, 2) }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full 
                        @if($request->status === 'PENDING') bg-yellow-100 text-yellow-800
                        @elseif($request->status === 'APPROVED') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        @if($request->status === 'PENDING') ລໍຖ້າ
                        @elseif($request->status === 'APPROVED') ອະນຸມັດ
                        @elseif($request->status === 'REJECTED') ປະຕິເສດ
                        @else {{ $request->status }} @endif
                    </span>
                </div>
            @empty
                <p class="text-gray-500">ບໍ່ມີຄຳຂໍລ່າສຸດ</p>
            @endforelse
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
            @forelse($recentMovements as $movement)
                <div class="flex items-center justify-between py-3 border-b last:border-b-0">
                    <div>
                        <p class="font-medium">{{ $movement->fromVault->vault_name }} → {{ $movement->toVault->vault_name }}</p>
                        <p class="text-sm text-gray-600">₭{{ number_format($movement->amount_cents / 100, 2) }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                        @if($movement->status === 'POSTED') ລົງບັນທຶກ
                        @elseif($movement->status === 'DRAFT') ແບບຮ່າງ
                        @else {{ $movement->status }} @endif
                    </span>
                </div>
            @empty
                <p class="text-gray-500">ບໍ່ມີການເຄື່ອນໄຫວລ່າສຸດ</p>
            @endforelse
        </div>
    </div>

<div class="container mt-4">

    {{-- Display Cash Request Alert --}}
    @if(session('cash_request_alert'))
        @php $request = session('cash_request_alert'); @endphp
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ $request->requesterUser->name }} requested {{ number_format($request->amount, 2) }}
            from {{ $request->requesterVault->name ?? 'a vault' }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row mb-4">
        <!-- your existing stats cards here -->
    </div>

    {{-- Recent Requests and Movements Tables --}}
    <!-- your existing tables here -->

</div>



@endsection