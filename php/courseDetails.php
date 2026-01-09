<?php
require_once 'CourseManager.php';
require_once 'KeywordsManager.php';

$manager = CourseManager::getInstance();
$id = $_GET['id'] ?? '';
$course = $manager->getCourseById($id);

if (!$course) {
    die('Corso non trovato.');
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dettagli Corso</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Dettagli Corso</h1>
    <h2><?php echo htmlspecialchars($course->getTitle()); ?></h2>
    <p><strong>ID:</strong> <?php echo htmlspecialchars($course->getId()); ?></p>
    <p><strong>Descrizione:</strong> <?php echo htmlspecialchars($course->getDescription()); ?></p>

    <h3>Multimedia</h3>
    <ul>
        <?php foreach ($course->getMultimediaGallery() as $media): ?>
            <li>
                <?php if (in_array($media['type'], ['jpg', 'png', 'gif'])): ?>
                    <img src="<?php echo htmlspecialchars($media['localPath']); ?>" alt="Media" style="max-width: 200px;">
                <?php elseif (in_array($media['type'], ['mp4', 'avi'])): ?>
                    <video controls style="max-width: 200px;">
                        <source src="<?php echo htmlspecialchars($media['localPath']); ?>" type="video/<?php echo $media['type']; ?>">
                    </video>
                <?php else: ?>
                    <a href="<?php echo htmlspecialchars($media['localPath']); ?>">Scarica <?php echo htmlspecialchars($media['type']); ?></a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Parole Chiave</h3>
    <ul>
        <?php
        $keywords = $course->getKeywords();
        foreach ($keywords as $kw):
            $name = $kw['keyword']->getName('it');
        ?>
            <li><?php echo htmlspecialchars($name); ?> (Peso: <?php echo $kw['weight']; ?>)</li>
        <?php endforeach; ?>
    </ul>

    <a href="listCourses.php">Torna all'Elenco</a> | <a href="updateCourse.php?id=<?php echo htmlspecialchars($course->getId()); ?>">Modifica Corso</a>
</body>
</html>