<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Recommender - Selection</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Course Recommender</h1>
        <p>Select up to 5 interests that appeal to you:</p>
        <form id="selectionForm" action="results.php" method="POST">
            <div class="counter">Selected: <span id="count">0</span></div>
            <div class="keywords" id="keywords">
                <!-- Keywords will be loaded via AJAX -->
            </div>
            <input type="hidden" name="selected" id="selectedInput">
            <button type="submit" class="submit-btn" id="submitBtn" disabled>Get Recommendations</button>
        </form>
    </div>
    <script src="../script.js"></script>
</body>
</html>