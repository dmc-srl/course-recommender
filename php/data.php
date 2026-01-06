<?php
include 'Course.php';
include 'Keyword.php';

function loadCourses() {
    $coursesData = json_decode(file_get_contents('../json/courses.json'), true);
    $courses = [];
    foreach ($coursesData as $courseKey => $courseData) {
        $keywordsSet = [];
        foreach ($courseData['keywords'] as $k => $kw) {
            $keywordsSet[] = $kw['name'];
        }
        $course = new Course(
            $courseData['id'],
            $courseData['title'],
            $courseData['description'],
            $courseData['multimediaGallery'],
            $keywordsSet
        );
        $courses[] = $course;
    }
    return $courses;
}

function loadKeywords() {
    $keywordsData = json_decode(file_get_contents('../json/keywords.json'), true);
    $keywords = [];
    foreach ($keywordsData as $keywordKey => $keywordData) {
        $coursesSet = [];
        foreach ($keywordData['courses'] as $c => $courseInfo) {
            $coursesSet[$courseInfo['id']] = $courseInfo['weight'];
        }
        $keyword = new Keyword($keywordData['name'], $coursesSet);
        $keywords[] = $keyword;
    }
    return $keywords;
}
?>