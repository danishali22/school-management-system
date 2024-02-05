<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['teacher_name'])) {
    header("location: teacher/index.php");
}
if (isset($_SESSION['student_name'])) {
    header("location: student/index.php");
}
$title = "Login";
include('partials/_head.php');
?>

<?php
$title = 'iSchool - Login';
require_once('partials/_head.php');
require_once('partials/_navbar.php');
?>

<div class="container-fluid my-body">
    <div class="row">
        <div class="col-md-12">
            <section class='login' id='login'>
                <div class='head'>
                    <h1 class='company mb-4'>School Management System</h1>
                    <hr>
                </div>
                <div class='form'>
                    <form method="post" id="student_login_form">
                        <div class="mb-3">
                            <i class="fas fa-envelope"></i><label for="login_email" class="form-label fw-bold">&nbsp;Email</label>
                            <input type="email" required="" class="form-control" id="login_email" name="login_email" placeholder="Email">
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-key"></i><label for="login_password" class="form-label fw-bold">&nbsp;Password</label>
                            <input type="password" required="" class="form-control" id="login_password" name="login_password" placeholder="Password">
                            <input type="checkbox" class="my-1" onclick="showLoginPass()"> &nbsp;Show Password
                        </div>
                        <div class="mb-4">
                            <i class="fas fa-user"></i><label for="login_type" class="form-label fw-bold">&nbsp;Account Type</label>
                            <select class="form-select" aria-label="Default select example" name="login_type">
                                <option selected>Account Type</option>
                                <option value="1">Teacher</option>
                                <option value="2">Student</option>
                                <option value="3">Admin</option>
                                <option value="4">Parent</option>
                            </select>
                        </div>
                        <button class='btn-login btn' id='do-login' name="login">Login</button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    function showLoginPass() {
        var x = document.getElementById("login_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

<?php
require_once('partials/_connection.php');

if (isset($_POST['login'])) {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];
    $type = $_POST['login_type'];

    if ($type == 1) {
        // Teacher login
        $teacher_sql = "SELECT * FROM `teachers` WHERE `teacher_email` = '$email'";
        $teacher_result = $conn->query($teacher_sql);
        $teacher_numExist = mysqli_num_rows($teacher_result);

        if ($teacher_numExist > 0) {
            while ($teacher_row = $teacher_result->fetch_assoc()) {
                if ($teacher_row['teacher_verify'] == 'Disable') {
                    session_destroy();
                    // Show account disabled message
?>
                    <script>
                        $(document).ready(function() {
                            Swal.fire('Login Failed!', "Your account is temporarily disabled. Contact the Administration Department.", "info");
                        });
                    </script>
                <?php
                } elseif ($teacher_row['teacher_password'] === $password) {
                    $_SESSION['teacher_login'] = TRUE;
                    $_SESSION['teacher_id'] = $teacher_row['teacher_id'];
                    $_SESSION['teacher_name'] = $teacher_row['teacher_name'];
                    $_SESSION['teacher_email'] = $teacher_row['teacher_email'];
                    $_SESSION['teacher_pic'] = $teacher_row['teacher_pic'];
                    $_SESSION['teacher_gender'] = $teacher_row['teacher_gender'];
                    echo "<script> window.location.href='teacher/index.php?teacher_profile' </script>";
                    exit;
                } else {
                    // Show wrong password message
                ?>
                    <script>
                        $(document).ready(function() {
                            Swal.fire('Wrong Password!', "You entered the wrong password. Please try again with the correct password.", "error");
                        });
                    </script>
            <?php
                }
            }
        } else {
            // Show wrong email message
            ?>
            <script>
                $(document).ready(function() {
                    Swal.fire('Wrong Email or Account Type!', "The Email or Account Typed you entered is incorrect. Please provide the correct Email and Account Type.", "error");
                });
            </script>
            <?php
            session_destroy();
        }
    } elseif ($type == 2) {
        // Student login
        $student_sql = "SELECT * FROM `students` WHERE `student_email` = '$email'";
        $student_result = $conn->query($student_sql);
        $student_numExist = mysqli_num_rows($student_result);

        if ($student_numExist > 0) {
            while ($student_row = $student_result->fetch_assoc()) {
                if ($student_row['student_verify'] == 'Disable') {
                    session_destroy();
                    // Show account disabled message
            ?>
                    <script>
                        $(document).ready(function() {
                            Swal.fire('Login Failed!', "Your account is temporarily disabled. Contact the Administration Department.", "info");
                        });
                    </script>
                <?php
                } elseif ($student_row['student_password'] === $password) {
                    $_SESSION['student_login'] = TRUE;
                    $_SESSION['student_id'] = $student_row['student_id'];
                    $_SESSION['student_name'] = $student_row['student_name'];
                    $_SESSION['student_email'] = $student_row['student_email'];
                    $_SESSION['student_rollno'] = $student_row['student_rollno'];
                    $_SESSION['student_class'] = $student_row['student_class'];
                    $_SESSION['student_pic'] = $student_row['student_pic'];
                    echo "<script> window.location.href='student/index.php?student_profile' </script>";
                    exit;
                } else {
                    // Show wrong password message
                ?>
                    <script>
                        $(document).ready(function() {
                            Swal.fire('Wrong Password!', "You entered the wrong password. Please try again with the correct password.", "error");
                        });
                    </script>
            <?php
                }
            }
        } else {
            // Show wrong email message
            ?>
            <script>
                $(document).ready(function() {
                    Swal.fire('Wrong Email or Account Type!', "The Email or Account Typed you entered is incorrect. Please provide the correct Email and Account Type.", "error");
                });
            </script>
            <?php
            session_destroy();
        }
    } elseif ($type == 3) {
        // Admin login
        $admin_sql = "SELECT * FROM `admin` WHERE `admin_email` = '$email'";
        $admin_result = $conn->query($admin_sql);
        $admin_numExist = mysqli_num_rows($admin_result);

        if ($admin_numExist > 0) {
            while ($admin_row = $admin_result->fetch_assoc()) {
                if ($admin_row['admin_password'] === $password) {
                    $_SESSION['admin_login'] = TRUE;
                    $_SESSION['admin_id'] = $admin_row['admin_id'];
                    $_SESSION['admin_name'] = $admin_row['admin_name'];
                    $_SESSION['admin_email'] = $admin_row['admin_email'];
                    echo "<script> window.location.href='admin/index.php?teacher' </script>";
                    exit;
                } else {
                    // Show wrong password message
            ?>
                    <script>
                        $(document).ready(function() {
                            Swal.fire('Wrong Password!', "You entered the wrong password. Please try again with the correct password.", "error");
                        });
                    </script>
            <?php
                }
            }
        } else {
            // Show wrong email message
            ?>
            <script>
                $(document).ready(function() {
                    Swal.fire('Wrong Email or Account Type!', "The Email or Account Typed you entered is incorrect. Please provide the correct Email and Account Type.", "error");
                });
            </script>
            <?php
            session_destroy();
        }
    } elseif ($type == 4) {
        // Parent login
        $parent_sql = "SELECT * FROM `parent` WHERE `parent_email` = '$email'";
        $parent_result = $conn->query($parent_sql);
        $parent_numExist = mysqli_num_rows($parent_result);

        if ($parent_numExist > 0) {
            $parent_row = $parent_result->fetch_assoc();
            if ($parent_row['parent_password'] === $password) {
                $_SESSION['parent_login'] = TRUE;
                $_SESSION['parent_id'] = $parent_row['parent_id'];
                $_SESSION['parent_name'] = $parent_row['parent_name'];
                $_SESSION['parent_email'] = $parent_row['parent_email'];
                $_SESSION['parent_pic'] = $parent_row['parent_pic'];
                $_SESSION['kids'] = $parent_row['kids'];
                echo "<script> window.location.href='parent/index.php?dashboard' </script>";
                exit;
            } else {
                // Show wrong password message
            ?>
                <script>
                    $(document).ready(function() {
                        Swal.fire('Wrong Password!', "You entered the wrong password. Please try again with the correct password.", "error");
                    });
                </script>
            <?php
            }
        } else {
            // Show wrong email message
            ?>
            <script>
                $(document).ready(function() {
                    Swal.fire('Wrong Email or Account Type!', "The Email or Account Typed you entered is incorrect. Please provide the correct Email and Account Type.", "error");
                });
            </script>
        <?php
            session_destroy();
        }
    } else {
        // Show account type error message
        ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Error!', "Log In Failed", "error");
            });
        </script>
<?php
        session_destroy();
    }
}
?>

<?php
require_once('partials/_footer.php');
require_once('partials/_bottom.php');
?>