@extends('layouts.app')

@section('content')
  <script src="https://resource.trickle.so/vendor_lib/unpkg/react@18/umd/react.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/react-dom@18/umd/react-dom.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/@babel/standalone/babel.min.js"></script>
    <link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
 
<div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">ເພີ່ມຜູ້ໃຊ້ໃໝ່</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Full Name -->
        <div>
            <label class="form-label">ຊື້ຜູ້ໃຊ້</label>
            <input type="text" name="full_name" class="input-field" value="{{ old('full_name') }}" required>
        </div>

        <!-- Username -->
        <div>
            <label class="form-label">ຜູ້ໃຊ້</label>
            <input type="text" name="username" class="input-field" value="{{ old('username') }}" required>
        </div>

        <!-- Password -->
        <div>
            <label class="form-label">ລະຫັດ</label>
            <input type="password" name="password" class="input-field" required>
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="form-label">ຢືນຢັນລະຫັດ</label>
            <input type="password" name="password_confirmation" class="input-field" required>
        </div>

        <!-- Role -->
        <div>
            <label class="form-label">ສິດ</label>
            <select name="role_id" class="input-field" required>
                <option value="">ເລືອກສິດ</option>
                @foreach($roles as $role)
                    <option value="{{ $role->role_id }}" {{ old('role_id') == $role->role_id ? 'selected' : '' }}>
                        {{ $role->role_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Status -->
  <div>
    <label class="form-label"></label>
    <select name="is_active" class="hidden" disabled>
        <option value="1" selected>ໃຊ້ງານ</option>
    </select>
    <!-- Send hidden value to backend -->
    <input type="hidden" name="is_active" value="1">
</div>


        <!-- Buttons -->
        <div class="flex space-x-4 mt-6">
            <button type="submit" class="btn-primary">Create</button>
            <a href="{{ route('users.index') }}" class="btn-secondary">ຍົກເລີກ</a>
        </div>
    </form>
</div>
@endsection
