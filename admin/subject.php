<?php
// Insert Subject
if (isset($_POST['create_subject'])) {
    $subject_code = $_POST['subject_code'];
    $subject_name = $_POST['subject_name'];
    $insert_subject_sql = "INSERT INTO `subject` (`subject_code`, `subject_name`, `created_at`) VALUES ('$subject_code', '$subject_name', current_timestamp());";
    if ($conn->query($insert_subject_sql)) {
?>
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Subject has been Added Successfully!',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'index.php?subject';
                });
            });
        </script>
    <?php
    } else {

    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Error!',
                    'Subject has not been Inserted! <br> We are facing some technical issue and your entry was not submitted successfully! We regret the inconvinience caused!',
                    'error')
            });
        </script>;
<?php
    }
}


// Delete Subject
if (isset($_GET['delete_subject_id'])) {
    $delete_subject_id = $_GET['delete_subject_id'];
    $delete_subject_sql = "DELETE FROM `subject` WHERE subject_id = '$delete_subject_id' ";
    if ($conn->query($delete_subject_sql)) {
    ?>
        <script>
    $(document).ready(function() {
        Swal.fire({
            title: 'Good job!',
            text: 'Subject has been Deleted Successfully!',
            icon: 'success'
        }).then(() => {
                window.location.href = 'index.php?subject';
        });
    })

        </script>
    <?php
    } 
    else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Subject has not been Deleted', 'error');
            });
        </script>
<?php
    }
}

?>
<!-- Add Subject  -->
        <div class="row col-md-8 mx-auto my-5">
            <h1 class="text-center my-3 bg-dark bg-gradient p-2 my-heading">Create New Subject</h1>
            <form method="post" enctype='multipart/form-data'>
                <div class="mb-3">
                    <label for="subject_code" class="form-label">Subject Code</label>
                    <input type="text" class="form-control" id="subject_code" name="subject_code" required="" placeholder="Subject Code">
                </div>
                <div class="mb-3">
                    <label for="subject_name" class="form-label">Subject Name</label>
                    <input type="text" class="form-control" id="subject_name" name="subject_name" required="" placeholder="Subject Name">
                </div>
                <div class="mt-2 text-center">
                    <button type="submit" class="btn btn-primary" name="create_subject" id="create_subject">Create</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                </div>
            </form>
        </div>

 <!-- View Subject -->
<div class="row col-md-10 mx-auto mt-5">
    <h1 class="text-center fs-1 bg-dark bg-gradient p-2 my-heading">Subjects</h1>
    <table class="table mb-5 text-center my-table" id="my-dataTable">
        <thead class="table-info">
            <tr>
                <th scope="col">Sr</th>
                <th scope="col">Subject Code</th>
                <th scope="col">Subject Name</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $subject_sql = "SELECT * FROM `subject`";
            $subject_result = $conn->query($subject_sql);
            $sno = 1;
            while ($subject_row = $subject_result->fetch_assoc()) {
            ?>
                <tr>
                    <th scope="row"><?= $sno++ ?></th>
                    <td> <?= $subject_row['subject_code'] ?> </td>
                    <td> <?= $subject_row['subject_name'] ?> </td>
                    <td> <?= $subject_row['created_at'] ?> </td>
                    <td>
                        <a class="btn btn-warning mx-1" href="index.php?edit_subject_id=<?= $subject_row['subject_id'] ?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger mx-1" href="index.php?delete_subject_id=<?= $subject_row['subject_id'] ?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php  }  ?>
        </tbody>
    </table>
</div>