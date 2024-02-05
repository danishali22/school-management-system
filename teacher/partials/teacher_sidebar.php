<?php
$teacher_pic = $_SESSION['teacher_pic'];
$teacher_name = $_SESSION['teacher_name'];
?>
<nav class="bg-light sidebar py-5 d-print-none m-0" style=" height: auto">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item mb-3">
                <img src="../admin/admin_images/registration/<?= $teacher_pic ?>" alt="Mr. <?php echo $teacher_name ?> Picture" class="border border-primary border-2 img-fluid img-thumbnail" width="200px">
            </li>
            <li class="nav-item">
                <a href="index.php?teacher_profile" class="nav-link">
                    <i class="fas fa-users"></i> Profile
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?notice" class="nav-link">
                    <i class="fas fa-bullhorn"></i> Notice
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?my_notice" class="nav-link">
                    <i class="fas fa-bell"></i> My Notices
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?timetable" class="nav-link">
                    <i class="nav-icon fas fa-calendar-alt"></i> Timetable
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?attendance" class="nav-link">
                    <i class="fa fa-calendar-check"></i> Attendance
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?exam" class="nav-link">
                    <i class="fa fa-book"></i> Exam
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?feedback" class="nav-link">
                    <i class="fas fa-comments"></i> Feedback
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?teacher_change_password" class="nav-link">
                    <i class="fas fa-key"></i> Change Password
                </a>
            </li>
            <li class="nav-item">
                <a href="../index.php" class="nav-link">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?teacher_logout" class="nav-link">
                    <i class="fa fa-sign-out-alt"></i>Logout
                </a>
            </li>
        </ul>
    </div>
</nav>