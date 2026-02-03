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

    document.querySelectorAll('#profileTabs button[data-bs-toggle="tab"]').forEach(link => {
        link.addEventListener('shown.bs.tab', (e) => {
            sessionStorage.setItem('activeProfileTab', e.target.id);
        });
    });

    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.btn-ajax');
        if (!btn) return;

        e.preventDefault();
        const url = btn.href;

        const isPublish = url.includes('publish_from_draft');
        const isDelete = url.includes('delete_event.php');
        const isCancel = url.includes('cancel_event.php');
        const isUnsubscribe = url.includes('unsubscribe.php');

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
                const currentTab = btn.closest('.tab-pane')?.id;

                if ((isPublish || isCancel) && isProfilePage) {
                    const targetPaneId = isPublish ? 'waiting-pane' : 'history-pane';
                    const targetPane = document.getElementById(targetPaneId);
                    
                    if (targetPane) {
                        let targetRow = targetPane.querySelector('.row');
                        if (!targetRow || targetPane.querySelector('.bi-calendar-x')) {
                            targetPane.innerHTML = '<div class="row g-4"></div>';
                            targetRow = targetPane.querySelector('.row');
                        }

                        cardContainer.style.transition = 'all 0.3s ease';
                        cardContainer.style.opacity = '0';
                        cardContainer.style.transform = 'scale(0.9)';

                        setTimeout(() => {
                            cardContainer.remove();
                            if (data.html) {
                                targetRow.insertAdjacentHTML('afterbegin', data.html);
                            }
                            checkEmptyTab();
                        }, 300);
                    }
                } 
                else if (isDelete || (isUnsubscribe && currentTab === 'subscriber-pane')) {
                    cardContainer.style.transition = 'all 0.3s ease';
                    cardContainer.style.opacity = '0';
                    cardContainer.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        cardContainer.remove();
                        if (isProfilePage) checkEmptyTab();
                    }, 300);
                } 
                else {
                    if (data.html) {
                        cardContainer.outerHTML = data.html;
                    } else {
                        window.location.reload();
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
            if (!container || container.querySelectorAll('article').length === 0) {
                pane.innerHTML = `
                    <div class="text-center py-5 text-muted bg-white rounded-4 shadow-sm border border-dashed">
                        <span class="bi bi-calendar-x display-4 mb-3 d-block opacity-25"></span>
                        <p class="mb-0">Nessun evento presente in questa sezione.</p>
                    </div>`;
            }
        });
    }
});