<?php
require_once('../partials/_connection.php');
// Retrieve the student's ID from the URL
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $fetch_student_sql = "SELECT * FROM students WHERE student_id = '$student_id' ";
    $student_result = $conn->query($fetch_student_sql);
    $student_row = $student_result->fetch_assoc();
    // Start a session for the student
    session_start();
    $_SESSION['student_login'] = TRUE;
    $_SESSION['student_id'] = $student_row['student_id'];
    $_SESSION['student_name'] = $student_row['student_name'];
    $_SESSION['student_email'] = $student_row['student_email'];
    $_SESSION['student_rollno'] = $student_row['student_rollno'];
    $_SESSION['student_class'] = $student_row['student_class'];
    $_SESSION['student_pic'] = $student_row['student_pic'];

    echo "<script> window.location.href='../student/index.php?student_profile' </script>";
    exit;
} else {
    // Handle the case when no student ID is provided in the URL
    echo "Please select a student from the parent dashboard.";
}
