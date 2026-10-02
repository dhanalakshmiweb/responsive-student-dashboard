<?php
include "db.php";
session_start();

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$courses = $conn->query("SELECT * FROM courses");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Courses</title>
    <link rel="stylesheet" href="courses.css">
</head>

<body>

<!-- 🔝 HEADER -->
<div class="header">
    <a href="dashboard.php">⬅ Back</a>
    <h2>📚 My Courses</h2>
</div>

<!-- 📦 CONTAINER -->
<div class="container">

<?php
if($courses->num_rows > 0){
    while($c = $courses->fetch_assoc()){
?>

    <!-- 📚 COURSE CARD -->
    <div class="course-card">
        <h3><?php echo $c['title']; ?></h3>
        <p><?php echo $c['description']; ?></p>

        <a class="course-btn" href="course_view.php?course_id=<?php echo $c['id']; ?>">
            🚀 Open Course
        </a>
    </div>

<?php
    }
} else {
    echo "<p style='padding:20px;'>No courses found 😢</p>";
}
?>

</div>

</body>
</html>