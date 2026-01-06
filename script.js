const keywordsDiv = document.getElementById('keywords');

if (keywordsDiv) {
    // Selection page
    const MAX_SELECTIONS_CAP = 5;
    const KEYWORDS_DIVISOR = 2;

    const countSpan = document.getElementById('count');
    const selectedInput = document.getElementById('selectedInput');
    const submitBtn = document.getElementById('submitBtn');
    let selected = [];
    let buttons = [];
    let maxSelections;

    // Fetch keywords via AJAX
    fetch('php/keywords_api.php')
        .then(response => response.json())
        .then(keywords => {
            maxSelections = Math.min(MAX_SELECTIONS_CAP, Math.floor(keywords.length / KEYWORDS_DIVISOR));
            document.querySelector('.counter').textContent = `Selected: 0/${maxSelections}`;
            keywords.forEach(keyword => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'keyword-btn';
                btn.dataset.keyword = keyword;
                btn.textContent = keyword;
                btn.addEventListener('click', () => {
                    if (selected.includes(keyword)) {
                        selected = selected.filter(k => k !== keyword);
                        btn.classList.remove('selected');
                    } else if (selected.length < maxSelections) {
                        selected.push(keyword);
                        btn.classList.add('selected');
                    }
                    updateUI();
                });
                keywordsDiv.appendChild(btn);
                buttons.push(btn);
            });
        });

    function updateUI() {
        countSpan.textContent = `${selected.length}/${maxSelections}`;
        selectedInput.value = selected.join(',');
        submitBtn.disabled = selected.length === 0;
        buttons.forEach(btn => {
            if (selected.length >= maxSelections && !selected.includes(btn.dataset.keyword)) {
                btn.classList.add('disabled');
            } else {
                btn.classList.remove('disabled');
            }
        });
    }
}

function loadKeywords() {
    fetch('php/api.php')
        .then(response => response.json())
        .then(keywords => {
            keywords.forEach(keyword => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'keyword-btn';
                btn.dataset.keyword = keyword;
                btn.textContent = keyword;
                btn.addEventListener('click', () => {
                    if (selected.includes(keyword)) {
                        selected = selected.filter(k => k !== keyword);
                        btn.classList.remove('selected');
                    } else if (selected.length < 5) {
                        selected.push(keyword);
                        btn.classList.add('selected');
                    }
                    updateUI();
                });
                keywordsDiv.appendChild(btn);
                buttons.push(btn);
            });
        });
}

function updateUI() {
    countSpan.textContent = selected.length;
    selectedInput.value = selected.join(',');
    submitBtn.disabled = selected.length === 0;
    buttons.forEach(btn => {
        if (selected.length >= 5 && !selected.includes(btn.dataset.keyword)) {
            btn.classList.add('disabled');
        } else {
            btn.classList.remove('disabled');
        }
    });
}