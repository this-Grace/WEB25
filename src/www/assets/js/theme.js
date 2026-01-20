/**
 * Theme manager - segue automaticamente le preferenze del sistema
 */
(function () {
    'use strict';

    const STORAGE_KEY = 'unimatch-theme';
    const THEME_AUTO = 'auto';
    const THEME_LIGHT = 'light';
    const THEME_DARK = 'dark';

    /**
     * Ottiene il tema dalle preferenze del sistema
     */
    function getSystemTheme() {
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? THEME_DARK : THEME_LIGHT;
    }

    /**
     * Ottiene il tema salvato o ritorna 'auto' come default
     */
    function getSavedTheme() {
        return localStorage.getItem(STORAGE_KEY) || THEME_AUTO;
    }

    /**
     * Calcola il tema effettivo da applicare
     */
    function getEffectiveTheme(savedTheme) {
        if (savedTheme === THEME_AUTO) {
            return getSystemTheme();
        }
        return savedTheme;
    }

    /**
     * Applica il tema al documento
     */
    function applyTheme(theme) {
        document.documentElement.setAttribute('data-bs-theme', theme);
    }

    /**
     * Salva la preferenza tema
     */
    function saveTheme(theme) {
        localStorage.setItem(STORAGE_KEY, theme);
    }

    /**
     * Inizializza il tema
     */
    function initTheme() {
        const savedTheme = getSavedTheme();
        const effectiveTheme = getEffectiveTheme(savedTheme);
        applyTheme(effectiveTheme);
    }

    /**
     * Ascolta i cambiamenti delle preferenze del sistema
     */
    function watchSystemTheme() {
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

        mediaQuery.addEventListener('change', (e) => {
            const savedTheme = getSavedTheme();
            // Aggiorna solo se l'utente sta usando il tema automatico
            if (savedTheme === THEME_AUTO) {
                const newTheme = e.matches ? THEME_DARK : THEME_LIGHT;
                applyTheme(newTheme);
            }
        });
    }

    /**
     * Cambia il tema manualmente (esposto globalmente)
     */
    window.setTheme = function (theme) {
        if ([THEME_AUTO, THEME_LIGHT, THEME_DARK].includes(theme)) {
            saveTheme(theme);
            const effectiveTheme = getEffectiveTheme(theme);
            applyTheme(effectiveTheme);
        }
    };

    /**
     * Ottiene il tema corrente (esposto globalmente)
     */
    window.getTheme = function () {
        return getSavedTheme();
    };

    // Inizializza il tema appena possibile
    initTheme();

    // Aspetta il DOM completo per il resto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', watchSystemTheme);
    } else {
        watchSystemTheme();
    }
})();
