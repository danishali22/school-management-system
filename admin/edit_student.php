<div class="row mt-5">
    <div class="col-md-10 mx-auto">
        <h1 class="text-center my-3 bg-dark bg-gradient p-2 my-heading">Edit Student Record</h1>
        <form method="post" enctype='multipart/form-data'>
            <?php
            if (isset($_GET['edit_student_id'])) {
                $edit_student_id = $_GET['edit_student_id'];
                $edit_sql = "SELECT * FROM `students` WHERE student_id = '$edit_student_id'";
                $edit_result = $conn->query($edit_sql);
                $edit_row = $edit_result->fetch_assoc();
            ?>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="student_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="student_name" name="student_name" value="<?= $edit_row['student_name'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="student_rollno" class="form-label">Roll Number</label>
                        <input type="text" class="form-control" id="student_rollno" name="student_rollno" value="<?= $edit_row['student_rollno'] ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="student_email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="student_email" name="student_email" value="<?= $edit_row['student_email'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="student_password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="student_password" name="student_password" value="<?= $edit_row['student_password'] ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="student_dob" class="form-label">DOB</label>
                        <input type="text" class="form-control" id="student_dob" name="student_dob" value="<?= $edit_row['student_dob'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="student_phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="student_phone" name="student_phone" value="<?= $edit_row['student_phone'] ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="room_class" class="form-label">Select Class</label>
                        <select id="room_class" class="form-select" name="room_class">
                            <option value="" selected>Select Class</option>
                            <?php
                            $fetch_class_sql = "SELECT * FROM class";
                            $class_result = $conn->query($fetch_class_sql);
                            while ($class_row = $class_result->fetch_assoc()) {
                            ?>
                                <option value="<?= $class_row['class_id'] ?>" <?php if ($edit_row['student_class'] == $class_row['class_id']) { ?> selected <?php } ?>> <?php echo $class_row['class_name'] ?></option>

                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="room_class_section" class="form-label">Select Section</label>
                        <select id="room_class_section" class="form-select" name="room_class_section">
                            <option value="" selected>Select Section</option>
                            <?php
                            $selected_class_id = $edit_row['student_class'];

                            // Fetch selected class's section IDs
                            $fetch_section_sql = "SELECT section_name FROM class WHERE class_id = '$selected_class_id'";
                            $section_result = $conn->query($fetch_section_sql);

                            if ($section_result->num_rows > 0) {
                                $section_row = $section_result->fetch_assoc();
                                $selected_section_ids = explode(',', $section_row['section_name']);

                                // Fetch all sections
                                $fetch_all_sections_sql = "SELECT section_id, section_title FROM section";
                                $all_sections_result = $conn->query($fetch_all_sections_sql);

                                while ($section_row = $all_sections_result->fetch_assoc()) {
                                    $section_id = $section_row['section_id'];
                                    $section_title = $section_row['section_title'];

                                    echo "<option value='$section_id'";
                                    if (in_array($section_id, $selected_section_ids) || $section_id == $edit_row['student_section']) {
                                        echo " selected";
                                    }
                                    echo ">$section_title</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="student_address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="student_address" name="student_address" value="<?= $edit_row['student_address'] ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md">
                        <label for="student_age" class="form-label">Age</label>
                        <input type="number" class="form-control" id="student_age" name="student_age" value="<?= $edit_row['student_age'] ?>">
                    </div>
                    <div class="col-md mt-4 ms-5">
                        <label for="gender" class="form-label">Gender &nbsp;&nbsp;&nbsp;</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" <?php if ($edit_row['student_gender'] == 'Male') { ?> checked <?php } ?> type="radio" name="student_gender" id="male" value="Male">
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" <?php if ($edit_row['student_gender'] == 'Female') { ?> checked <?php } ?> type="radio" name="student_gender" id="female" value="Female">
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="pic" class="form-label">Insert Picture</label>
                        <input type="file" value="<?php echo $edit_row['student_pic'] ?>" class="form-control" name="student_pic" id="student_pic">
                        <img src="admin_images/registration/<?= $edit_row['student_pic'] ?>" alt="Student Image" height="70" width="80" class="img-fluid img-thumbnail">
                        <input type="hidden" name="student_old_pic" value="<?php echo $edit_row['student_pic'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="cnic" class="form-label">Father CNIC</label>
                        <input type="text" class="form-control" id="cnic" name="cnic" value="<?= $edit_row['father_cnic'] ?>">
                        <span id="cnic-error-message" style="color: red;"></span>
                    </div>
                </div>
            <?php } ?>
            <div class="text-center my-5">
                <button type="submit" class="btn btn-primary" name="update_room" id="update_room">Update</button>
                <a href="index.php?student" class="btn btn-danger">Back</a>
            </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['update_room'])) {;
    $student_rollno = $_POST['student_rollno'];
    $student_name = $_POST['student_name'];
    $student_email = $_POST['student_email'];
    $student_password = $_POST['student_password'];
    $student_dob = $_POST['student_dob'];
    $student_phone = $_POST['student_phone'];
    $student_class = $_POST['room_class'];
    $student_section = $_POST['room_class_section'];
    $student_address = $_POST['student_address'];
    $student_age = $_POST['student_age'];
    $student_gender = $_POST['student_gender'];
    if ($_FILES['student_pic']['name'] != "") {
        $random_pic = strtotime("now");
        $student_pic = $random_pic . "_" . $_FILES['student_pic']['name'];
        $temp_pic = $_FILES['student_pic']['tmp_name'];
        move_uploaded_file($temp_pic, "admin_images/registration/$student_pic");
    } else {
        $student_pic = $_POST['student_old_pic'];
    }
    $father_cnic = $_POST['cnic'];
    $update_sql = "UPDATE `students` SET student_rollno = '$student_rollno', student_name = '$student_name', student_email = '$student_email', student_password = '$student_password',student_dob = '$student_dob', student_phone = '$student_phone', student_class = '$student_class', student_section = '$student_section', student_address = '$student_address', student_age = '$student_age', student_gender = '$student_gender', student_pic = '$student_pic', father_cnic = '$father_cnic'  WHERE student_id = '$edit_student_id' ";
    // echo $update_sql;
    // exit;
    if ($conn->query($update_sql)) {
?>
        <script>
            $(document).ready(function() {
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Good job!',
                        text: 'Student Record has been Updated Successfully!',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'index.php?student';
                    });
                })
            });
        </script>
    <?php
    } else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Student Record has not been Updated', 'error');
            });
        </script>
<?php
    }
}
?>

<script>
    $(document).ready(function() {
        $('#room_class').on('change', function() {
            var classId = $(this).val();
            if (classId !== '') {
                $.ajax({
                    url: 'get_sections.php',
                    method: 'POST',
                    data: {
                        class_id: classId
                    },
                    dataType: 'json',
                    success: function(data) {
                        var sectionContainer = $('#room_class_section_container');
                        var sectionSelect = $('#room_class_section');

                        sectionSelect.empty().append($('<option>', {
                            value: '',
                            text: 'Select Class Section'
                        }));

                        if (data.length > 0) {
                            $.each(data, function(index, section) {
                                sectionSelect.append($('<option>', {
                                    value: section.section_id,
                                    text: section.section_title
                                }));
                            });

                            // Show the section selection container
                            sectionContainer.show();
                        } else {
                            // Hide the section selection container
                            sectionContainer.hide();
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.log('Error:', errorThrown);
                    }
                });
            } else {
                // Hide the section selection container
                $('#room_class_section_container').hide();
                $('#room_class_section').empty().append($('<option>', {
                    value: '',
                    text: 'Select Class Section'
                }));
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
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