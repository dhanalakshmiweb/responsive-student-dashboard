<?php
session_start();
include "db.php";

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$course_id = $_GET['course_id'];
$step = $_GET['step'];

/* 🔥 STEP NAME */
$step_names = [
    1 => "Basic",
    2 => "Intermediate",
    3 => "Advanced"
];

$level = isset($step_names[$step]) ? $step_names[$step] : "Level";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Questions</title>
    <link rel="stylesheet" href="questions.css">
</head>

<body>

<!-- 🔝 HEADER -->
<div class="header">
    <a href="courses.php">⬅ Back</a>
    <h2>👋 Welcome to <?php echo $level; ?></h2>
    <p>Start your <?php echo $level; ?> level 🚀</p>
</div>

<!-- 📦 CONTAINER -->
<div class="container">

<form action="submit.php" method="POST" class="question-box">

    <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
    <input type="hidden" name="step" value="<?php echo $step; ?>">

    <!-- Q1 -->
    <div class="question">
        <p>1. What is this module about?</p>
        <input type="text" name="answer[]" required>
    </div>

    <!-- Q2 -->
    <div class="question">
        <p>2. Explain the architecture or internal working?</p>
        <input type="text" name="answer[]" required>
    </div>

    <!-- Q3 -->
    <div class="question">
        <p>3. Suggest improvements or future enhancements.</p>
        <input type="text" name="answer[]" required>
    </div>

    <!-- Q4 -->
    <div class="question">
        <p>4. Why have you chosen this course?</p>
        <input type="text" name="answer[]" required>
    </div>

    <!-- 🚀 SUBMIT -->
    <button type="submit" class="submit-btn">Submit Answers</button>

</form>

</div>

</body>
</html>
