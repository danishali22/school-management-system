<div class="row my-5">
    <div class="col-md-8 mx-auto">
        <h1 class="text-center mt-3 bg-dark bg-gradient p-2 my-heading">Edit Subject</h1>
        <form method="post" enctype='multipart/form-data'>
            <?php
            if (isset($_GET['edit_subject_id'])) {
                $edit_subject_id = $_GET['edit_subject_id'];
                $sql = "SELECT * FROM `subject` WHERE subject_id = '$edit_subject_id'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
            ?>
            <div class="mb-3">
                <label for="subject_code" class="form-label">Subject Code</label>
                <input type="text" class="form-control" id="subject_code" name="subject_code"
                    value="<?= $row['subject_code'] ?>">
            </div>
            <div class="mb-3">
                <label for="subject_name" class="form-label">Subject Name</label>
                <input type="text" class="form-control" id="subject_name" name="subject_name"
                    value="<?= $row['subject_name'] ?>">
            </div>
            <?php }?>
            <div class="mt-2 text-center">
                <button type="submit" class="btn btn-primary" name="update_subject" id="update_subject">Update</button>
                <a href="index.php?subject" class="btn btn-danger">Back</a>
            </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['update_subject'])) {;
    $subject_code = $_POST['subject_code'];
    $subject_name = $_POST['subject_name'];
    $update_sql = "UPDATE `subject` SET subject_code = '$subject_code', subject_name = '$subject_name', `created_at` = CURRENT_TIME() WHERE subject_id = '$edit_subject_id' ";
    if ($conn->query($update_sql)) {
?>
<script>
$(document).ready(function() {
    $(document).ready(function() {
        Swal.fire({
            title: 'Good job!',
            text: 'Subject has been Updated Successfully!',
            icon: 'success'
        }).then(() => {
                window.location.href = 'index.php?subject';
        });
    })
});
</script>
<?php
    } else {
    ?>
<script>
$(document).ready(function() {
    Swal.fire('Oops!', 'Subject has not been Updated', 'error');
});
</script>
<?php
    }
}
?>