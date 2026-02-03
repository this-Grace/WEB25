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
            badge.classList.add('badge', 'd-flex', 'align-items-center', 'p-2', 'btn-cate', 'me-2', 'mb-2');

            if (filterButton) {
                Array.from(filterButton.classList).forEach(c => {
                    if (c.startsWith('btn-cate-')) badge.classList.add(c);
                });
            }

            const text = document.createElement('span');
            text.className = 'fw-medium';
            text.textContent = label;

            const closeBtn = document.createElement('button');
            closeBtn.type = 'button';
            closeBtn.className = 'btn-close ms-2';
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
            sbtn.className = 'btn btn-sm btn-outline-secondary me-2 mb-2';
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

        activeCategories.forEach((data, id) => {
            params.append('categories[]', id);
        });

        if (searchInput && searchInput.value.trim()) {
            params.set('search', searchInput.value.trim());
        }

        const limit = 6;
        params.set('limit', limit);
        params.set('offset', 0);

        try {
            eventsGrid.style.opacity = '0.5';
            const res = await fetch('api/list_events.php?' + params.toString());
            const data = await res.json();

            if (data.success) {
                eventsGrid.innerHTML = data.html ||
                    `<div class="text-center py-5 w-100"><p class="text-muted">Nessun evento trovato.</p></div>`;
                
                if (typeof window.resetLoadMoreOffset === 'function') {
                    window.resetLoadMoreOffset();
                }

                const loadMoreBtn = document.getElementById('load-more-container');
                if (loadMoreBtn) {
                    loadMoreBtn.style.display = (data.count < limit) ? 'none' : 'block';
                }
            }

            eventsGrid.style.opacity = '1';
            renderActiveFilters();
        } catch (err) {
            console.error('Errore:', err);
            eventsGrid.style.opacity = '1';
        }
    }

    categoryButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const id = btn.dataset.id;
            const name = btn.textContent.trim();

            if (btn.classList.contains('active')) {
                btn.classList.remove('active');
                activeCategories.delete(id);
            } else {
                btn.classList.add('active');
                activeCategories.set(id, { name });
            }
            fetchAndRender();
        });
    });

    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', (e) => {
            e.preventDefault();
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
    renderActiveFilters();
});