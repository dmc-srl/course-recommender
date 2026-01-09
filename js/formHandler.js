// formHandler.js - Gestione dinamica dei form

document.addEventListener('DOMContentLoaded', function() {
    // Prevenzione duplicati nelle parole chiave
    const keywordSelects = document.querySelectorAll('select[name^="keyword"]');
    keywordSelects.forEach(select => {
        select.addEventListener('change', function() {
            const selectedValues = Array.from(keywordSelects).map(s => s.value).filter(v => v !== '');
            const duplicates = selectedValues.filter((item, index) => selectedValues.indexOf(item) !== index);
            if (duplicates.length > 0) {
                alert('Parole chiave duplicate non consentite.');
                this.value = '';
            }
        });
    });

    // Filtro file per multimedia
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/avi'];
            for (let file of this.files) {
                if (!allowedTypes.includes(file.type)) {
                    alert('Tipo di file non supportato: ' + file.name);
                    this.value = '';
                    break;
                }
            }
        });
    });
});