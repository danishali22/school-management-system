<?php
// Insert Period
if (isset($_POST['create_period'])) {
    $period_name = $_POST['period_name'];
    $period_start_time = $_POST['period_start_time'];
    $period_end_time = $_POST['period_end_time'];
    $insert_period_sql = "INSERT INTO `period` (`period_name`, `period_start_time`, `period_end_time`, `created_at`)
    VALUES ('$period_name', '$period_start_time', '$period_end_time', current_timestamp())";
    if ($conn->query($insert_period_sql)) {
?>
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Period has been Added Successfully!',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'index.php?period';
                });
            });
        </script>
    <?php
    } else {

    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Error!',
                    'Period has not been Inserted! <br> We are facing some technical issue and your entry was not submitted successfully! We regret the inconvinience caused!',
                    'error')
            });
        </script>
<?php
    }
}


// Delete Period
if (isset($_GET['delete_period_id'])) {
    $delete_period_id = $_GET['delete_period_id'];
    $delete_period_sql = "DELETE FROM `period` WHERE period_id = '$delete_period_id' ";
    if ($conn->query($delete_period_sql)) {
    ?>
        <script>
    $(document).ready(function() {
        Swal.fire({
            title: 'Good job!',
            text: 'Period has been Deleted Successfully!',
            icon: 'success'
        }).then(() => {
                window.location.href = 'index.php?period';
        });
    })

        </script>
    <?php
    } 
    else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Period has not been Deleted', 'error');
            });
        </script>
<?php
    }
}

?>
<!-- Add Period  -->
        <div class="row col-md-8 mx-auto my-5">
            <h1 class="text-center my-3 bg-dark bg-gradient p-2 my-heading">Create New Period</h1>
            <form method="post" enctype='multipart/form-data'>
                <div class="mb-3">
                    <label for="period_name" class="form-label">Period Name</label>
                    <input type="text" class="form-control" id="period_name" name="period_name" required="" placeholder="Period Name">
                </div>
                <div class="mb-3 row">
                    <div class="col-md-6">
                        <label for="period_start_time" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="period_start_time" name="period_start_time" required="">
                    </div>
                    <div class="col-md-6">
                        <label for="period_end_time" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="period_end_time" name="period_end_time" required="">
                    </div>
                </div>
                <div class="mt-2 text-center">
                    <button type="submit" class="btn btn-primary" name="create_period" id="create_period">Create</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                </div>
            </form>
        </div>

 <!-- View Period -->
<div class="row col-md-10 mx-auto mt-5">
    <h1 class="text-center fs-1 bg-dark bg-gradient p-2 my-heading">Periods</h1>
    <table class="table mb-5 text-center my-table" id="my-dataTable">
        <thead class="table-info">
            <tr>
                <th scope="col">Sr</th>
                <th scope="col">Period Name</th>
                <th scope="col">Start Time</th>
                <th scope="col">End Time</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $period_sql = "SELECT * FROM `period`";
            $period_result = $conn->query($period_sql);
            $sno = 1;
            while ($period_row = $period_result->fetch_assoc()) {
            ?>
                <tr>
                    <th scope="row"><?= $sno++ ?></th>
                    <td> <?= $period_row['period_name'] ?> </td>
                    <td> <?= $period_row['period_start_time'] ?> </td>
                    <td> <?= $period_row['period_end_time'] ?> </td>
                    <td> <?= $period_row['created_at'] ?> </td>
                    <td>
                        <a class="btn btn-warning mx-1" href="index.php?edit_period_id=<?= $period_row['period_id'] ?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger mx-1" href="index.php?delete_period_id=<?= $period_row['period_id'] ?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php  }  ?>
        </tbody>
    </table>
</div>