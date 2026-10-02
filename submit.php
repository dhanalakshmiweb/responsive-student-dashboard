<?php
session_start();
include "db.php";

$student_id = $_SESSION['student_id'];
$course_id = $_POST['course_id'];
$step = $_POST['step'];

/* mark step complete */
$conn->query("
    INSERT INTO student_progress (student_id, course_id, step, status)
    VALUES ($student_id, $course_id, $step, 'completed')
");

/* unlock next step */
$next_step = $step + 1;

echo "<script>
alert('Step Completed!');
window.location.href='course_view.php?course_id=$course_id';
</script>";
?>