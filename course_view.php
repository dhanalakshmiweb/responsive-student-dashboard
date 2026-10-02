<?php
session_start();
include "db.php";

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['course_id'])){
    echo "Course ID missing";
    exit();
}

$student_id = $_SESSION['student_id'];
$course_id = $_GET['course_id'];

/* 🔥 COURSE TITLE FETCH */
$courseData = $conn->query("SELECT title FROM courses WHERE id=$course_id")->fetch_assoc();
$course_title = $courseData ? $courseData['title'] : "Course";

/* 📌 Completed steps */
$completedSteps = [];

$res = $conn->query("
    SELECT step 
    FROM student_progress 
    WHERE student_id=$student_id 
    AND course_id=$course_id
");

while($row = $res->fetch_assoc()){
    $completedSteps[] = $row['step'];
}

/* 📚 syllabus */
$syllabus = [
    1 => "Module 1 Basics",
    2 => "Module 2 Intermediate",
    3 => "Module 3 Advanced"
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Course View</title>
    <link rel="stylesheet" href="dashboard.css">

    <style>
    /* 🔥 COURSE HEADER */
    .course-header {
        background: linear-gradient(135deg,#6a0dad,#9b30ff);
        color: white;
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .course-header h1 {
        margin: 0;
        font-size: 26px;
    }

    /* 🎯 MODULE CARD */
    .module-card {
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 15px;
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: 0.3s;
    }

    .module-card:hover {
        transform: translateY(-5px);
    }

    /* 🎨 STATUS COLORS */
    .done { border-left: 6px solid #28a745; }
    .active { border-left: 6px solid #007bff; }
    .locked { border-left: 6px solid #ccc; opacity: 0.7; }

    /* 🔥 BUTTON STYLE */
    .btn {
        padding: 8px 15px;
        border: none;
        border-radius: 8px;
        color: white;
        cursor: pointer;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-start {
        background: linear-gradient(135deg,#007bff,#66b3ff);
    }

    .btn-revisit {
        background: linear-gradient(135deg,#28a745,#5cd65c);
    }

    .btn-locked {
        background: gray;
        cursor: not-allowed;
    }

    .btn:hover {
        transform: scale(1.05);
    }

    .status {
        font-size: 13px;
        margin-left: 10px;
    }
    </style>
</head>
<body>
<!-- 🔥 NEW HEADER -->
<div class="course-header">
    <h1>👋 Welcome to <?php echo $course_title; ?></h1>
    <p>Learn from basics to advanced step by step 🚀</p>
    <button class="btn:'btn-start'>"><a href="courses.php">⬅ Back</a></button>
            </div>

<?php foreach($syllabus as $step_id => $title) { ?>

<?php
$isCompleted = in_array($step_id, $completedSteps);
$isUnlocked = ($step_id == 1) || in_array($step_id - 1, $completedSteps);

/* CLASS */
$cardClass = $isCompleted ? "module-card done" : ($isUnlocked ? "module-card active" : "module-card locked");
?>

<div class="<?php echo $cardClass; ?>">

    <h3>
        <?php echo $title; ?>

        <?php if($isCompleted) { ?>
            <span class="status">✔ Completed</span>
        <?php } ?>

        <?php if(!$isUnlocked) { ?>
            <span class="status">🔒 Locked</span>
        <?php } ?>
    </h3>

    <?php if($isUnlocked) { ?>
        <a href="questions.php?course_id=<?php echo $course_id; ?>&step=<?php echo $step_id; ?>">
            <button class="btn <?php echo $isCompleted ? 'btn-revisit' : 'btn-start'; ?>">
                <?php echo $isCompleted ? "Revisit" : "Start"; ?>
            </button>
        </a>
    <?php } else { ?>
        <button class="btn btn-locked">Locked</button>
    <?php } ?>

</div>

<?php } ?>

</div>

</body>
</html>