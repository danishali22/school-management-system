<div class="container-fluid mt-5">
    <div class="col-md-10 mx-auto">
        <h1 class="text-center my-3 my-heading" style="background-color: #4598c7; color: white;">Edit Exam</h1>
        <form method="post" enctype='multipart/form-data' id="examForm">
            <?php
            if (isset($_GET['edit_exam_id'])) {
                $edit_exam_id = $_GET['edit_exam_id'];
                $edit_sql = "SELECT * FROM `exam` WHERE exam_id = '$edit_exam_id'";
                $edit_result = $conn->query($edit_sql);
                $edit_row = $edit_result->fetch_assoc();
            ?>
                <div class="mb-3">
                    <label for="exam_name" class="form-label">Exam Name</label>
                    <input type="text" class="form-control" id="exam_name" name="exam_name" value="<?= $edit_row['exam_name'] ?>">
                </div>
                <div class="my-3">
                    <label for="gender" class="form-label">Exam Type &nbsp;&nbsp;&nbsp;</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" <?php if ($edit_row['exam_type'] == 'Test') { ?> checked <?php } ?> type="radio" name="exam_type" id="test" value="Test">
                        <label class="form-check-label" for="test">Test</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" <?php if ($edit_row['exam_type'] == 'Assignment') { ?> checked <?php } ?> type="radio" name="exam_type" id="assignment" value="Assignment">
                        <label class="form-check-label" for="assignment">Assignment</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" <?php if ($edit_row['exam_type'] == 'Mid') { ?> checked <?php } ?> type="radio" name="exam_type" id="mid" value="Mid">
                        <label class="form-check-label" for="mid">Mid Term</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" <?php if ($edit_row['exam_type'] == 'Final') { ?> checked <?php } ?> type="radio" name="exam_type" id="final" value="Final">
                        <label class="form-check-label" for="final">Final Term</label>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="total_marks" class="form-label">Total Marks</label>
                            <input type="text" class="form-control" id="total_marks" name="total_marks" value="<?= $edit_row['total_marks'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="obtained_marks" class="form-label">Obtained Marks</label>
                            <input type="text" class="form-control" id="obtained_marks" name="obtained_marks" value="<?= $edit_row['obtained_marks'] ?>">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="class_name" class="form-label">Select Class</label>
                        <select id="class_name" class="form-select" name="class_name" required>
                            <option value="" selected>Select Class</option>
                            <?php
                            $class_sql = "SELECT class_id, class_name FROM `class`";
                            $class_result = $conn->query($class_sql);
                            while ($class_row = $class_result->fetch_assoc()) {
                                $selected = ($class_row['class_id'] == $edit_row['e_class_id']) ? "selected" : "";
                            ?>
                                <option value="<?= $class_row['class_id'] ?>" <?= $selected ?>>
                                    <?= $class_row['class_name'] ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="student_name" class="form-label">Select Student</label>
                        <select id="student_name" class="form-select" name="student_name" required>
                            <option value="" selected>Select Student</option>
                            <?php
                            $student_sql = "SELECT student_id, student_name, student_class FROM `students`";
                            $student_result = $conn->query($student_sql);
                            while ($student_row = $student_result->fetch_assoc()) {
                                $selected = ($student_row['student_id'] == $edit_row['e_student_id']) ? "selected" : "";
                            ?>
                                <option value="<?= $student_row['student_id'] ?>" <?= $selected ?>>
                                    <?= $student_row['student_name'] ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="subject_name" class="form-label">Select Subject</label>
                        <select id="subject_name" class="form-select" name="subject_name" required>
                            <option value="" selected>Select Subject</option>
                            <?php
                            $subject_sql = "SELECT subject_id, subject_name FROM `subject`";
                            $subject_result = $conn->query($subject_sql);
                            while ($subject_row = $subject_result->fetch_assoc()) {
                                $selected = ($subject_row['subject_id'] == $edit_row['e_subject_id']) ? "selected" : "";
                            ?>
                                <option value="<?= $subject_row['subject_id'] ?>" <?= $selected ?>>
                                    <?= $subject_row['subject_name'] ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            <?php } ?>
            <div class="mt-2 text-center">
                <button type="submit" class="btn btn-primary" name="update_exam" id="update_exam">Update</button>
                <a href="index.php?exam" class="btn btn-danger">Back</a>
            </div>
        </form>
    </div>
</div>
<?php
if (isset($_POST['update_exam'])) {;
    $exam_name = $_POST['exam_name'];
    $exam_type = $_POST['exam_type'];
    $total_marks = $_POST['total_marks'];
    $obtained_marks = $_POST['obtained_marks'];
    $class_name = $_POST['class_name'];
    $student_name = $_POST['student_name'];
    $subject_name = $_POST['subject_name'];
    $teacher_id = $_SESSION['teacher_id'];

    // Validate input (e.g., check if numeric)
    if (!is_numeric($total_marks) || !is_numeric($obtained_marks)) {
?>
        <script>
            $(document).ready(function() {
                Swal.fire('Error!',
                    'Invalid input. Please enter numeric values for total marks and obtained marks.',
                    'error')
            });
        </script>;
    <?php
    }

    // Check if obtained marks are not greater than total marks
    if ($obtained_marks > $total_marks) {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Error!',
                    'Obtained marks cannot be greater than total marks.',
                    'error')
            });
        </script>;
        <?php
    } else {

        $update_sql = "UPDATE `exam` SET exam_name = '$exam_name', exam_type = '$exam_type', total_marks = '$total_marks', obtained_marks = '$obtained_marks', e_class_id = '$class_name', e_student_id = '$student_name', e_subject_id = '$subject_name', e_teacher_id = '$teacher_id', `exam_date` = CURRENT_TIME() WHERE exam_id = '$edit_exam_id' ";
        if ($conn->query($update_sql)) {
        ?>
            <script>
                $(document).ready(function() {
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Good job!',
                            text: 'Exam has been Updated Successfully!',
                            icon: 'success'
                        }).then(() => {
                            window.location.href = 'index.php?exam';
                        });
                    })
                });
            </script>
        <?php
        } else {
        ?>
            <script>
                $(document).ready(function() {
                    Swal.fire('Oops!', 'Exam has not been Updated', 'error');
                });
            </script>
<?php
        }
    }
}
?>


<script>
    $(document).ready(function() {
        $('#class_name').on('change', function() {
            var classSelect = $(this);
            var classId = classSelect.val();
            var studentSelect = $('#student_name');
            var subjectSelect = $('#subject_name');

            studentSelect.empty().append($('<option>', {
                value: '',
                text: 'Select Student'
            }));

            subjectSelect.empty().append($('<option>', {
                value: '',
                text: 'Select Subject'
            }));

            if (classId !== '') {
                // Make an AJAX request to fetch students for the selected class
                $.ajax({
                    url: 'get_students_by_class.php',
                    method: 'POST',
                    data: {
                        class_id: classId
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log('Received data from get_students_by_class.php:', data);

                        if (data.students.length > 0) {
                            $.each(data.students, function(index, student) {
                                studentSelect.append($('<option>', {
                                    value: student.student_id,
                                    text: student.student_name
                                }));
                            });
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.log('Error in get_students_by_class.php:', errorThrown);
                    }
                });

                // Make an AJAX request to fetch subject IDs for the selected class
                $.ajax({
                    url: 'get_subject_ids_by_class.php',
                    method: 'POST',
                    data: {
                        class_id: classId
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log('Received data from get_subject_ids_by_class.php:', data);

                        if (data.subject_name !== '') {
                            var subjectIds = data.subject_name.split(',');
                            console.log('Parsed subject IDs:', subjectIds);

                            // Make another AJAX request to fetch subject names
                            $.ajax({
                                url: 'get_student_subjects.php',
                                method: 'POST',
                                data: {
                                    subject_ids: subjectIds
                                },
                                dataType: 'json',
                                success: function(subjects) {
                                    console.log('Received data from get_student_subjects.php:', subjects);

                                    if (subjects.length > 0) {
                                        $.each(subjects, function(index, subject) {
                                            subjectSelect.append($('<option>', {
                                                value: subject.subject_id,
                                                text: subject.subject_name
                                            }));
                                        });
                                    }
                                },
                                error: function(xhr, textStatus, errorThrown) {
                                    console.log('Error in get_student_subjects.php:', errorThrown);
                                }
                            });
                        } else {
                            console.log('No subject IDs found in the data.');
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.log('Error in get_subject_ids_by_class.php:', errorThrown);
                    }
                });
            }
        });
    });
</script>

<script>
    document.getElementById("examForm").addEventListener("submit", function(event) {
        var examType = $("input[name='exam_type']:checked").val();
        var marks = document.getElementById("total_marks").value;
        if (examType == "Assignment" && marks != 15) {
                Swal.fire('Invalid Entry!', `Invalid marks entered for Assignment. Total Marks should be exactly 15.`, 'error');
                event.preventDefault();
        } else if (examType == "Test" && marks != 15) {
                Swal.fire('Invalid Entry!', `Invalid marks entered for Test. Total Marks should be exactly 15.`, 'error');
                event.preventDefault();
        } else if (examType == "Mid" && marks != 20) {
                Swal.fire('Invalid Entry!', `Invalid marks entered for Mid Term. Total Marks should be exactly 20.`, 'error');
                event.preventDefault();
        } else if (examType == "Final" && marks != 50) {
                Swal.fire('Invalid Entry!', `Invalid marks entered for Final Term. Total Marks should be exactly 50.`, 'error');
                event.preventDefault();
        }

    });
</script>