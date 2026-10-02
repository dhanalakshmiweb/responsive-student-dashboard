<?php
session_start();
include "db.php";

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

/* 👤 USER */
$user = $conn->query("SELECT * FROM students WHERE id=$student_id")->fetch_assoc();

/* 📚 COURSES */
$total_courses = $conn->query("SELECT COUNT(*) as t FROM courses")->fetch_assoc()['t'];

$completed_courses = $conn->query("
    SELECT COUNT(DISTINCT course_id) as c 
    FROM student_progress 
    WHERE student_id=$student_id AND step=3
")->fetch_assoc()['c'];

$pending_courses = $total_courses - $completed_courses;

/* 📝 ASSIGNMENTS */
$total_submitted = $conn->query("
    SELECT COUNT(DISTINCT assignment_id) as t 
    FROM submissions 
    WHERE student_id=$student_id
")->fetch_assoc()['t'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>

<body>

<!-- 🔝 TOPBAR -->
<div class="topbar">
    <div class="menu-icon" onclick="toggleMenu()">☰</div>
    <h2>Profile</h2>
</div>

<!-- 📌 SIDEBAR -->
<div id="sidebar" class="sidebar">
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="profile.php">👤 Profile</a>
    <a href="assignment.php">📝 Assignments</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- 👤 CONTENT -->
<div class="container">

    <div class="profile-card">

        <h2>👤 <?php echo $user['username']; ?></h2>

        <div class="stats">

            <div class="box green">
                <h3>Completed Courses</h3>
                <p><?php echo $completed_courses; ?></p>
            </div>

            <div class="box orange">
                <h3>Pending Courses</h3>
                <p><?php echo $pending_courses; ?></p>
            </div>

            <div class="box blue">
                <h3>Assignments Submitted</h3>
                <p><?php echo $total_submitted; ?></p>
            </div>

        </div>

    </div>

</div>

<!-- ⚙️ JS -->
<script>
function toggleMenu() {
    document.getElementById("sidebar").classList.toggle("active");
}
</script>

</body>
</html>