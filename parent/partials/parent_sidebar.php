<?php
require_once('../partials/_connection.php');
$parent_pic = $_SESSION['parent_pic'];
$parent_name = $_SESSION['parent_name'];
$kids = explode(',', $_SESSION['kids']);
foreach ($kids as $kid) {
    $fetch_student_sql = "SELECT `student_name` FROM `students` WHERE student_id = '$kid'";
    $fetch_student_result = $conn->query($fetch_student_sql);
    $fetch_student_row = $fetch_student_result->fetch_assoc();
    // echo $fetch_studenyyt_row['student_name'] . "<br>";
    $student_names = $fetch_student_row['student_name'] . "<br>";
    $parent_kids[] = $student_names;
}

?>
<nav class="bg-light bg-gradient sidebar py-5 d-print-none m-0" style=" height: auto; margin-top:10px !important;">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item mb-3">
                <img src="../admin/admin_images/registration/<?= $parent_pic ?>" alt="<?= $parent_name ?> Picture" class="border border-primary border-2 img-fluid img-thumbnail" width="200px">
                <h5 class="my-2"> <?= $parent_name ?> </h5>
                <h5>Kids:</h5>
                <?php
                    foreach ($parent_kids as $kid) {
                        echo "<h5 class='my-2'>&nbsp;&nbsp;&nbsp;&nbsp;$kid</h5>";
                    }
                ?>
            </li>
            <li class="nav-item">
                <a href="index.php?dashboard" class="nav-link">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?parent_profile" class="nav-link">
                    <i class="fas fa-users"></i> Profile
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?parent_change_password" class="nav-link">
                    <i class="fas fa-key"></i> Change Password
                </a>
            </li>
            <li class="nav-item">
                <a href="../index.php" class="nav-link">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?parent_logout" class="nav-link">
                    <i class="fa fa-sign-out-alt"></i>Logout
                </a>
            </li>
        </ul>
    </div>
</nav>