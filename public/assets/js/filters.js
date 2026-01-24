document.addEventListener('DOMContentLoaded', () => {
    const ALL_FILTERS_ID = 'all';

    const filterButtons = document.querySelectorAll('.btn-cate');
    const getCards = () => document.querySelectorAll('[data-category-id]');
    const activeFiltersSection = document.getElementById('active-filters-section');
    const activeFiltersList = document.getElementById('active-filters-list');
    const clearFiltersButton = document.getElementById('clear-filters-btn');

    const activeFilters = new Set();

    if (!filterButtons.length || !activeFiltersSection || !activeFiltersList) {
        console.warn('Filter script cannot run: one or more essential elements are missing from the DOM.');
        return;
    }

    const applyFiltersToCards = () => {
        const cards = getCards();
        const hasActiveFilters = activeFilters.size > 0;

        cards.forEach(card => {
            if (!hasActiveFilters) {
                card.style.display = '';
                return;
            }

            const categoryId = card.dataset.categoryId || '';
            const userEmail = card.dataset.userEmail || '';
            const status = card.dataset.status || '';

            const isVisible = [...activeFilters].some(id =>
                id === categoryId ||
                id === userEmail ||
                (id === 'waiting' && status === 'WAITING')
            );

            card.style.display = isVisible ? '' : 'none';
        });
    };

    /**
     * Re-renders the entire filter UI based on the current state.
     */
    const render = () => {
        const hasActiveFilters = activeFilters.size > 0;

        activeFiltersSection.style.display = hasActiveFilters ? 'block' : 'none';

        activeFiltersList.innerHTML = '';
        activeFilters.forEach(id => {
            const filterButton = document.querySelector(`.btn-cate[data-id="${id}"]`);
            const label = filterButton ? filterButton.textContent.trim() : id;

            const badgeHTML = `
                <span class="badge d-flex align-items-center p-2 btn-cate ${[...filterButton?.classList].filter(c => c.startsWith('btn-cate-')).join(' ')}">
                    <span class="fw-medium">${label}</span>
                    <button type="button" class="btn-close ms-2" data-id="${id}" aria-label="Remove filter"></button>
                </span>
            `;
            activeFiltersList.insertAdjacentHTML('beforeend', badgeHTML);
        });

        applyFiltersToCards();

        const allButton = document.querySelector(`.btn-cate[data-id="${ALL_FILTERS_ID}"]`);
        if (allButton) {
            allButton.classList.toggle('active', !hasActiveFilters);
        }
    };

    /**
     * Deactivates all filters and resets the UI.
     */
    const resetFilters = () => {
        activeFilters.clear();
        filterButtons.forEach(button => button.classList.remove('active'));
        render();
    };

    const handleFilterButtonClick = (e) => {
        e.preventDefault();
        const button = e.currentTarget;
        const id = button.dataset.id || '';

        if (id === ALL_FILTERS_ID) {
            resetFilters();
            return;
        }

        button.classList.toggle('active');
        if (button.classList.contains('active')) {
            activeFilters.add(id);
        } else {
            activeFilters.delete(id);
        }
        render();
    };

    const handleBadgeRemoveClick = (e) => {
        const removeButton = e.target.closest('button[data-id]');
        if (!removeButton) return;

        const id = removeButton.dataset.id;
        activeFilters.delete(id);

        const filterButton = document.querySelector(`.btn-cate[data-id="${id}"]`);
        if (filterButton) {
            filterButton.classList.remove('active');
        }
        render();
    };

    filterButtons.forEach(button => button.addEventListener('click', handleFilterButtonClick));
    activeFiltersList.addEventListener('click', handleBadgeRemoveClick);
    if (clearFiltersButton) {
        clearFiltersButton.addEventListener('click', (e) => {
            e.preventDefault();
            resetFilters();
        });
    }
    document.addEventListener('events:cards-added', () => applyFiltersToCards());

    render();
});