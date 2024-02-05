<?php 
    $title = 'Student Result'; 
    require_once('partials/student_head.php');
?>
<div class="container-fluid my-5">
    <div class="card shadow">
        <div class="card-header text-center bg-primary bg-gradient text-white">
            <h2 class="my-heading">RESULT CARD</h2>
        </div>
        <div class="card-body">
            <table class="table text-center my-table" id="my-dataTable">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Subjects</th>
                        <th scope="col">Assignment</th>
                        <th scope="col">Test</th>
                        <th scope="col">Mid</th>
                        <th scope="col">Final</th>
                        <th scope="col">Total</th>
                        <th scope="col">Percentage</th>
                        <th scope="col">Grade</th>
                        <th scope="col">Passing Status</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    // Retrieve the student's class from the session variable
    $student_class = $_SESSION['student_class'];

    // Fetch the subject names associated with the student's class
    $class_subjects_sql = "SELECT subject_name FROM class WHERE class_id = '$student_class'";
    $class_subjects_result = $conn->query($class_subjects_sql);

    if ($class_subjects_result->num_rows > 0) {
        $row = $class_subjects_result->fetch_assoc();
        $subject_ids = explode(',', $row['subject_name']);

        // Fetch exam marks for each subject
        foreach ($subject_ids as $subject_id) {
            // Trim and sanitize the subject_id
            $subject_id = trim($subject_id);

            // Fetch the subject name based on the subject_id
            $subject_name_sql = "SELECT subject_name FROM `subject` WHERE subject_id = '$subject_id'";
            $subject_name_result = $conn->query($subject_name_sql);

            // Pick Student Id from Session
            $student_id = $_SESSION['student_id'];

            if ($subject_name_result->num_rows > 0) {
                $subject_row = $subject_name_result->fetch_assoc();
                $subject_name = $subject_row['subject_name'];

                // Construct the SQL query to retrieve exam marks
                $exam_marks_sql = "SELECT exam_type, obtained_marks FROM exam WHERE e_student_id = '$student_id' AND e_subject_id = '$subject_id'";
                $exam_marks_result = $conn->query($exam_marks_sql);

                // Initialize variables for marks
                $assignment_marks = '-';
                $test_marks = '-';
                $mid_marks = '-';
                $final_marks = '-';

                // Fetch and update marks if they exist
                while ($exam_marks_row = $exam_marks_result->fetch_assoc()) {
                    $exam_type = $exam_marks_row['exam_type'];
                    $obtained_marks = $exam_marks_row['obtained_marks'];

                    switch ($exam_type) {
                        case 'Assignment':
                            $assignment_marks = $obtained_marks;
                            break;
                        case 'Test':
                            $test_marks = $obtained_marks;
                            break;
                        case 'Mid':
                            $mid_marks = $obtained_marks;
                            break;
                        case 'Final':
                            $final_marks = $obtained_marks;
                            break;
                    }
                }

                // Calculate the total marks
                $total_marks = ($assignment_marks != '-' ? $assignment_marks : 0) +
                              ($test_marks != '-' ? $test_marks : 0) +
                              ($mid_marks != '-' ? $mid_marks : 0) +
                              ($final_marks != '-' ? $final_marks : 0);

                // Calculate the percentage
                $percentage = ($total_marks > 0) ? (($total_marks /100) * 100) : 0;

                // Calculate Grade
                if($percentage < 100 && $percentage >= 90 ){
                    $grade = 'A+';
                } else if($percentage < 90 && $percentage >= 80 ){
                    $grade = 'A';
                }  else if($percentage < 80 && $percentage >= 70 ){
                    $grade = 'B+';
                } else if($percentage < 70 && $percentage >= 60 ){
                    $grade = 'B';
                } else if($percentage < 60 && $percentage >= 50 ){
                    $grade = 'C';
                } else if($percentage < 50 && $percentage >= 0 ){
                    $grade = 'F';
                } else{
                    $grade = 'N/A';
                }


                // Determine pass/fail status
                $pass_fail_status = ($percentage >= 50) ? 'PASS' : 'FAIL';
    ?>
                <tr>
                    <td><?= $subject_name ?></td>
                    <td><?= $assignment_marks ?></td>
                    <td><?= $test_marks ?></td>
                    <td><?= $mid_marks ?></td>
                    <td><?= $final_marks ?></td>
                    <td><?= $total_marks ?></td>
                    <td><?= number_format($percentage, 2) . '%' ?></td>
                    <td><?= $grade ?></td>
                    <?php if($pass_fail_status === "PASS"){ ?>
                    <td class="bg-success bg-gradient"><?= $pass_fail_status ?></td>
                    <?php  } else if($pass_fail_status === "FAIL") {    ?>
                    <td class="bg-danger bg-gradient"><?= $pass_fail_status ?></td>
                     <?php  }  ?> 
                </tr>
    <?php
            }
        }
    } else {
    ?>
        <tr>
            <td colspan="8">No result found for this student</td>
        </tr>
    <?php
    }
    ?>
</tbody>


            </table>
        </div>
    </div>
</div>

<?php
// Pick Student Id my SESSION
// $studet_id = $_SESSION['student_id'];

// // Pick Subject Id by Subject Name
// $search_sql = "SELECT * FROM `subject` WHERE subject_name = '$subject_name'";
// $search_result = $conn->query($search_sql);
// $search_row = $search_result->fetch_assoc();
// $sub_id = $search_row['subject_id'];

// // Now Selectin the base of Exam Type and Subject Name
// $assignment_sql = "SELECT * FROM `exam` WHERE exam_type = 'Assignment' AND e_subject_id = '$sub_id' AND e_student_id = '$studet_id'";
// $assignment_result = $conn->query($assignment_sql);
// while ($assignment_row = $assignment_result->fetch_assoc()) {
//     echo $assignment_row['obtained_marks'];
// }
?>