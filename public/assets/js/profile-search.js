document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('profileSearchInput');
    const searchContainer = document.getElementById('profile-search-container');
    const tabButtons = document.querySelectorAll('#profileTabs button');

    const toggleSearchVisibility = () => {
        const activePane = document.querySelector('.tab-pane.active');
        const hasEvents = activePane && activePane.querySelector('.row') && activePane.querySelector('.row').children.length > 0;
        const isPlaceholderPresent = activePane && activePane.querySelector('.bi-calendar-x');

        if (hasEvents && !isPlaceholderPresent) {
            searchContainer.classList.remove('d-none');
        } else {
            searchContainer.classList.add('d-none');
        }
    };

    const handleSearch = () => {
        const term = searchInput.value.toLowerCase().trim();
        const activePane = document.querySelector('.tab-pane.active');
        if (!activePane) return;

        const cards = activePane.querySelectorAll('article');
        let foundAny = false;

        cards.forEach(card => {
            const title = card.querySelector('.card-title')?.textContent || '';
            const description = card.querySelector('.preview-description')?.textContent || '';
            const category = card.querySelector('.badge')?.textContent || '';
            const location = card.querySelector('.bi-geo-alt')?.parentElement?.textContent || '';
            const date = card.querySelector('.bi-calendar3')?.parentElement?.textContent || '';

            const allContent = `${title} ${description} ${category} ${location} ${date}`.toLowerCase();

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
                noResultMsg.innerHTML = `
                    <div class="text-muted">
                        <i class="bi bi-search display-6 d-block mb-3 opacity-25"></i>
                        <p>Nessun risultato trovato per "<strong>${term}</strong>"</p>
                    </div>`;
                activePane.querySelector('.row').appendChild(noResultMsg);
            }
        } else if (noResultMsg) {
            noResultMsg.remove();
        }
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