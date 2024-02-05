<?php require_once('partials/teacher_head.php'); 
?>
<?php
// session_start();
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
            <?php require_once('partials/teacher_topnav.php') 
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <!-- Sidebar  -->
            <?php require_once('partials/teacher_sidebar.php'); 
            ?>
        </div>
        <!-- Content  -->
        <div class="col-md-10">
            <?php
            require_once('../partials/_connection.php');
            // Dashboard

            // Exam
            if (isset($_GET['exam'])) {
                require_once('exam.php');
            }
            if (isset($_GET['add_exam'])) {
                require_once('add_exam.php');
            }
            if (isset($_GET['edit_exam_id'])) {
                require_once('edit_exam.php');
            }
            if (isset($_GET['delete_exam_id'])) {
                require_once('exam.php');
            }

            // Logout
            if (isset($_GET['teacher_logout'])) {
                require_once('teacher_logout.php');
            }

             // Teacher Change Ppassword
             if (isset($_GET['teacher_change_password'])) {
                require_once('teacher_change_password.php');
            }

             // Teacher Profile
             if (isset($_GET['teacher_profile'])) {
                require_once('teacher_profile.php');
            }

            // Notice
            if (isset($_GET['notice'])) {
                require_once('notice.php');
            }
            if (isset($_GET['view_notice_id'])) {
                require_once('view_notice.php');
            }
            if (isset($_GET['my_notice'])) {
                require_once('my_notice.php');
            }
            if (isset($_GET['edit_notice_id'])) {
                require_once('edit_notice.php');
            }
            if (isset($_GET['delete_notice_id'])) {
                require_once('my_notice.php');
            }

            // Attendance
            if (isset($_GET['add_attendance'])) {
                require_once('add_attendance.php');
            }
            if (isset($_GET['attendance'])) {
                require_once('attendance.php');
            }
            if (isset($_GET['edit_att_id'])) {
                require_once('edit_attendance.php');
            }
            if (isset($_GET['attendance'])) {
                require_once('attendance.php');
            }
            if (isset($_GET['delete_att_id'])) {
                require_once('attendance.php');
            }

            // Feedback
            if (isset($_GET['feedback'])) {
                require_once('feedback.php');
            }
            if (isset($_GET['edit_feedback_id'])) {
                require_once('edit_feedback.php');
            }
            if (isset($_GET['delete_feedback_id'])) {
                require_once('feedback.php');
            }

            // Timetable
            if (isset($_GET['timetable'])) {
                require_once('timetable.php');
            }
            ?>
        </div>
    </div>
<?php require_once('partials/teacher_footer.php'); 
?>