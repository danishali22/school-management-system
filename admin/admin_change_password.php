<?php
$admin_email = $_SESSION['admin_email'];
$sql = "SELECT * FROM `admin` WHERE admin_email = '$admin_email'";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $admin_old_password = $row['admin_password'];
}

if (isset($_POST['stu_new_pass_btn'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    if ($old_password  == $admin_old_password) {
        if ($new_password == $confirm_password) {
            $sql = "UPDATE `admin` SET `admin_password` = '$new_password' WHERE admin_email = '$admin_email' ";
            // echo $sql;
            // exit;
            $conn->query($sql);
?>
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Good job!',
                        text: 'Your Password is Changed Sucessfully!',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'index.php?dashboard';
                    });
                });
            </script>
        <?php
        } else {
        ?>
            <script>
                $(document).ready(function() {
                    Swal.fire('Error!',
                        'Your Passwords does not Match!! Please Try again',
                        'error')
                });
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Error!',
                    'Your Current Password is Incorrect!! Type correct Password and Try again',
                    'error')
            });
        </script>
    <?php
    }
    if ($old_password  != $admin_old_password && $new_password != $confirm_password) {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Error!',
                    'Your Old Password is Incorrect and Your Passwords does not Match!! Please Try again',
                    'error')
            });
        </script>
<?php
    }
}
?>
<div class="col-md-10 mx-auto p-5 my-3">
    <h1 class="text-center bg-dark bg-gradient text-white mb-2 p-2 my-heading">Change Your Password</h1>
    <form method="post">
        <div class="mb-3">
            <label for="old_password" class="form-label">Enter Your old Password</label>
            <input type="password" class="form-control" id="old_password" name="old_password" required="">
            <input type="checkbox" class="my-3" onclick="myFunction1()"> &nbsp;Show Password
        </div>
        <div class="mb-3">
            <label for="txtNewPassword" class="form-label">New Password</label>
            <input type="password" class="form-control" id="txtNewPassword" name="new_password" required="">
            <input type="checkbox" class="my-3" onclick="myFunction2()"> &nbsp;Show Password
        </div>
        <div class="mb-3">
            <label for="txtConfirmPassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="txtConfirmPassword" name="confirm_password" required="">
            <input type="checkbox" class="my-3" onclick="myFunction3()"> &nbsp;Show Password
        </div>
        <div class="registrationFormAlert" style="color:green;" id="CheckPasswordMatch"></div>
        <div class="mt-2 text-center">
            <button type="submit" class="btn btn-outline-dark" name="stu_new_pass_btn" id="stu_new_pass_btn">Change
                Password</button>
        </div>
    </form>
</div>
<script>
    function myFunction1() {
        var x = document.getElementById("old_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function myFunction2() {
        var x = document.getElementById("txtNewPassword");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function myFunction3() {
        var x = document.getElementById("txtConfirmPassword");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function checkPasswordMatch() {
        var password = $("#txtNewPassword").val();
        var confirmPassword = $("#txtConfirmPassword").val();
        if (password != confirmPassword)
            $("#CheckPasswordMatch").html("Passwords does not match!");
        else if (password == confirmPassword)
            $("#CheckPasswordMatch").html("Passwords match.");
    }
    $(document).ready(function() {
        $("#txtConfirmPassword").keyup(checkPasswordMatch);
    });
</script>