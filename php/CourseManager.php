<?php
require_once 'Course.php';
require_once 'KeywordsManager.php';

/**
 * CourseManager is a singleton class responsible for managing courses data stored in courses.json.
 * It handles loading, saving, and manipulating course objects. Keywords are managed by KeywordsManager.
 */
class CourseManager {
    private static $instance = null;
    private $coursesFile = '../json/courses.json';
    private $courses = [];
    private $minKeywords;
    private $maxKeywords;

    /**
     * Private constructor to prevent direct instantiation.
     * Loads courses data and configuration from the JSON file.
     */
    private function __construct() {
        $this->loadCourses();
    }

    /**
     * Gets the singleton instance of CourseManager.
     *
     * @return CourseManager The singleton instance.
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Loads courses and configuration from the JSON file into memory.
     */
    private function loadCourses() {
        $keywordsManager = KeywordsManager::getInstance();
        $keywordMap = $keywordsManager->getAllKeywords();
        if (file_exists($this->coursesFile)) {
            $data = json_decode(file_get_contents($this->coursesFile), true);
            if ($data) {
                $this->minKeywords = (int)($data['minKeywords'] ?? 4);
                $this->maxKeywords = (int)($data['maxKeywords'] ?? 4);
                if (isset($data['courses'])) {
                    foreach ($data['courses'] as $courseData) {
                        $this->courses[$courseData['id']] = Course::fromArray($courseData, $keywordMap);
                    }
                }
            }
        }
    }

    /**
     * Saves the current courses to the JSON file.
     */
    private function saveCourses() {
        $data = ['courses' => array_map(function($course) {
            return $course->toArray();
        }, array_values($this->courses))];
        file_put_contents($this->coursesFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Gets all courses.
     *
     * @return array Array of Course objects keyed by id.
     */
    public function getAllCourses() {
        return $this->courses;
    }

    /**
     * Gets a course by its id.
     *
     * @param string $id The course id.
     * @return Course|null The Course object or null if not found.
     */
    public function getCourseById($id) {
        return isset($this->courses[$id]) ? $this->courses[$id] : null;
    }

    /**
     * Adds a new course.
     *
     * @param Course $course The course to add.
     */
    public function addCourse(Course $course) {
        $this->courses[$course->getId()] = $course;
        $this->saveCourses();
    }

    /**
     * Updates an existing course.
     *
     * @param string $id The course id to update.
     * @param Course $course The updated course.
     */
    public function updateCourse($id, Course $course) {
        if (isset($this->courses[$id])) {
            $this->courses[$id] = $course;
            $this->saveCourses();
        }
    }

    /**
     * Deletes a course by id.
     *
     * @param string $id The course id to delete.
     */
    public function deleteCourse($id) {
        if (isset($this->courses[$id])) {
            unset($this->courses[$id]);
            $this->saveCourses();
        }
    }

    /**
     * Gets the minimum number of keywords per course.
     *
     * @return int The minimum number of keywords.
     */
    public function getMinKeywords() {
        return $this->minKeywords;
    }

    /**
     * Gets the maximum number of keywords per course.
     *
     * @return int The maximum number of keywords.
     */
    public function getMaxKeywords() {
        return $this->maxKeywords;
    }

    /**
     * Generates the next available course id.
     *
     * @return string The next id.
     */
    public function generateNextId() {
        $ids = array_keys($this->courses);
        if (empty($ids)) {
            return '001';
        }
        $maxId = max(array_map('intval', $ids));
        return str_pad($maxId + 1, 3, '0', STR_PAD_LEFT);
    }
}
?>