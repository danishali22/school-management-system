<div class="container-fluid my-5 row col-md-10 mx-auto">
    <div class="card shadow">
        <div class="card-header text-center bg-primary bg-gradient text-white">
            <h2 class="my-heading">ATTENDANCE RECORD</h2>
        </div>
        <nav class="navbar">
            <form method="post" class="">
                <div class="row">
                    <div class="col-md-5">
                        <label for="att_date" class="form-label">Select Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date">
                    </div>

                    <div class="col-md-5">
                        <label for="att_date" class="form-label">Select End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date">
                    </div>
                    <div class="col-md-2">
                        <br>
                        <button class="btn btn-success" id="date_filter" name="date_filer" type="submit">Date</button>
                    </div>
                </div>
            </form>
        </nav>
        <div class="card-body">
            <table class="table text-center my-table" id="my-dataTable">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $student_id = $_SESSION['student_id'];
                    $student_class = $_SESSION['student_class'];
                    if (isset($_POST['start_date']) && !empty($_POST['start_date']) && isset($_POST['end_date']) && !empty($_POST['end_date'])) {
                        // Date range filter is set
                        $start_date = $_POST['start_date'];
                        $end_date = $_POST['end_date'];
                        $att_sql = "SELECT * FROM `attendance` WHERE a_class_id = $student_class AND a_student_id = $student_id AND attendance_date BETWEEN '$start_date' AND '$end_date'";
                        // echo $att_sql;
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
                                    <td><?= $convertedDate ?></td>
                                    <?php if ($status === "Present") { ?>
                                        <td class="text-success"><?= $status ?></td>
                                    <?php  } else if ($status === "Absent") {    ?>
                                        <td class="text-danger"><?= $status ?></td>
                                    <?php  } else if ($status === "Leave") {    ?>
                                        <td class="text-warning"><?= $status ?></td>
                                    <?php  }  ?>
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
                        $att_sql = "SELECT * FROM `attendance` WHERE a_class_id = $student_class AND a_student_id = $student_id";
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
                                    <td><?= $convertedDate ?></td>
                                    <?php if ($status === "Present") { ?>
                                        <td class="text-success"><?= $status ?></td>
                                    <?php  } else if ($status === "Absent") {    ?>
                                        <td class="text-danger"><?= $status ?></td>
                                    <?php  } else if ($status === "Leave") {    ?>
                                        <td class="text-warning"><?= $status ?></td>
                                    <?php  }  ?>
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