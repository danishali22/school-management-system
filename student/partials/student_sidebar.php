<?php
    require_once('../partials/_connection.php');
    $student_pic = $_SESSION['student_pic'];
    $student_name = $_SESSION['student_name'];
    $student_rollno = $_SESSION['student_rollno'];
    $student_class_id = $_SESSION['student_class'];
    $fetch_class_sql = "SELECT class_name FROM class WHERE class_id = '$student_class_id' ";
    $class_result = $conn->query($fetch_class_sql);
    $fetch_class_row = $class_result->fetch_assoc();
    // Student Class
    $student_class = $fetch_class_row['class_name'];

?>
<nav class="bg-light bg-gradient sidebar py-5 d-print-none m-0" style=" height: auto; margin-top:10px !important;">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item mb-3">
                <img src="../admin/admin_images/registration/<?= $student_pic ?>" alt="<?= $student_name ?> Picture" class="border border-primary border-2 img-fluid img-thumbnail" width="200px">
                <h5 class="my-2"> <?= $student_name?> </h5>
                <h5 class="my-2"> <?= $student_rollno?> </h5>
                <h5 class="my-2">Class: <?= $student_class?> </h5>
            </li>
            <li class="nav-item">
                <a href="index.php?student_profile" class="nav-link">
                    <i class="fas fa-users"></i> Profile
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?attendance" class="nav-link">
                <i class="fa fa-calendar-check"></i> Attendance
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?feedback" class="nav-link">
                    <i class="fas fa-comments"></i> Feedback
                </a>
            </li>
            <li class="nav-item">
            <a href="index.php?timetable" class="nav-link">
              <i class="nav-icon fas fa-calendar-alt"></i>Timetable
            </a>
          </li>
            <li class="nav-item">
                <a href="index.php?notice" class="nav-link">
                    <i class="fas fa-bullhorn"></i> Notice
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?grade" class="nav-link">
                    <i class="fas fa-star"></i> Grade
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?result" class="nav-link">
                <i class="fas fa-trophy"></i> Result
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?fee" class="nav-link">
                <i class="fas fa-dollar-sign"></i> Fee
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?student_change_password" class="nav-link">
                    <i class="fas fa-key"></i> Change Password
                </a>
            </li>
            <li class="nav-item">
                <a href="../index.php" class="nav-link">
                <i class="fas fa-arrow-left"></i> Back
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?student_logout" class="nav-link">
                    <i class="fa fa-sign-out-alt"></i>Logout
                </a>
            </li>
        </ul>
    </div>
</nav>