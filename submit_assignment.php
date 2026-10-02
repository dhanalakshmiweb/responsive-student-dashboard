<?php
session_start();
include "db.php";

$student_id = $_SESSION['student_id'];
$assignment_id = $_POST['assignment_id'];

$file = $_FILES['assignment_file']['name'];
$tmp = $_FILES['assignment_file']['tmp_name'];

move_uploaded_file($tmp, "uploads/".$file);

/* Insert into submissions */
$conn->query("
    INSERT INTO submissions (student_id, assignment_id, file, status)
    VALUES ($student_id, $assignment_id, '$file', 'Submitted')
");

header("Location: assignment.php");
?>