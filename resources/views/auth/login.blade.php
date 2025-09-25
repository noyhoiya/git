

<!DOCTYPE html>
<html lang="lo">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>ເຂົ້າສູ່ລະບົບ - ຄັງເງິນສົດ</title>
     <script src="https://resource.trickle.so/vendor_lib/unpkg/react@18/umd/react.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/react-dom@18/umd/react-dom.production.min.js"></script>
    <script src="https://resource.trickle.so/vendor_lib/unpkg/@babel/standalone/babel.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
    <script type="text/babel" src="components/Header.js"></script>
    <script type="text/babel" src="components/Sidebar.js"></script>
    <script type="text/babel" src="components/StatCard.js"></script>
    <script type="text/babel" src="components/TransactionList.js"></script>
    <script type="text/babel" src="components/CashFlowChart.js"></script>
    <script type="text/babel" src="components/QuickActions.js"></script>
    <script type="text/babel" src="utils/dataManager.js"></script>
    <script type="text/babel" src="app.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Optional: set config BEFORE loading the CDN -->
  <script>
    tailwind = {
      config: {
        theme: {
          extend: {
            colors: {
              primary: '#10b981',
              accent: '#059669'
            }
          }
        }
      }
    }
  </script>

  <!-- Tailwind Play CDN (compiles type="text/tailwindcss" on the fly) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Your Tailwind-layered styles (processed by the Play CDN) -->
  <style type="text/tailwindcss">
    @layer base {
      :root {
        --primary-color: #10b981;
        --accent-color: #059669;
        --border-color: #e5e7eb;
      }
      body { font-family: 'Noto Sans Lao', Inter, system-ui, sans-serif; }
    }

    @layer components {
      .btn-primary {
        @apply bg-[var(--primary-color)] hover:bg-[var(--accent-color)] text-white px-6 py-3 rounded-lg font-medium;
      }
      .card {
        @apply bg-white rounded-lg shadow-sm border border-[var(--border-color)] p-6;
      }
    }
  </style>

  <!-- Lucide icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50">
  <div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-xl shadow-lg">
        <div class="flex-shrink-0">
            <!-- Big Logo -->
            <img src="{{ asset('assets/image/logo_t.png') }}" alt="SSB Logo" class="h-40 w-auto mx-auto">
       
        </div>

        <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">ຊື່ຜູ້ໃຊ້</label>
                    <input id="username" name="username" type="text" autocomplete="username" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">ລະຫັດຜ່ານ</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-green-600 text-white font-semibold rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                ເຂົ້າສູ່ລະບົບ
            </button>
        </form>
    </div>
</div>
<script>
  (function () {
    const form = document.querySelector('form[action="{{ route('login') }}"]');
    if (!form) return;

    let submittingSession = false;

    form.addEventListener('submit', async function (e) {
      if (submittingSession) return; // allow the second (session) submit

      e.preventDefault();

      const username = document.getElementById('username')?.value?.trim();
      const password = document.getElementById('password')?.value || '';

      // 1) API login (token)
      try {
        const res = await fetch('/api/auth/login', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
          body: JSON.stringify({ username, password })
        });

        const data = await res.json();
        if (!res.ok || !data?.token) {
          alert(data?.message || 'API login failed');
          return;
        }
        localStorage.setItem('api_token', data.token);

        // 2) Web session login (session cookie)
        submittingSession = true;
        form.submit(); // will hit /login and then redirect to dashboard
      } catch (err) {
        alert(err?.message || 'Network error');
      }
    });
  })();
</script>
</body>
</html>
