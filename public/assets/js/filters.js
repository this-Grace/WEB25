document.addEventListener('DOMContentLoaded', function () {
    const categoryButtons = document.querySelectorAll('.btn-cate');
    const eventsGrid = document.getElementById('events-grid');
    const activeFiltersSection = document.getElementById('active-filters-section');
    const activeFiltersList = document.getElementById('active-filters-list');
    const clearFiltersBtn = document.getElementById('clear-filters-btn');
    const searchInput = document.getElementById('searchInput');

    let activeCategories = new Map();

    function renderActiveFilters() {
        activeFiltersList.innerHTML = '';

        const hasActive = activeCategories.size > 0 || (searchInput && searchInput.value.trim());
        activeFiltersSection.style.display = hasActive ? 'block' : 'none';

        activeCategories.forEach((data, id) => {
            const filterButton = document.querySelector(`.btn-cate[data-id="${id}"]`);
            const label = filterButton ? filterButton.textContent.trim() : (data.name || id);

            const badge = document.createElement('span');
            badge.classList.add('badge', 'd-flex', 'align-items-center', 'p-2', 'btn-cate');

            // prefer the actual modifier class from the original button, fallback to stored cateClass
            if (filterButton) {
                Array.from(filterButton.classList).forEach(c => {
                    if (c.startsWith('btn-cate-')) badge.classList.add(c);
                });
            } else if (data.cateClass) {
                badge.classList.add(data.cateClass);
            }

            const text = document.createElement('span');
            text.className = 'fw-medium';
            text.textContent = label;

            const closeBtn = document.createElement('button');
            closeBtn.type = 'button';
            closeBtn.className = 'btn-close ms-2';
            closeBtn.setAttribute('data-id', id);
            closeBtn.setAttribute('aria-label', 'Remove filter');
            closeBtn.addEventListener('click', () => {
                activeCategories.delete(id);
                const matched = document.querySelector(`.btn-cate[data-id="${id}"]`);
                if (matched) matched.classList.remove('active');
                fetchAndRender();
            });

            badge.appendChild(text);
            badge.appendChild(closeBtn);
            activeFiltersList.appendChild(badge);
        });

        if (searchInput && searchInput.value.trim()) {
            const sbtn = document.createElement('button');
            sbtn.className = 'btn btn-sm btn-outline-secondary';
            sbtn.textContent = `Ricerca: ${searchInput.value.trim()}`;
            sbtn.addEventListener('click', () => {
                searchInput.value = '';
                fetchAndRender();
            });
            activeFiltersList.appendChild(sbtn);
        }
    }

    async function fetchAndRender() {
        const params = new URLSearchParams();
        // if only one category selected, send the category filter; if multiple, we'll fetch all and client-filter
        if (activeCategories.size === 1) {
            for (let id of activeCategories.keys()) params.set('categoryId', id);
        }
        if (searchInput && searchInput.value.trim()) params.set('search', searchInput.value.trim());
        params.set('limit', 12);

        try {
            const res = await fetch('api/list_events.php?' + params.toString());
            if (!res.ok) throw new Error('Network error');
            const data = await res.json();
            if (!data.success) throw new Error('Server error');

            // If multiple categories selected, filter client-side by data-category-id attributes
            let html = data.html || '';
            eventsGrid.innerHTML = html || `<div class="text-center py-5"><p class="text-muted">Nessun evento disponibile al momento.</p></div>`;

            if (activeCategories.size > 1) {
                // hide events that don't match any selected category
                const selected = new Set(Array.from(activeCategories.keys()).map(x => String(x)));
                const articles = eventsGrid.querySelectorAll('article');
                let anyVisible = false;
                articles.forEach(a => {
                    const cid = a.dataset.categoryId || a.getAttribute('data-category-id');
                    if (selected.has(String(cid))) {
                        a.style.display = '';
                        anyVisible = true;
                    } else {
                        a.style.display = 'none';
                    }
                });
                if (!anyVisible) {
                    eventsGrid.innerHTML = `<div class="text-center py-5"><p class="text-muted">Nessun evento disponibile per i filtri selezionati.</p></div>`;
                }
            }

            renderActiveFilters();
        } catch (err) {
            console.error(err);
        }
    }

    categoryButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            const id = btn.dataset.id;
            const name = btn.textContent.trim();

            // trova la classe btn-cate-*
            const cateClass = Array.from(btn.classList)
                .find(c => c.startsWith('btn-cate-'));

            if (btn.classList.contains('active')) {
                btn.classList.remove('active');
                activeCategories.delete(id);
            } else {
                btn.classList.add('active');
                activeCategories.set(id, { name, cateClass });
            }

            fetchAndRender();
        });
    });


    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', (e) => {
            e.preventDefault();
            // reset
            activeCategories.clear();
            categoryButtons.forEach(b => b.classList.remove('active'));
            if (searchInput) searchInput.value = '';
            fetchAndRender();
        });
    }

    if (searchInput) {
        let timeout = null;
        searchInput.addEventListener('input', () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => fetchAndRender(), 400);
        });
    }

    // initial state: render any server-provided events (no-op) but ensure active filters hidden
    renderActiveFilters();
});