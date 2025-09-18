<!DOCTYPE html>
<html lang="lo">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ຄັງເງິນສົດ')</title>
    <meta name="description" content="ລະບົບຄັງເງິນສົດ">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://cdn.tailwindcss.com/3.3.2/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('css/report.css') }}" rel="stylesheet">
    <link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
    <link href="https://unpkg.com/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/lucide/dist/lucide.min.js"></script>

    
    <style>
        :root {
            --primary-color: #10b981;
            --secondary-color: #f0fdf4;
            --accent-color: #059669;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --background-light: #f9fafb;
        }

        /* Page transition base */
        body {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.2s ease, transform 0.2ss ease;
        }

        body.page-active {
            opacity: 1;
            transform: translateY(0);
        }

    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('assets/image/logo.png') }}" alt="SSB Logo" class="h-10 w-auto mx-auto">
                    </div>
                    <h1 class="text-xl font-bold text-gray-900">ສະຖາບັນການເງິນທີ່ຮັບຝາກເອສເອສບີ</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Back Page -->
                            <a href="javascript:history.back()" 
                            class="p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-primary-color"
                            title="ກັບຄືນ">
                                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                            </a>
                     <button type="button" id="reloadButton"
                        class="p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-color">
                        <!-- Lucide Refresh Icon SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M21 12a9 9 0 11-3-7.7M21 3v6h-6"/>
                        </svg>
                    </button>
                          <div class="flex items-center space-x-2">
                    
                    <!-- Back Home -->
                            <a href="{{ url('/') }}" 
                            class="p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-primary-color"
                            title="ໜ້າຫຼັກ">
                                <i data-lucide="home" class="w-5 h-5"></i>
                            </a>
</div>

<!-- Add this before </body> -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons(); // initialize all icons
</script>
  @php
    $user = auth()->user();
    $isAllowed = in_array(optional($user)->role_id, [1,3,5]);
@endphp

@if($isAllowed)
    <!-- Notify Button -->
    <div class="relative inline-block text-left">
    <button id="notifyButton" class="relative p-2 rounded-full bg-gradient-to-br from-blue-500 to-green-600 hover:scale-110 transition-transform shadow-md flex items-center justify-center focus:outline-none">
        <!-- Bell Icon -->
        <div class="relative w-4 h-4 flex flex-col items-center">
            <div class="w-3 h-3 bg-white rounded-t-full border-b-[2px] border-white"></div>
            <div class="w-1 h-1 bg-white rounded-full mt-[1px]"></div>
        </div>

        <!-- Notification dot -->
        @if(session()->has('cash_request_alerts') && count(session('cash_request_alerts')) > 0)
            <span class="absolute top-0.5 right-0.5 w-2 h-2 bg-red-500 border border-white rounded-full animate-ping"></span>
            <span class="absolute top-0.5 right-0.5 w-2 h-2 bg-red-500 rounded-full"></span>
        @endif
    </button>

<div id="notifyDropdown" class="hidden absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-lg border border-gray-200 z-50">

        <div class="p-2 border-b border-gray-100 font-semibold">ການແຈ້ງເຕືອນ</div>
        <ul class="max-h-64 overflow-y-auto">
            @if(session()->has('cash_request_alerts') && count(session('cash_request_alerts')) > 0)
                @foreach(session('cash_request_alerts') as $request)
              <li class="p-2 hover:bg-gray-100 rounded flex justify-between items-center" data-request-id="{{ $request->request_id }}">
    <!-- Make link fill all text space -->
    <a href="{{ route('cash-requests.index', ['id' => $request->request_id]) }}" 
       class="flex-1 cursor-pointer no-underline text-gray-800">
        <div>
            <p class="text-sm font-medium">
               {{ $request->request_id }}  {{ $request->requesterUser->full_name }} 
            </p>
            <p class="text-xs text-gray-500">
                ຄຳຂໍ {{ number_format($request->amount, 2) }} ກີບ
                {{ $request->requesterVault->vault_name ?? 'a vault' }}

                   at {{ \Carbon\Carbon::parse($request['created_at'])->format('d M Y H:i') }}

            
            </p>
        </div>
    </a>

    <!-- Dismiss button -->
    <button class="dismissBtn ml-2 px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700 transition flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M8 7V4a1 1 0 011-1h6a1 1 0 011 1v3" />
        </svg>
    </button>
</li>
                @endforeach
            @else
                <li class="p-2 text-gray-500">ບໍ່ມີການແຈ້ງເຕືອນ.</li>
            @endif
        </ul>
    </div>
</div>


@endif

                    @auth
                        <span class="text-sm text-gray-600">ຜູ້ໃຊ້: {{ auth()->user()->full_name }}</span>
                        <form method="POST" action="/logout" class="inline">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-red-500 transition">
                                
                                <!-- Logout Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="h-5 w-5" viewBox="0 0 24 24" fill="none" 
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6
                                            a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1"/>
                                </svg>

                                ອອກຈາກລະບົບ
                            </button>
                                                    

                        </form>
                            
                    @endauth

                                   

                </div>
            </div>
        </div>
        
    </nav>

    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
      
        @yield('content')
    </main>
    
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-gray-500">
                © 2025 ຄັງເງິນສົດ. ສະຖາບັນການເງິນທີ່ຮັບຝາກເອສເອສບີ.
            </p>
        </div>
    </footer>



<script>
document.addEventListener("DOMContentLoaded", function () {
    const body = document.body;
    const transitionTime = 200; // ms

    // Fade/slide IN on load
    requestAnimationFrame(() => {
        body.classList.add("page-active");
    });

    // Fade/slide OUT on navigation or reload
    function fadeOutAndNavigate(href) {
        body.classList.remove("page-active");
        setTimeout(() => {
            if (href) {
                window.location.href = href;
            } else {
                location.reload();
            }
        }, transitionTime);
    }

    // Handle all internal links
    document.querySelectorAll("a[href]").forEach(link => {
        link.addEventListener("click", function (e) {
            const target = this.getAttribute("target");
            const href = this.getAttribute("href");

            if (
                href &&
                !href.startsWith("http") &&
                !href.startsWith("#") &&
                !href.startsWith("javascript:") &&
                target !== "_blank"
            ) {
                e.preventDefault();
                fadeOutAndNavigate(href);
            }
        });
    });

    // Handle form submissions
    document.querySelectorAll("form").forEach(form => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            fadeOutAndNavigate(); // normal submission after fade
            setTimeout(() => form.submit(), transitionTime);
        });
    });

    // Handle buttons with data-href
    document.querySelectorAll("button[data-href]").forEach(btn => {
        btn.addEventListener("click", function () {
            const href = this.getAttribute("data-href");
            fadeOutAndNavigate(href);
        });
    });

    // Special reload button
    const reloadBtn = document.getElementById("reloadButton");
    if (reloadBtn) {
        reloadBtn.addEventListener("click", function (e) {
            e.preventDefault();
            fadeOutAndNavigate();
        });
    }

    // Ensure slide-in works on back/forward
    window.addEventListener("pageshow", function (event) {
        if (event.persisted) {
            body.classList.add("page-active");
        }
    });

    // Fade-out on normal reload or leaving page
    window.addEventListener("beforeunload", function () {
        body.classList.remove("page-active");
    });
});
//for notti
document.addEventListener('DOMContentLoaded', function() {
    const notifyButton = document.getElementById('notifyButton');
    const notifyDropdown = document.getElementById('notifyDropdown');

    // Toggle dropdown visibility
    notifyButton.addEventListener('click', (e) => {
        e.stopPropagation();
        notifyDropdown.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    window.addEventListener('click', (e) => {
        if (!notifyButton.contains(e.target) && !notifyDropdown.contains(e.target)) {
            notifyDropdown.classList.add('hidden');
        }
    });

    // Dismiss each notification
    const dismissButtons = notifyDropdown.querySelectorAll('.dismissBtn');
    dismissButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation(); // prevent dropdown from closing immediately
            const li = btn.closest('li'); // the <li> element to remove
            const requestId = li.dataset.requestId; // get the alert ID

            // --- FETCH POST request to dismiss ---
            fetch("{{ route('dismiss.cash.alert') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id: requestId }) // send alert ID to backend
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === "success"){
                    li.remove(); // remove only this alert from DOM
                }
            });
        });
    });
});

</script>



</body>
</html>