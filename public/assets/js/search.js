/**
 * Homepage Search Controller
 * Handles global event searches via AJAX to provide a seamless user experience.
 */
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('homepage-search-form');
    const input = document.getElementById('searchInput');
    const grid = document.getElementById('events-grid');

    if (!form || !input || !grid) return;

    /**
     * Intercepts the form submission to perform an asynchronous search.
     * @param {SubmitEvent} e - The form submission event.
     * @returns {Promise<void>}
     */
    form.addEventListener('submit', async function (e) {
        e.preventDefault(); // Stop page from refreshing

        const q = input.value.trim();
        
        /** * Construct query parameters. 
         * Note: limit is set to 1000 to retrieve a broad set of results.
         * @type {URLSearchParams} 
         */
        const params = new URLSearchParams({ 
            search: q, 
            limit: '1000', 
            offset: '0' 
        });

        grid.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary mb-2" role="status"></div>
                <p class="text-muted">Caricamento...</p>
            </div>`;

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
