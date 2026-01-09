<?php
require_once 'deleteCourseFunctions.php';

handleDeleteCourse();

$id = $_GET['id'] ?? $_POST['selected_course'] ?? '';
$course = null;
if (!empty($id)) {
    $course = CourseManager::getInstance()->getCourseById($id);
}

$allCourses = CourseManager::getInstance()->getAllCourses();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elimina Corso</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<?php if ($course): ?>
    <h1>Elimina Corso</h1>
    <p>Sei sicuro di voler eliminare il corso "<?php echo htmlspecialchars($course->getTitle()); ?>"?</p>
    <form action="deleteCourse.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <button type="submit">Sì, Elimina</button>
        <a href="listCourses.php">Annulla</a>
    </form>
<?php else: ?>
    <h1>Seleziona Corso da Eliminare</h1>
    <form action="deleteCourse.php" method="post">
        <label for="selected_course">Seleziona Corso:</label>
        <select name="selected_course" id="selected_course" required>
            <option value="">Seleziona</option>
            <?php foreach ($allCourses as $c): ?>
                <option value="<?php echo htmlspecialchars($c->getId()); ?>"><?php echo htmlspecialchars($c->getId()); ?> - <?php echo htmlspecialchars($c->getTitle()); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Elimina</button>
    </form>
    <a href="../html/menu.html">Torna al Menu</a>
<?php endif; ?>
</body>
</html>