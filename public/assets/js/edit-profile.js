document.addEventListener('DOMContentLoaded', function () {
    const profileContainer = document.getElementById('profile-container');
    const btnSave = document.getElementById('btn-save');

    if (!profileContainer) return;

    /**
     * Toggles between view mode and edit mode
     * @param {boolean} isEditing - State of the editor
     */
    window.toggleEdit = function (isEditing) {
        const viewModes = profileContainer.querySelectorAll('.view-mode');
        const editModes = profileContainer.querySelectorAll('.edit-mode');

        if (isEditing) {
            // Hide text, show inputs
            viewModes.forEach(el => el.classList.add('d-none'));
            editModes.forEach(el => {
                el.classList.remove('d-none');
                // Re-apply flex layout to the name row if necessary
                if (el.id === 'wrapper-name-edit' || el.querySelector('.edit-input-flex')) {
                    el.classList.add('d-flex');
                }
            });

            // Auto-focus the first input field
            const firstInput = document.getElementById('input-first-name');
            if (firstInput) firstInput.focus();
        } else {
            // Show text, hide inputs
            viewModes.forEach(el => el.classList.remove('d-none'));
            editModes.forEach(el => {
                el.classList.add('d-none');
                el.classList.remove('d-flex');
            });
        }
    };
});

/**
 * Global style injection for consistent interaction states
 */
(function addInlineStyles() {
    const id = 'edit-profile-js-styles';
    if (document.getElementById(id)) return;
    const style = document.createElement('style');
    style.id = id;
    style.innerHTML = `
        .spinner-border-sm { width: 1rem; height: 1rem; border-width: 0.15em; }
        .edit-mode.d-flex { align-items: baseline; }
    `;
    document.head.appendChild(style);
})();