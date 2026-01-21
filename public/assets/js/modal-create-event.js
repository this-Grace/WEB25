(() => {
    'use strict';

    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('createEventModal');
        if (!modal) return;

        const pageRegions = Array.from(document.querySelectorAll('header, main, footer'));
        let lastTrigger = null;

        modal.addEventListener('show.bs.modal', (ev) => {
            lastTrigger = document.activeElement;
            pageRegions.forEach(el => {
                try {
                    if ('inert' in el) el.inert = true;
                    else el.setAttribute('aria-hidden', 'true');
                } catch (e) {
                    el.setAttribute('aria-hidden', 'true');
                }
            });
        });

        modal.addEventListener('hidden.bs.modal', (ev) => {
            pageRegions.forEach(el => {
                try {
                    if ('inert' in el) el.inert = false;
                    else el.removeAttribute('aria-hidden');
                } catch (e) {
                    el.removeAttribute('aria-hidden');
                }
            });
            if (lastTrigger && typeof lastTrigger.focus === 'function') {
                lastTrigger.focus();
            }
            lastTrigger = null;
        });

        // --- Preview + drag/drop image upload ---
        const titleInput = document.getElementById('modal-event-title');
        const dateInput = document.getElementById('modal-event-date');
        const startTimeInput = document.getElementById('modal-event-start-time');
        const endTimeInput = document.getElementById('modal-event-end-time');
        const locationInput = document.getElementById('modal-event-location');
        const maxParticipantsInput = document.getElementById('modal-event-max-participants');
        const imageInput = document.getElementById('modal-event-image');
        const dropzone = document.getElementById('modal-image-dropzone');

        const previewTitle = document.getElementById('create-event-preview-title');
        const previewMeta = document.getElementById('create-event-preview-meta');
        const previewImage = document.getElementById('create-event-preview-image');

        const updatePreview = () => {
            if (previewTitle) previewTitle.textContent = titleInput && titleInput.value ? titleInput.value : 'Titolo del tuo evento';
            const parts = [];
            if (dateInput && dateInput.value) {
                const date = dateInput.value;
                let timeRange = '';
                if (startTimeInput && startTimeInput.value) timeRange += startTimeInput.value;
                if (endTimeInput && endTimeInput.value) timeRange += (timeRange ? ' - ' : '') + endTimeInput.value;
                parts.push(`${date}${timeRange ? ' • ' + timeRange : ''}`);
            } else {
                parts.push('Data e ora');
            }
            parts.push(locationInput && locationInput.value ? locationInput.value : 'Luogo');
            parts.push(maxParticipantsInput && maxParticipantsInput.value ? `${maxParticipantsInput.value} posti` : 'Partecipanti');
            if (previewMeta) previewMeta.innerHTML = parts.join('<br>');
        };

        [titleInput, dateInput, startTimeInput, endTimeInput, locationInput, maxParticipantsInput].forEach(el => {
            if (!el) return;
            el.addEventListener('input', updatePreview);
        });

        const handleFile = (file) => {
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                if (previewImage) {
                    previewImage.src = e.target.result;
                    previewImage.alt = titleInput && titleInput.value ? titleInput.value : 'Anteprima evento';
                }
            };
            reader.readAsDataURL(file);
        };

        if (imageInput) {
            imageInput.addEventListener('change', (ev) => {
                const f = ev.target.files && ev.target.files[0];
                handleFile(f);
            });
        }

        if (dropzone) {
            const prevent = (e) => { e.preventDefault(); e.stopPropagation(); };
            ['dragenter', 'dragover'].forEach(evt => dropzone.addEventListener(evt, (e) => { prevent(e); dropzone.classList.add('drag-over'); }));
            ['dragleave', 'drop', 'dragend'].forEach(evt => dropzone.addEventListener(evt, (e) => { prevent(e); dropzone.classList.remove('drag-over'); }));
            dropzone.addEventListener('drop', (e) => {
                prevent(e);
                const dt = e.dataTransfer;
                if (dt && dt.files && dt.files[0]) {
                    const file = dt.files[0];
                    if (imageInput) imageInput.files = dt.files;
                    handleFile(file);
                }
            });
            dropzone.addEventListener('click', () => imageInput && imageInput.click());
            dropzone.addEventListener('keydown', (e) => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); imageInput && imageInput.click(); } });
        }

        // Initialize preview values
        updatePreview();
    });
})();
