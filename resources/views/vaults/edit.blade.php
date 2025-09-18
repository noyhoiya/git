@extends('layouts.app')
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
        --primary-color: #10b981;
        --secondary-color: #f0fdf4;
        --accent-color: #059669;
        --text-primary: #111827;
        --text-secondary: #6b7280;
        --border-color: #e5e7eb;
        --background-light: #f9fafb;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
    }
}


     html, body, #app, .card, .stat-card, .modal, #previewModal,#printPreview {
    font-family: 'Noto Sans Lao', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }


@layer components {
    .btn-primary {
        @apply bg-[var(--primary-color)] hover:bg-[var(--accent-color)] text-white px-6 py-3 rounded-lg font-medium transition-colors;
    }
    .btn-secondary {
        @apply bg-white hover:bg-gray-50 text-[var(--text-primary)] border border-[var(--border-color)] px-6 py-3 rounded-lg font-medium transition-colors;
    }
    .card {
        @apply bg-white rounded-lg shadow-sm border border-[var(--border-color)] p-6;
    }
    .stat-card {
        @apply bg-white rounded-lg shadow-sm border border-[var(--border-color)] p-6 hover:shadow-md transition-shadow;
    }
    .input-field {
        @apply w-full px-4 py-3 border border-[var(--border-color)] rounded-lg focus:ring-2 focus:ring-[var(--primary-color)] focus:border-transparent;
    }
}
.lao-font {
  font-family: 'Noto Sans Lao', 'Inter', sans-serif !important;
}
@media print {
  * {
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
    color-adjust: exact !important; /* for older browsers */
  }

  table th,
  table td {
    background-color: inherit !important;
  }


       body * { visibility: hidden; }
    #previewModal, #previewModal * { visibility: visible; }
    #printPreview, #closePreview { display: none !important; }
     #previewModal {
        width: 100%;
        height: auto;
        max-width: 794px; /* A4 width */
        margin: 0 auto;
        background-color: white !important;
    }

    #previewModal table th,
    #previewModal table td {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        background-color: inherit !important;
        color: inherit !important;
    }

    /* Hide floating buttons */
    #printPreview, #closePreview {
        display: none !important;
    }
}

</style>
@section('content')
<div class="container mx-auto py-8 lao-font">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-900">Edit Vault</h1>

        @if ($errors->any())
            <div class="mb-4">
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('vaults.update', $vault) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Vault Name -->
            <div>
                <label for="vault_name" class="block text-sm font-medium text-gray-700 mb-1">Vault Name</label>
                <input type="text" name="vault_name" id="vault_name" 
                    class="input-field w-full" 
                    value="{{ old('vault_name', $vault->vault_name) }}" required>
            </div>

            <!-- Vault Type -->
            <div>
                <label for="vault_type" class="block text-sm font-medium text-gray-700 mb-1">Vault Type</label>
                <select name="vault_type" id="vault_type" class="input-field w-full" required>
                    <option value="MAIN" {{ $vault->vault_type === 'MAIN' ? 'selected' : '' }}>MAIN</option>
                    <option value="SUB" {{ $vault->vault_type === 'SUB' ? 'selected' : '' }}>SUB</option>
                </select>
            </div>

            <!-- Current Balance -->
            {{-- <div>
                <label for="current_balance" class="block text-sm font-medium text-gray-700 mb-1">Current Balance</label>
                <input type="number" name="current_balance" id="current_balance" 
                    class="input-field w-full" 
                    value="{{ old('current_balance', $vault->current_balance) }}" step="0.01" required>
            </div> --}}

            <!-- Active Status -->
            <div class="flex items-center space-x-4">
                <input type="checkbox" name="is_active" id="is_active" value="1" 
                    {{ $vault->is_active ? 'checked' : '' }} class="h-5 w-5 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                <label for="is_active" class="text-gray-700 font-medium">Active</label>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('vaults.index') }}" 
                   class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Update Vault</button>
            </div>
        </form>
    </div>
</div>
@endsection
