<div class="row">
    <div class="col-md-10 mx-auto">
        <h1 class="text-center my-5 bg-dark bg-gradient p-2 my-heading">Edit Teacher Record</h1>
        <form method="post" enctype='multipart/form-data'>
            <?php
            if (isset($_GET['edit_teacher_id'])) {
                $edit_teacher_id = $_GET['edit_teacher_id'];
                $edit_sql = "SELECT * FROM `teachers` WHERE teacher_id = '$edit_teacher_id'";
                $edit_result = $conn->query($edit_sql);
                $edit_row = $edit_result->fetch_assoc();
            ?>
            <div class="row mb-3">
                <div class="col-md-12">
                <label for="teacher_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="teacher_name" name="teacher_name"
                    value="<?= $edit_row['teacher_name'] ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                <label for="teacher_email" class="form-label">Email</label>
                <input type="text" class="form-control" id="teacher_email" name="teacher_email"
                    value="<?= $edit_row['teacher_email'] ?>">
                </div>
                <div class="col-md-6">
                <label for="teacher_password" class="form-label">Password</label>
                <input type="text" class="form-control" id="teacher_password" name="teacher_password"
                    value="<?= $edit_row['teacher_password'] ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                <label for="teacher_dob" class="form-label">DOB</label>
                <input type="date" class="form-control" id="teacher_dob" name="teacher_dob"
                    value="<?= $edit_row['teacher_dob'] ?>">
                </div>
                <div class="col-md-4">
                <label for="teacher_phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="teacher_phone" name="teacher_phone"
                    value="<?= $edit_row['teacher_phone'] ?>">
                </div>
                <div class="col-md-4">
                <label for="teacher_subject" class="form-label">Subject</label>
                    <select id="teacher_subject" class="form-select" name="teacher_subject">
                        <option value="" selected>Select Subject</option>
                        <?php
                        $fetch_subject_sql = "SELECT * FROM `subject`";
                        $subject_result = $conn->query($fetch_subject_sql);
                        while ($subject_row = $subject_result->fetch_assoc()) {
                        ?>
                            <option value="<?= $subject_row['subject_id'] ?>" <?php if ($edit_row['teacher_subject'] == $subject_row['subject_id']) { ?> selected <?php } ?>> <?php echo $subject_row['subject_name'] ?></option>

                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="teacher_address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="teacher_address" name="teacher_address"
                    value="<?= $edit_row['teacher_address'] ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md">
                    <label for="teacher_age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="teacher_age" name="teacher_age"
                    value="<?= $edit_row['teacher_age'] ?>">
                </div>
                <div class="col-md mt-4 ms-5">
                <label for="gender" class="form-label">Gender &nbsp;&nbsp;&nbsp;</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" <?php if ($edit_row['teacher_gender'] == 'Male') { ?> checked <?php } ?> type="radio" name="teacher_gender" id="male" value="Male">
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" <?php if ($edit_row['teacher_gender'] == 'Female') { ?> checked <?php } ?> type="radio" name="teacher_gender" id="female" value="Female">
                    <label class="form-check-label" for="female">Female</label>
                </div>
                </div>
                <div class="col-md">
                    <label for="pic" class="form-label">Insert Picture</label>
                    <input type="file" value="<?php echo $edit_row['teacher_pic'] ?>" class="form-control" name="teacher_pic" id="teacher_pic">
                    <img src="admin_images/registration/<?= $edit_row['teacher_pic'] ?>" alt="teacher Image" height="70" width="80" class="img-fluid img-thumbnail">
                    <input type="hidden" name="teacher_old_pic" value="<?php echo $edit_row['teacher_pic'] ?>">
                </div>
            </div>
            <?php }?>
            <div class="text-center my-5">
                <button type="submit" class="btn btn-primary" name="update_room" id="update_room">Update</button>
                <a href="index.php?teacher" class="btn btn-danger">Back</a>
            </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['update_room'])) {;
    $teacher_name = $_POST['teacher_name'];
    $teacher_email = $_POST['teacher_email'];
    $teacher_password = $_POST['teacher_password'];
    $teacher_dob = $_POST['teacher_dob'];
    $teacher_phone = $_POST['teacher_phone'];
    $teacher_subject = $_POST['teacher_subject'];
    $teacher_address = $_POST['teacher_address'];
    $teacher_age = $_POST['teacher_age'];
    $teacher_gender = $_POST['teacher_gender'];
    if($_FILES['teacher_pic']['name'] != "" ){
        $random_pic = strtotime("now");
        $teacher_pic = $random_pic . "_" . $_FILES['teacher_pic']['name'];
        $temp_pic = $_FILES['teacher_pic']['tmp_name'];
        move_uploaded_file($temp_pic, "admin_images/registration/$teacher_pic");
    }else{
        $teacher_pic = $_POST['teacher_old_pic'];
    }
    $update_sql = "UPDATE `teachers` SET teacher_name = '$teacher_name', teacher_email = '$teacher_email', teacher_password = '$teacher_password',teacher_dob = '$teacher_dob', teacher_phone = '$teacher_phone', teacher_subject = '$teacher_subject', teacher_address = '$teacher_address', teacher_age = '$teacher_age', teacher_gender = '$teacher_gender', teacher_pic = '$teacher_pic' WHERE teacher_id = '$edit_teacher_id' ";
    // echo $update_sql;
    // exit;
    if ($conn->query($update_sql)) {
?>
<script>
$(document).ready(function() {
    $(document).ready(function() {
        Swal.fire({
            title: 'Good job!',
            text: 'Teacher Record has been Updated Successfully!',
            icon: 'success'
        }).then(() => {
                window.location.href = 'index.php?teacher';
        });
    })
});
</script>
<?php
    } else {
    ?>
<script>
$(document).ready(function() {
    Swal.fire('Oops!', 'Teacher Record has not been Updated', 'error');
});
</script>
<?php
    }
}
?>