<div class="row col-md-10 mx-auto mt-5">
    <h1 class="text-center fs-1 my-heading bg-primary bg-gradient p-2">Attendance</h1>
    <div class="row mb-3">
        <nav class="navbar">
            <form method="post" class="d-flex" id="class_form">
                <!-- <label for="room_class" class="form-label">Select Class</label> -->
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
                    <option value="All"> All </option>
                </select>
                <button class="btn btn-success mx-2" id="class_btn" name="class_btn" type="submit">Select</button>
            </form>
        </nav>
    </div>
    <table class="table mb-5 text-center my-table" id="my-dataTable">
        <thead class="table-info">
            <tr>
                <th scope="col">Sr</th>
                <th scope="col">Student Name</th>
                <th scope="col">Roll No</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_POST['class_btn'])) {
                $class_btn = $_POST['class_name'];
                $sno = 1;
                if ($class_btn === "All") {
                    $student_sql = "SELECT * FROM `students`";
                } else {
                    $student_sql = "SELECT * FROM `students` WHERE student_class = '$class_btn'";
                }
                $student_result = $conn->query($student_sql);

                if ($student_result->num_rows > 0) {
                    while ($student_row = $student_result->fetch_assoc()) {
            ?>

                        <tr>
                            <th scope="row"><?= $sno++ ?></th>
                            <td> <?= $student_row['student_name'] ?></td>
                            <td> <?= $student_row['student_rollno'] ?></td>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="Present" name="attendance_status[<?= $student_row['student_id'] ?>]" data-student-id="<?= $student_row['student_id'] ?>">
                                    <label class="form-check-label" for="present">Present</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="Absent" name="attendance_status[<?= $student_row['student_id'] ?>]" data-student-id="<?= $student_row['student_id'] ?>">
                                    <label class="form-check-label" for="absent">Absent</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="Leave" name="attendance_status[<?= $student_row['student_id'] ?>]" data-student-id="<?= $student_row['student_id'] ?>">
                                    <label class="form-check-label" for="leave">Leave</label>
                                </div>
                            </td>
                            <?php
                            $class = $student_row['student_class'];
                            $class_sql = "SELECT * FROM `class` WHERE class_id = '$class'";
                            $class_result = $conn->query($class_sql);
                            if ($class_result->num_rows > 0) {
                                while ($class_row = $class_result->fetch_assoc()) {
                            ?>
                                    <input type="hidden" id="hid_class_id" name="hid_class_id" value="<?= $class_row['class_id'] ?>">
                            <?php

                                }
                            }
                            ?>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="3" class="bg-danger bg-gradient"><?= "No students found in the selected class." ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
    <div class="mt-2 text-center">
        <button type="submit" class="btn btn-primary" name="submit_attendance" id="submit_attendance">Submit</button>
        <button type="reset" class="btn btn-warning">Reset</button>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#submit_attendance').click(function() {
            var studentAttendance = {};

            // Select all the radio buttons for attendance status
            var radioInputs = $('input[type="radio"]:checked');

            // Get the teacher_id from the session (make sure the session is started)
            var teacher_id = <?= $_SESSION['teacher_id'] ?>;

            // Get the class_id from the selected option in the select field
            var class_id = $('#hid_class_id').val();

            // Loop through the selected radio buttons and store the student ID and attendance status
            radioInputs.each(function() {
                var studentID = $(this).data('student-id');
                var attendanceStatus = $(this).val();
                studentAttendance[studentID] = attendanceStatus;
            });

            // Send the attendance data to the server using jQuery AJAX
            $.ajax({
                type: 'POST',
                url: 'handle_attendance.php',
                data: {
                    studentAttendance: studentAttendance,
                    teacher_id: teacher_id,
                    class_id: class_id,
                },
                success: function(data) {
                    if (data == 'success') {
                        Swal.fire('Good job!', 'Attendance has been Submitted!', 'success');
                        $('input[type="radio"]:checked').prop('checked', false);
                        // location.reload();
                    } else {
                        Swal.fire('Error!', 'Attendance has not been Submitted!', 'error');
                    }
                },
                error: function(error) {
                    console.error('There was a problem with the AJAX request:', error);
                }
            });
        });
    });
</script>