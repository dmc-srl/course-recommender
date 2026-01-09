<?php
/**
 * Handles the server-side logic for deleting a course.
 * Processes form submissions for deleting courses.
 */

require_once 'CourseManager.php';

/**
 * Processes the course deletion form submission.
 * Handles POST requests for deleting a course.
 */
function handleDeleteCourse() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $manager = CourseManager::getInstance();
        $id = $_POST['id'];
        $manager->deleteCourse($id);
        header('Location: listCourses.php');
        exit;
    }
}
?>