@extends('layouts.app')

@section('content')
  <script src="https://resource.trickle.so/vendor_lib/unpkg/react@18/umd/react.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/react-dom@18/umd/react-dom.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/@babel/standalone/babel.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;500;600;700&display=swap" rel="stylesheet">

 <style type="text/tailwindcss">
@layer theme {
    :root {
        --primary-color: #10b981;        /* Main green */
        --secondary-color: #f0fdf4;      /* Light green background */
        --accent-color: #059669;         /* Darker green for hover */
        --text-primary: #111827;         /* Main text color */
        --text-secondary: #6b7280;       /* Secondary text color */
        --border-color: #e5e7eb;         /* Light border */
        --background-light: #f9fafb;     /* Light background */
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
    }
}

@layer base {
    body {
        font-family: 'Noto Sans Lao', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--text-primary);
        background-color: var(--background-light);
    }
    a {
        text-decoration: none;
    }
}

@layer components {
    /* Buttons */
    .btn-primary {
        @apply bg-[var(--primary-color)] hover:bg-[var(--accent-color)] text-white px-6 py-3 rounded-lg font-medium transition-colors;
    }

    .btn-secondary {
        @apply bg-white hover:bg-gray-50 text-[var(--text-primary)] border border-[var(--border-color)] px-6 py-3 rounded-lg font-medium transition-colors;
    }

    /* Cards */
    .card {
        @apply bg-white rounded-lg shadow-sm border border-[var(--border-color)] p-6;
    }

    .stat-card {
        @apply bg-white rounded-lg shadow-sm border border-[var(--border-color)] p-6 hover:shadow-md transition-shadow cursor-pointer;
    }

    .stat-card-disabled {
        @apply bg-gray-100 rounded-lg shadow-sm border border-[var(--border-color)] p-6 opacity-50 cursor-not-allowed;
    }

    /* Input Fields */
    .input-field {
        @apply w-full px-4 py-3 border border-[var(--border-color)] rounded-lg focus:ring-2 focus:ring-[var(--primary-color)] focus:border-transparent transition;
    }

    /* Labels */
    .form-label {
        @apply block text-sm font-medium text-[var(--text-secondary)] mb-1;
    }

    /* Badge Styles */
    .badge-success {
        @apply px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs font-medium;
    }
    .badge-warning {
        @apply px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-medium;
    }
    .badge-danger {
        @apply px-2 py-1 rounded-full bg-red-100 text-red-800 text-xs font-medium;
    }
}
</style>
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
