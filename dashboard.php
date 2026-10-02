<?php
session_start();
include "db.php";

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

/* 👤 Student Info */
$student = $conn->query("SELECT * FROM students WHERE id=$student_id")->fetch_assoc();

/* 📚 Total Courses */
$total_courses = $conn->query("SELECT COUNT(*) as total FROM courses")->fetch_assoc()['total'];

/* ✔ Completed Courses */
$completed = $conn->query("
    SELECT COUNT(DISTINCT course_id) as c 
    FROM student_progress 
    WHERE student_id=$student_id AND step=3
")->fetch_assoc()['c'];

$pending = $total_courses - $completed;

/* 📝 Assignments (FIXED COUNT) */
$total_assignments = $conn->query("SELECT COUNT(*) as total FROM assignments")->fetch_assoc()['total'];

$submitted = $conn->query("
    SELECT COUNT(DISTINCT assignment_id) as total 
    FROM submissions 
    WHERE student_id=$student_id
")->fetch_assoc()['total'];

$pending_assignments = $total_assignments - $submitted;

/* 📊 Progress */
$total_steps = $total_courses * 3;

$row = $conn->query("SELECT COUNT(*) as c FROM student_progress WHERE student_id=$student_id")->fetch_assoc();

$completed_steps = (int)$row['c'];
$pending_steps = max(0, $total_steps - $completed_steps);
$progress_percent = ($total_steps > 0) ? ($completed_steps / $total_steps) * 100 : 0;

$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

/* 🌈 BASE */
body {
    margin:0;
    font-family: 'Segoe UI';
    background:#ddd;
}

/* 🔥 LAYOUT */
.wrapper {
    display:flex;
}

/* 📌 SIDEBAR */
.sidebar {
    width:228px;
    height:100vh;
    background:linear-gradient(135deg,#6a0dad,#9b30ff);
    color:white;
    padding:20px;
    position:fixed;
    left:0;
    top:0;
    transition:0.3s;
}

.sidebar.closed {
    left:-250px;
}

/* 📄 CONTENT */
.main {
    margin-left:250px;
    padding:20px;
    width:100%;
    transition:0.3s;
}

.main.full {
    margin-left:0;
}
.sidebar a {
    display:block;
    color:white;
    text-decoration:none; /* underline remove */
    margin:8px 0;
    padding:5px;
    cursor:default; /* link feel remove */
}

.sidebar a:hover {
    background:rgba(255,255,255,0.1);
    border-radius:5px;
}

/* 🔝 TOPBAR */
.topbar {
    background:linear-gradient(135deg,#6a0dad,#9b30ff);
    color:white;
    padding:20px;
    border-radius:10px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

/* ☰ */
.menu-btn {
    font-size:24px;
    cursor:pointer;
}

/* 📦 CARDS */
.cards {
    display:flex;
    gap:20px;
    flex-wrap:wrap;
    margin-top:20px;
}

.card {
    flex:1;
    min-width:200px;
    padding:25px;
    border-radius:15px;
    color:white;
    text-align:center;
    font-size:20px;
}
/* 🔥 CLICK POP EFFECT */
.card.clicked {
    transform: scale(1.1);
    transition: 0.2s ease;
}
.card {
    transition: 0.2s ease;
}
/* 🔥 SMOOTH TRANSITION */
.card {
    transition: all 0.25s ease;
}

/* 🔥 HOVER POP */
.card:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 25px rgba(222, 241, 244, 0.25);
}

/* 🔥 CLICK POP (STRONG) */
.card.clicked {
    transform: scale(1.1);
    box-shadow: 0 18px 35px rgba(234, 240, 243, 0.35);
}

.purple {background:linear-gradient(135deg,#6a0dad,#9b30ff);}
.green {background:linear-gradient(135deg,#28a745,#4caf50);}
.orange {background:linear-gradient(135deg,#ff9800,#ff5722);}
.blue {background:linear-gradient(135deg,#2196f3,#64b5f6);}

/* 📊 FLEX SECTION */
.flex-section {
    display:flex;
    gap:30px;
    margin-top:30px;
    flex-wrap:wrap;
}

.box {
    flex:1;
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(13, 224, 221, 0.1);
}
#chart {
    height:300px !important;
}

/* 📊 PROGRESS BAR */
.progress-bar {
    background:#ddd;
    border-radius:10px;
    overflow:hidden;
    margin-bottom:10px;
}
.progress-fill {
    background:#6a0dad;
    color:white;
    text-align:center;
}

</style>
</head>

<body>

<div class="wrapper">

<!-- SIDEBAR -->
<div id="sidebar" class="sidebar">
<h3>Main</h3>
<br>
<a href="dashboard.php">🏠 Dashboard</a>
<br>
<a href="courses.php">📚 Courses</a>
<br>
<a href="assignment.php">📝 Assignment</a>

<h3>Personal</h3>
<a href="profile.php">👤 Profile</a>
<br>
<a href="message.php">📢 Messages</a>
<br>
<a href="logout.php">🚪 Logout</a>
<br>
<a href="settings.php">⚙️settings</a>
</div>

<!-- MAIN -->
<div id="main" class="main">

<div class="topbar">
<span class="menu-btn" onclick="toggleMenu()">☰</span>
<h2>🎓 Student Dashboard</h2>
<span>👤 <?php echo $student['username']; ?></span>
</div>

<!-- CARDS -->
<div class="cards">
<div class="card purple">Total Courses<br><?php echo $total_courses; ?></div>
<div class="card green">Course Completed<br><?php echo $completed; ?></div>
<div class="card orange">Course Pending<br><?php echo $pending; ?></div>
<div class="card blue">Assignments<br><?php echo $total_assignments; ?></div>
</div>

<!-- FLEX (CHART + COURSE) -->
<div class="flex-section">

<!-- CHART -->
<div class="box">
<h3>Overall Progress</h3>
<canvas id="chart" style="max-width:300px;margin:auto;"></canvas>
</div>

<!-- COURSE -->
<div class="box">
<h3>Course Progress</h3>

<?php
$courses = $conn->query("
SELECT c.title, COUNT(p.id) as done
FROM courses c
LEFT JOIN student_progress p 
ON c.id=p.course_id AND p.student_id=$student_id
GROUP BY c.id
");

while($c=$courses->fetch_assoc()){
$percent = ($c['done']/3)*100;
?>

<p><?= $c['title'] ?></p>
<div class="progress-bar">
<div class="progress-fill" style="width:<?= $percent ?>%">
<?= round($percent) ?>%
</div>
</div>

<?php } ?>

</div>

</div>

</div>
</div>

<script>
function toggleMenu() {
    document.getElementById("sidebar").classList.toggle("closed");
    document.querySelector(".container").classList.toggle("full");
    document.querySelector(".topbar").classList.toggle("full");
}

/* 🔥 PIE CHART */
new Chart(document.getElementById("chart"), {
type:"pie",
data:{
labels:["Completed","Pending"],
datasets:[{
data:[<?= $completed ?>, <?= $pending ?>],
backgroundColor:["#28a745","#ff9800"]
}]
}
});
document.querySelectorAll(".card").forEach(card => {
    card.addEventListener("click", function() {
        this.classList.add("clicked");

        setTimeout(() => {
            this.classList.remove("clicked");
        }, 200);
    });
});

</script>

</body>
</html>