<?php
require_once 'CourseManager.php';

$manager = CourseManager::getInstance();
$courses = $manager->getAllCourses();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elenco Corsi</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Elenco Corsi</h1>
    <a href="createCourse.php">Crea Nuovo Corso</a>
    <ul>
        <?php foreach ($courses as $course): ?>
            <li>
                <strong><?php echo htmlspecialchars($course->getId()); ?>:</strong> <?php echo htmlspecialchars($course->getTitle()); ?>
                <a href="courseDetails.php?id=<?php echo htmlspecialchars($course->getId()); ?>">Dettagli</a>
                <a href="updateCourse.php?id=<?php echo htmlspecialchars($course->getId()); ?>">Modifica</a>
                <a href="deleteCourse.php?id=<?php echo htmlspecialchars($course->getId()); ?>">Elimina</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="../html/menu.html">Torna al Menu</a>
</body>
</html>