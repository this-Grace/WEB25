document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('searchInput');
    const grid = document.getElementById('events-grid');
    const btn = document.getElementById('load-more-btn');
    const limit = btn ? parseInt(btn.dataset.limit || '6', 10) : 6;

    if (!input) return;

    let debounceTimer = null;

    const doSearch = async (query) => {
        const filters = Array.from(document.querySelectorAll('.btn-cate.active'))
            .map(b => b.dataset.id)
            .filter(x => x !== undefined && x !== null)
            .join(',');

        try {
            const resp = await fetch(`/api/load_events.php?offset=0&limit=${limit}&filters=${encodeURIComponent(filters)}${query ? '&q=' + encodeURIComponent(query) : ''}`);
            if (!resp.ok) throw new Error('Network error');
            const data = await resp.json();
            if (data && typeof data.html === 'string') {
                // remove existing article cards (keep wrapper/button intact)
                const wrapper = btn ? btn.parentElement : null;
                // remove all children that are article elements
                Array.from(grid.children).forEach(child => {
                    if (child.tagName && child.tagName.toLowerCase() === 'article') child.remove();
                });

                if (wrapper) {
                    // insert new html items before wrapper
                    wrapper.insertAdjacentHTML('beforebegin', data.html);
                } else {
                    // fallback: replace all grid content
                    grid.innerHTML = data.html;
                }

                // update offset on button and visibility
                if (btn) {
                    btn.dataset.offset = data.count || 0;
                    if ((data.count || 0) < limit) btn.style.display = 'none'; else btn.style.display = '';
                }

                document.dispatchEvent(new CustomEvent('events:cards-added'));
            }
        } catch (err) {
            console.error('Search failed', err);
        }
    };

    input.addEventListener('input', (e) => {
        const q = e.target.value.trim();
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => doSearch(q), 300);
    });
});
