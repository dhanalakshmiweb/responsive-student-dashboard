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

/* 📝 PENDING ASSIGNMENTS */
$pending_assignments = $conn->query("
    SELECT COUNT(*) as c 
    FROM assignments a
    LEFT JOIN submissions s 
    ON a.id = s.assignment_id AND s.student_id=$student_id
    WHERE s.id IS NULL
")->fetch_assoc()['c'];

/* ⏳ DEADLINE */
$deadline = $conn->query("
    SELECT MIN(deadline) as d FROM assignments
")->fetch_assoc()['d'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Messages</title>
    <link rel="stylesheet" href="message.css">
</head>

<body>

<!-- 🔝 TOPBAR -->
<div class="topbar">
    <div class="menu-icon" onclick="toggleMenu()">☰</div>
    <h2>Messages</h2>
</div>

<!-- 📌 SIDEBAR -->
<div id="sidebar" class="sidebar">
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="profile.php">👤 Profile</a>
    <a href="assignment.php">📝 Assignments</a>
    <a href="message.php">📢 Messages</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- 📦 CONTENT -->
<div class="container">

    <div class="message-box">

        <h2>📢 Notifications</h2>

        <p>👋 Welcome <b><?php echo $user['username']; ?></b>!</p>

        <p>📚 You have <b><?php echo $pending_courses; ?></b> pending courses — complete them soon.</p>

        <p>📝 You have <b><?php echo $pending_assignments; ?></b> pending assignments.</p>

        <p>⏳ Nearest deadline: <b><?php echo $deadline; ?></b></p>

        <p class="warning">⚠ Please complete before deadline.</p>

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