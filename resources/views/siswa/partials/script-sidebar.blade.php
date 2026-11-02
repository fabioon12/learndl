<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggleSidebarBtn = document.getElementById('toggle-sidebar');
        const closeSidebarBtn = document.getElementById('close-sidebar-btn');
        const themeToggleBtn = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;

        // Buka / Tutup Full Sidebar (Desktop & Mobile)
        function toggleSidebar() {
            if (!sidebar) return;

            if (window.innerWidth >= 1024) {
                // Pada Desktop: Gunakan kombinasi width 0 dan transform agar benar-benar tertutup bersih
                sidebar.classList.toggle('lg:w-0');
                sidebar.classList.toggle('lg:w-64');
                sidebar.classList.toggle('lg:p-0');
                sidebar.classList.toggle('lg:border-none');
            } else {
                // Pada Mobile: Slide Out penuh ke kiri
                const isHidden = sidebar.classList.contains('-translate-x-full');
                if (isHidden) {
                    sidebar.classList.remove('-translate-x-full');
                    if (overlay) overlay.classList.remove('hidden');
                } else {
                    closeMobileSidebar();
                }
            }
        }

        function closeMobileSidebar() {
            if (!sidebar) return;
            sidebar.classList.add('-translate-x-full');
            if (overlay) overlay.classList.add('hidden');
        }

        if (toggleSidebarBtn) {
            toggleSidebarBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleSidebar();
            });
        }

        if (closeSidebarBtn) {
            closeSidebarBtn.addEventListener('click', closeMobileSidebar);
        }

        if (overlay) {
            overlay.addEventListener('click', closeMobileSidebar);
        }

        // Reset class saat resize layar
        window.addEventListener('resize', () => {
            if (!sidebar) return;
            if (window.innerWidth >= 1024) {
                if (overlay) overlay.classList.add('hidden');
                sidebar.classList.remove('-translate-x-full');
            } else {
                sidebar.classList.remove('lg:w-0', 'lg:p-0', 'lg:border-none');
                sidebar.classList.add('lg:w-64', '-translate-x-full');
            }
        });

        // Toggle Dark/Light Mode
        function updateThemeUI(isDark) {
            const themeIcon = document.getElementById('theme-icon');
            if (!themeIcon) return;

            if (isDark) {
                themeIcon.className = "fa-solid fa-sun text-lg text-amber-400 group-hover:scale-110 transition-transform";
            } else {
                themeIcon.className = "fa-solid fa-moon text-lg text-gray-600 dark:text-pink-400 group-hover:scale-110 transition-transform";
            }
        }

        const isDarkStored = localStorage.getItem('theme') === 'dark' || 
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);

        if (isDarkStored) {
            htmlElement.classList.add('dark');
            updateThemeUI(true);
        } else {
            htmlElement.classList.remove('dark');
            updateThemeUI(false);
        }

        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', () => {
                const isDarkNow = htmlElement.classList.toggle('dark');
                localStorage.setItem('theme', isDarkNow ? 'dark' : 'light');
                updateThemeUI(isDarkNow);
            });
        }
    });
</script>