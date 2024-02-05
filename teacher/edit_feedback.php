<div class="row">
    <div class="col-md-8 mx-auto">
        <h1 class="text-center my-5 bg-primary bg-gradient p-2 my-heading">Edit Room</h1>
        <form method="post" enctype='multipart/form-data'>
            <?php
            if (isset($_GET['edit_feedback_id'])) {
                $edit_feedback_id = $_GET['edit_feedback_id'];
                $edit_sql = "SELECT * FROM `feedback` WHERE feedback_id = '$edit_feedback_id'";
                $edit_result = $conn->query($edit_sql);
                $edit_row = $edit_result->fetch_assoc();
            ?>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="class_name" class="form-label">Select Class</label>
                        <select id="class_name" class="form-select" name="class_name">
                            <option value="" selected>Select Class</option>
                            <?php
                            $fetch_class_sql = "SELECT * FROM class";
                            $class_result = $conn->query($fetch_class_sql);
                            while ($class_row = $class_result->fetch_assoc()) {
                            ?>
                                <option value="<?= $class_row['class_id'] ?>" <?php if ($edit_row['f_class_id'] == $class_row['class_id']) { ?> selected <?php } ?>> <?php echo $class_row['class_name'] ?></option>

                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                    <label for="student_name" class="form-label">Select Student</label>
                        <select id="student_name" class="form-select" name="student_name" required>
                            <option value="" selected>Select Student</option>
                            <?php
                            $student_sql = "SELECT student_id, student_name, student_class FROM `students`";
                            $student_result = $conn->query($student_sql);
                            while ($student_row = $student_result->fetch_assoc()) {
                                $selected = ($student_row['student_id'] == $edit_row['f_student_id']) ? "selected" : "";
                            ?>
                                <option value="<?= $student_row['student_id'] ?>" <?= $selected ?>>
                                    <?= $student_row['student_name'] ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="feedback" class="form-label">Description</label>
                        <textarea type="text" class="form-control" id="feedback" name="feedback"> <?= $edit_row['remarks'] ?></textarea>
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" class="form-select" name="status" required>
                            <option value="">Select Status</option>
                            <option value="Positive" <?php if ($edit_row['status'] == 'Positive') { ?> selected <?php } ?> >Positive</option>
                            <option value="Negative" <?php if ($edit_row['status'] == 'Negative') { ?> selected <?php } ?>> Negative</option>
                        </select>
                    </div>
                </div>
            <?php } ?>
            <div class="mt-2 text-center">
                <button type="submit" class="btn btn-primary" name="update_feedback" id="update_feedback">Update</button>
                <a href="index.php?feedback" class="btn btn-danger">Back</a>
            </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['update_feedback'])) {;
    $class = $_POST['class_name'];
    $student = $_POST['student_name'];
    $feedback = $_POST['feedback'];
    $status = $_POST['status'];
    $update_sql = "UPDATE `feedback` SET `f_class_id` = '$class', `f_student_id` = '$student', `remarks` = '$feedback', `status` = '$status' WHERE feedback_id = '$edit_feedback_id' ";
    if ($conn->query($update_sql)) {
?>
        <script>
            $(document).ready(function() {
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Good job!',
                        text: 'Feedback has been Updated Successfully!',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'index.php?feedback';
                    });
                })
            });
        </script>
    <?php
    } else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Feedback has not been Updated', 'error');
            });
        </script>
<?php
    }
}
?>

<script>
    $(document).ready(function() {
        $('#class_name').on('change', function() {
            var classSelect = $(this);
            var classId = classSelect.val();
            var studentSelect = $('#student_name');

            studentSelect.empty().append($('<option>', {
                value: '',
                text: 'Select Student'
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
            }
        });
    });
</script>