<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - LearnDL</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Alpine.js CDN (Letakkan di dalam <head>) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            20%, 60% { transform: rotate(14deg); }
            40%, 80% { transform: rotate(-14deg); }
        }

        .animate-wave {
            display: inline-block;
            transform-origin: 70% 70%; /* Titik poros lambaian tangan */
            animation: wave 1.8s infinite;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex">

    <!-- Kolom Kiri: Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Kolom Kanan: Header + Area Main Content -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen">
        
        <!-- Header -->
        @include('admin.partials.navbar')

        <!-- Main Content View -->
        <main class="flex-1 p-6 lg:p-8 overflow-y-auto">
            @yield('content')
        </main>

    </div>
        @if (session('success') || session('error') || $errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // 1. Notifikasi BERHASIL (Toast Melayang Top-Right)
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{!! session('success') !!}",
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'rounded-2xl border border-emerald-100 shadow-xl'
                    }
                });
            @endif

            // 2. Notifikasi GAGAL / ERROR (Pop-up Modal di Tengah Screen)
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{!! session('error') !!}",
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#e11d48',
                    customClass: {
                        popup: 'rounded-3xl p-6',
                        confirmButton: 'px-5 py-2.5 rounded-xl text-xs font-bold'
                    }
                });
            @endif

            // 3. Notifikasi ERROR VALIDASI INPUT FORM
            @if ($errors->any())
                Swal.fire({
                    icon: 'warning',
                    title: 'Periksa Inputan Anda!',
                    html: `
                        <ul class="text-left text-xs text-slate-600 space-y-1 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    `,
                    confirmButtonText: 'Mengerti',
                    confirmButtonColor: '#9333ea',
                    customClass: {
                        popup: 'rounded-3xl p-6',
                        confirmButton: 'px-5 py-2.5 rounded-xl text-xs font-bold'
                    }
                });
            @endif

        });
    </script>
    @endif
    @stack('scripts')
</body>
</html>