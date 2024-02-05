<?php
// Delete Class
if (isset($_GET['delete_teacher_id'])) {
    $delete_teacher_id = $_GET['delete_teacher_id'];
    $delete_teacher_sql = "DELETE FROM `teachers` WHERE teacher_id = '$delete_teacher_id' ";
    if ($conn->query($delete_teacher_sql)) {
    ?>
        <script>
    $(document).ready(function() {
        Swal.fire({
            title: 'Good job!',
            text: 'Teacher Record has been Deleted Successfully!',
            icon: 'success'
        }).then(() => {
                window.location.href = 'index.php?teacher';
        });
    })

        </script>
    <?php
    } 
    else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Teacher Record has not been Deleted', 'error');
            });
        </script>
<?php
    }
}
?>


<div class="row col-md-10 mx-auto my-5">
    <h1 class="text-center fs-1 bg-dark bg-gradient mt-3 p-2 my-heading">Teachers</h1>
    <div>
        <a href="index.php?add_teacher" class="btn btn-outline-info mb-3"> <i class="fas fa-plus-square"> Add Teacher</i></a>
    </div>
    <table class="table mb-5 text-center my-table" id="my-dataTable">
        <thead class="table-info">
            <tr>
                <th scope="col">Sr</th>
                <th scope="col">Name</th>
                <th scope="col">Subject</th>
                <th scope="col">Picture</th>
                <th scope="col">Account Verify</th>
                <th scope="col">View</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $teacher_sql = "SELECT * FROM `teachers`";
            $teacher_result = $conn->query($teacher_sql);
            $sno = 1;
            while ($teacher_row = $teacher_result->fetch_assoc()) {
            ?>
            
                <tr>
                    <th scope="row"><?= $sno++ ?></th>
                    <td> <?= $teacher_row['teacher_name'] ?> </td>
                    <td>
                        <?php
                        $timetable_subject_id = $teacher_row['teacher_subject'];
                        $fetch_subject_sql = "SELECT subject_name FROM `subject` WHERE subject_id = '$timetable_subject_id' ";
                        $subject_result = $conn->query($fetch_subject_sql);
                        $fetch_subject_row = $subject_result->fetch_assoc();
                        echo $fetch_subject_row['subject_name'];
                        ?>
                    </td>
                    <td>
                        <img src="admin_images/registration/<?= $teacher_row['teacher_pic'] ?>" alt="Teacher Image" height="70" width="80" class="img-fluid img-thumbnail">
                    </td>
                    <td> <?= $teacher_row['teacher_verify'] ?> </td>
                    <td>
                        <a class="btn btn-primary" href="index.php?view_teacher_id=<?= $teacher_row['teacher_id'] ?>"><i class="fa fa-eye"></i></a>
                    </td>
                    <td>
                        <a class="btn btn-warning mx-1" href="index.php?edit_teacher_id=<?= $teacher_row['teacher_id'] ?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger mx-1" href="index.php?delete_teacher_id=<?= $teacher_row['teacher_id'] ?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php  }  ?>
        </tbody>
    </table>