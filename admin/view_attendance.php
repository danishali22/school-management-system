<div class="container-fluid my-5 row col-md-10 mx-auto">
    <div>
        <div class="text-center bg-dark p-2 bg-gradient text-white">
            <h1 class="my-heading mt-3">Attendance Record</h1>
        </div>
        <div class="card-body">
            <table class="table text-center my-table" id="my-dataTable">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Class</th>
                        <th scope="col">Teacher</th>
                        <th scope="col">Student</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
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
                                    $attendance_teacher_id = $att_row['a_teacher_id'];
                                    $fetch_teacher_sql = "SELECT teacher_name, teacher_gender FROM teachers WHERE teacher_id = '$attendance_teacher_id' ";
                                    $teacher_result = $conn->query($fetch_teacher_sql);
                                    $fetch_teacher_row = $teacher_result->fetch_assoc();
                                    $teacher_name = $fetch_teacher_row['teacher_name'];
                                    $teacher_gender = $fetch_teacher_row['teacher_gender'];
                                    $gender = ($teacher_gender === 'Male') ? 'Sir ' : (($teacher_gender === 'Female') ? 'Miss ' : '');
                                    echo $gender . $teacher_name;
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
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>