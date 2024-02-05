<?php

// Insert Parent
if (isset($_POST['add_parent'])) {
    $parent_name = $_POST['parent_name'];
    $parent_email = $_POST['parent_email'];
    $parent_password = $_POST['parent_password'];
    $parent_cpassword = $_POST['parent_cpassword'];
    $kids = implode(',', $_POST['kids']);
    $cnic = $_POST['cnic'];

    $random_nums = strtotime("now");
    $parent_pic = $random_nums . "_" . $_FILES['parent_pic']['name'];
    $temp_pic = $_FILES['parent_pic']['tmp_name'];
    move_uploaded_file($temp_pic, "admin_images/registration/$parent_pic");

    $check_sql = "SELECT * FROM parent WHERE parent_email = '$parent_email' ";
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
        if ($parent_password == $parent_cpassword) {

            $insert_parent_sql = "INSERT INTO `parent` (`parent_name`, `parent_email`, `parent_password`, `kids`,`cnic`, `parent_pic`, `created_at`) VALUES ('$parent_name', '$parent_email', '$parent_password', '$kids','$cnic', '$parent_pic', current_timestamp());";
            // echo $insert_parent_sql;
            // exit;
            if ($conn->query($insert_parent_sql)) {
        ?>
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Good job!',
                            text: 'Parent Record has been Added Successfully!',
                            icon: 'success'
                        }).then(() => {
                            window.location.href = 'index.php?parent';
                        });
                    });
                </script>
            <?php
            } else {

            ?>
                <script>
                    $(document).ready(function() {
                        Swal.fire('Error!',
                            'Parent Record has not been Inserted!',
                            'error')
                    });
                </script>;
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
    <form action="" id="parent-registration" method="post" enctype="multipart/form-data">
        <h1 class="text-center my-3 bg-dark bg-gradient p-2 mt-3 my-heading">Parent Profile</h1>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="parent_name">Full Name</label>
                    <input type="text" class="form-control" placeholder="Full Name" name="parent_name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="parent_email">Email</label>
                    <input type="email" required class="form-control" placeholder="Email Address" name="parent_email">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="parent_password">Password</label>
                    <input type="password" required class="form-control" placeholder="Password" name="parent_password" id="parent_password">
                    <div class="ms-3 mt-1">
                        <input type="checkbox" class="my-1 form-check-input" onClick="myFunction()"> &nbsp;Show Password
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="parent_password">Confirm Password</label>
                    <input type="password" required class="form-control" placeholder="Password" name="parent_cpassword" id="parent_cpassword">
                    <div class="ms-3 mt-1">
                        <input type="checkbox" class="my-1 form-check-input" onClick="myFunction1()"> &nbsp;Show Password
                    </div>
                </div>
            </div>
        </div>
        <div class="registrationFormAlert mb-3" style="color:green;" id="CheckPasswordMatch"></div>
        <div class="row mb-3">
            <div class="col-lg-6">
                <label for="kids" class="form-label">Kids</label> <br>
                <select id="kids" class="form-select multi-select" name="kids[]" required multiple="multiple">
                    <option value="" selected disabled>Your Kid</option>
                    <?php
                    $student_sql = "SELECT * FROM `students`";
                    $student_result = $conn->query($student_sql);
                    while ($student_row = $student_result->fetch_assoc()) {
                    ?>
                        <option value="<?= $student_row['student_id'] ?>"><?= $student_row['student_name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="cnic">CNIC</label>
                    <input type="text" class="form-control" placeholder="CNIC" name="cnic">
                    <span id="cnic-error-message" style="color: red;"></span>
                </div>
            </div>
        </div>
        <div class="row col-md-12">
            <div class="mb-3">
                <label for="parent_pic" class="form-label">Insert Picture</label>
                <input type="file" class="form-control" name="parent_pic">
            </div>
        </div>
        <button type="submit" name="add_parent" id="add_parent" class="btn btn-primary"></i></span> Register</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#kids').multiselect({
            templates: {
                button: '<button type="button" class="multiselect dropdown-toggle btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false" style="width: 500px;"><span class="multiselect-selected-text"></span></button>',
            },
        });
    });
</script>

<script>
    function myFunction() {
        var x = document.getElementById("parent_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function myFunction1() {
        var cx = document.getElementById("parent_cpassword");
        if (cx.type === "password") {
            cx.type = "text";
        } else {
            cx.type = "password";
        }
    }

    function checkPasswordMatch() {
        var password = $("#parent_password").val();
        var confirmPassword = $("#parent_cpassword").val();
        if (password != confirmPassword)
            $("#CheckPasswordMatch").html("Passwords do not match!");
        else
            $("#CheckPasswordMatch").html("Passwords match.");
    }

    $(document).ready(function() {
        $("#parent_cpassword").keyup(checkPasswordMatch);

        $("input[name='cnic']").change(function() {
            var cnicInput = $(this);
            var cnic = cnicInput.val();
            var cnicRegex = /^[0-9]{5}-[0-9]{7}-[0-9]$/;
            var errorMessage = $("#cnic-error-message");

            if (cnicRegex.test(cnic)) {
                errorMessage.html("<span class='text-success'>Valid CNIC</span>");
            } else {
                errorMessage.html("CNIC is not valid. Please enter a valid CNIC in the format: 12345-1234567-1");
                cnicInput.val("0");
            }
        });
    });
</script>