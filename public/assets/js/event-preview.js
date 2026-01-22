document.addEventListener('DOMContentLoaded', function () {
    const previewTitle = document.getElementById('previewTitleDisplay');
    const previewDescription = document.getElementById('previewDescription');
    const previewDate = document.getElementById('previewDate');
    const previewTime = document.getElementById('previewTime');
    const previewLocation = document.getElementById('previewLocation');
    const previewMaxSeats = document.getElementById('previewMaxSeats');
    const previewCategoryBadge = document.getElementById('previewCategoryBadge');

    const titleInput = document.getElementById('eventTitleInput');
    const descInput = document.getElementById('eventDescriptionInput');
    const dateInput = document.getElementById('eventDateInput');
    const timeInput = document.getElementById('eventTimeInput'); // hidden input to submit HH:MM
    const timeHourSelect = document.getElementById('eventTimeHour');
    const timeMinuteSelect = document.getElementById('eventTimeMinute');
    const locationInput = document.getElementById('eventLocationInput');
    const roomInput = document.getElementById('eventRoomInput');
    const maxSeatsInput = document.getElementById('eventMaxSeatsInput');
    const categorySelect = document.getElementById('eventCategorySelector');

    function formatDate(value) {
        if (!value) return '';
        try {
            const d = new Date(value);
            if (isNaN(d)) return value;
            return d.toLocaleDateString();
        } catch (e) {
            return value;
        }
    }

    function formatTime24(value) {
        if (!value) return '';
        return value;
    }

    function updatePreview() {
        if (previewTitle && titleInput) previewTitle.textContent = titleInput.value.trim() || 'Titolo del tuo evento';
        if (previewDescription && descInput) previewDescription.textContent = descInput.value.trim() || 'Breve descrizione dell\'evento';

        // Combine date and time into a single display (Data - Ora in 24H)
        if (previewDate) {
            const dateVal = dateInput && dateInput.value ? formatDate(dateInput.value) : '';
            // build HH:MM from selects (if available) or fallback to hidden input
            let timeVal = '';
            if (timeHourSelect && timeMinuteSelect) {
                timeVal = timeHourSelect.value + ':' + timeMinuteSelect.value;
                if (timeInput) timeInput.value = timeVal; // populate hidden input for form submit
            } else if (timeInput && timeInput.value) {
                timeVal = timeInput.value;
            }
            timeVal = timeVal ? formatTime24(timeVal) : '';
            previewDate.textContent = (dateVal || timeVal) ? [dateVal, timeVal].filter(Boolean).join(' - ') : 'Data da definire';
        }
        if (previewTime) previewTime.textContent = ''; // not used now

        if (previewLocation && locationInput) {
            const building = locationInput.value.trim();
            const room = roomInput && roomInput.value.trim() ? roomInput.value.trim() : '';
            const combined = [building, room].filter(Boolean).join(' — ');
            previewLocation.textContent = combined || 'Luogo da definire';
        }
        if (previewMaxSeats && maxSeatsInput) previewMaxSeats.textContent = maxSeatsInput.value ? maxSeatsInput.value : '∞';
        if (previewCategoryBadge && categorySelect) {
            const v = categorySelect.value;
            const cateClasses = [
                'badge-cate-conferenze',
                'badge-cate-workshop',
                'badge-cate-seminari',
                'badge-cate-networking',
                'badge-cate-sport',
                'badge-cate-social'
            ];
            // remove any previous category-specific classes
            previewCategoryBadge.classList.remove(...cateClasses);

            const mapping = {
                'Conferenze': 'badge-cate-conferenze',
                'Workshop': 'badge-cate-workshop',
                'Seminari': 'badge-cate-seminari',
                'Networking': 'badge-cate-networking',
                'Sport': 'badge-cate-sport',
                'Social': 'badge-cate-social'
            };

            const cls = mapping[v] || '';
            if (cls) previewCategoryBadge.classList.add(cls);
            previewCategoryBadge.textContent = v || 'Categoria';
        }
    }

    if (titleInput) titleInput.addEventListener('input', updatePreview);
    if (descInput) descInput.addEventListener('input', updatePreview);
    if (dateInput) dateInput.addEventListener('change', updatePreview);
    if (timeInput) timeInput.addEventListener('change', updatePreview);
    if (timeHourSelect) timeHourSelect.addEventListener('change', updatePreview);
    if (timeMinuteSelect) timeMinuteSelect.addEventListener('change', updatePreview);
    if (locationInput) locationInput.addEventListener('input', updatePreview);
    if (roomInput) roomInput.addEventListener('input', updatePreview);
    if (maxSeatsInput) maxSeatsInput.addEventListener('input', updatePreview);
    if (categorySelect) categorySelect.addEventListener('change', updatePreview);

    // Initialize preview with current values
    // If hidden time input already has a value (e.g., from server or previous state), populate selects
    if (timeInput && timeInput.value && timeHourSelect && timeMinuteSelect) {
        const parts = timeInput.value.split(':');
        if (parts.length >= 2) {
            timeHourSelect.value = parts[0].padStart(2, '0');
            timeMinuteSelect.value = parts[1].padStart(2, '0');
        }
    }

    updatePreview();
});
