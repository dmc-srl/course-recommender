<?php
header('Content-Type: application/json');

$keywordsData = json_decode(file_get_contents('../json/keywords.json'), true);
$keywords = [];
foreach ($keywordsData as $keywordKey => $keywordData) {
    $keywords[] = $keywordData['name'];
}

echo json_encode($keywords);
?>