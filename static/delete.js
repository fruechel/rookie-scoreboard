Array.prototype.forEach.call(
    document.forms,
    function confirmDelete(form) {
        form.addEventListener('submit', function(e) {
            if (!confirm(form.dataset.question)) {
                e.preventDefault();
                return false;
            }
        });
    }
);