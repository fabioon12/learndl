<!DOCTYPE html>
<html lang="id" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - LearnDL</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        cyberdark: {
                            50: '#f4f7fb',
                            100: '#e7eef7',
                            800: '#111a2e',
                            900: '#0a0f1d',
                            950: '#050811'
                        }
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS Animations -->
    <style>
        * { transition: background-color 0.25s ease, border-color 0.25s ease; }

        @keyframes spin-slow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .animate-spin-slow { animation: spin-slow 8s linear infinite; }
        
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) rotate(-0.5deg); }
            50% { transform: translateY(-12px) rotate(1.5deg); }
        }
        .animate-float { animation: floatSlow 6s ease-in-out infinite; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-cyberdark-950 text-gray-800 dark:text-pink-50 font-sans overflow-hidden">

    <div class="flex h-screen w-screen relative">
        <div id="sidebar-overlay" class="fixed inset-0 bg-cyberdark-950/60 backdrop-blur-sm z-30 hidden lg:hidden"></div>

        @include('guru.partials.sidebar')

        <div class="flex-1 flex flex-col h-screen overflow-y-auto">
            
            @include('guru.partials.navbar')

            <main class="p-4 md:p-6 space-y-6 max-w-7xl w-full mx-auto">
                @yield('content')
            </main>

        </div>
    </div>

    <!-- SweetAlert2 Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const isDark = document.documentElement.classList.contains('dark');
                
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3500,
                    timerProgressBar: true,
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    background: isDark ? '#0a0f1d' : '#ffffff',
                    color: isDark ? '#ffffff' : '#1f2937',
                    customClass: {
                        popup: 'rounded-2xl border border-pink-500/20 shadow-2xl'
                    }
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const isDark = document.documentElement.classList.contains('dark');

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    background: isDark ? '#0a0f1d' : '#ffffff',
                    color: isDark ? '#ffffff' : '#1f2937',
                    customClass: {
                        popup: 'rounded-2xl border border-red-500/20 shadow-2xl'
                    }
                });
            });
        </script>
    @endif

    @stack('scripts')
    <!-- Script Sidebar Guru Toggle Handler -->
    @include('guru.partials.script-sidebar')
</body>
</html>