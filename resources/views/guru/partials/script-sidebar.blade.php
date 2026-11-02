<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleSidebarBtn = document.getElementById('toggle-sidebar');
        const closeSidebarBtn = document.getElementById('close-sidebar-btn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');

        
        function isDesktop() {
            return window.innerWidth >= 1024;
        }

        function openSidebar() {
            if (sidebar) {
                if (isDesktop()) {
                    sidebar.classList.remove('lg:hidden', 'lg:w-0', 'lg:-ml-72');
                } else {
                    sidebar.classList.remove('-translate-x-full');
                    if (sidebarOverlay) sidebarOverlay.classList.remove('hidden');
                }
            }
        }

        function closeSidebar() {
            if (sidebar) {
                if (isDesktop()) {
                    sidebar.classList.add('lg:hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    if (sidebarOverlay) sidebarOverlay.classList.add('hidden');
                }
            }
        }

        if (toggleSidebarBtn) {
            toggleSidebarBtn.addEventListener('click', (e) => {
                e.stopPropagation();

                if (isDesktop()) {
                    if (sidebar.classList.contains('lg:hidden')) {
                        openSidebar();
                    } else {
                        closeSidebar();
                    }
                } else {
                    if (sidebar.classList.contains('-translate-x-full')) {
                        openSidebar();
                    } else {
                        closeSidebar();
                    }
                }
            });
        }

        if (closeSidebarBtn) {
            closeSidebarBtn.addEventListener('click', closeSidebar);
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebar);
        }

        window.addEventListener('resize', () => {
            if (isDesktop()) {
                if (sidebarOverlay) sidebarOverlay.classList.add('hidden');
                // Pastikan transform mobile dibersihkan di desktop
                if (sidebar) sidebar.classList.remove('-translate-x-full');
            } else {
                if (sidebar && !sidebar.classList.contains('-translate-x-full')) {
                    if (sidebarOverlay) sidebarOverlay.classList.remove('hidden');
                }
            }
        });


        function updateThemeIcon(isDark) {
            if (!themeIcon) return;
            if (isDark) {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        }

        const savedTheme = localStorage.getItem('theme');
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
            document.documentElement.classList.add('dark');
            updateThemeIcon(true);
        } else {
            document.documentElement.classList.remove('dark');
            updateThemeIcon(false);
        }

        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', () => {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                updateThemeIcon(isDark);
            });
        }
    });
</script>