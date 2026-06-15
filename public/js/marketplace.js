document.addEventListener('DOMContentLoaded', () => {
    initQuantityControls();
    initProductGallery();
    initAlerts();
    initDeleteConfirm();
});

function initQuantityControls() {
    document.querySelectorAll('[data-qty-minus]').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.parentElement.querySelector('[data-qty-input]');
            const min = parseInt(input.min) || 1;
            const val = parseInt(input.value) || min;
            if (val > min) input.value = val - 1;
        });
    });

    document.querySelectorAll('[data-qty-plus]').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.parentElement.querySelector('[data-qty-input]');
            const max = parseInt(input.max) || 999;
            const val = parseInt(input.value) || 1;
            if (val < max) input.value = val + 1;
        });
    });
}

function initProductGallery() {
    const mainImage = document.getElementById('productMainImage');
    if (!mainImage) return;

    document.querySelectorAll('.product-gallery-thumb').forEach(thumb => {
        thumb.addEventListener('click', () => {
            mainImage.src = thumb.dataset.src;
            document.querySelectorAll('.product-gallery-thumb').forEach(t => t.classList.remove('active'));
            thumb.classList.add('active');
        });
    });
}

function initAlerts() {
    document.querySelectorAll('.alert-dismissible.auto-dismiss').forEach(alert => {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 5000);
    });
}

function initDeleteConfirm() {
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', e => {
            if (!confirm(el.dataset.confirm || 'Tem a certeza?')) {
                e.preventDefault();
            }
        });
    });
}
