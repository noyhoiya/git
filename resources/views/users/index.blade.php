@extends('layouts.app')
<script src="https://resource.trickle.so/vendor_lib/unpkg/react@18/umd/react.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/react-dom@18/umd/react-dom.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/@babel/standalone/babel.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;500;600;700&display=swap" rel="stylesheet">
@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">ຈັດການຜູ້ໃຊ້</h2>

    <!-- Add New User Button -->
    <div class="mb-6">
        <a href="{{ route('users.create') }}" class="btn-primary">
            + ເພີ່ມຜູ້ໃຊ້ໃໝ່
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-gSSSSreen-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Users Table -->
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ລະຫັດ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ຊື່ຜູ້ໃຊ້</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ຜູ້ໃຊ້</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ສິດ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ສະຖານະ</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">ແກ້ໄຂ</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->user_id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->full_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->username }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->role?->role_name }}</td>
                    <td class="px-6 py-4 text-sm">
                        @if($user->is_active)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                ໃຊ້ງານ
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                ປິດການໃຊ້ງານ
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center text-sm space-x-2">
                        <a href="{{ route('users.edit', $user) }}" class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-sm font-medium">
                            ແກ້ໄຂ
                        </a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium">
                                ລົບ
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
