document.addEventListener('DOMContentLoaded', () => {
    const categoryFilterButtonsContainer = document.querySelector('section.py-4 .d-flex.justify-content-center');
    const activeFiltersSection = document.getElementById('active-filters-section');
    const activeFiltersList = document.getElementById('active-filters-list');
    const clearFiltersBtn = document.getElementById('clear-filters-btn');

    if (!categoryFilterButtonsContainer || !activeFiltersSection || !activeFiltersList) {
        return;
    }

    const categoryClassMap = {
        'Conferenze': 'badge-cate-conferenze',
        'Workshop': 'badge-cate-workshop',
        'Seminari': 'badge-cate-seminari',
        'Networking': 'badge-cate-networking',
        'Sport': 'badge-cate-sport',
        'Social': 'badge-cate-social'
    };

    function resetToDefault() {
        const categoryFilters = categoryFilterButtonsContainer.querySelectorAll('.btn-cate');
        categoryFilters.forEach(btn => btn.classList.remove('active'));
        
        const tuttiButton = Array.from(categoryFilters).find(btn => btn.textContent.trim() === 'Tutti');
        if (tuttiButton) {
            tuttiButton.classList.add('active');
        }

        updateActiveFilters();
    }

    function updateActiveFilters() {
        activeFiltersList.innerHTML = '';
        const activeFilterButtons = categoryFilterButtonsContainer.querySelectorAll('.btn-cate.active');
        let hasActiveFilters = false;

        activeFilterButtons.forEach(button => {
            const filterLabel = button.textContent.trim();
            if (filterLabel === 'Tutti') {
                return;
            }
            
            hasActiveFilters = true;
            const badgeClass = categoryClassMap[filterLabel] || 'bg-secondary text-white';

            const filterBadge = document.createElement('span');
            filterBadge.className = `badge rounded-pill d-flex align-items-center p-2 ps-3 ${badgeClass}`;
            filterBadge.innerHTML = `
                <span class="fw-medium">${filterLabel}</span>
                <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 0.7em;" aria-label="Rimuovi filtro" data-filter="${filterLabel}"></button>
            `;
            activeFiltersList.appendChild(filterBadge);
        });

        activeFiltersSection.style.display = hasActiveFilters ? 'block' : 'none';
    }

    categoryFilterButtonsContainer.addEventListener('click', function (e) {
        if (!e.target.matches('.btn-cate')) {
            return;
        }
        e.preventDefault();
        
        const clickedButton = e.target;
        const isTutti = clickedButton.textContent.trim() === 'Tutti';
        const categoryFilters = categoryFilterButtonsContainer.querySelectorAll('.btn-cate');
        const tuttiButton = Array.from(categoryFilters).find(btn => btn.textContent.trim() === 'Tutti');

        if (isTutti) {
            if (!clickedButton.classList.contains('active')) {
                resetToDefault();
            }
        } else {
            clickedButton.classList.toggle('active');
            if (tuttiButton) {
                tuttiButton.classList.remove('active');
            }
        }

        const anyActive = Array.from(categoryFilters).some(btn => btn.classList.contains('active') && btn.textContent.trim() !== 'Tutti');
        if (!anyActive && tuttiButton && !tuttiButton.classList.contains('active')) {
            tuttiButton.classList.add('active');
        }

        updateActiveFilters();
    });

    activeFiltersList.addEventListener('click', function (e) {
        if (!e.target.matches('button[data-filter]')) {
            return;
        }
        
        const filterToRemove = e.target.dataset.filter;
        const categoryFilters = categoryFilterButtonsContainer.querySelectorAll('.btn-cate');
        const buttonToDeactivate = Array.from(categoryFilters).find(btn => btn.textContent.trim() === filterToRemove);
        
        if (buttonToDeactivate) {
            buttonToDeactivate.classList.remove('active');
        }

        const anyActive = Array.from(categoryFilters).some(btn => btn.classList.contains('active') && btn.textContent.trim() !== 'Tutti');
        if (!anyActive) {
            const tuttiButton = Array.from(categoryFilters).find(btn => btn.textContent.trim() === 'Tutti');
            if (tuttiButton) {
                tuttiButton.classList.add('active');
            }
        }
        
        updateActiveFilters();
    });

    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', (e) => {
            e.preventDefault();
            resetToDefault();
        });
    }
    
    updateActiveFilters();
});
