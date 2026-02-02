document.addEventListener('DOMContentLoaded', () => {

    const activeTabId = sessionStorage.getItem('activeProfileTab');
    if (activeTabId) {
        const tabTriggerEl = document.querySelector(`#${activeTabId}`);
        if (tabTriggerEl) {
            const tab = new bootstrap.Tab(tabTriggerEl);
            tab.show();
        }
    }

    const tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
    tabEls.forEach(tabEl => {
        tabEl.addEventListener('shown.bs.tab', (event) => {
            sessionStorage.setItem('activeProfileTab', event.target.id);
        });
    });

    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.btn-ajax');
        if (!btn) return;

        e.preventDefault();
        const url = btn.href;
        
        const isPublish = url.includes('publish_from_draft');
        const isApprove = url.includes('approve_event.php');
        const isDelete = url.includes('delete_event.php');
        const isCancel = url.includes('cancel_event.php');

        if ((isDelete || isCancel) && !confirm('Sei sicuro di voler procedere?')) return;

        try {
            btn.classList.add('disabled');
            const response = await fetch(url, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();

            if (data.success) {
                if ((isPublish || isApprove) && document.getElementById('profileTabsContent')) {
                    window.location.reload();
                    return;
                }

                const cardContainer = btn.closest('article');
                if (cardContainer) {
                    cardContainer.style.transition = 'all 0.3s ease';
                    cardContainer.style.opacity = '0';
                    cardContainer.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        cardContainer.remove();
                        checkEmptyTab(); 
                    }, 300);
                }
            } else {
                alert(data.message || 'Errore');
                btn.classList.remove('disabled');
            }
        } catch (error) {
            console.error('Errore:', error);
            btn.classList.remove('disabled');
        }
    });

    function checkEmptyTab() {
        document.querySelectorAll('.tab-pane').forEach(pane => {
            const container = pane.querySelector('.row');
            if (container && container.children.length === 0) {
                pane.innerHTML = `
                    <div class="text-center py-5 text-muted bg-white rounded-4 shadow-sm border border-dashed">
                        <span class="bi bi-calendar-x display-4 mb-3 d-block opacity-25"></span>
                        <p class="mb-0">Nessun evento presente in questa sezione.</p>
                    </div>`;
            }
        });
    }
});