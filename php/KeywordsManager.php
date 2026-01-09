<?php
/**
 * KeywordsManager is a singleton class responsible for managing keywords data stored in keywords.json.
 * It handles loading, saving, and manipulating keyword objects.
 */
class KeywordsManager {
    private static $instance = null;
    private $keywordsFile = '../json/keywords.json';
    private $keywords = []; // array of Keyword objects, keyed by id

    /**
     * Private constructor to prevent direct instantiation.
     * Loads keywords data from the JSON file.
     */
    private function __construct() {
        $this->loadKeywords();
    }

    /**
     * Gets the singleton instance of KeywordsManager.
     *
     * @return KeywordsManager The singleton instance.
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Loads keywords from the JSON file into memory.
     */
    private function loadKeywords() {
        if (file_exists($this->keywordsFile)) {
            $data = json_decode(file_get_contents($this->keywordsFile), true);
            if ($data && isset($data['keywords'])) {
                foreach ($data['keywords'] as $kwData) {
                    $keyword = Keyword::fromArray($kwData);
                    $this->keywords[$keyword->getId()] = $keyword;
                }
            }
        }
    }

    /**
     * Saves the current keywords to the JSON file.
     */
    private function saveKeywords() {
        $data = ['keywords' => array_map(function($keyword) {
            $kwArray = $keyword->toArray();
            // Note: courses are managed by CourseManager, so not included here
            unset($kwArray['courses']);
            return $kwArray;
        }, array_values($this->keywords))];
        file_put_contents($this->keywordsFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Gets all keywords.
     *
     * @return array Array of Keyword objects keyed by id.
     */
    public function getAllKeywords() {
        return $this->keywords;
    }

    /**
     * Gets a keyword by its id.
     *
     * @param string $id The keyword id.
     * @return Keyword|null The Keyword object or null if not found.
     */
    public function getKeywordById($id) {
        return isset($this->keywords[$id]) ? $this->keywords[$id] : null;
    }

    /**
     * Adds or updates a keyword.
     *
     * @param Keyword $keyword The keyword to add or update.
     */
    public function saveKeyword(Keyword $keyword) {
        $this->keywords[$keyword->getId()] = $keyword;
        $this->saveKeywords();
    }

    /**
     * Deletes a keyword by id.
     *
     * @param string $id The keyword id to delete.
     */
    public function deleteKeyword($id) {
        if (isset($this->keywords[$id])) {
            unset($this->keywords[$id]);
            $this->saveKeywords();
        }
    }

    /**
     * Saves all keywords to the JSON file.
     */
    public function saveAllKeywords() {
        $this->saveKeywords();
    }

    /**
     * Generates the next available keyword id (not used in current implementation).
     *
     * @return string The next id.
     */
    public function generateNextId() {
        $ids = array_keys($this->keywords);
        if (empty($ids)) {
            return 'KW001';
        }
        $maxId = max(array_map(function($id) {
            return (int)substr($id, 2);
        }, $ids));
        return 'KW' . str_pad($maxId + 1, 3, '0', STR_PAD_LEFT);
    }
}
?>