document.addEventListener('DOMContentLoaded', () => {
    const profileContainer = document.getElementById('profile-container');
    const inlineInputs = document.querySelectorAll('.form-control-inline');

    if (!profileContainer) return;

    const syncInputWidth = (input) => {
        const tempSpan = document.createElement('span');
        const style = window.getComputedStyle(input);
        
        Object.assign(tempSpan.style, {
            visibility: 'hidden',
            position: 'absolute',
            whiteSpace: 'pre',
            font: style.font,
            letterSpacing: style.letterSpacing,
            textTransform: style.textTransform
        });

        tempSpan.innerText = input.value || input.placeholder || " ";
        document.body.appendChild(tempSpan);
        input.style.width = `${tempSpan.offsetWidth + 2}px`;
        document.body.removeChild(tempSpan);
    };

    inlineInputs.forEach(input => {
        syncInputWidth(input);
        input.addEventListener('input', () => syncInputWidth(input));
    });

    /**
     * Toggles between view mode and edit mode
     * @param {boolean} isEditing - State of the editor
     */
    window.toggleEdit = (isEditing) => {
        const viewModes = profileContainer.querySelectorAll('.view-mode');
        const editModes = profileContainer.querySelectorAll('.edit-mode');

        viewModes.forEach(el => el.classList.toggle('d-none', isEditing));
        editModes.forEach(el => {
            el.classList.toggle('d-none', !isEditing);
            el.classList.toggle('d-flex', isEditing);

            const isTarget = el.id === 'wrapper-name-edit' || el.classList.contains('buttons-edit-wrapper');
            el.classList.toggle('justify-content-center-mobile', isEditing && isTarget);
        });

        if (isEditing) {
            setTimeout(() => inlineInputs.forEach(syncInputWidth), 0);
            document.getElementById('input-first-name')?.focus();
        }
    };
});