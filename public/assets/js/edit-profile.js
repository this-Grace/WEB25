document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.form-control-inline');
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

    inputs.forEach(input => {
        syncInputWidth(input);
        input.addEventListener('input', () => syncInputWidth(input));
    });

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

    window.previewImage = (input) => {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                document.getElementById('display-avatar').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    const unsubModal = document.getElementById('unsubEventModal');
    if (unsubModal) {
        unsubModal.addEventListener('show.bs.modal', (e) => {
            const btn = e.relatedTarget;
            unsubModal.querySelector('#modal-event-name').textContent = btn.dataset.eventTitle;
            unsubModal.querySelector('#modal-event-id').value = btn.dataset.eventId;
        });
    }
});