document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('load-more-btn');
    if (!btn) return;
    const container = document.getElementById('events-grid');
    let page = parseInt(btn.getAttribute('data-page') || '1', 10);
    const limit = parseInt(btn.getAttribute('data-limit') || '6', 10);

    btn.addEventListener('click', function (e) {
        e.preventDefault();
        page += 1;
        btn.disabled = true;
        btn.textContent = 'Caricamento...';
        fetch(`/api/events.php?page=${page}&limit=${limit}`)
            .then(r => r.json())
            .then(data => {
                if (data && data.html) {
                    const temp = document.createElement('div');
                    temp.innerHTML = data.html;
                    while (temp.firstChild) {
                        container.appendChild(temp.firstChild);
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
