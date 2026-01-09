<?php
// Menu principale
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principale - Sistema di Gestione Corsi</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Menu Principale</h1>
    <nav>
        <ul>
            <li><a href="listCourses.php">Elenco Corsi</a></li>
            <li><a href="createCourse.php">Crea Nuovo Corso</a></li>
        </ul>
        <h2>Modifica o Elimina Corso</h2>
        <form action="editCourse.php" method="get">
            <label for="edit-id">ID Corso da modificare:</label>
            <input type="text" id="edit-id" name="id" required>
            <button type="submit">Modifica Corso</button>
        </form>
        <form action="deleteCourse.php" method="get">
            <label for="delete-id">ID Corso da eliminare:</label>
            <input type="text" id="delete-id" name="id" required>
            <button type="submit">Elimina Corso</button>
        </form>
    </nav>
</body>
</html>