<div class="row col-md-10 mx-auto mt-5">
    <h1 class="text-center fs-1 bg-dark bg-gradient p-2 my-heading">Feeedbacks</h1>
    <table class="table mb-5 text-center my-table" id="my-dataTable">
        <thead class="table-info">
            <tr>
                <th scope="col">Sr</th>
                <th scope="col">Teacher Name</th>
                <th scope="col">Class</th>
                <th scope="col">Student Name</th>
                <th scope="col">Feedback</th>
                <th scope="col">Status</th>
                <th scope="col">Created At</th>
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
                        $attendance_teacher_id = $feedback_row['f_teacher_id'];
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