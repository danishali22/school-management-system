<?php

// Insert Student
if (isset($_POST['add_teacher'])) {
    $teacher_name = $_POST['teacher_name'];
    $teacher_email = $_POST['teacher_email'];
    $teacher_password = $_POST['teacher_password'];
    $teacher_cpassword = $_POST['teacher_cpassword'];
    $teacher_dob = $_POST['teacher_dob'];
    $teacher_phone = $_POST['teacher_phone'];
    $teacher_subject = $_POST['teacher_subject'];
    $teacher_address = $_POST['teacher_address'];
    $teacher_age = $_POST['teacher_age'];
    $teacher_gender = $_POST['teacher_gender'];

    $random_nums = strtotime("now");
    $teacher_pic = $random_nums . "_" . $_FILES['teacher_pic']['name'];
    $temp_pic = $_FILES['teacher_pic']['tmp_name'];
    move_uploaded_file($temp_pic, "admin_images/registration/$teacher_pic");

    $check_sql = "SELECT * FROM teachers WHERE teacher_email = '$teacher_email' ";
    $check_result = $conn->query($check_sql);
    $check_count = mysqli_num_rows($check_result);
    if ($check_count > 0) {
?>
        <script>
            $(document).ready(function() {
                Swal.fire('Registration Failed!',
                    'This Email is already Registered, So try a different Email',
                    'error')
            });
        </script>
        <?php
    } else {
        if ($teacher_password == $teacher_cpassword) {

            $insert_teacher_sql = "INSERT INTO `teachers` (`teacher_name`, `teacher_email`, `teacher_password`, `teacher_dob`,`teacher_phone`, `teacher_subject`, `teacher_address`, `teacher_age`,`teacher_gender`, `teacher_pic`,  `teacher_joining_date`) VALUES ('$teacher_name', '$teacher_email', '$teacher_password', '$teacher_dob','$teacher_phone', '$teacher_subject', '$teacher_address', '$teacher_age','$teacher_gender', '$teacher_pic', current_timestamp());";
            if ($conn->query($insert_teacher_sql)) {
        ?>
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Good job!',
                            text: 'Teacher Record has been Added Successfully!',
                            icon: 'success'
                        }).then(() => {
                            window.location.href = 'index.php?teacher';
                        });
                    });
                </script>
            <?php
            } else {

            ?>
                <script>
                    $(document).ready(function() {
                        Swal.fire('Error!',
                            'Teacher Record has not been Inserted!',
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
                        'Your Password must be same, So Please try again and type same Password',
                        'error')
                });
            </script>
<?php
        }
    }
}
?>

<div class="container my-5">
    <form action="" id="student-registration" method="post" enctype="multipart/form-data">
        <h1 class="text-center my-3 bg-dark bg-gradient p-2 mt-5 my-heading">Add New Teacher</h1>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="teacher_name">Full Name</label>
                    <input type="text" class="form-control" placeholder="Full Name" name="teacher_name">
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="teacher_email">Email</label>
                    <input type="email" required class="form-control" placeholder="Email Address" name="teacher_email">
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="teacher_password">Password</label>
                    <input type="password" required class="form-control" placeholder="Password" name="teacher_password" id="teacher_password">
                    <div class="ms-3 mt-1">
                        <input type="checkbox" class="my-1 form-check-input" onClick="myFunction()"> &nbsp;Show Password
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="teacher_password">Confirm Password</label>
                    <input type="password" required class="form-control" placeholder="Password" name="teacher_cpassword" id="teacher_cpassword">
                    <div class="ms-3 mt-1">
                        <input type="checkbox" class="my-1 form-check-input" onClick="myCFunction()"> &nbsp;Show Password
                    </div>
                </div>
            </div>
            <div class="registrationFormAlert mb-3" style="color:green;" id="CheckPasswordMatch"></div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="teacher_dob">DOB</label>
                    <input type="date" required class="form-control" placeholder="DOB" name="teacher_dob">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="teacher_phone">Phone</label>
                    <input type="text" class="form-control" placeholder="Mobile" name="teacher_phone">
                </div>
            </div>
            <div class="col-lg-4">
                <label for="teacher_subject" class="form-label">Subject</label>
                <select id="teacher_subject" class="form-select" name="teacher_subject" required>
                    <option value="" selected>Select Subject</option>
                    <?php
                    $subject_sql = "SELECT * FROM `subject`";
                    $subject_result = $conn->query($subject_sql);
                    while ($subject_row = $subject_result->fetch_assoc()) {
                    ?>
                        <option value="<?= $subject_row['subject_id'] ?>"><?= $subject_row['subject_name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="teacher_address">Address</label>
                    <input type="text" class="form-control" placeholder="Address" name="teacher_address">
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md">
                <div class="form-group">
                    <label for="teacher_age">Age</label>
                    <input type="number" class="form-control" placeholder="Age" name="teacher_age">
                </div>
            </div>
            <div class="col-md mt-4 ms-5">
                <label for="teacher_gender" class="form-label">Gender &nbsp;&nbsp;&nbsp;</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="male" value="Male" name="teacher_gender">
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="female" value="Female" name="teacher_gender">
                    <label class="form-check-label" for="female">Female</label>
                </div>
            </div>
            <div class="col-md">
                <div class="mb-3">
                    <label for="teacher_pic" class="form-label">Insert Picture</label>
                    <input type="file" class="form-control" name="teacher_pic">
                </div>
            </div>
        </div>
        <button type="submit" name="add_teacher" id="add_teacher" class="btn btn-primary"></i></span> Register</button>
    </form>
</div>

<script>
    function myFunction() {
        var x = document.getElementById("teacher_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    function myCFunction() {
        var cx = document.getElementById("teacher_cpassword");
        if (cx.type === "password") {
            cx.type = "text";
        } else {
            cx.type = "password";
        }
    }

    function checkPasswordMatch() {
        var password = $("#teacher_password").val();
        var confirmPassword = $("#teacher_cpassword").val();
        if (password != confirmPassword)
            $("#CheckPasswordMatch").html("Passwords do not match!");
        else
            $("#CheckPasswordMatch").html("Passwords match.");
    }

    $(document).ready(function() {
        $("#teacher_cpassword").keyup(checkPasswordMatch);
    });
</script>