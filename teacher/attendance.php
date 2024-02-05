<?php
// Delete Period
if (isset($_GET['delete_att_id'])) {
    $delete_att_id = $_GET['delete_att_id'];
    $delete_period_sql = "DELETE FROM `attendance` WHERE attendance_id = '$delete_att_id' ";
    if ($conn->query($delete_period_sql)) {
    ?>
        <script>
    $(document).ready(function() {
        Swal.fire({
            title: 'Good job!',
            text: 'Attendance Record has been Deleted Successfully!',
            icon: 'success'
        }).then(() => {
                window.location.href = 'index.php?attendance';
        });
    })

        </script>
    <?php
    } 
    else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Attendance Record has not been Deleted', 'error');
            });
        </script>
<?php
    }
}

?>


<div class="container-fluid my-5 row col-md-10 mx-auto">
    <div class="card shadow">
        <div class="card-header text-center bg-primary bg-gradient text-white">
            <h2 class="my-heading">ATTENDANCE RECORD</h2>
        </div>
        <nav class="navbar">
            <form method="post" class="d-flex justify-content-center">
                <div class="row">
                    <div class="col-md-4">
                        <label for="att_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date">
                    </div>

                    <div class="col-md-4">
                        <label for="att_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date">
                    </div>
                    <div class="col-md-4">
                    <label for="class_name" class="form-label">Class</label>
                        <select id="class_name" class="form-select col-md-12" name="class_name" required>
                            <option value="" selected disabled>Select Class</option>
                            <?php
                            $class_sql = "SELECT * FROM `class`";
                            $class_result = $conn->query($class_sql);
                            while ($class_row = $class_result->fetch_assoc()) {
                            ?>
                                <option value="<?= $class_row['class_id'] ?>"><?= $class_row['class_name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <button class="btn btn-success mx-2" id="class_btn" name="class_btn" type="submit">Select</button>
            </form>
        </nav>
        <div class="">
        <a href="index.php?add_attendance" class="float-end btn btn-outline-info mb-3"> <i class="fas fa-plus-square"> Add Attendance</i></a>
    </div>
        <div class="card-body">
            <table class="table text-center my-table" id="my-dataTable">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Class</th>
                        <th scope="col">Student</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['start_date']) && !empty($_POST['start_date']) && isset($_POST['end_date']) && !empty($_POST['end_date']) && isset($_POST['end_date']) && !empty($_POST['end_date']) && isset($_POST['class_name']) && !empty($_POST['class_name'])) {
                        $start_date = $_POST['start_date'];
                        $end_date = $_POST['end_date'];
                        $class_name = $_POST['class_name'];
                        $att_sql = "SELECT * FROM `attendance` WHERE a_class_id = $class_name AND attendance_date BETWEEN '$start_date' AND '$end_date'";
                        $att_result = $conn->query($att_sql);
                        $sno = 1;
                        if ($att_result->num_rows > 0) {
                            while ($att_row = $att_result->fetch_assoc()) {
                                $status = $att_row['attendance_status'];
                                $dateStr = $att_row['attendance_date'];
                                $convertedDate = date("d F Y", strtotime($dateStr));
                    ?>

                                <tr>
                                    <td><?= $sno++ ?></td>
                                    <td>
                                        <?php
                                        $attendance_class_id = $att_row['a_class_id'];
                                        $fetch_class_sql = "SELECT class_name FROM class WHERE class_id = '$attendance_class_id' ";
                                        $class_result = $conn->query($fetch_class_sql);
                                        $fetch_class_row = $class_result->fetch_assoc();
                                        echo $fetch_class_row['class_name'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $exam_student_id = $att_row['a_student_id'];
                                        $fetch_student_sql = "SELECT student_name FROM students WHERE student_id = '$exam_student_id' ";
                                        $student_result = $conn->query($fetch_student_sql);
                                        $fetch_student_row = $student_result->fetch_assoc();
                                        echo $fetch_student_row['student_name'];
                                        ?>
                                    </td>
                                    <td><?= $convertedDate ?></td>
                                    <?php if ($status === "Present") { ?>
                                        <td class="text-success"><?= $status ?></td>
                                    <?php  } else if ($status === "Absent") {    ?>
                                        <td class="text-danger"><?= $status ?></td>
                                    <?php  } else if ($status === "Leave") {    ?>
                                        <td class="text-warning"><?= $status ?></td>
                                    <?php  }  ?>
                                    <td>
                                        <a class="btn btn-warning mx-1" href="index.php?edit_att_id=<?= $att_row['attendance_id'] ?>"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-danger mx-1" href="index.php?delete_att_id=<?= $att_row['attendance_id'] ?>"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="8">No attendance found for this student</td>
                            </tr>
                            <?php
                        }
                    } else {
                        $att_sql = "SELECT * FROM `attendance`";
                        $att_result = $conn->query($att_sql);
                        $sno = 1;
                        if ($att_result->num_rows > 0) {
                            while ($att_row = $att_result->fetch_assoc()) {
                                $status = $att_row['attendance_status'];
                                $dateStr = $att_row['attendance_date'];
                                $convertedDate = date("d F Y", strtotime($dateStr));
                            ?>

                                <tr>
                                    <td><?= $sno++ ?></td>
                                    <td>
                                        <?php
                                        $attendance_class_id = $att_row['a_class_id'];
                                        $fetch_class_sql = "SELECT class_name FROM class WHERE class_id = '$attendance_class_id' ";
                                        $class_result = $conn->query($fetch_class_sql);
                                        $fetch_class_row = $class_result->fetch_assoc();
                                        echo $fetch_class_row['class_name'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $exam_student_id = $att_row['a_student_id'];
                                        $fetch_student_sql = "SELECT student_name FROM students WHERE student_id = '$exam_student_id' ";
                                        $student_result = $conn->query($fetch_student_sql);
                                        $fetch_student_row = $student_result->fetch_assoc();
                                        echo $fetch_student_row['student_name'];
                                        ?>
                                    </td>
                                    <td><?= $convertedDate ?></td>
                                    <?php if ($status === "Present") { ?>
                                        <td class="text-success"><?= $status ?></td>
                                    <?php  } else if ($status === "Absent") {    ?>
                                        <td class="text-danger"><?= $status ?></td>
                                    <?php  } else if ($status === "Leave") {    ?>
                                        <td class="text-warning"><?= $status ?></td>
                                    <?php  }  ?>
                                    <td>
                                        <a class="btn btn-warning mx-1" href="index.php?edit_att_id=<?= $att_row['attendance_id'] ?>"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-danger mx-1" href="index.php?delete_att_id=<?= $att_row['attendance_id'] ?>"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="8">No attendance found for this student</td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>