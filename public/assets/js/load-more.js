document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('load-more-btn');
    if (!btn) return;
    const container = document.getElementById('events-grid');
    let page = parseInt(btn.getAttribute('data-page') || '1', 10);
    const limit = parseInt(btn.getAttribute('data-limit') || '6', 10);

    const btnWrapper = btn.parentElement; // the full-width wrapper around the button

    btn.addEventListener('click', function (e) {
        e.preventDefault();
        page += 1;
        btn.disabled = true;
        btn.textContent = 'Caricamento...';
        // include current search query if present so pagination keeps the filter
        const searchInput = document.getElementById('searchInput');
        const q = searchInput ? (searchInput.value || '').trim() : '';
        const url = `/api/events.php?page=${page}&limit=${limit}` + (q ? '&q=' + encodeURIComponent(q) : '');
        fetch(url)
            .then(r => r.json())
            .then(data => {
                if (data && data.html) {
                    const temp = document.createElement('div');
                    temp.innerHTML = data.html;
                    // Insert new cards before the load-more button wrapper so the button stays at the end
                    while (temp.firstChild) {
                        if (btnWrapper && container.contains(btnWrapper)) {
                            container.insertBefore(temp.firstChild, btnWrapper);
                        } else {
                            container.appendChild(temp.firstChild);
                        }
                    }
                    if (data.count < limit) {
                        btn.style.display = 'none';
                    } else {
                        btn.disabled = false;
                        btn.textContent = 'Carica altri eventi';
                        btn.setAttribute('data-page', page);
                    }
                } else {
                    btn.style.display = 'none';
                }
            }).catch(() => {
                btn.disabled = false;
                btn.textContent = 'Carica altri eventi';
            });
    });
});
