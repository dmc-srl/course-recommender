<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Recommendations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Your Course Recommendations</h1>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected'])) {
            $selected = explode(',', $_POST['selected']);
            $selected = array_filter($selected); // remove empty

            include 'data.php';
            $courses = loadCourses();
            $keywords = loadKeywords();

            $recommendations = [];
            foreach ($courses as $course) {
                $score = 0;
                foreach ($selected as $keywordName) {
                    foreach ($keywords as $keyword) {
                        if ($keyword->getKeywordName() === $keywordName) {
                            $coursesSet = $keyword->getCoursesSet();
                            if (isset($coursesSet[$course->getId()])) {
                                $score += $coursesSet[$course->getId()];
                            }
                            break;
                        }
                    }
                }
                $recommendations[] = ['course' => $course->getName(), 'score' => $score];
            }

            usort($recommendations, function($a, $b) {
                return $b['score'] <=> $a['score'];
            });

            echo '<p>Based on your interests: ' . htmlspecialchars(implode(', ', $selected)) . '</p>';
            echo '<div>';
            foreach ($recommendations as $index => $rec) {
                echo '<div class="recommendation">';
                echo '<span class="course-name">' . ($index + 1) . '. ' . htmlspecialchars($rec['course']) . '</span>';
                echo '<span class="score">Score: ' . number_format($rec['score'] * 100, 1) . '%</span>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>No selections received.</p>';
        }
        ?>
        <button class="back-btn" onclick="window.location.href='index.html'">Start Over</button>
    </div>
</body>
</html>