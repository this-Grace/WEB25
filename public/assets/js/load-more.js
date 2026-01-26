document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('load-more-btn');
    const grid = document.getElementById('events-grid');
    if (!btn || !grid) return;

    const limit = parseInt(btn.dataset.limit || '6', 10);
    let offset = parseInt(btn.dataset.offset || '0', 10);

    const getActiveFiltersString = () => {
        const active = Array.from(document.querySelectorAll('.btn-cate.active'))
            .map(b => b.dataset.id)
            .filter(x => x !== undefined && x !== null);
        return active.join(',');
    };

    const setLoading = (loading) => {
        btn.disabled = loading;
        btn.textContent = loading ? 'Caricamento...' : 'Carica altri eventi';
    };

    btn.addEventListener('click', async (e) => {
        e.preventDefault();
        setLoading(true);
        const filters = encodeURIComponent(getActiveFiltersString());
        const searchInput = document.getElementById('searchInput');
        const q = searchInput ? encodeURIComponent(searchInput.value.trim()) : '';
        const categoryId = '';
        try {
            const resp = await fetch(`/api/load_events.php?offset=${offset}&limit=${limit}&filters=${filters}${q ? '&q=' + q : ''}${categoryId ? '&category_id=' + categoryId : ''}`);
            if (!resp.ok) throw new Error('Network response was not ok');
            const data = await resp.json();
            if (data && data.html) {
                // Insert new items before the load-more button wrapper to avoid a full-width
                // button remaining between old and new cards (causing large gaps).
                const wrapper = btn.parentElement;
                if (wrapper) {
                    wrapper.insertAdjacentHTML('beforebegin', data.html);
                } else {
                    grid.insertAdjacentHTML('beforeend', data.html);
                }
                // update offset
                offset += (data.count || 0);
                btn.dataset.offset = offset;
                // If fewer results than limit, hide the button
                if ((data.count || 0) < limit) {
                    btn.style.display = 'none';
                }
                // notify filter system that new cards were added
                document.dispatchEvent(new CustomEvent('events:cards-added'));
            }
        } catch (err) {
            console.error('Failed to load events', err);
        } finally {
            setLoading(false);
        }
    });
});
