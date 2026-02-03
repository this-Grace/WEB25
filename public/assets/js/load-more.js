/**
 * Pagination & Load More Controller
 * Handles incremental loading of event cards while preserving active filter states.
 */
document.addEventListener('DOMContentLoaded', () => {
    const loadMoreBtn = document.getElementById('load-more-btn');
    const eventsGrid = document.getElementById('events-grid');
    const btnText = document.getElementById('btn-text');
    const btnSpinner = document.getElementById('btn-spinner');
    
    /** @type {number} The starting point for the next database query */
    let offset = 6; 
    /** @type {number} Number of items to fetch per request */
    const limit = 6;

    if (!loadMoreBtn) return;

    /**
     * Event listener for the "Load More" button.
     * Collects current filters and requests the next set of events.
     */
    loadMoreBtn.addEventListener('click', async () => {
        loadMoreBtn.disabled = true;
        btnText.textContent = 'Caricamento...';
        btnSpinner.classList.remove('d-none');

        const activeParams = new URLSearchParams();
        
        // Step 1: Sync with current category filters
        document.querySelectorAll('.btn-cate.active').forEach(btn => {
            const id = btn.dataset.id;
            if (id) activeParams.append('categories[]', id);
        });

        // Step 2: Sync with search input
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

    /**
     * Toggles the visibility of the "Load More" button container.
     * @param {boolean} show - Whether to display the button.
     * @returns {void}
     */
    function toggleLoadMoreVisibility(show) {
        const container = document.getElementById('load-more-container');
        if (container) {
            container.style.display = show ? 'block' : 'none';
        }
    }

    /**
     * Resets the pagination offset. 
     * Exposed globally to be called by the filtering system when search/category changes.
     * @global
     * @returns {void}
     */
    window.resetLoadMoreOffset = () => {
        offset = 6;
        toggleLoadMoreVisibility(true);
    };
});