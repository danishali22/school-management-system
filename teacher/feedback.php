<?php
// Insert Feedback
if (isset($_POST['create_feedback'])) {
    $class = $_POST['class_name'];
    $teacher = $_SESSION['teacher_id'];
    $student = $_POST['student_name'];
    $feedback = $_POST['feedback'];
    $insert_feedback_sql = "INSERT INTO `feedback` (`f_class_id`, `f_teacher_id`, `f_student_id`, `remarks`, `created_at`)
    VALUES ('$class', '$teacher', '$student', '$feedback', current_timestamp())";
    // echo $insert_feedback_sql;
    // exit;
    if ($conn->query($insert_feedback_sql)) {
?>
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Feedback has been Added Successfully!',
                    icon: 'success'
                })
            });
        </script>
    <?php
    } else {

    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Error!',
                    'Feedback has not been Added!', 'error')
            });
        </script>
    <?php
    }
}


// Delete Feedback
if (isset($_GET['delete_feedback_id'])) {
    $delete_feedback_id = $_GET['delete_feedback_id'];
    $delete_feedback_sql = "DELETE FROM `feedback` WHERE feedback_id = '$delete_feedback_id' ";
    if ($conn->query($delete_feedback_sql)) {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Feedback has been Deleted Successfully!',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'index.php?feedback';
                });
            })
        </script>
    <?php
    } else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Feedback has not been Deleted', 'error');
            });
        </script>
<?php
    }
}

?>
<!-- Add Feedback  -->
<div class="container-fluid my-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <h1 class="text-center my-3 my-heading bg-primary bg-gradient p-2">Create New Feedback</h1>
            <form method="post" enctype='multipart/form-data'>
                <div class="row mb-3">
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                        <label for="student_name" class="form-label">Select Student</label>
                        <select id="student_name" class="form-select" name="student_name" required>
                            <option value="" selected>Select Student</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="feedback" class="form-label">Feedback</label>
                            <textarea type="text" class="form-control" id="feedback" name="feedback" required="" placeholder="Give Feedback"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="feedback" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option selected>Select Status</option>
                            <option value="Positive">Positive</option>
                            <option value="Negative">Negative</option>
                        </select>
                    </div>
                </div>
                <div class="mt-2 text-center">
                    <button type="submit" class="btn btn-primary" name="create_feedback" id="create_feedback">Create</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                </div>
                </h6>
            </form>
        </div>
    </div>
</div>

<!-- View Feedback -->
<div class="row col-md-10 mx-auto mt-5">
    <h1 class="text-center fs-1 bg-primary bg-gradient p-2 my-heading">Feeedbacks</h1>
    <table class="table mb-5 text-center my-table" id="my-dataTable">
        <thead class="table-info">
            <tr>
                <th scope="col">Sr</th>
                <th scope="col">Class</th>
                <th scope="col">Student Name</th>
                <th scope="col">Feedback</th>
                <th scope="col">Status</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $feedback_sql = "SELECT * FROM `feedback`";
            $feedback_result = $conn->query($feedback_sql);
            $sno = 1;
            while ($feedback_row = $feedback_result->fetch_assoc()) {
            ?>
                <tr>
                    <th scope="row"><?= $sno++ ?></th>
                    <td>
                        <?php
                        $class_id = $feedback_row['f_class_id'];
                        $fetch_class_sql = "SELECT class_name FROM class WHERE class_id = '$class_id' ";
                        $class_result = $conn->query($fetch_class_sql);
                        $fetch_class_row = $class_result->fetch_assoc();
                        echo $fetch_class_row['class_name'];
                        ?>
                    </td>
                    <td>
                        <?php
                        $feedback_student_id = $feedback_row['f_student_id'];
                        $fetch_student_sql = "SELECT student_name FROM students WHERE student_id = '$feedback_student_id' ";
                        $student_result = $conn->query($fetch_student_sql);
                        $fetch_student_row = $student_result->fetch_assoc();
                        echo $fetch_student_row['student_name'];
                        ?>
                    </td>
                    <td> <?= $feedback_row['remarks'] ?> </td>
                    <?php if($feedback_row['status'] === "Positive"){ ?>
                    <td class="bg-success bg-gradient"><?= $feedback_row['status'] ?></td>
                    <?php  } else if($feedback_row['status'] === "Negative") {    ?>
                    <td class="bg-danger bg-gradient"><?= $feedback_row['status'] ?></td>
                     <?php  }  ?> 
                    <td> <?= $feedback_row['created_at'] ?> </td>
                    <td>
                        <a class="btn btn-warning mx-1" href="index.php?edit_feedback_id=<?= $feedback_row['feedback_id'] ?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger mx-1" href="index.php?delete_feedback_id=<?= $feedback_row['feedback_id'] ?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php  }  ?>
        </tbody>
    </table>
</div>

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