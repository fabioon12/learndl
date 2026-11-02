<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false, mobileMenu: false, isPreloading: true }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LearnDL — Platform Premium Logika Percabangan & Deep Learning')</title>
    
    <!-- CDNs -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style type="text/tailwindcss">
        /* FIX UTAMA TAILWIND v4: Mendeklarasikan ulang deteksi class .dark untuk mode manual */
        @custom-variant dark (&:where(.dark, .dark *));

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            @apply transition-colors duration-500 ease-in-out;
        }

        /* Animasi Transisi Halus untuk Perpindahan Tema */
        .theme-transition {
            @apply transition-all duration-500 ease-in-out;
        }
        
        /* Animasi Ornamen Visual Bergerak */
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

        /* Efek Shadow Neon Mewah Khusus Mode Gelap (Dark Mode) */
        .dark .neon-card-purple {
            box-shadow: 0 0 35px rgba(147, 51, 234, 0.35);
            border-color: rgba(147, 51, 234, 0.4);
        }
        .dark .neon-card-blue {
            box-shadow: 0 0 35px rgba(59, 130, 246, 0.3);
            border-color: rgba(59, 130, 246, 0.35);
        }

        /* Animasi Lembut Saat Halaman Selesai Dimuat */
        .reveal-view {
            opacity: 0;
            transform: translateY(15px);
            transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal-ready .reveal-view {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body 
    x-init="setTimeout(() => { isPreloading = false; $el.classList.add('reveal-ready') }, 1000)"
    class="bg-slate-50 text-slate-900 dark:bg-[#070514] dark:text-slate-100 antialiased overflow-x-hidden relative"
>

    {{-- Preloader Component --}}
    @include('landingpage.partials.preloader')

    {{-- Background Glow Ornaments --}}
    <div class="absolute top-[-5%] left-[-5%] w-[600px] h-[600px] bg-purple-400/15 dark:bg-purple-600/25 rounded-full blur-[130px] pointer-events-none animate-glow"></div>
    <div class="absolute top-[30%] right-[-5%] w-[500px] h-[500px] bg-blue-400/15 dark:bg-blue-600/20 rounded-full blur-[130px] pointer-events-none animate-glow" style="animation-delay: -4s"></div>
    <div class="absolute top-[60%] left-[-10%] w-[450px] h-[450px] bg-pink-400/10 dark:bg-pink-600/15 rounded-full blur-[120px] pointer-events-none animate-glow" style="animation-delay: -2s"></div>

    {{-- Navbar Component --}}
    @include('landingpage.partials.navbar')

    {{-- Main Content Section --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer Component --}}
    @include('landingpage.partials.footer')

</body>
</html>