<?php
require_once 'createCourseFunctions.php';

handleCreateCourse();

$keywordsList = KeywordsManager::getInstance()->getAllKeywords();
$courseManager = CourseManager::getInstance();
$minKeywords = $courseManager->getMinKeywords();
$maxKeywords = $courseManager->getMaxKeywords();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Nuovo Corso</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Crea Nuovo Corso</h1>
    <form action="createCourse.php" method="post" enctype="multipart/form-data">
        <label for="title">Titolo (Italiano):</label>
        <input type="text" id="title" name="title" required><br>

        <label for="description">Descrizione (Italiano):</label>
        <textarea id="description" name="description" required></textarea><br>

        <label>Multimedia:</label>
        <input type="file" name="multimedia[]" multiple accept="image/*,video/*"><br>

        <div id="keywords">
            <h3>Parole Chiave (<?php echo $minKeywords; ?> obbligatorie)</h3>
            <?php for ($i = 1; $i <= $maxKeywords; $i++): ?>
                <div class="keyword-group">
                    <label>Parola Chiave <?php echo $i; ?>:</label>
                    <select name="keyword<?php echo $i; ?>" required>
                        <option value="">Seleziona</option>
                        <?php foreach ($keywordsList as $kw): ?>
                            <option value="<?php echo htmlspecialchars($kw->getId()); ?>"><?php echo htmlspecialchars($kw->getName('it')); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Peso:</label>
                    <input type="number" step="0.01" name="weight<?php echo $i; ?>" required>
                </div>
            <?php endfor; ?>
        </div>

        <button type="submit">Crea Corso</button>
    </form>
    <a href="../html/menu.html">Torna al Menu</a>
    <script src="../js/formHandler.js"></script>
</body>
</html>