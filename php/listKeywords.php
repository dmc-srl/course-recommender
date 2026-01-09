<?php
require_once 'KeywordsManager.php';

$keywordsManager = KeywordsManager::getInstance();
$keywords = $keywordsManager->getAllKeywords();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elenco Parole Chiave</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Elenco Parole Chiave</h1>
    <a href="createKeyword.php">Crea Nuova Parola Chiave</a>
    <ul>
        <?php foreach ($keywords as $keyword): ?>
            <li>
                <strong><?php echo htmlspecialchars($keyword->getId()); ?>:</strong>
                <?php foreach ($keyword->getNames() as $lang => $name): ?>
                    <?php echo htmlspecialchars($lang); ?>: <?php echo htmlspecialchars($name); ?> |
                <?php endforeach; ?>
                <a href="updateKeyword.php?id=<?php echo htmlspecialchars($keyword->getId()); ?>">Modifica</a>
                <a href="deleteKeyword.php?id=<?php echo htmlspecialchars($keyword->getId()); ?>">Elimina</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="../html/menu.html">Torna al Menu</a>
</body>
</html>