document.addEventListener('DOMContentLoaded', () => {

    const activeTabId = sessionStorage.getItem('activeProfileTab');
    if (activeTabId) {
        const tabTrigger = document.querySelector(`#${activeTabId}`);
        if (tabTrigger) {
            document.querySelectorAll('.nav-link, .tab-pane').forEach(el => {
                el.classList.remove('active', 'show');
            });
            const tab = new bootstrap.Tab(tabTrigger);
            tab.show();
        }
    }

    document.querySelectorAll('#profileTabs a[data-bs-toggle="tab"]').forEach(link => {
        link.addEventListener('shown.bs.tab', (e) => {
            sessionStorage.setItem('activeProfileTab', e.target.id);
        });
    });

    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.btn-ajax');
        if (!btn) return;

        e.preventDefault();

        const url = btn.href;
        const isDelete = url.includes('delete_event.php');
        const isCancel = url.includes('cancel_event.php');
        const isUnsubscribe = url.includes('unsubscribe.php');
        const isPublish = url.includes('publish_from_draft');

        if ((isDelete || isCancel) && !confirm('Sei sicuro di voler procedere?')) {
            return;
        }

        const cardContainer = btn.closest('article');
        const isProfilePage = document.getElementById('profileTabsContent') !== null;

        try {
            btn.classList.add('disabled');
            const response = await fetch(url, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            const data = await response.json();

            if (data.success) {
                if (isPublish && isProfilePage) {
                    window.location.reload();
                    return;
                }

                let shouldRemove = false;

                if (isDelete) {
                    shouldRemove = true;
                } else if (isCancel) {
                    shouldRemove = isProfilePage;
                } else if (isUnsubscribe) {
                    shouldRemove = btn.closest('#subscriber-pane') !== null;
                }

                if (shouldRemove) {
                    cardContainer.style.transition = 'all 0.3s ease';
                    cardContainer.style.opacity = '0';
                    cardContainer.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        cardContainer.remove();
                        if (isProfilePage) checkEmptyTab(); 
                    }, 300);
                } else {
                    if (data.html) {
                        cardContainer.outerHTML = data.html;
                    }
                }
            } else {
                alert(data.message || 'Errore durante l\'operazione');
                btn.classList.remove('disabled');
            }
        } catch (error) {
            console.error('Errore AJAX:', error);
            alert('Errore di connessione o sessione scaduta');
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