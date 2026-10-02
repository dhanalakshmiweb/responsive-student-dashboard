<?php
session_start();
include "db.php";

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

/* 👤 Fetch student */
$student = $conn->query("SELECT * FROM students WHERE id=$student_id")->fetch_assoc();

$msg = "";

/* 🔄 RESET COURSES */
if(isset($_POST['reset_courses'])){
    $conn->query("DELETE FROM student_progress WHERE student_id=$student_id");
    $msg = "Courses Reset Successfully!";
}

/* 📝 RESET ASSIGNMENTS */
if(isset($_POST['reset_assignments'])){
    $conn->query("DELETE FROM submissions WHERE student_id=$student_id");
    $msg = "Assignments Reset Successfully!";
}

/* 🔐 CHANGE PASSWORD */
if(isset($_POST['change_password'])){

    $old = $_POST['old_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    $res = $conn->query("SELECT password FROM students WHERE id=$student_id");
    $row = $res->fetch_assoc();
    $db_password = $row['password'];

    if(!password_verify($old, $db_password)){
        $msg = "❌ You entered wrong old password!";
    }
    else if($new !== $confirm){
        $msg = "❌ New password and confirm password do not match!";
    }
    else{
        $hash = password_hash($new, PASSWORD_DEFAULT);
        $conn->query("UPDATE students SET password='$hash' WHERE id=$student_id");
        $msg = "✔ Password updated successfully!";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Settings</title>
<link rel="stylesheet" href="settings.css">
</head>

<body>

<div class="wrapper">

<!-- TOPBAR -->
<div class="topbar">
    <span class="menu-btn" onclick="toggleMenu()">☰</span>
    <h2>⚙️ Settings</h2>
    <span>👤 <?= $student['username'] ?></span>
</div>

<!-- SIDEBAR -->
<div id="sidebar" class="sidebar">
    <h3>Menu</h3>

    <a href="dashboard.php">🏠 Dashboard</a><br><br>
    <a href="courses.php">📚 Courses</a><br><br>
    <a href="assignment.php">📝 Assignment</a><br><br>
    <a href="logout.php">🚪 Logout</a><br><br>
</div>

<!-- MAIN -->
<div id="main" class="main">

<?php if($msg){ ?>
<div class="msg"><?= $msg ?></div>
<?php } ?>
<br><br><br>
<!-- 👤 PROFILE -->
<div class="card">
<h3>👤 Profile</h3>
<p><b>Username:</b> <?= $student['username'] ?></p>
</div>

<!-- 🔄 RESET -->
<div class="card">
<h3>🔄 Reset Data</h3>

<form method="post">
<button class="btn danger" name="reset_courses">Reset Courses</button>
<button class="btn warning" name="reset_assignments">Reset Assignments</button>
</form>

</div>

<!-- 🔐 PASSWORD -->
<div class="card">
<h3>🔐 Change Password</h3>

<form method="post" class="form">
<input type="password" name="old_password" placeholder="Old Password" required>
<input type="password" name="new_password" placeholder="New Password" required>
<input type="password" name="confirm_password" placeholder="Confirm Password" required>

<button class="btn primary" name="change_password">Update Password</button>
</form>

</div>

</div> <!-- main -->
</div> <!-- wrapper -->

<script>
function toggleMenu(){
    document.getElementById("sidebar").classList.toggle("closed");
}
</script>

</body>
</html>