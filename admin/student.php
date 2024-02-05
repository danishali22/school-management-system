<?php
// Delete Class
if (isset($_GET['delete_student_id'])) {
    $delete_student_id = $_GET['delete_student_id'];
    $delete_student_sql = "DELETE FROM `students` WHERE student_id = '$delete_student_id' ";
    if ($conn->query($delete_student_sql)) {
    ?>
        <script>
    $(document).ready(function() {
        Swal.fire({
            title: 'Good job!',
            text: 'Student Record has been Deleted Successfully!',
            icon: 'success'
        }).then(() => {
                window.location.href = 'index.php?student';
        });
    })

        </script>
    <?php
    } 
    else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Student Record has not been Deleted', 'error');
            });
        </script>
<?php
    }
}
?>

<!-- Modal -->
<div class="modal fade" id="openModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Students Full Detail</h1>
      </div>
      <div class="modal-body">
      <?php
      if (isset($_GET['view_student_id'])) {
        $view_student_id = $_GET['view_student_id'];
        $view_sql = "SELECT * FROM `students` WHERE student_id = '$view_student_id'";
        $view_result = $conn->query($view_sql);
        if(!$view_result){
            echo "Error. $conn->error;";
        } else{
        $student_row1 = $view_result->fetch_assoc();
      ?>
        <div class="row mb-2">
            <div class="col-md-4 fw-bold">
                Name
            </div>
            <div class="col-md-8">
            <?= $student_row1['student_name'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4 fw-bold">
                Email
            </div>
            <div class="col-md-8">
            <?= $student_row1['student_email'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4 fw-bold">
                Password
            </div>
            <div class="col-md-8">
            <?= $student_row1['student_password'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4 fw-bold">
                Roll no
            </div>
            <div class="col-md-8">
            <?= $student_row1['student_rollno'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4 fw-bold">
                Class
            </div>
            <div class="col-md-8">
            <?= $student_row1['student_class'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4 fw-bold">
                Phone
            </div>
            <div class="col-md-8">
            <?= $student_row1['student_phone'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4 fw-bold">
                Address
            </div>
            <div class="col-md-8">
            <?= $student_row1['student_address'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4 fw-bold">
                DOB
            </div>
            <div class="col-md-8">
            <?= $student_row1['student_dob'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4 fw-bold">
                Age
            </div>
            <div class="col-md-8">
            <?= $student_row1['student_age'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4 fw-bold">
                Gender
            </div>
            <div class="col-md-8">
            <?= $student_row1['student_gender'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4 fw-bold">
                Father's Name
            </div>
            <div class="col-md-8">
            <?= $student_row1['father_name'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4 fw-bold">
                Father's Phone
            </div>
            <div class="col-md-8">
            <?= $student_row1['father_phone'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4 fw-bold">
                Father's Ocuupation
            </div>
            <div class="col-md-8">
            <?= $student_row1['father_occ'] ?>
            </div>
        </div>
        <?php  } } else{
            echo "view_student_id is not get";
        } ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
</div>

<div class="row col-md-10 mx-auto mt-5">
    <h1 class="text-center fs-1 bg-dark bg-gradient mt-3 p-2 my-heading">Students</h1>
    <div>
        <a href="index.php?add_student" class="btn btn-outline-info mb-3"> <i class="fas fa-plus-square"> Add Student</i></a>
    </div>
    <table class="table text-center my-table" id="my-dataTable">
        <thead class="table-info">
            <tr>
                <th scope="col">Sr</th>
                <th scope="col">Name</th>
                <th scope="col">Rollno</th>
                <th scope="col">Class</th>
                <th scope="col">Section</th>
                <th scope="col">Picture</th>
                <th scope="col">Account Verify</th>
                <th scope="col">View</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $student_sql = "SELECT * FROM `students`";
            $student_result = $conn->query($student_sql);
            $sno = 1;
            while ($student_row = $student_result->fetch_assoc()) {
            ?>
            
                <tr class="mt-3">
                    <th scope="row"><?= $sno++ ?></th>
                    <td> <?= $student_row['student_name'] ?> </td>
                    <td> <?= $student_row['student_rollno'] ?> </td>
                    <td>
                        <?php
                            $student_class_id = $student_row['student_class'];
                            $fetch_class_sql = "SELECT class_name FROM class WHERE class_id = '$student_class_id' ";
                            $class_result = $conn->query($fetch_class_sql);
                            $fetch_class_row = $class_result->fetch_assoc();
                            echo $fetch_class_row['class_name'];
                        ?>
                    </td>
                    <td>
                        <?php
                            $student_section_id = $student_row['student_section'];
                            $fetch_section_sql = "SELECT section_title FROM section WHERE section_id = '$student_section_id' ";
                            $section_result = $conn->query($fetch_section_sql);
                            $fetch_section_row = $section_result->fetch_assoc();
                            echo $fetch_section_row['section_title'];
                        ?>
                    </td>
                    <td>
                        <img src="admin_images/registration/<?= $student_row['student_pic'] ?>" alt="<?= $student_row['student_name'] ?> Image" class="img-fluid img-thumbnail" style="height: 70px;">
                    </td>
                     <?php  if($student_row['student_verify'] == "Active"){   ?> 
                            <td> <a href=""><span class="btn btn-success btn-gradient p-2"><?= $student_row['student_verify'] ?></span></a></td>
                            <?php } else if($student_row['student_verify'] == "Disable"){ ?>
                            <td><a href=""><span class="btn btn-danger btn-gradient p-2"><?= $student_row['student_verify'] ?></span></a></td>
                            <?php } ?>
                    <td>
                            <a class="btn btn-primary" href="index.php?view_student_id=<?= $student_row['student_id'] ?>"><i class="fa fa-eye"></i></a>
                            <!-- data-bs-target="#openModal" data-bs-toggle="modal" -->
                    </td>
                    <td>
                        <div></div>
                        <a class="btn btn-warning mx-1" href="index.php?edit_student_id=<?= $student_row['student_id'] ?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger mx-1" href="index.php?delete_student_id=<?= $student_row['student_id'] ?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php  }  ?>
        </tbody>
    </table>
</div>