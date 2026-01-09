<?php
/**
 * LanguagesManager is a singleton class responsible for managing languages data stored in languages.json.
 * It handles loading and providing language information.
 */
class LanguagesManager {
    private static $instance = null;
    private $languagesFile = '../json/languages.json';
    private $languages = []; // array of Language objects, keyed by code
    private $defaultLang;

    /**
     * Private constructor to prevent direct instantiation.
     * Loads languages data from the JSON file.
     */
    private function __construct() {
        $this->loadLanguages();
    }

    /**
     * Gets the singleton instance of LanguagesManager.
     *
     * @return LanguagesManager The singleton instance.
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Loads languages from the JSON file into memory.
     */
    private function loadLanguages() {
        if (file_exists($this->languagesFile)) {
            $data = json_decode(file_get_contents($this->languagesFile), true);
            if ($data && isset($data['langs'])) {
                foreach ($data['langs'] as $langData) {
                    $language = Language::fromArray($langData);
                    $this->languages[$language->getCode()] = $language;
                }
            }
            $this->defaultLang = $data['default-lang'] ?? 'it';
        }
    }

    /**
     * Gets all languages.
     *
     * @return array Array of Language objects keyed by code.
     */
    public function getAllLanguages() {
        return $this->languages;
    }

    /**
     * Gets a language by its code.
     *
     * @param string $code The language code.
     * @return Language|null The Language object or null if not found.
     */
    public function getLanguageByCode($code) {
        return isset($this->languages[$code]) ? $this->languages[$code] : null;
    }

    /**
     * Gets the default language code.
     *
     * @return string The default language code.
     */
    public function getDefaultLanguage() {
        return $this->defaultLang;
    }

    /**
     * Gets the supported language codes.
     *
     * @return array Array of language codes.
     */
    public function getSupportedLanguages() {
        return array_keys($this->languages);
    }
}
?>