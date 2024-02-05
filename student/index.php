<?php require_once('partials/student_head.php'); 
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
            <?php require_once('partials/student_topnav.php') 
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <!-- Sidebar  -->
            <?php require_once('partials/student_sidebar.php'); 
            ?>
        </div>
        <!-- Content  -->
        <div class="col-md-10">
            <?php
            require_once('../partials/_connection.php');
            // Dashboard
            if (isset($_GET['add_student'])) {
                require_once('student_form.php');
            }

            // Grade
            if (isset($_GET['grade'])) {
                require_once('grade.php');
            }

            // Result
            if (isset($_GET['result'])) {
                require_once('result.php');
            }

            // Logout
            if (isset($_GET['student_logout'])) {
                require_once('student_logout.php');
            }

            // Student Change Password
            if (isset($_GET['student_change_password'])) {
                require_once('student_change_password.php');
            }

            // Student Fee
            if (isset($_GET['fee'])) {
                require_once('fee.php');
            }
            if (isset($_GET['pay_fee_id'])) {
                require_once('add_fee.php');
            }

            // Notice
            if (isset($_GET['notice'])) {
                require_once('notice.php');
            }
            if (isset($_GET['view_notice_id'])) {
                require_once('view_notice.php');
            }
            
            // Attendance
            if (isset($_GET['attendance'])) {
                require_once('attendance.php');
            }

            // Feedback
            if (isset($_GET['feedback'])) {
                require_once('feedback.php');
            }

            // Timetable
            if (isset($_GET['timetable'])) {
                require_once('timetable.php');
            }

            // Profile
            if (isset($_GET['student_profile'])) {
                require_once('student_profile.php');
            }
            ?>
        </div>
    </div>
<?php require_once('partials/student_footer.php'); 
?>