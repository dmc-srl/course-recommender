<?php
/**
 * Handles the server-side logic for updating a course.
 * Processes form submissions, validates data, handles file uploads, and updates the course.
 */

require_once 'CourseManager.php';
require_once 'KeywordsManager.php';

/**
 * Processes the course update form submission.
 * Handles POST requests for updating an existing course.
 */
function handleUpdateCourse() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $manager = CourseManager::getInstance();
        $id = $_POST['id'];
        $course = $manager->getCourseById($id);
        if (!$course) {
            die('Corso non trovato.');
        }

        $titles = [];
        $descriptions = [];
        $langs = ['it'];
        if (isset($_POST['langs'])) {
            $langs = array_merge($langs, $_POST['langs']);
        }
        foreach ($langs as $lang) {
            $title = $_POST["title_$lang"] ?? '';
            $desc = $_POST["description_$lang"] ?? '';
            if (!empty($title)) $titles[$lang] = $title;
            if (!empty($desc)) $descriptions[$lang] = $desc;
        }

        $keywords = [];
        $allLangs = ['it'];
        if (isset($_POST['langs'])) {
            $allLangs = array_merge($allLangs, $_POST['langs']);
        }
        for ($i = 1; $i <= 4; $i++) {
            $kwId = $_POST["keyword{$i}"] ?? '';
            $weight = floatval($_POST["weight{$i}"] ?? 0);
            if (!empty($kwId)) {
                $keyword = KeywordsManager::getInstance()->getKeywordById($kwId);
                if ($keyword) {
                    // Update names
                    foreach ($allLangs as $lang) {
                        $name = $_POST["keyword_name_{$i}_{$lang}"] ?? '';
                        if (!empty($name)) {
                            $keyword->setName($lang, $name);
                        }
                    }
                    $keywords[] = ['keyword' => $keyword, 'weight' => $weight];
                }
            }
        }

        // Handle file uploads
        $multimedia = $course->getMultimediaGallery();
        $mediaDir = "../courses/{$id}/media";
        if (!is_dir($mediaDir)) {
            mkdir($mediaDir, 0777, true);
        }
        // Find max index
        $maxIndex = 0;
        foreach ($multimedia as $media) {
            if (preg_match('/\/(\d+)\.\w+$/', $media['localPath'], $matches)) {
                $maxIndex = max($maxIndex, (int)$matches[1]);
            }
        }
        $index = $maxIndex + 1;
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

        $updatedCourse = new Course($id, $titles, $descriptions, $multimedia, $keywords);
        $manager->updateCourse($id, $updatedCourse);
        KeywordsManager::getInstance()->saveAllKeywords();

        header('Location: listCourses.php');
        exit;
    }
}
?>