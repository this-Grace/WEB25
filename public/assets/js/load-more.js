document.addEventListener('DOMContentLoaded', () => {
    const loadMoreBtn = document.getElementById('load-more-btn');
    const eventsGrid = document.getElementById('events-grid');
    const btnText = document.getElementById('btn-text');
    const btnSpinner = document.getElementById('btn-spinner');
    
    let offset = 6; 
    const limit = 6;

    if (!loadMoreBtn) return;

    loadMoreBtn.addEventListener('click', async () => {
        loadMoreBtn.disabled = true;
        btnText.textContent = 'Caricamento...';
        btnSpinner.classList.remove('d-none');

        const activeParams = new URLSearchParams();
        
        document.querySelectorAll('.btn-cate.active').forEach(btn => {
            const id = btn.dataset.id;
            if (id) activeParams.append('categories[]', id);
        });

        const searchInput = document.getElementById('searchInput');
        if (searchValue = searchInput?.value.trim()) {
            activeParams.set('search', searchValue);
        }

        activeParams.set('offset', offset);
        activeParams.set('limit', limit);

        try {
            const response = await fetch(`api/list_events.php?${activeParams.toString()}`);
            const data = await response.json();

            if (data.success && data.html.trim() !== "") {
                eventsGrid.insertAdjacentHTML('beforeend', data.html);
                
                offset += limit;

                if (data.count < limit) {
                    toggleLoadMoreVisibility(false);
                }
            } else {
                toggleLoadMoreVisibility(false);
            }
        } catch (error) {
            console.error('Errore Load More:', error);
        } finally {
            if (loadMoreBtn) {
                loadMoreBtn.disabled = false;
                btnText.textContent = 'Carica Altri';
                btnSpinner.classList.add('d-none');
            }
        }
    });

    function toggleLoadMoreVisibility(show) {
        const container = document.getElementById('load-more-container');
        if (container) {
            container.style.display = show ? 'block' : 'none';
        }
    }

    window.resetLoadMoreOffset = () => {
        offset = 6;
        toggleLoadMoreVisibility(true);
    };
});