@extends('layouts.app')
    <script src="https://resource.trickle.so/vendor_lib/unpkg/react@18/umd/react.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/react-dom@18/umd/react-dom.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/@babel/standalone/babel.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    <link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;500;600;700&display=swap" rel="stylesheet">

 
@section('content')
   

<div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ isset($user) ? 'Edit User' : 'ເພີ່ມຜູ້ໃຊ້' }}</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}" method="POST" class="space-y-4">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif

        <!-- Full Name -->
        <div>
            <label class="form-label">ຊື້ຜູ້ໃຊ້</label>
            <input type="text" name="full_name" class="input-field" value="{{ old('full_name', $user->full_name ?? '') }}" required>
        </div>

        <!-- Username -->
        <div>
            <label class="form-label">ຜູ້ໃຊ້</label>
            <input type="text" name="username" class="input-field" value="{{ old('username', $user->username ?? '') }}" required>
        </div>

        <!-- Password -->
        <div>
            <label class="form-label">ລະຫັດຜ່ານ {{ isset($user) ? '(Leave blank to keep current)' : '' }}</label>
            <input type="password" name="password" class="input-field" {{ isset($user) ? '' : 'required' }}>
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="form-label">ຢືນຢັນລະຫັດຜ່ານ</label>
            <input type="password" name="password_confirmation" class="input-field" {{ isset($user) ? '' : 'required' }}>
        </div>

        <!-- Role -->
        <div>
            <label class="form-label">ສິດ</label>
            <select name="role_id" class="input-field" required>
                <option value="">Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->role_id }}" {{ (old('role_id', $user->role_id ?? '') == $role->role_id) ? 'selected' : '' }}>{{ $role->role_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Status -->
        <div>
            <label class="form-label">ສະຖານະ</label>
            <select name="is_active" class="input-field" required>
                <option value="1" {{ (old('is_active', $user->is_active ?? 1) == 1) ? 'selected' : '' }}>Active</option>
                <option value="0" {{ (old('is_active', $user->is_active ?? 1) == 0) ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="flex space-x-4 mt-4">
            <button type="submit" class="btn-primary">{{ isset($user) ? 'Update' : 'Create' }}</button>
            <a href="{{ route('users.index') }}" class="btn-secondary">ຍົກເລີກ</a>
        </div>


    </form>
</div>

@endsection
