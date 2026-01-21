(() => {
    const mql = window.matchMedia("(prefers-color-scheme: dark)");

    const applyTheme = isDark => {
        document.documentElement.setAttribute("data-bs-theme", isDark ? "dark" : "light");
    };

    applyTheme(mql.matches);

    const handler = event => applyTheme(event.matches);
    if (mql.addEventListener) {
        mql.addEventListener("change", handler);
    } else if (mql.addListener) {
        mql.addListener(handler);
    }
})();