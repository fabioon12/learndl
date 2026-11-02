<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title' . 'Learn DL')</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
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

        /* Style bantuan untuk radio button card kustom */
        input[type="radio"]:checked + div {
            border-color: #a855f7 !important;
            background-color: rgba(168, 85, 247, 0.08) !important;
            box-shadow: 0 10px 15px -3px rgba(168, 85, 247, 0.2);
        }
        .dark input[type="radio"]:checked + div {
            background-color: rgba(168, 85, 247, 0.15) !important;
        }
        input[type="radio"]:checked + div .role-icon {
            color: #a855f7 !important;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#0b0914] text-slate-900 dark:text-slate-100 min-h-screen flex items-center justify-center p-0 sm:p-4 overflow-x-hidden antialiased">
    @include('auth.partials.preloader')

    @yield('content')

    <script>
        const loader = document.getElementById('global-loader');

        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                loader.classList.add('opacity-0', 'pointer-events-none');
                setTimeout(() => loader.classList.add('hidden'), 300);
            }, 1000);
        });


        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

    </script>
</body>
</html>