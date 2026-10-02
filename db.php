<?php
$conn = new mysqli(
    getenv("DB_HOST") ?: "localhost",
    getenv("DB_USER") ?: "root",
    getenv("DB_PASS") ?: "",
    getenv("DB_NAME") ?: "student_dashboard"
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>