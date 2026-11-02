<!DOCTYPE html>
<html lang="id" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Siswa') - Deep Learning EdTech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
    <style>
        * { transition: background-color 0.25s ease, border-color 0.25s ease; }

        /* Animasi Kustom untuk Loader & Ornamen */
        @keyframes spin-slow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .animate-spin-slow { animation: spin-slow 8s linear infinite; }
        
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) rotate(-0.5deg); }
            50% { transform: translateY(-12px) rotate(1.5deg); }
        }
        @keyframes floatFast {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-8px) scale(1.05); }
        }
        @keyframes pulseGlow {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.08); }
        }
        
        .animate-float { animation: floatSlow 6s ease-in-out infinite; }
        .animate-float-fast { animation: floatFast 4s ease-in-out infinite; }
        .animate-glow { animation: pulseGlow 8s ease-in-out infinite; }

    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 dark:bg-cyberdark-950 text-gray-800 dark:text-pink-50 font-sans overflow-hidden">

    <div class="flex h-screen w-screen relative">
        <div id="sidebar-overlay" class="fixed inset-0 bg-cyberdark-950/60 backdrop-blur-sm z-30 hidden lg:hidden"></div>

        @include('siswa.partials.sidebar')

        <div class="flex-1 flex flex-col h-screen overflow-y-auto">
            
            @include('siswa.partials.navbar')

            <main class="p-4 md:p-6 space-y-6 max-w-7xl w-full mx-auto">
                @yield('content')
            </main>

        </div>
    </div>

    <!-- Load SweetAlert2 Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const isDark = document.documentElement.classList.contains('dark');
            const hasSuccess = {{ session('success') ? 'true' : 'false' }};
            const showMoodModal = {{ session('show_mood_modal') ? 'true' : 'false' }};

            if (hasSuccess) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 2500,
                    timerProgressBar: true,
                    showConfirmButton: true,
                    confirmButtonText: 'Oke',
                    background: isDark ? '#0a0f1d' : '#ffffff',
                    color: isDark ? '#ffffff' : '#1f2937',
                    customClass: {
                        popup: 'rounded-2xl border border-pink-500/20 shadow-2xl'
                    }
                }).then(() => {
                    if (showMoodModal) {
                        triggerMoodModal(isDark);
                    }
                });
            } 

            else if (showMoodModal) {
                triggerMoodModal(isDark);
            }
        });


        function triggerMoodModal(isDark) {
            Swal.fire({
                title: 'Bagaimana perasaanmu hari ini? ✨',
                text: 'Pilih suasana hati untuk memulai petualangan belajarmu!',
                html: `
                    <div class="grid grid-cols-4 gap-3 my-4">
                        <button type="button" onclick="selectMoodChoice('😊', 'Senang')" class="mood-btn p-3 bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/40 rounded-2xl hover:border-pink-500 hover:scale-105 transition flex flex-col items-center gap-1 group cursor-pointer">
                            <span class="text-3xl group-hover:scale-110 transition-transform">😊</span>
                            <span class="text-[10px] font-bold text-gray-700 dark:text-gray-300">Senang</span>
                        </button>
                        <button type="button" onclick="selectMoodChoice('🔥', 'Semangat')" class="mood-btn p-3 bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/40 rounded-2xl hover:border-pink-500 hover:scale-105 transition flex flex-col items-center gap-1 group cursor-pointer">
                            <span class="text-3xl group-hover:scale-110 transition-transform">🔥</span>
                            <span class="text-[10px] font-bold text-gray-700 dark:text-gray-300">Semangat</span>
                        </button>
                        <button type="button" onclick="selectMoodChoice('😴', 'Lelah')" class="mood-btn p-3 bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/40 rounded-2xl hover:border-pink-500 hover:scale-105 transition flex flex-col items-center gap-1 group cursor-pointer">
                            <span class="text-3xl group-hover:scale-110 transition-transform">😴</span>
                            <span class="text-[10px] font-bold text-gray-700 dark:text-gray-300">Lelah</span>
                        </button>
                        <button type="button" onclick="selectMoodChoice('🤔', 'Fokus')" class="mood-btn p-3 bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/40 rounded-2xl hover:border-pink-500 hover:scale-105 transition flex flex-col items-center gap-1 group cursor-pointer">
                            <span class="text-3xl group-hover:scale-110 transition-transform">🤔</span>
                            <span class="text-[10px] font-bold text-gray-700 dark:text-gray-300">Fokus</span>
                        </button>
                    </div>
                `,
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                background: isDark ? '#0a0f1d' : '#ffffff',
                color: isDark ? '#ffffff' : '#1f2937',
                customClass: {
                    popup: 'rounded-3xl border border-pink-500/30 shadow-2xl backdrop-blur-md',
                    title: 'text-base font-extrabold text-gray-900 dark:text-white',
                }
            });
        }

        function selectMoodChoice(emoji, label) {
            fetch("{{ route('siswa.profil.update-mood') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ mood: emoji })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    window.dispatchEvent(new CustomEvent('mood-updated', { 
                        detail: { mood: emoji, label: label } 
                    }));

                    Swal.fire({
                        icon: 'success',
                        title: 'Selamat Belajar! 🚀',
                        text: `Suasana hatimu diset ke ${emoji} ${label}`,
                        timer: 1800,
                        showConfirmButton: false,
                        background: document.documentElement.classList.contains('dark') ? '#0a0f1d' : '#ffffff',
                        color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#1f2937',
                        customClass: {
                            popup: 'rounded-3xl border border-pink-500/30'
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.close();
            });
        }
    </script>

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    background: document.documentElement.classList.contains('dark') ? '#0a0f1d' : '#ffffff',
                    color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#1f2937',
                    customClass: {
                        popup: 'rounded-2xl border border-red-500/20 shadow-2xl'
                    }
                });
            });
        </script>
    @endif
    
    <!-- script sidebar -->
    @include('siswa.partials.script-sidebar')
</body>
</html>