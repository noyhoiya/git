@extends('layouts.app')
 <script src="https://resource.trickle.so/vendor_lib/unpkg/react@18/umd/react.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/react-dom@18/umd/react-dom.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/@babel/standalone/babel.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
    <script src="https://unpkg.com/pdf-lib/dist/pdf-lib.min.js"></script>
<script src="https://unpkg.com/@pdf-lib/fontkit/dist/fontkit.umd.js"></script>

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

    @layer base {
        body {
            font-family: 'Noto Sans Lao', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-primary);
        }
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
    </style>

@section('content')
<div class="max-w-6xl mx-auto p-8">
    <h2 class="text-2xl font-bold mb-6">ລາຍການຄຳຮ້ອງຂໍ</h2>

    <a href="{{ route('cash-requests.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded mb-6 inline-block">
        ສ້າງຄຳຮ້ອງໃໝ່
    </a>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200 text-left text-sm font-semibold text-gray-700">
                    <th class="px-4 py-3 border">ID</th>
                    <th class="px-4 py-3 border">Vault</th>
                    <th class="px-4 py-3 border">User</th>
                    <th class="px-4 py-3 border">Amount</th>
                    <th class="px-4 py-3 border">Purpose</th>
                    <th class="px-4 py-3 border">Status</th>
                    <th class="px-4 py-3 border">Created At</th>
                    <th class="px-4 py-3 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @foreach($cashRequests as $cashRequest)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $cashRequest->request_id }}</td>
                        <td class="px-4 py-2 border">{{ $cashRequest->requesterVault->vault_name ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $cashRequest->requesterUser->full_name ?? '-' }}</td>
                        <td class="px-4 py-2 border font-semibold">{{ number_format($cashRequest->amount) }} ກີບ</td>
                        <td class="px-4 py-2 border">{{ $cashRequest->purpose->purpose_name ?? $cashRequest->purpose_text }}</td>
                        <td class="px-4 py-2 border">{{ $cashRequest->status }}</td>
                        <td class="px-4 py-2 border">{{ $cashRequest->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-2 py-2 border text-center flex justify-center items-center space-x-1">
                            <button
                                class="preview-btn bg-gray-500 hover:bg-blue-600 text-white p-2 rounded-full"
                                data-id="{{ $cashRequest->request_id }}"
                                data-vault="{{ $cashRequest->requesterVault->vault_name ?? '-' }}"
                                data-user="{{ $cashRequest->requesterUser->full_name ?? '-' }}"
                                data-amount="{{ number_format($cashRequest->amount, 2) }} ₭"
                                data-amount_in_words="{{ $cashRequest->amount_in_words ?? '-' }}"
                                data-purpose="{{ $cashRequest->purpose->purpose_name ?? $cashRequest->purpose_text }}"
                                data-created="{{ $cashRequest->created_at->format('d/m/Y H:i') }}"
                                title="Preview PDF"
                            >
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">{{ $cashRequests->links() }}</div>
</div>

<!-- PDF Preview Modal -->
<div id="pdfModal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white w-full max-w-4xl h-[90vh] p-2 relative flex flex-col">
        <button id="closePdfModal" class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded">✕</button>
        <iframe id="pdfViewer" class="w-full h-full border"></iframe>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/pdf-lib/dist/pdf-lib.min.js"></script>
<script src="https://unpkg.com/@pdf-lib/fontkit/dist/fontkit.umd.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const templateUrl = {!! json_encode(asset('assets/pdf/1.pdf')) !!};
    const previewButtons = document.querySelectorAll('.preview-btn');
    const modal = document.getElementById('pdfModal');
    const iframe = document.getElementById('pdfViewer');
    const closeBtn = document.getElementById('closePdfModal');
    let currentObjectUrl = null;

    async function fetchTemplateBytes() {
        const res = await fetch(templateUrl);
        if (!res.ok) throw new Error('Could not load template PDF: ' + res.status);
        return await res.arrayBuffer();
    }

    function getDenominations() {
        // Example: replace with dynamic HTML table values if you have
        return [
            { denom: '', quantity: '0' },
            { denom: '', quantity: '0' },
            { denom: '', quantity: '0' },
                { denom: '', quantity: '0' },
            { denom: '', quantity: '0' },
            { denom: '', quantity: '0' },
                { denom: '', quantity: '0' },
            { denom: '', quantity: '0' }
        ];
    }

    previewButtons.forEach(btn => {
        btn.addEventListener('click', async () => {
            try {
                const data = {
                    id: btn.dataset.id || '',
                    vault: btn.dataset.vault || '',
                    user: btn.dataset.user || '',
                    amount: btn.dataset.amount || '',
                    amount_in_words: btn.dataset.amount_in_words || '',
                    purpose: btn.dataset.purpose || '',
                    created: btn.dataset.created || ''
                };

                const templateBytes = await fetchTemplateBytes();
                const pdfDoc = await PDFLib.PDFDocument.load(templateBytes);

                pdfDoc.registerFontkit(window.fontkit);

                const fontBytes = await fetch('/assets/fonts/phetsarath ot.ttf').then(res => res.arrayBuffer());
                const laoFont = await pdfDoc.embedFont(fontBytes);

                const pages = pdfDoc.getPages();
                const firstPage = pages[0];
                const { width, height } = firstPage.getSize();

                // Draw main info
                firstPage.drawText(data.id, { x: 340, y: height - 165, size: 12, font: laoFont });
                firstPage.drawText(data.user, { x: 140, y: height - 298, size: 11, font: laoFont });
                firstPage.drawText(data.amount, { x: 170, y: height - 440, size: 12, font: laoFont });
                firstPage.drawText(data.amount_in_words, { x: 190, y: height - 485, size: 12, maxWidth: 300, font: laoFont });
                firstPage.drawText(data.purpose, { x: 180, y: height - 390, size: 11, maxWidth: 300, font: laoFont });
                firstPage.drawText(data.created, { x: 480, y: height - 139, size: 11, font: laoFont });

                // Draw denomination table
                const denominations = getDenominations();
                let startX = 360;
                let startY = height - 298;
                const lineHeight = 33;
                denominations.forEach((row, i) => {
                    firstPage.drawText(row.denom, { x: startX, y: startY - i*lineHeight, size: 11, font: laoFont });
                    firstPage.drawText(row.quantity, { x: startX + 150, y: startY - i*lineHeight, size: 11, font: laoFont });
                });

                const pdfBytes = await pdfDoc.save();
                const blob = new Blob([pdfBytes], { type: 'application/pdf' });

                if (currentObjectUrl) URL.revokeObjectURL(currentObjectUrl);
                currentObjectUrl = URL.createObjectURL(blob);
                iframe.src = currentObjectUrl;

                modal.classList.remove('hidden');
                modal.classList.add('flex');

            } catch (err) {
                console.error('Preview error:', err);
                alert('Error creating preview: ' + err.message);
            }
        });
    });

    closeBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        if (currentObjectUrl) URL.revokeObjectURL(currentObjectUrl);
        iframe.src = '';
    });

    modal.addEventListener('click', e => { if (e.target === modal) closeBtn.click(); });
});
</script>
@endsection 