/**
 * UI Controller for dynamic forms and profile editing.
 * Handles auto-resizing inputs, view/edit mode toggling, and image previews.
 */
document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.form-control-inline');

    /**
     * Dynamically adjusts the width of an input field based on its text content.
     * Uses an off-screen span element to calculate pixel width accurately.
     * @param {HTMLInputElement} input - The input element to resize.
     * @returns {void}
     */
    const syncInputWidth = (input) => {
        const measure = document.createElement('span');
        const style = window.getComputedStyle(input);

        Object.assign(measure.style, {
            visibility: 'hidden',
            position: 'absolute',
            whiteSpace: 'pre',
            font: style.font,
            fontWeight: style.fontWeight,
            fontSize: style.fontSize,
            fontFamily: style.fontFamily,
            letterSpacing: style.letterSpacing,
            textTransform: style.textTransform,
            padding: '0',
            boxSizing: 'content-box'
        });

        measure.textContent = input.value || input.placeholder || " ";
        document.body.appendChild(measure);

        input.style.width = (measure.getBoundingClientRect().width + 2) + 'px';

        document.body.removeChild(measure);
    };

    // Initialize all inline inputs and attach event listeners
    inputs.forEach(input => {
        syncInputWidth(input);
        input.addEventListener('input', () => syncInputWidth(input));
    });

    /**
     * Toggles the UI between viewing mode and editing mode.
     * @global
     * @param {boolean} isEditing - True if switching to edit mode, false for view mode.
     * @returns {void}
     */
    window.toggleEdit = (isEditing) => {
        const views = document.querySelectorAll('.view-mode');
        const edits = document.querySelectorAll('.edit-mode');

        views.forEach(v => v.classList.toggle('d-none', isEditing));
        edits.forEach(e => {
            e.classList.toggle('d-none', !isEditing);
            if (isEditing) e.classList.add('d-flex');
        });

        if (isEditing) {
            setTimeout(() => {
                inputs.forEach(syncInputWidth);
                document.getElementById('input-first-name')?.focus();
            }, 50);
        }
    };

    /**
     * Handles the preview of an uploaded image file.
     * @global
     * @param {HTMLInputElement} input - The file input element.
     * @returns {void}
     */
    window.previewImage = (input) => {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                document.getElementById('display-avatar').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    };
});