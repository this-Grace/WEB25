// UniMatch theme manager: automatic + manual selection via navbar
(function () {
    const THEME_KEY = 'unimatch-theme';
    const media = window.matchMedia('(prefers-color-scheme: dark)');

    const getStoredTheme = () => localStorage.getItem(THEME_KEY);
    const setStoredTheme = (theme) => localStorage.setItem(THEME_KEY, theme);

    const resolveAuto = () => (media.matches ? 'dark' : 'light');

    const applyTheme = (theme) => {
        const value = theme === 'auto' ? resolveAuto() : theme;
        document.documentElement.setAttribute('data-bs-theme', value);
    };

    const updateUI = (theme) => {
        document.querySelectorAll('[data-theme-value]').forEach((el) => {
            const val = el.getAttribute('data-theme-value');
            const isActive = val === theme;
            el.classList.toggle('active', isActive);
            el.setAttribute('aria-pressed', String(isActive));
        });

        const icon = document.getElementById('themeIcon');
        if (icon) {
            icon.textContent = theme === 'dark' ? '●' : theme === 'light' ? '○' : '◐';
        }
    };

    const init = () => {
        const stored = getStoredTheme() || 'auto';
        applyTheme(stored);
        updateUI(stored);

        media.addEventListener('change', () => {
            const current = getStoredTheme() || 'auto';
            if (current === 'auto') {
                applyTheme('auto');
                updateUI('auto');
            }
        });

        document.addEventListener('click', (e) => {
            const target = e.target.closest('[data-theme-value]');
            if (!target) return;
            const value = target.getAttribute('data-theme-value');
            setStoredTheme(value);
            applyTheme(value);
            updateUI(value);
        });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

