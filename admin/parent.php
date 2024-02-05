<?php
// Delete Class
if (isset($_GET['delete_parent_id'])) {
    $delete_parent_id = $_GET['delete_parent_id'];
    $delete_parent_sql = "DELETE FROM `parent` WHERE parent_id = '$delete_parent_id' ";
    if ($conn->query($delete_parent_sql)) {
    ?>
        <script>
    $(document).ready(function() {
        Swal.fire({
            title: 'Good job!',
            text: 'Parent Record has been Deleted Successfully!',
            icon: 'success'
        }).then(() => {
                window.location.href = 'index.php?parent';
        });
    })

        </script>
    <?php
    } 
    else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Parent Record has not been Deleted', 'error');
            });
        </script>
<?php
    }
}
?>


<div class="row col-md-10 mx-auto my-5">
    <h1 class="text-center fs-1 bg-dark bg-gradient mt-3 p-2 my-heading">Parents</h1>
    <div>
        <a href="index.php?add_parent" class="btn btn-outline-info mb-3"> <i class="fas fa-plus-square"> Add Parent</i></a>
    </div>
    <table class="table mb-5 text-center my-table" id="my-dataTable">
        <thead class="table-info">
            <tr>
                <th scope="col">Sr</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Kids</th>
                <th scope="col">CNIC</th>
                <th scope="col">Picture</th>
                <th scope="col">Account Verify</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $parent_sql = "SELECT * FROM `parent`";
            $parent_result = $conn->query($parent_sql);
            $sno = 1;
            while ($parent_row = $parent_result->fetch_assoc()) {
            ?>
                <tr>
                    <th scope="row"><?= $sno++ ?></th>
                    <td> <?= $parent_row['parent_name'] ?> </td>
                    <td> <?= $parent_row['parent_email'] ?> </td>
                    <td>
                        <?php
                        $kids = explode(',', $parent_row['kids']);
                        foreach ($kids as $kid) {
                            $fetch_student_sql = "SELECT `student_name` FROM `students` WHERE student_id = '$kid'";
                            $fetch_student_result = $conn->query($fetch_student_sql);
                            $fetch_student_row = $fetch_student_result->fetch_assoc();
                            echo $fetch_student_row['student_name'] . "<br>";
                        }
                        ?>
                    </td>
                    <td> <?= $parent_row['cnic'] ?> </td>
                    <td>
                        <img src="admin_images/registration/<?= $parent_row['parent_pic'] ?>" alt="parent Image" height="70" width="80" class="img-fluid img-thumbnail">
                    </td>
                    <td> <?= $parent_row['parent_verify'] ?> </td>
                    <td>
                        <a class="btn btn-warning mx-1" href="index.php?edit_parent_id=<?= $parent_row['parent_id'] ?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger mx-1" href="index.php?delete_parent_id=<?= $parent_row['parent_id'] ?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php  }  ?>
        </tbody>
    </table>