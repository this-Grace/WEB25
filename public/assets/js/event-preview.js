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
    const timeInput = document.getElementById('eventTimeInput');
    const timeHourSelect = document.getElementById('eventTimeHour');
    const timeMinuteSelect = document.getElementById('eventTimeMinute');
    const locationInput = document.getElementById('eventLocationInput');
    const roomInput = document.getElementById('eventRoomInput');
    const maxSeatsInput = document.getElementById('eventMaxSeatsInput');
    const categorySelect = document.getElementById('eventCategorySelector');

    const categoryClassMap = {
        'Conferenze': 'badge-cate-conferenze',
        'Workshop': 'badge-cate-workshop',
        'Seminari': 'badge-cate-seminari',
        'Networking': 'badge-cate-networking',
        'Sport': 'badge-cate-sport',
        'Social': 'badge-cate-social'
    };
    const allCategoryClasses = Object.values(categoryClassMap);

    function formatDate(value) {
        if (!value) return '';
        const d = new Date(value);
        return isNaN(d) ? value : d.toLocaleDateString();
    }

    function updatePreview() {
        if (previewTitle) previewTitle.textContent = titleInput?.value.trim() || 'Titolo del tuo evento';
        if (previewDescription) previewDescription.textContent = descInput?.value.trim() || "Breve descrizione dell'evento";

        const dateVal = dateInput?.value ? formatDate(dateInput.value) : '';
        let timeVal = '';
        if (timeHourSelect && timeMinuteSelect && timeHourSelect.value && timeMinuteSelect.value) {
            timeVal = `${timeHourSelect.value}:${timeMinuteSelect.value}`;
            if (timeInput) timeInput.value = timeVal;
        } else if (timeInput && timeInput.value) {
            timeVal = timeInput.value;
            if (timeHourSelect && timeMinuteSelect) {
                const parts = timeVal.split(':');
                if (parts.length >= 2) {
                    timeHourSelect.value = parts[0].padStart(2, '0');
                    timeMinuteSelect.value = parts[1].padStart(2, '0');
                }
            }
        }
        if (previewDate) previewDate.textContent = (dateVal || timeVal) ? [dateVal, timeVal].filter(Boolean).join(' - ') : 'Data da definire';
        if (previewTime) previewTime.textContent = '';

        if (previewLocation) {
            const building = locationInput?.value.trim() || '';
            const room = roomInput?.value.trim() || '';
            previewLocation.textContent = [building, room].filter(Boolean).join(' — ') || 'Luogo da definire';
        }

        if (previewMaxSeats) previewMaxSeats.textContent = maxSeatsInput?.value || '∞';

        if (previewCategoryBadge) {
            previewCategoryBadge.classList.remove(...allCategoryClasses);
            const v = categorySelect?.value || '';
            const cls = categoryClassMap[v] || '';
            if (cls) previewCategoryBadge.classList.add(cls);
            previewCategoryBadge.textContent = v || 'Categoria';
        }
    }

    const listeners = [
        [titleInput, 'input'],
        [descInput, 'input'],
        [dateInput, 'change'],
        [timeInput, 'change'],
        [timeHourSelect, 'change'],
        [timeMinuteSelect, 'change'],
        [locationInput, 'input'],
        [roomInput, 'input'],
        [maxSeatsInput, 'input'],
        [categorySelect, 'change']
    ];
    listeners.forEach(([el, ev]) => { if (el) el.addEventListener(ev, updatePreview); });

    updatePreview();
});
