<?php require_once('partials/parent_head.php'); 
?>
<?php
//session_start();
// $site_url = 'http://localhost/youtube-sms/';
// if(isset($_SESSION['login']) && $_SESSION['login'] == TRUE)
// {
//   if(isset($_SESSION['user_type']) && $_SESSION['user_type'] != 'admin')
//   {
//     $user_type = $_SESSION['user_type'];
//     header('Location: /sms/'.$user_type.'/dashboard.php');
//   }
// }
// else 
// {
//   header('Location: ../login.php');
// }
?>
    <div class="row">
        <div class="col-md-12">
            <!-- Topnav  -->
            <?php require_once('partials/parent_topnav.php') 
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <!-- Sidebar  -->
            <?php require_once('partials/parent_sidebar.php'); 
            ?>
        </div>
        <!-- Content  -->
        <div class="col-md-10">
            <?php
            require_once('../partials/_connection.php');
            if (isset($_GET['dashboard'])) {
                require_once('dashboard.php');
            }

            // Logout
            if (isset($_GET['parent_logout'])) {
                require_once('parent_logout.php');
            }

            // Change Password
            if (isset($_GET['parent_change_password'])) {
                require_once('parent_change_password.php');
            }

            // Profile
            if (isset($_GET['parent_profile'])) {
                require_once('parent_profile.php');
            }
            ?>
        </div>
    </div>
<?php require_once('partials/parent_footer.php'); 
?>