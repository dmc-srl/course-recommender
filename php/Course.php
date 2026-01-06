<?php
class Course {
    private $id;
    private $name;
    private $description;
    private $multimediaGallery;
    private $keywordsSet;

    public function __construct($id, $name, $description, $multimediaGallery, $keywordsSet) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->multimediaGallery = $multimediaGallery;
        $this->keywordsSet = $keywordsSet;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getMultimediaGallery() {
        return $this->multimediaGallery;
    }

    public function setMultimediaGallery($multimediaGallery) {
        $this->multimediaGallery = $multimediaGallery;
    }

    public function getKeywordsSet() {
        return $this->keywordsSet;
    }

    public function setKeywordsSet($keywordsSet) {
        $this->keywordsSet = $keywordsSet;
    }
}
?>