<?php
// Insert Class
if (isset($_POST['create_exam'])) {
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
        $check_sql = "SELECT * FROM `exam` WHERE `exam_type` = '$exam_type' AND `e_subject_id` = '$subject_name' AND `e_student_id` = '$student_name' AND `e_teacher_id` = '$teacher_id'";

        $result = $conn->query($check_sql);

        if ($result->num_rows > 0) {
            // Display an error message for duplicate entry
            ?>
            <script>
                $(document).ready(function() {
                    Swal.fire('Duplicate entry!',
                        'The exam record already exists for this student, subject, and exam type.',
                        'error')
                });
            </script>;
            <?php
        } else {
        $insert_exam_sql = "INSERT INTO `exam` (`exam_name`, `exam_type`, `total_marks`, `obtained_marks`, `e_class_id`, `e_student_id`, `e_subject_id`, `e_teacher_id`, `exam_date`) VALUES ('$exam_name', '$exam_type', '$total_marks', '$obtained_marks', '$class_name', '$student_name', '$subject_name', '$teacher_id', current_timestamp());";
        if ($conn->query($insert_exam_sql)) {

        ?>
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Good job!',
                        text: 'Exam has been Added Successfully!',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'index.php?exam';
                    });
                });
            </script>
        <?php
        } else {
        ?>
            <script>
                $(document).ready(function() {
                    Swal.fire('Error!',
                        'Exam has not been Inserted!',
                        'error')
                });
            </script>;
<?php
        }
    }
    }
}
?>
<div class="container-fluid my-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <h1 class="text-center my-3 my-heading" style="background-color: #4598c7; color: white;">Create New Exam</h1>
            <form method="post" enctype='multipart/form-data' id="examForm">
                <div class="my-3">
                    <label for="exam_name" class="form-label">Exam Name</label>
                    <input type="text" class="form-control" id="exam_name" name="exam_name" required="" placeholder="Exam Name">
                </div>
                <div class="mb-3">
                    <label for="exam_type" class="form-label">Exam Type &nbsp;&nbsp;&nbsp;</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input exam_type" type="radio" id="test" value="Test" name="exam_type" required>
                        <label class="form-check-label" for="test">Test</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input exam_type" type="radio" id="assignment" value="Assignment" name="exam_type" required>
                        <label class="form-check-label" for="assignment">Assignment</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input exam_type" type="radio" id="mid" value="Mid" name="exam_type" required>
                        <label class="form-check-label" for="mid">Mid Term</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input exam_type" type="radio" id="final" value="Final" name="exam_type" required>
                        <label class="form-check-label" for="final">Final Term</label>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="total_marks" class="form-label">Total Marks</label>
                        <input type="number" class="form-control" id="total_marks" name="total_marks" required="" placeholder="Total Title" min=0>
                    </div>
                    <div class="col-md-6">
                        <label for="obtained_marks" class="form-label">Obtained Marks</label>
                        <input type="number" class="form-control" id="obtained_marks" name="obtained_marks" required="" placeholder="Obtained Title" min=0>
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
                            ?>
                                <option value="<?= $class_row['class_id'] ?>"><?= $class_row['class_name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="student_name" class="form-label">Select Student</label>
                        <select id="student_name" class="form-select" name="student_name" required>
                            <option value="" selected>Select Student</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="subject_name" class="form-label">Select Subject</label>
                        <select id="subject_name" class="form-select" name="subject_name" required>
                            <option value="" selected>Select Subject</option>
                        </select>
                    </div>
                </div>
                <div class="mt-2 text-center">
                    <button type="submit" class="btn btn-primary" name="create_exam" id="create_exam" on>Create</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                </div>
                <h6 class="mt-3">If you don't create Exam? <a href="index.php?exam" class="btn btn-danger">Go Back</a>
                </h6>
            </form>
        </div>
    </div>
</div>

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
    $(document).ready(function() {
    // Event listener for exam type radio buttons
    $("input[name='exam_type']").change(function() {
        var examType = $(this).val();
        var totalMarksInput = $("#total_marks");

        // Set the total marks based on the selected exam type
        if (examType === "Assignment") {
            totalMarksInput.val(15);
        } else if (examType === "Test") {
            totalMarksInput.val(15);
        } else if (examType === "Mid") {
            totalMarksInput.val(20);
        } else if (examType === "Final") {
            totalMarksInput.val(50);
        }
        // Make the total marks field read-only
        totalMarksInput.prop("readonly", true);
    });
});

</script>

<!-- <script>
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

    }); -->
</script>