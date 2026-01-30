document.addEventListener('DOMContentLoaded', function () {
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('fileElem');
    const previewImg = document.getElementById('previewImageSidebar');

    if (!dropArea || !fileInput || !previewImg) return;

    function highlight() { dropArea.classList.add('dragover'); }
    function unhighlight() { dropArea.classList.remove('dragover'); }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            highlight();
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            unhighlight();
        }, false);
    });

    dropArea.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }, false);

    fileInput.addEventListener('change', (e) => {
        handleFiles(fileInput.files);
    });

    dropArea.addEventListener('click', () => fileInput.click());

    function handleFiles(files) {
        if (!files || files.length === 0) return;
        const file = files[0];

        if (!file.type.startsWith('image/')) {
            alert('Seleziona un file immagine (PNG/JPG/GIF).');
            return;
        }
        const maxSize = 10 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('Immagine troppo grande. Dimensione massima: 10MB.');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            previewImg.src = e.target.result;
        };
        reader.readAsDataURL(file);

        try {
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;
        } catch (err) {
            console.warn('Could not assign file to input programmatically', err);
        }
    }
});

(function addDragStyle() {
    const id = 'drag-and-drop-inline-style';
    if (document.getElementById(id)) return;
    const style = document.createElement('style');
    style.id = id;
    style.innerHTML = `#drop-area.dragover { border-color: #0d6efd; background-color: rgba(13,110,253,0.03); }`;
    document.head.appendChild(style);
})();