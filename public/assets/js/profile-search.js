document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('profileSearchInput');
    const searchContainer = document.getElementById('profile-search-container');
    const tabButtons = document.querySelectorAll('#profileTabs button');

    const handleSearch = () => {
        const term = searchInput.value.toLowerCase().trim();
        const activePane = document.querySelector('.tab-pane.active');
        if (!activePane) return;

        const cards = activePane.querySelectorAll('article');
        let foundAny = false;

        cards.forEach(card => {
            const title = card.querySelector('.card-title')?.innerText || '';
            const description = card.querySelector('.preview-description')?.innerText || '';
            const location = card.querySelector('.bi-geo-alt')?.parentElement?.innerText || '';
            const date = card.querySelector('.bi-calendar3')?.parentElement?.innerText || '';

            const statusBadge = card.querySelector('.position-absolute.top-50 .badge')?.innerText || '';
            const categoryElement = card.querySelector('[class*="badge-cate-"]');
            const category = categoryElement ? (categoryElement.textContent || categoryElement.innerText) : '';

            const allContent = [title, description, category, location, date, statusBadge]
                .join(' ')
                .toLowerCase()
                .trim();

            if (allContent.includes(term)) {
                card.classList.remove('d-none');
                foundAny = true;
            } else {
                card.classList.add('d-none');
            }
        });

        let noResultMsg = activePane.querySelector('.search-no-results');
        if (!foundAny && term.length > 0) {
            if (!noResultMsg) {
                noResultMsg = document.createElement('div');
                noResultMsg.className = 'search-no-results text-center py-5 w-100';
                noResultMsg.innerHTML = `<p class="text-muted">Nessun risultato per "<strong>${term}</strong>"</p>`;
                activePane.querySelector('.row').appendChild(noResultMsg);
            }
        } else if (noResultMsg) {
            noResultMsg.remove();
        }
    };

    const toggleSearchVisibility = () => {
        const activePane = document.querySelector('.tab-pane.active');
        const hasEvents = activePane && activePane.querySelectorAll('article').length > 0;
        searchContainer?.classList.toggle('d-none', !hasEvents);
    };

    if (searchInput) {
        searchInput.addEventListener('input', handleSearch);
    }

    tabButtons.forEach(btn => {
        btn.addEventListener('shown.bs.tab', () => {
            if (searchInput) searchInput.value = '';
            document.querySelectorAll('article').forEach(a => a.classList.remove('d-none'));
            document.querySelectorAll('.search-no-results').forEach(m => m.remove());
            toggleSearchVisibility();
        });
    });

    toggleSearchVisibility();
});