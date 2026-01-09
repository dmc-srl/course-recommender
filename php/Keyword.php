<?php
class Keyword {
    private $id;
    private $names;

    public function __construct($id, $names = []) {
        $this->id = $id;
        $this->names = $names;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName($lang) {
        return isset($this->names[$lang]) ? $this->names[$lang] : '';
    }

    public function setName($lang, $name) {
        $this->names[$lang] = $name;
    }

    public function getNames() {
        return $this->names;
    }

    public function setNames($names) {
        $this->names = $names;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->names
        ];
    }

    public static function fromArray($data) {
        return new self($data['id'], $data['name'] ?? []);
    }
}
?>