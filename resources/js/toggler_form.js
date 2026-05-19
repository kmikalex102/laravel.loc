(function () {
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.querySelector('select[name="type_val"]');
        if (typeSelect === null) {
            console.log('null');
            return;
        }
        const fields = document.querySelectorAll('[name]');
        function togglerForm() {
            const selectedValue = typeSelect.value;
            fields.forEach(function (field) {
                if (field === typeSelect) {
                    return;
                }
                const fieldName = field.getAttribute('name');
                let sameGroupSelect = fieldName.split("_")[1];
                if (sameGroupSelect !== undefined) {
                    const container = field.closest('p') || field;
                    container.style.display = sameGroupSelect === selectedValue ? '' : 'none';
                }
            });
        }
        typeSelect.addEventListener('change', togglerForm);
        togglerForm();
    });
})();
