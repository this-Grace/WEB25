document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('homepage-search-form');
    const input = document.getElementById('searchInput');
    const grid = document.getElementById('events-grid');
    const activeSection = document.getElementById('active-filters-section');
    const activeList = document.getElementById('active-filters-list');
    const clearBtn = document.getElementById('clear-filters-btn');

    function normalize(s) {
        return (s || '').toLowerCase();
    }

    if (!form || !grid) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const qRaw = (input && input.value || '').trim();
        const q = qRaw.toLowerCase();
        const loadMoreBtn = document.getElementById('load-more-btn');
        const limit = parseInt(loadMoreBtn?.getAttribute('data-limit') || '6', 10);
        const btnWrapper = loadMoreBtn ? loadMoreBtn.parentElement : null;

        // If empty query, reload first page (unfiltered)
        const url = '/api/events.php?page=1&limit=' + limit + (qRaw ? '&q=' + encodeURIComponent(qRaw) : '');

        fetch(url)
            .then(r => r.json())
            .then(data => {
                if (!data || !data.html) return;
                const temp = document.createElement('div');
                temp.innerHTML = data.html;
                // clear existing cards but keep button wrapper
                if (btnWrapper && grid.contains(btnWrapper)) grid.removeChild(btnWrapper);
                grid.innerHTML = '';
                while (temp.firstChild) {
                    grid.appendChild(temp.firstChild);
                }
                if (btnWrapper) grid.appendChild(btnWrapper);

                // adjust load-more visibility and state
                if (data.count < limit) {
                    if (loadMoreBtn) loadMoreBtn.style.display = 'none';
                } else {
                    if (loadMoreBtn) {
                        loadMoreBtn.style.display = '';
                        loadMoreBtn.disabled = false;
                        loadMoreBtn.textContent = 'Carica altri eventi';
                        loadMoreBtn.setAttribute('data-page', '1');
                    }
                }

                // show active filter
                if (qRaw) {
                    if (activeSection) {
                        activeSection.style.display = '';
                        activeList.innerHTML = '';
                        const badge = document.createElement('span');
                        badge.className = 'btn btn-sm btn-outline-secondary';
                        badge.textContent = 'Ricerca: "' + qRaw + '"';
                        activeList.appendChild(badge);
                    }
                } else {
                    if (activeSection) {
                        activeSection.style.display = 'none';
                        activeList.innerHTML = '';
                    }
                }
            }).catch(() => {
                // fallback: do nothing
            });
    });

    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            if (input) input.value = '';
            Array.from(grid.querySelectorAll('.col-lg-4')).forEach(c => c.style.display = '');
            if (activeSection) {
                activeSection.style.display = 'none';
                activeList.innerHTML = '';
            }
        });
    }
});
