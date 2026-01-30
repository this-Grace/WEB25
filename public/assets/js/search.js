document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('homepage-search-form');
    const input = document.getElementById('searchInput');
    const grid = document.getElementById('events-grid');

    if (!form || !input || !grid) return;

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const q = input.value.trim();
        const params = new URLSearchParams({ search: q, limit: 1000, offset: 0 });

        // show loading placeholder
        grid.innerHTML = '<div class="text-center py-5"><p class="text-muted">Caricamento...</p></div>';

        try {
            const res = await fetch('api/list_events.php?' + params.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!res.ok) throw new Error('Network response was not ok');
            const data = await res.json();
            if (data && data.success) {
                grid.innerHTML = data.html && data.html.trim() !== '' ? data.html : '<div class="text-center py-5"><p class="text-muted">Nessun evento trovato.</p></div>';
            } else {
                grid.innerHTML = '<div class="text-center py-5"><p class="text-muted">Errore nel caricamento.</p></div>';
            }
        } catch (err) {
            grid.innerHTML = '<div class="text-center py-5"><p class="text-muted">Errore di rete.</p></div>';
            console.error('Search error', err);
        }
    });
});
