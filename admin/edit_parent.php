<div class="row mt-3">
    <div class="col-md-10 mx-auto">
        <h1 class="text-center my-5 bg-dark bg-gradient p-2 my-heading">Edit Parent Record</h1>
        <form method="post" enctype='multipart/form-data'>
            <?php
            if (isset($_GET['edit_parent_id'])) {
                $edit_parent_id = $_GET['edit_parent_id'];
                $edit_sql = "SELECT * FROM `parent` WHERE parent_id = '$edit_parent_id'";
                $edit_result = $conn->query($edit_sql);
                $edit_row = $edit_result->fetch_assoc();
            ?>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="parent_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="parent_name" name="parent_name" value="<?= $edit_row['parent_name'] ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="parent_email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="parent_email" name="parent_email" value="<?= $edit_row['parent_email'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="parent_password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="parent_password" name="parent_password" value="<?= $edit_row['parent_password'] ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="kids" class="form-label">Kids</label> <br>
                        <select id="kids" class="form-select multi-select" name="kids[]" multiple="multiple">
                            <option value="" disabled>Select Kids</option>
                            <?php
                            $fetch_student_sql = "SELECT * FROM `students`";
                            $student_result = $conn->query($fetch_student_sql);
                            $selected_students = explode(',', $edit_row['kids']); // Convert comma-separated student IDs to an array
                            while ($student_row = $student_result->fetch_assoc()) {
                                $student_id = $student_row['student_id'];
                                $student_name = $student_row['student_name'];
                                $selected = in_array($student_id, $selected_students) ? 'selected' : '';
                            ?>
                                <option value="<?= $student_id ?>" <?= $selected ?>> <?= $student_name ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="cnic" class="form-label">CNIC</label>
                        <input type="text" class="form-control" id="cnic" name="cnic" value="<?= $edit_row['cnic'] ?>">
                        <span id="cnic-error-message" style="color: red;"></span>
                    </div>
                </div>
                <div class="row col-md-12">
                    <label for="pic" class="form-label">Insert Picture</label>
                    <input type="file" value="<?php echo $edit_row['parent_pic'] ?>" class="form-control" name="parent_pic" id="parent_pic">
                    <img src="admin_images/registration/<?= $edit_row['parent_pic'] ?>" alt="parent Image" height="70" width="80" class="img-fluid img-thumbnail" style="width: 100px;">
                    <input type="hidden" name="parent_old_pic" value="<?php echo $edit_row['parent_pic'] ?>">
                </div>
            <?php } ?>
            <div class="text-center my-5">
                <button type="submit" class="btn btn-primary" name="update_room" id="update_room">Update</button>
                <a href="index.php?parent" class="btn btn-danger">Back</a>
            </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['update_room'])) {;
    $parent_name = $_POST['parent_name'];
    $parent_email = $_POST['parent_email'];
    $parent_password = $_POST['parent_password'];
    $kids = implode(',', $_POST['kids']);
    $cnic = $_POST['cnic'];

    if ($_FILES['parent_pic']['name'] != "") {
        $random_pic = strtotime("now");
        $parent_pic = $random_pic . "_" . $_FILES['parent_pic']['name'];
        $temp_pic = $_FILES['parent_pic']['tmp_name'];
        move_uploaded_file($temp_pic, "admin_images/registration/$parent_pic");
    } else {
        $parent_pic = $_POST['parent_old_pic'];
    }
    $update_sql = "UPDATE `parent` SET parent_name = '$parent_name', parent_email = '$parent_email', parent_password = '$parent_password',kids = '$kids', cnic = '$cnic', parent_pic = '$parent_pic' WHERE parent_id = '$edit_parent_id' ";
    // echo $update_sql;
    // exit;
    if ($conn->query($update_sql)) {
?>
        <script>
            $(document).ready(function() {
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Good job!',
                        text: 'Parent Record has been Updated Successfully!',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'index.php?parent';
                    });
                })
            });
        </script>
    <?php
    } else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Parent Record has not been Updated', 'error');
            });
        </script>
<?php
    }
}
?>

<script>
    $(document).ready(function() {
        $('#kids').multiselect({
            templates: {
                button: '<button type="button" class="multiselect dropdown-toggle btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false" style="width: 400px;"><span class="multiselect-selected-text"></span></button>',
            },
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