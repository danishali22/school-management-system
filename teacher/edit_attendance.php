<div class="row my-5">
    <div class="col-md-6 mx-auto">
        <h1 class="text-center mt-3 bg-primary bg-gradient p-2 my-heading">Edit Attendance Record</h1>
        <form method="post" enctype='multipart/form-data'>
            <?php
            if (isset($_GET['edit_att_id'])) {
                $edit_att_id = $_GET['edit_att_id'];
                $sql = "SELECT * FROM `attendance` WHERE attendance_id = '$edit_att_id'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc()
            ?>
                <div class="mb-3">
                    <label for="gender" class="form-label">Stataus &nbsp;&nbsp;&nbsp;</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" <?php if ($row['attendance_status'] == 'Present') { ?> checked <?php } ?> type="radio" name="attendance_status" id="present" value="Present">
                        <label class="form-check-label" for="present">Present</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" <?php if ($row['attendance_status'] == 'Absent') { ?> checked <?php } ?> type="radio" name="attendance_status" id="absent" value="Absent">
                        <label class="form-check-label" for="absent">Absent</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" <?php if ($row['attendance_status'] == 'Leave') { ?> checked <?php } ?> type="radio" name="attendance_status" id="leave" value="Leave">
                        <label class="form-check-label" for="leave">Leave</label>
                    </div>
                </div>
            <?php
            }
            ?>
            <div class="mt-2 text-center">
                <button type="submit" class="btn btn-primary" name="update_att" id="update_att">Update</button>
                <a href="index.php?attendance" class="btn btn-danger">Back</a>
            </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['update_att'])) {;
    $status = $_POST['attendance_status'];
    $update_sql = "UPDATE `attendance` SET attendance_status = '$status' WHERE attendance_id = '$edit_att_id' ";
    if ($conn->query($update_sql)) {
?>
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Attendance Status has been Updated Successfully!',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'index.php?attendance';
                });
            })
        </script>
    <?php
    } else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Attendance Status has not been Updated', 'error');
            });
        </script>
<?php
    }
}

?>