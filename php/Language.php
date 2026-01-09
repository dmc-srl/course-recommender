<?php
/**
 * Language represents a language entity with code and name.
 */
class Language {
    private $code;
    private $name;

    /**
     * Constructor for Language.
     *
     * @param string $code The language code (e.g., 'it').
     * @param string $name The language name (e.g., 'Italiano').
     */
    public function __construct($code, $name) {
        $this->code = $code;
        $this->name = $name;
    }

    /**
     * Gets the language code.
     *
     * @return string The language code.
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Gets the language name.
     *
     * @return string The language name.
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Converts the language to an array.
     *
     * @return array The language as an array.
     */
    public function toArray() {
        return [$this->code => $this->name];
    }

    /**
     * Creates a Language instance from an array.
     *
     * @param array $data The data array.
     * @return Language The Language instance.
     */
    public static function fromArray($data) {
        $code = key($data);
        $name = $data[$code];
        return new self($code, $name);
    }
}
?>