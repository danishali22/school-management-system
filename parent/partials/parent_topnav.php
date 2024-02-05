<?php 
    $parent_name = $_SESSION['parent_name'];
?>
<nav class="navbar navbar-dark fixed-top p-0 shadow" style="background-color: #225470;">
    <a href="index.php?dashboard" class="navbar-brand col-sm-3 col-md-2">Parent Portal - Star Model High School
        <span style="margin-left: 400px">Welcome Mr &nbsp;<?= $parent_name ?></span>
    </a>
</nav>