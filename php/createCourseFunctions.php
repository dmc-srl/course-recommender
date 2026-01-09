<?php
/**
 * Handles the server-side logic for creating a new course.
 * Processes form submissions, validates data, handles file uploads, and saves the course.
 */

require_once 'CourseManager.php';
require_once 'KeywordsManager.php';

/**
 * Processes the course creation form submission.
 * Handles POST requests for creating a new course.
 */
function handleCreateCourse() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $manager = CourseManager::getInstance();
        $id = $manager->generateNextId();
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $keywords = [];
        $courseManager = CourseManager::getInstance();
        $maxKeywords = $courseManager->getMaxKeywords();
        for ($i = 1; $i <= $maxKeywords; $i++) {
            $kwId = $_POST["keyword{$i}"] ?? '';
            $weight = floatval($_POST["weight{$i}"] ?? 0);
            if (!empty($kwId)) {
                $keyword = KeywordsManager::getInstance()->getKeywordById($kwId);
                if ($keyword) {
                    $keywords[] = ['keyword' => $keyword, 'weight' => $weight];
                }
            }
        }

        // Handle file uploads
        $multimedia = [];
        $mediaDir = "../courses/{$id}/media";
        if (!is_dir($mediaDir)) {
            mkdir($mediaDir, 0777, true);
        }
        $index = 1;
        if (isset($_FILES['multimedia'])) {
            $files = $_FILES['multimedia'];
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $type = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
                    $localPath = "{$mediaDir}/{$index}.{$type}";
                    move_uploaded_file($files['tmp_name'][$i], $localPath);
                    $multimedia[] = ['type' => $type, 'localPath' => $localPath];
                    $index++;
                }
            }
        }

        $course = new Course($id, ['it' => $title], ['it' => $description], $multimedia, $keywords);
        $manager->addCourse($course);

        header('Location: listCourses.php');
        exit;
    }
}
?>