<!DOCTYPE html>
<html lang="lo">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'ຄັງເງິນສົດ'); ?></title>
    <meta name="description" content="ລະບົບຄັງເງິນສົດ">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.jsx']); ?>
    <!-- <link href="https://cdn.tailwindcss.com/3.3.2/tailwind.min.css" rel="stylesheet"> -->
    <link href="<?php echo e(asset('css/report.css')); ?>" rel="stylesheet">
    <link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
    <link href="https://unpkg.com/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/lucide/dist/lucide.min.js"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <img src="<?php echo e(asset('assets/image/logo.png')); ?>" alt="SSB Logo" class="h-10 w-auto mx-auto">
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
                            <a href="<?php echo e(url('/')); ?>" 
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
  <?php
    $user = auth()->user();
    $isAllowed = in_array(optional($user)->role_id, [1,3,5]);
?>

<?php if($isAllowed): ?>
    <!-- Notify Button -->
    <div class="relative inline-block text-left">
    <button id="notifyButton" class="relative p-2 rounded-full bg-gradient-to-br from-blue-500 to-green-600 hover:scale-110 transition-transform shadow-md flex items-center justify-center focus:outline-none">
        <!-- Bell Icon -->
        <div class="relative w-4 h-4 flex flex-col items-center">
            <div class="w-3 h-3 bg-white rounded-t-full border-b-[2px] border-white"></div>
            <div class="w-1 h-1 bg-white rounded-full mt-[1px]"></div>
        </div>

        <!-- Notification dot -->
        <?php if(session()->has('cash_request_alerts') && count(session('cash_request_alerts')) > 0): ?>
            <span class="absolute top-0.5 right-0.5 w-2 h-2 bg-red-500 border border-white rounded-full animate-ping"></span>
            <span class="absolute top-0.5 right-0.5 w-2 h-2 bg-red-500 rounded-full"></span>
        <?php endif; ?>
    </button>

<div id="notifyDropdown" class="hidden absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-lg border border-gray-200 z-50">

        <div class="p-2 border-b border-gray-100 font-semibold">ການແຈ້ງເຕືອນ</div>
        <ul class="max-h-64 overflow-y-auto">
            <?php if(session()->has('cash_request_alerts') && count(session('cash_request_alerts')) > 0): ?>
                <?php $__currentLoopData = session('cash_request_alerts'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li class="p-2 hover:bg-gray-100 rounded flex justify-between items-center" data-request-id="<?php echo e($request->request_id); ?>">
    <!-- Make link fill all text space -->
    <a href="<?php echo e(route('cash-requests.index', ['id' => $request->request_id])); ?>" 
       class="flex-1 cursor-pointer no-underline text-gray-800">
        <div>
            <p class="text-sm font-medium">
               <?php echo e($request->request_id); ?>  <?php echo e($request->requesterUser->full_name); ?> 
            </p>
            <p class="text-xs text-gray-500">
                ຄຳຂໍ <?php echo e(number_format($request->amount, 2)); ?> ກີບ
                <?php echo e($request->requesterVault->vault_name ?? 'a vault'); ?>


                   at <?php echo e(\Carbon\Carbon::parse($request['created_at'])->format('d M Y H:i')); ?>


            
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <li class="p-2 text-gray-500">ບໍ່ມີການແຈ້ງເຕືອນ.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>


<?php endif; ?>

                    <?php if(auth()->guard()->check()): ?>
                        <span class="text-sm text-gray-600">ຜູ້ໃຊ້: <?php echo e(auth()->user()->full_name); ?></span>
                        <form method="POST" action="/logout" class="inline">
                            <?php echo csrf_field(); ?>
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
                        <button id="themeToggle" class="btn-primary mb-2 rounded-full">🌙</button>

                    <?php endif; ?>

                                   

                </div>
            </div>
        </div>
        

    </nav>

    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <?php if(session('success')): ?>
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
      
        <?php echo $__env->yieldContent('content'); ?>
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
            fetch("<?php echo e(route('dismiss.cash.alert')); ?>", {
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


  lucide.createIcons(); // initialize all icons
  // dark mode toggle
  (function(){
  console.clear();
  console.log('[theme-debug] init —', new Date().toLocaleString());

  function debugInfo() {
    console.log('[theme-debug] document.readyState:', document.readyState);
    console.log('[theme-debug] html.classList:', document.documentElement.className);
    console.log('[theme-debug] localStorage.theme:', (()=>{try{return localStorage.getItem('theme')}catch(e){return 'localStorage unavailable'}})());
  }

  function makeButtonClickable(btn) {
    if(!btn) return;
    btn.style.cursor = 'pointer';
    btn.style.userSelect = 'none';
    // Ensure clickable if something overlaps
    if (!btn.style.zIndex || parseInt(btn.style.zIndex) < 50) {
      btn.style.zIndex = 9999;
      btn.style.position = btn.style.position || 'relative';
    }
    // Avoid pointer disabled
    try { btn.style.pointerEvents = 'auto'; } catch(e){}
  }

  function updateIcon(btn) {
    if(!btn) return;
    try {
      btn.setAttribute('aria-pressed', document.documentElement.classList.contains('dark') ? 'true' : 'false');
      // keep icon only — do not modify other inner HTML if your button has complex children
      if(btn.dataset.simpleIcon === 'true' || btn.innerText.trim().length <= 2) {
        btn.innerText = document.documentElement.classList.contains('dark') ? '☀️' : '🌙';
      }
    } catch(e) { console.warn('[theme-debug] updateIcon error', e); }
  }

  function attachHandler(btn) {
    if(!btn) return;
    // remove any previous duplicate handler marker
    if(btn.__themeHandlerAttached) return;
    btn.__themeHandlerAttached = true;

    makeButtonClickable(btn);
    updateIcon(btn);

    btn.addEventListener('click', function(e){
      try {
        e.preventDefault();
      } catch(err) {}
      document.documentElement.classList.toggle('dark');
      try { localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light'); } catch(e){}
      updateIcon(btn);
      console.log('[theme-debug] click -> dark=', document.documentElement.classList.contains('dark'));
    });
  }

  // main init (immediate)
  debugInfo();
  const btn = document.getElementById('themeToggle');
  if (btn) {
    console.log('[theme-debug] themeToggle found immediately', btn);
    // if your button contains only an emoji, mark it simple so we may replace text
    if (btn.innerText.trim().length <= 2) btn.dataset.simpleIcon = 'true';
    attachHandler(btn);
  } else {
    console.warn('[theme-debug] themeToggle NOT found yet. Will observe DOM for 3s to catch dynamic insertion.');
    // watch for dynamic insertion (e.g. blade sections / auth / client frameworks)
    const obs = new MutationObserver((mutations, observer) => {
      const b = document.getElementById('themeToggle');
      if (b) {
        console.log('[theme-debug] themeToggle found by MutationObserver', b);
        if (b.innerText.trim().length <= 2) b.dataset.simpleIcon = 'true';
        attachHandler(b);
        observer.disconnect();
      }
    });
    obs.observe(document.documentElement || document.body, { childList: true, subtree: true });
    // stop observing after 3s
    setTimeout(() => { try{ obs.disconnect(); }catch(e){} }, 3000);
  }

  // global delegated fallback (works even if button replaced)
  document.addEventListener('click', function(e){
    const t = e.target.closest && e.target.closest('#themeToggle');
    if (!t) return;
    // If native handler already runs, this is fine — it's idempotent
    e.preventDefault();
    document.documentElement.classList.toggle('dark');
    try { localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light'); } catch(e){}
    updateIcon(t);
    console.log('[theme-debug] delegated click -> dark=', document.documentElement.classList.contains('dark'));
  });

  // quick helper: test visual change by toggling then restoring (comment out if noisy)
  // console.log('[theme-debug] test toggle (visual). Run manually: document.documentElement.classList.toggle("dark")');

  // Useful check for overlapped element
  setTimeout(() => {
    const el = document.getElementById('themeToggle');
    if (el) {
      const cs = getComputedStyle(el);
      console.log('[theme-debug] computed style for #themeToggle -> display:', cs.display,
                  'pointer-events:', cs.pointerEvents, 'z-index:', cs.zIndex, 'position:', cs.position);
      // check ancestors for pointer-events:none or overlay
      let p = el.parentElement;
      while (p && p !== document.body) {
        const pcs = getComputedStyle(p);
        if (pcs.pointerEvents === 'none') console.warn('[theme-debug] ancestor with pointer-events:none', p);
        p = p.parentElement;
      }
    }
  }, 1500);

  // Final status after 1.5s
  setTimeout(() => {
    debugInfo();
    console.log('[theme-debug] done initialization (1.5s). If the button still does nothing, copy console logs and paste them in the chat.');
  }, 1500);

})();
(function () {
  const savedTheme = localStorage.getItem("theme") || "light";
  document.documentElement.classList.remove("light", "dark");
  document.documentElement.classList.add(savedTheme);
})();
</script>

<?php echo $__env->yieldContent('scripts'); ?>  <!-- <-- ต้องอยู่ตรงนี้ -->

</body>
</html><?php /**PATH C:\xampp\htdocs\cash_center_v3\resources\views/layouts/app.blade.php ENDPATH**/ ?>