<div class="row my-5">
    <div class="col-md-8 mx-auto"  style="margin-top: 10px;">
        <h1 class="text-center mt-3 bg-dark bg-gradient p-2 my-heading">Edit Period</h1>
        <form method="post" enctype='multipart/form-data'>
            <?php
            if (isset($_GET['edit_period_id'])) {
                $edit_period_id = $_GET['edit_period_id'];
                $edit_sql = "SELECT * FROM `period` WHERE period_id = '$edit_period_id'";
                $edit_result = $conn->query($edit_sql);
                $edit_row = $edit_result->fetch_assoc();
            ?>
            <div class="mb-3">
                <label for="period_name" class="form-label">Period Name</label>
                <input type="text" class="form-control" id="period_name" name="period_name"
                    value="<?= $edit_row['period_name'] ?>">
            </div>
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="period_start_time" class="form-label">Start Time</label>
                    <input type="time" class="form-control" id="period_start_time" name="period_start_time"
                    value="<?= $edit_row['period_start_time'] ?>">
                </div>
                <div class="col-md-6">
                    <label for="period_end_time" class="form-label">End Time</label>
                    <input type="time" class="form-control" id="period_end_time" name="period_end_time"
                    value="<?= $edit_row['period_end_time'] ?>">
                </div>
            </div>
            <?php }?>
            <div class="mt-2 text-center">
                <button type="submit" class="btn btn-primary" name="update_period" id="update_period">Update</button>
                <a href="index.php?period" class="btn btn-danger">Back</a>
            </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['update_period'])) {;
    $period_name = $_POST['period_name'];
    $period_start_time = $_POST['period_start_time'];
    $period_end_time = $_POST['period_end_time'];
    $update_sql = "UPDATE `period` SET period_name = '$period_name', period_start_time = '$period_start_time', period_end_time = '$period_end_time', `created_at` = CURRENT_TIME() WHERE period_id = '$edit_period_id' ";
    if ($conn->query($update_sql)) {
?>
<script>
$(document).ready(function() {
    $(document).ready(function() {
        Swal.fire({
            title: 'Good job!',
            text: 'Period has been Updated Successfully!',
            icon: 'success'
        }).then(() => {
                window.location.href = 'index.php?period';
        });
    })
});
</script>
<?php
    } else {
    ?>
<script>
$(document).ready(function() {
    Swal.fire('Oops!', 'Period has not been Updated', 'error');
});
</script>
<?php
    }
}
?>