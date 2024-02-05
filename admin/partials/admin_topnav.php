<?php 
    $admin_name = $_SESSION['admin_name'];
?>
<nav class="navbar navbar-dark fixed-top shadow" style="background-color: #343A40; margin-left: 250px;">
    <a href="index.php?dashboard" class="navbar-brand col-sm-3 col-md-2">Admin Portal - Star Model High School
        <span style="margin-left: 300px">Welcome <?= $admin_name ?></span>
    </a>
</nav>