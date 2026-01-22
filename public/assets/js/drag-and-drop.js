(() => {
    'use strict';

    const resizeToDataUrl = (image, w, h, quality = 0.9) => {
        const canvas = document.createElement('canvas');
        canvas.width = w;
        canvas.height = h;
        const ctx = canvas.getContext('2d');
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, w, h);
        const ratio = Math.min(w / image.width, h / image.height);
        const newW = image.width * ratio;
        const newH = image.height * ratio;
        const dx = (w - newW) / 2;
        const dy = (h - newH) / 2;
        ctx.drawImage(image, dx, dy, newW, newH);
        return canvas.toDataURL('image/jpeg', quality);
    };

    function handleFiles(files, previewImageSidebar, gallery) {
        if (files.length > 0) {
            const file = files[0];
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = function () {
                const imgObj = new Image();
                imgObj.onload = function () {
                    const targetW = 800;
                    const targetH = 450;
                    const dataUrl = resizeToDataUrl(imgObj, targetW, targetH, 0.92);
                    if (previewImageSidebar) previewImageSidebar.src = dataUrl;
                    const thumb = document.createElement('img');
                    thumb.src = resizeToDataUrl(imgObj, 300, 170, 0.8);
                    thumb.classList.add('img-fluid', 'rounded-3', 'mt-3');
                    thumb.style.maxHeight = '120px';
                    if (gallery) {
                        gallery.innerHTML = '';
                        gallery.appendChild(thumb);
                    }
                };
                imgObj.src = reader.result;
            }
        }
    }

    function setupFileUpload(dropArea, fileElem, previewImageSidebar) {
        if (!dropArea || !fileElem) return;

        const gallery = document.getElementById('gallery');

        dropArea.addEventListener('click', () => fileElem.click());

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.classList.add('bg-primary-subtle'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.classList.remove('bg-primary-subtle'), false);
        });

        dropArea.addEventListener('drop', e => {
            handleFiles(e.dataTransfer.files, previewImageSidebar, gallery);
        }, false);

        fileElem.addEventListener('change', function () {
            handleFiles(this.files, previewImageSidebar, gallery);
        });
    }

    function updateCategoryBadge(previewCategoryBadge, value) {
        if (!previewCategoryBadge) return;
        if (!value) value = 'Categoria';
        previewCategoryBadge.textContent = value;
        const suffix = value.toString().toLowerCase().replace(/\s+/g, '-');
        previewCategoryBadge.className = `badge badge-cate-${suffix} position-absolute top-0 start-0 m-3 shadow-sm`;
    }

    function setupLivePreview(eventTitleInput, previewTitleDisplay, eventCategorySelector, previewCategoryBadge) {
        if (eventTitleInput) {
            eventTitleInput.addEventListener('input', (e) => {
                if (previewTitleDisplay) previewTitleDisplay.textContent = e.target.value || "Titolo del tuo evento";
            });
        }

        if (eventCategorySelector) {
            eventCategorySelector.addEventListener('change', (e) => {
                updateCategoryBadge(previewCategoryBadge, e.target.value);
            });
            if (eventCategorySelector.value) {
                updateCategoryBadge(previewCategoryBadge, eventCategorySelector.value);
            }
        }
    }

    function init() {
        const dropArea = document.getElementById('drop-area');
        const fileElem = document.getElementById('fileElem');
        const previewImageSidebar = document.getElementById('previewImageSidebar');
        const previewTitleDisplay = document.getElementById('previewTitleDisplay');
        const eventTitleInput = document.getElementById('eventTitleInput');
        const eventCategorySelector = document.getElementById('eventCategorySelector');
        const previewCategoryBadge = document.getElementById('previewCategoryBadge');

        setupFileUpload(dropArea, fileElem, previewImageSidebar);
        setupLivePreview(eventTitleInput, previewTitleDisplay, eventCategorySelector, previewCategoryBadge);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();