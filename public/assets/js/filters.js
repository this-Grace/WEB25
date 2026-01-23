document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.btn-cate');
    const cards = document.querySelectorAll('[data-category-id]');
    const activeSection = document.getElementById('active-filters-section');
    const activeList = document.getElementById('active-filters-list');
    const clearBtn = document.getElementById('clear-filters-btn');

    if (!buttons.length || !activeSection || !activeList) return;

    const active = new Set();

    function render() {
        activeList.innerHTML = '';
        const hasAny = active.size > 0;
        activeSection.style.display = hasAny ? 'block' : 'none';

        // render badges
        active.forEach(id => {
            const btn = document.querySelector('.btn-cate[data-id="' + id + '"]');
            const label = btn ? btn.textContent.trim() : id;
            const span = document.createElement('span');
            span.className = 'badge rounded-pill d-flex align-items-center p-2';
            span.innerHTML = '<span class="fw-medium">' + label + '</span>';
            const rem = document.createElement('button');
            rem.type = 'button';
            rem.className = 'btn-close ms-2';
            rem.setAttribute('aria-label', 'Rimuovi filtro');
            rem.dataset.id = id;
            span.appendChild(rem);
            activeList.appendChild(span);
        });

        // filter cards
        if (!hasAny) {
            cards.forEach(c => c.style.display = '');
        } else {
            cards.forEach(c => {
                const cid = (c.dataset.categoryId || '').toString();
                c.style.display = active.has(cid) ? '' : 'none';
            });
        }
    }

    function reset() {
        active.clear();
        buttons.forEach(b => b.classList.remove('active'));
        const tutti = document.querySelector('.btn-cate[data-id="tutti"]');
        if (tutti) tutti.classList.add('active');
        render();
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const id = (btn.dataset.id || '').toString();
            if (id === 'tutti') {
                reset();
                return;
            }
            btn.classList.toggle('active');
            if (btn.classList.contains('active')) active.add(id); else active.delete(id);

            const tutti = document.querySelector('.btn-cate[data-id="tutti"]');
            if (tutti && active.size > 0) tutti.classList.remove('active');
            if (active.size === 0 && tutti) tutti.classList.add('active');
            render();
        });
    });

    activeList.addEventListener('click', e => {
        const remBtn = e.target.closest('button[data-id]');
        if (!remBtn) return;
        const id = remBtn.dataset.id;
        active.delete(id);
        const btn = document.querySelector('.btn-cate[data-id="' + id + '"]');
        if (btn) btn.classList.remove('active');
        const tutti = document.querySelector('.btn-cate[data-id="tutti"]');
        if (active.size === 0 && tutti) tutti.classList.add('active');
        render();
    });

    if (clearBtn) clearBtn.addEventListener('click', e => { e.preventDefault(); reset(); });

    // initial render
    render();
});
