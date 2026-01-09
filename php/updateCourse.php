<?php
require_once 'updateCourseFunctions.php';

handleUpdateCourse();

$id = $_GET['id'] ?? $_POST['selected_course'] ?? '';
$course = null;
if (!empty($id)) {
    $course = CourseManager::getInstance()->getCourseById($id);
}

$keywordsList = KeywordsManager::getInstance()->getAllKeywords();
$allCourses = CourseManager::getInstance()->getAllCourses();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Corso</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<?php if ($course): ?>
    <h1>Modifica Corso: <?php echo htmlspecialchars($course->getTitle()); ?></h1>
    <form action="updateCourse.php?id=<?php echo htmlspecialchars($id); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
<?php else: ?>
    <h1>Seleziona Corso da Modificare</h1>
    <form action="updateCourse.php" method="post">
        <label for="selected_course">Seleziona Corso:</label>
        <select name="selected_course" id="selected_course" required>
            <option value="">Seleziona</option>
            <?php foreach ($allCourses as $c): ?>
                <option value="<?php echo htmlspecialchars($c->getId()); ?>"><?php echo htmlspecialchars($c->getId()); ?> - <?php echo htmlspecialchars($c->getTitle()); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Modifica</button>
    </form>
    <a href="../html/menu.html">Torna al Menu</a>
<?php endif; ?>
<?php if ($course): ?>
        <div id="language-fields">
            <div class="lang-row" data-lang="it">
                <h3>Italiano</h3>
                <label>Titolo:</label>
                <input type="text" name="title_it" value="<?php echo htmlspecialchars($course->getTitle('it')); ?>" required><br>
                <label>Descrizione:</label>
                <textarea name="description_it" required><?php echo htmlspecialchars($course->getDescription('it')); ?></textarea><br>
            </div>
            <?php
            $titles = $course->getTitles();
            $descriptions = $course->getDescriptions();
            $existingLangs = array_keys(array_merge($titles, $descriptions));
            $existingLangs = array_diff($existingLangs, ['it']);
            foreach ($existingLangs as $lang):
            ?>
            <div class="lang-row" data-lang="<?php echo $lang; ?>">
                <h3><?php echo htmlspecialchars($lang); ?> <button type="button" class="remove-lang-btn">Rimuovi</button></h3>
                <label>Titolo:</label>
                <input type="text" name="title_<?php echo $lang; ?>" value="<?php echo htmlspecialchars($course->getTitle($lang)); ?>"><br>
                <label>Descrizione:</label>
                <textarea name="description_<?php echo $lang; ?>"><?php echo htmlspecialchars($course->getDescription($lang)); ?></textarea><br>
                <input type="hidden" name="langs[]" value="<?php echo $lang; ?>">
            </div>
            <?php endforeach; ?>
        </div>

        <div id="add-language">
            <label for="lang-select">Aggiungi o rimuovi una lingua:</label>
            <select id="lang-select">
                <option value="">Seleziona</option>
                <option value="en">English</option>
                <option value="fr">Français</option>
                <option value="de">Deutsch</option>
                <option value="es">Español</option>
            </select>
            <button type="button" id="add-lang-btn">Seleziona</button>
        </div>

        <label>Multimedia (aggiungi nuovi):</label>
        <input type="file" name="multimedia[]" multiple accept="image/*,video/*"><br>

        <div id="keywords">
            <h3>Parole Chiave (4 obbligatorie)</h3>
            <?php
            $existingKeywords = $course->getKeywords();
            $allLangs = ['it'];
            $titles = $course->getTitles();
            $descriptions = $course->getDescriptions();
            $existingLangs = array_keys(array_merge($titles, $descriptions));
            $allLangs = array_unique(array_merge($allLangs, $existingLangs));
            for ($i = 1; $i <= 4; $i++):
                $kw = $existingKeywords[$i-1] ?? ['keyword' => null, 'weight' => 0];
                $kwId = $kw['keyword'] ? $kw['keyword']->getId() : '';
            ?>
                <div class="keyword-group">
                    <label>Parola Chiave <?php echo $i; ?>:</label>
                    <select name="keyword<?php echo $i; ?>" required>
                        <option value="">Seleziona</option>
                        <?php foreach ($keywordsList as $kwOption): ?>
                            <option value="<?php echo htmlspecialchars($kwOption->getId()); ?>" <?php if ($kwId === $kwOption->getId()) echo 'selected'; ?>><?php echo htmlspecialchars($kwOption->getName('it')); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Peso:</label>
                    <input type="number" step="0.01" name="weight<?php echo $i; ?>" value="<?php echo $kw['weight']; ?>" required>
                    <div class="keyword-names">
                        <?php foreach ($allLangs as $lang): ?>
                            <label>Nome in <?php echo htmlspecialchars($lang); ?>:</label>
                            <input type="text" name="keyword_name_<?php echo $i; ?>_<?php echo $lang; ?>" value="<?php echo $kw['keyword'] ? htmlspecialchars($kw['keyword']->getName($lang)) : ''; ?>">
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endfor; ?>
        </div>

        <button type="submit">Aggiorna Corso</button>
    </form>
    <a href="listCourses.php">Torna all'Elenco</a>
    <script src="../js/formHandler.js"></script>
<?php endif; ?>
    <script>
        document.getElementById('add-lang-btn').addEventListener('click', function() {
            const select = document.getElementById('lang-select');
            const lang = select.value;
            if (lang && !document.querySelector(`[data-lang="${lang}"]`)) {
                const container = document.getElementById('language-fields');
                const row = document.createElement('div');
                row.className = 'lang-row';
                row.setAttribute('data-lang', lang);
                row.innerHTML = `
                    <h3>${lang} <button type="button" class="remove-lang-btn">Rimuovi</button></h3>
                    <label>Titolo:</label>
                    <input type="text" name="title_${lang}"><br>
                    <label>Descrizione:</label>
                    <textarea name="description_${lang}"></textarea><br>
                    <input type="hidden" name="langs[]" value="${lang}">
                `;
                container.appendChild(row);

                // Add keyword name fields
                const keywordGroups = document.querySelectorAll('.keyword-group .keyword-names');
                keywordGroups.forEach((group, index) => {
                    const label = document.createElement('label');
                    label.textContent = `Nome in ${lang}:`;
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.name = `keyword_name_${index + 1}_${lang}`;
                    group.appendChild(label);
                    group.appendChild(input);
                });

                select.value = '';
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-lang-btn')) {
                const row = e.target.closest('.lang-row');
                const lang = row.getAttribute('data-lang');
                row.remove();

                // Remove keyword name fields for this lang
                const inputs = document.querySelectorAll(`input[name*="_${lang}"]`);
                inputs.forEach(input => {
                    if (input.name.startsWith('keyword_name_')) {
                        input.previousElementSibling.remove(); // label
                        input.remove();
                    }
                });
            }
        });
    </script>
</body>
</html>