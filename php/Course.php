<?php
require_once 'Keyword.php';

/**
 * Course represents a course entity with multilingual support for titles, descriptions, and associated keywords.
 */
class Course {
    private $id;
    private $title;
    private $description;
    private $multimediaGallery;
    private $keywords; // array of ['keyword' => Keyword, 'weight' => float]

    /**
     * Constructor for Course.
     *
     * @param string $id The course ID.
     * @param array $title Array of titles keyed by language code.
     * @param array $description Array of descriptions keyed by language code.
     * @param array $multimediaGallery Array of multimedia items.
     * @param array $keywords Array of keyword associations.
     */
    public function __construct($id, $title = [], $description = [], $multimediaGallery = [], $keywords = []) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->multimediaGallery = $multimediaGallery;
        $this->keywords = $keywords;
    }

    /**
     * Gets the course ID.
     *
     * @return string The course ID.
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets the course ID.
     *
     * @param string $id The course ID.
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Gets the title for a specific language.
     *
     * @param string $lang The language code (default 'it').
     * @return string The title or empty string if not found.
     */
    public function getTitle($lang = 'it') {
        return isset($this->title[$lang]) ? $this->title[$lang] : '';
    }

    /**
     * Sets the title for a specific language.
     *
     * @param string $lang The language code.
     * @param string $title The title.
     */
    public function setTitle($lang, $title) {
        $this->title[$lang] = $title;
    }

    /**
     * Gets all titles.
     *
     * @return array Array of titles keyed by language.
     */
    public function getTitles() {
        return $this->title;
    }

    /**
     * Gets the description for a specific language.
     *
     * @param string $lang The language code (default 'it').
     * @return string The description or empty string if not found.
     */
    public function getDescription($lang = 'it') {
        return isset($this->description[$lang]) ? $this->description[$lang] : '';
    }

    /**
     * Sets the description for a specific language.
     *
     * @param string $lang The language code.
     * @param string $description The description.
     */
    public function setDescription($lang, $description) {
        $this->description[$lang] = $description;
    }

    /**
     * Gets all descriptions.
     *
     * @return array Array of descriptions keyed by language.
     */
    public function getDescriptions() {
        return $this->description;
    }

    /**
     * Gets the multimedia gallery.
     *
     * @return array The multimedia gallery.
     */
    public function getMultimediaGallery() {
        return $this->multimediaGallery;
    }

    /**
     * Sets the multimedia gallery.
     *
     * @param array $multimediaGallery The multimedia gallery.
     */
    public function setMultimediaGallery($multimediaGallery) {
        $this->multimediaGallery = $multimediaGallery;
    }

    /**
     * Adds a multimedia item to the gallery.
     *
     * @param string $type The media type.
     * @param string $localPath The local path.
     */
    public function addMultimedia($type, $localPath) {
        $this->multimediaGallery[] = ['type' => $type, 'localPath' => $localPath];
    }

    /**
     * Gets the keywords.
     *
     * @return array Array of keyword associations.
     */
    public function getKeywords() {
        return $this->keywords;
    }

    /**
     * Sets the keywords.
     *
     * @param array $keywords Array of keyword associations.
     */
    public function setKeywords($keywords) {
        $this->keywords = $keywords;
    }

    /**
     * Adds a keyword with weight.
     *
     * @param Keyword $keyword The keyword object.
     * @param float $weight The weight.
     */
    public function addKeyword(Keyword $keyword, $weight) {
        $this->keywords[] = ['keyword' => $keyword, 'weight' => $weight];
    }

    /**
     * Converts the course to an array for JSON serialization.
     *
     * @return array The course as an array.
     */
    public function toArray() {
        $keywordsArray = [];
        foreach ($this->keywords as $kw) {
            $keywordsArray[] = [
                'id' => $kw['keyword']->getId(),
                'weight' => $kw['weight']
            ];
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'multimediaGallery' => $this->multimediaGallery,
            'keywords' => $keywordsArray
        ];
    }

    /**
     * Creates a Course instance from an array.
     *
     * @param array $data The data array.
     * @param array $keywordMap Map of keywords keyed by id.
     * @return Course The Course instance.
     */
    public static function fromArray($data, $keywordMap = []) {
        $keywords = [];
        if (isset($data['keywords'])) {
            foreach ($data['keywords'] as $kwData) {
                if (isset($kwData['id'])) {
                    $keyword = isset($keywordMap[$kwData['id']]) ? $keywordMap[$kwData['id']] : new Keyword($kwData['id']);
                    $keywords[] = ['keyword' => $keyword, 'weight' => $kwData['weight'] ?? 0];
                }
            }
        }
        return new self(
            $data['id'],
            $data['title'] ?? [],
            $data['description'] ?? [],
            $data['multimediaGallery'] ?? [],
            $keywords
        );
    }
}
?>