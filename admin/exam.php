<?php
// Delete Class
if (isset($_GET['delete_exam_id'])) {
    $delete_exam_id = $_GET['delete_exam_id'];
    $delete_exam_sql = "DELETE FROM `exam` WHERE exam_id = '$delete_exam_id' ";
    if ($conn->query($delete_exam_sql)) {
?>
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Exam has been Deleted Successfully!',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'index.php?exam';
                });
            })
        </script>
    <?php
    } else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Exam has not been Deleted', 'error');
            });
        </script>
<?php
    }
}

?>

<div class="row col-md-12 mx-auto my-5">
    <h1 class="text-center fs-1 bg-dark bg-gradient p-2 mt-3 my-heading">Exams</h1>
    <div>
    </div>
    <table class="table mb-5 text-center my-table" id="my-dataTable">
        <thead class="table-info">
            <tr>
                <th scope="col">Sr</th>
                <th scope="col">Teacher Name</th>
                <th scope="col">Student Name</th>
                <th scope="col">Class</th>
                <th scope="col">Subject</th>
                <th scope="col">Exam Name</th>
                <th scope="col">Exam Type</th>
                <th scope="col">Total Marks</th>
                <th scope="col">Obtained Marks</th>
                <th scope="col">Percentage</th>
                <th scope="col">Grade</th>
                <th scope="col">Passing Status</th>
                <th scope="col">Exam Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $exam_sql = "SELECT * FROM `exam`";
            $exam_result = $conn->query($exam_sql);
            $sno = 1;
            while ($exam_row = $exam_result->fetch_assoc()) {
            ?>
                <tr>
                    <th scope="row"><?= $sno++ ?></th>
                    <td>
                        <?php
                        $exam_teacher_id = $exam_row['e_teacher_id'];
                        $fetch_teacher_sql = "SELECT teacher_name,teacher_gender FROM teachers WHERE teacher_id = '$exam_teacher_id' ";
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
                        $exam_student_id = $exam_row['e_student_id'];
                        $fetch_student_sql = "SELECT student_name FROM students WHERE student_id = '$exam_student_id' ";
                        $student_result = $conn->query($fetch_student_sql);
                        $fetch_student_row = $student_result->fetch_assoc();
                        echo $fetch_student_row['student_name'];
                        ?>
                    </td>
                    <td>
                        <?php
                        $exam_class_id = $exam_row['e_class_id'];
                        $fetch_class_sql = "SELECT class_name FROM class WHERE class_id = '$exam_class_id' ";
                        $class_result = $conn->query($fetch_class_sql);
                        $fetch_class_row = $class_result->fetch_assoc();
                        echo $fetch_class_row['class_name'];
                        ?>
                    </td>
                    <td>
                        <?php
                        $exam_subject_id = $exam_row['e_subject_id'];
                        $fetch_subject_sql = "SELECT subject_name FROM `subject` WHERE subject_id = '$exam_subject_id' ";
                        $subject_result = $conn->query($fetch_subject_sql);
                        $fetch_subject_row = $subject_result->fetch_assoc();
                        echo $fetch_subject_row['subject_name'];
                        ?>
                    </td>
                    <td> <?= $exam_row['exam_name'] ?> </td>
                    <td> <?= $exam_row['exam_type'] ?> </td>
                    <td> <?= $exam_row['total_marks'] ?> </td>
                    <td> <?= $exam_row['obtained_marks'] ?> </td>
                    <?php

                    $total_marks = $exam_row['total_marks'];
                    $obtained_marks = $exam_row['obtained_marks'];
                    // Calculate the percentage
                    $percentage = ($total_marks > 0) ? (($obtained_marks / $total_marks) * 100) : 0;

                    // Calculate Grade
                    if ($percentage <= 100 && $percentage >= 90) {
                        $grade = 'A+';
                    } else if ($percentage < 90 && $percentage >= 80) {
                        $grade = 'A';
                    } else if ($percentage < 80 && $percentage >= 70) {
                        $grade = 'B+';
                    } else if ($percentage < 70 && $percentage >= 60) {
                        $grade = 'B';
                    } else if ($percentage < 60 && $percentage >= 50) {
                        $grade = 'C';
                    } else if ($percentage < 50 && $percentage >= 0) {
                        $grade = 'F';
                    } else {
                        $grade = 'N/A';
                    }


                    // Determine pass/fail status
                    $pass_fail_status = ($percentage >= 50) ? 'PASS' : 'FAIL';
                    ?>
                    <td><?= number_format($percentage, 2) . '%' ?></td>
                    <td><?= $grade ?></td>
                    <?php if($pass_fail_status === "PASS"){ ?>
                    <td class="bg-success bg-gradient"><?= $pass_fail_status ?></td>
                    <?php  } else if($pass_fail_status === "FAIL") {    ?>
                    <td class="bg-danger bg-gradient"><?= $pass_fail_status ?></td>
                     <?php  }  ?> 
                    <td> <?= $exam_row['exam_date'] ?> </td>
                </tr>
            <?php  }  ?>
        </tbody>
    </table>
</div>