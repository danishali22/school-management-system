<?php 
    $teacher_name = $_SESSION['teacher_name'];
    $teacher_gender = $_SESSION['teacher_gender'];
?>
<nav class="navbar navbar-dark fixed-top p-0 shadow" style="background-color: #225470;">
    <a href="index.php?dashboard" class="navbar-brand col-sm-3 col-md-2">Teacher Portal - Star Model School
    <span style="margin-left: 400px">Welcome <?php  $gender = ($teacher_gender === 'Male') ? 'Sir ' : (($teacher_gender === 'Female') ? 'Miss ' : ''); echo $gender . $teacher_name;   ?>
    </span>
    </a>
</nav>
