<?php
class Keyword {
    private $keywordName;
    private $coursesSet;

    public function __construct($keywordName, $coursesSet) {
        $this->keywordName = $keywordName;
        $this->coursesSet = $coursesSet; // array of courseId => weight
    }

    public function getKeywordName() {
        return $this->keywordName;
    }

    public function setKeywordName($keywordName) {
        $this->keywordName = $keywordName;
    }

    public function getCoursesSet() {
        return $this->coursesSet;
    }

    public function setCoursesSet($coursesSet) {
        $this->coursesSet = $coursesSet;
    }
}
?>