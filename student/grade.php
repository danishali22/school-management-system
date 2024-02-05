<!-- MDB CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.css" rel="stylesheet" />

<?php
$stuid_sql = "SELECT e_student_id FROM `exam`";
$stuid_result = $conn->query($stuid_sql);
$stuid_row = $stuid_result->fetch_assoc();
$student_exam_id = $stuid_row['e_student_id'];

// Fetch the class ID for the student
$classid_sql = "SELECT student_class FROM students WHERE student_id = '$student_exam_id'";
$classid_result = $conn->query($classid_sql);
$classid_row = $classid_result->fetch_assoc();
$student_class_id = $classid_row['student_class'];

// Fetch the subject IDs for the student's class
$subjectid_sql = "SELECT subject_name FROM class WHERE class_id = '$student_class_id'";
$subjectid_result = $conn->query($subjectid_sql);
$subjectid_row = $subjectid_result->fetch_assoc();
$subject_ids = explode(',', $subjectid_row['subject_name']);

// Fetch and store subject names in an array
$subject_names = [];
foreach ($subject_ids as $subject_id) {
    $subject_info_sql = "SELECT subject_name FROM subject WHERE subject_id = '$subject_id'";
    $subject_info_result = $conn->query($subject_info_sql);
    $subject_info_row = $subject_info_result->fetch_assoc();
    $subject_names[] = $subject_info_row['subject_name'];
}
?>

<div class="mt-3">
    <ul class="nav nav-tabs my-5" id="myTab0" role="tablist">
        <?php
        // Create a tab for each subject
        foreach ($subject_names as $index => $subject_name) {
            $tab_id = 'tab' . $index;
        ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php if ($index === 0) echo 'active'; ?>" id="<?php echo $tab_id; ?>-tab0" data-mdb-toggle="tab" data-mdb-target="#<?php echo $tab_id; ?>0" type="button" role="tab" aria-controls="<?php echo $tab_id; ?>" aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                    <?php echo $subject_name; ?>
                </button>
            </li>
        <?php } ?>
    </ul>
</div>

<div class="tab-content" id="myTabContent0">
    <?php
    // Create tab content for each subject
    foreach ($subject_names as $index => $subject_name) {
        $tab_id = 'tab' . $index;
    ?>
        <div class="tab-pane fade <?php if ($index === 0) echo 'show active'; ?>" id="<?php echo $tab_id; ?>0" role="tabpanel" aria-labelledby="<?php echo $tab_id; ?>-tab0">
            <div class="card container-fluid my-5 shadow">
                <div class="card-header text-center bg-primary bg-gradient text-white">
                    <h2 class="my-heading">GRADEBOOK - <?= strtoupper($subject_name); ?> </h2>
                </div>
                <div class="card-body">
                    <div class="accordion container my-3" id="accordionExample">
                        <!-- Assignment -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    Assignments
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <table class="table text-center" id="my-dataTable">
                                        <thead style="background-color: #225470;">
                                            <tr>
                                                <th scope="col" style="color: white;">Title</th>
                                                <th scope="col" style="color: white;">Total Marks</th>
                                                <th scope="col" style="color: white;">Obtained Marks</th>
                                                <th scope="col" style="color: white;">Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Pick Student Id my SESSION
                                            $studet_id = $_SESSION['student_id'];

                                            // Pick Subject Id by Subject Name
                                            $search_sql = "SELECT * FROM `subject` WHERE subject_name = '$subject_name'";
                                            $search_result = $conn->query($search_sql);
                                            $search_row = $search_result->fetch_assoc();
                                            $sub_id = $search_row['subject_id'];

                                            // Now Selectin the base of Exam Type and Subject Name
                                            $assignment_sql = "SELECT * FROM `exam` WHERE exam_type = 'Assignment' AND e_subject_id = '$sub_id' AND e_student_id = '$studet_id'";
                                            $assignment_result = $conn->query($assignment_sql);
                                            $total_per_obtained_marks = 0;
                                            $total_per_marks = 0;

                                            while ($assignment_row = $assignment_result->fetch_assoc()) {

                                                $total_per_obtained_marks += $assignment_row['obtained_marks'];
                                                $total_per_marks += $assignment_row['total_marks'];
                                                if ($total_per_marks != 0) {
                                                    $per = round(($total_per_obtained_marks / $total_per_marks) * 100) . '%';
                                                } else {
                                                    echo ''; // Display some appropriate message when division by zero occurs
                                                }
                                            ?>
                                                <tr>
                                                    <td><?= $assignment_row['exam_name'] ?></td>
                                                    <td><?= $assignment_row['total_marks'] ?></td>
                                                    <td><?= $assignment_row['obtained_marks'] ?></td>
                                                    <td><?= $per ?></td>
                                                </tr>
                                            <?php  } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th><?= $total_per_marks ?></th>
                                                <th><?= $total_per_obtained_marks ?></th>
                                                <th>
                                                    <?php
                                                    if (isset($total_per_marks) && $total_per_marks != 0) {
                                                        echo round(($total_per_obtained_marks / $total_per_marks) * 100) . '%';
                                                    } else {
                                                        $total_per_marks = 0;
                                                        echo $total_per_marks . '%';
                                                    }
                                                    ?>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Tests -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    Tests
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <table class="table text-center" id="my-dataTable">
                                        <thead style="background-color: #225470;">
                                            <tr>
                                                <th scope="col" style="color: white;">Title</th>
                                                <th scope="col" style="color: white;">Total Marks</th>
                                                <th scope="col" style="color: white;">Obtained Marks</th>
                                                <th scope="col" style="color: white;">Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Pick Student Id my SESSION
                                            $studet_id = $_SESSION['student_id'];

                                            // Pick Subject Id by Subject Name
                                            $search_sql = "SELECT * FROM `subject` WHERE subject_name = '$subject_name'";
                                            $search_result = $conn->query($search_sql);
                                            $search_row = $search_result->fetch_assoc();
                                            $sub_id = $search_row['subject_id'];

                                            // Now Selectin the base of Exam Type and Subject Name
                                            $assignment_sql = "SELECT * FROM `exam` WHERE exam_type = 'Test' AND e_subject_id = '$sub_id' AND e_student_id = '$studet_id'";
                                            $assignment_result = $conn->query($assignment_sql);
                                            $total_per_obtained_marks = 0;
                                            $total_per_marks = 0;

                                            while ($assignment_row = $assignment_result->fetch_assoc()) {

                                                $total_per_obtained_marks += $assignment_row['obtained_marks'];
                                                $total_per_marks += $assignment_row['total_marks'];

                                            ?>
                                                <tr>
                                                    <td><?= $assignment_row['exam_name'] ?></td>
                                                    <td><?= $assignment_row['total_marks'] ?></td>
                                                    <td><?= $assignment_row['obtained_marks'] ?></td>
                                                    <td><?= round(($assignment_row['obtained_marks'] / $assignment_row['total_marks']) * 100) ?>%</td>
                                                </tr>
                                            <?php  } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th><?= $total_per_marks ?></th>
                                                <th><?= $total_per_obtained_marks ?></th>
                                                <th>
                                                    <?php
                                                    if (isset($total_per_marks) && $total_per_marks != 0) {
                                                        echo round(($total_per_obtained_marks / $total_per_marks) * 100) . '%';
                                                    } else {
                                                        $total_per_marks = 0;
                                                        echo $total_per_marks . '%';
                                                    }
                                                    ?>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Mid Term -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                    Mid Term
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <table class="table text-center" id="my-dataTable">
                                        <thead style="background-color: #225470;">
                                            <tr>
                                                 <th scope="col" style="color: white;">Title</th>
                                                 <th scope="col" style="color: white;">Total Marks</th>
                                                 <th scope="col" style="color: white;">Obtained Marks</th>
                                                 <th scope="col" style="color: white;">Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Pick Student Id my SESSION
                                            $studet_id = $_SESSION['student_id'];

                                            // Pick Subject Id by Subject Name
                                            $search_sql = "SELECT * FROM `subject` WHERE subject_name = '$subject_name'";
                                            $search_result = $conn->query($search_sql);
                                            $search_row = $search_result->fetch_assoc();
                                            $sub_id = $search_row['subject_id'];

                                            // Now Selectin the base of Exam Type and Subject Name
                                            $assignment_sql = "SELECT * FROM `exam` WHERE exam_type = 'Mid' AND e_subject_id = '$sub_id' AND e_student_id = '$studet_id'";
                                            $assignment_result = $conn->query($assignment_sql);
                                            $total_per_obtained_marks = 0;
                                            $total_per_marks = 0;

                                            while ($assignment_row = $assignment_result->fetch_assoc()) {

                                                $total_per_obtained_marks += $assignment_row['obtained_marks'];
                                                $total_per_marks += $assignment_row['total_marks'];

                                            ?>
                                                <tr>
                                                    <td><?= $assignment_row['exam_name'] ?></td>
                                                    <td><?= $assignment_row['total_marks'] ?></td>
                                                    <td><?= $assignment_row['obtained_marks'] ?></td>
                                                    <td><?= round(($assignment_row['obtained_marks'] / $assignment_row['total_marks']) * 100) ?>%</td>
                                                </tr>
                                            <?php  } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th><?= $total_per_marks ?></th>
                                                <th><?= $total_per_obtained_marks ?></th>
                                                <th>
                                                    <?php
                                                    if (isset($total_per_marks) && $total_per_marks != 0) {
                                                        echo round(($total_per_obtained_marks / $total_per_marks) * 100) . '%';
                                                    } else {
                                                        $total_per_marks = 0;
                                                        echo $total_per_marks . '%';
                                                    }
                                                    ?>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Final Term -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                    Final Term
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <table class="table text-center" id="my-dataTable">
                                        <thead style="background-color: #225470;">
                                            <tr>
                                                 <th scope="col" style="color: white;">Title</th>
                                                 <th scope="col" style="color: white;">Total Marks</th>
                                                 <th scope="col" style="color: white;">Obtained Marks</th>
                                                 <th scope="col" style="color: white;">Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Pick Student Id my SESSION
                                            $studet_id = $_SESSION['student_id'];

                                            // Pick Subject Id by Subject Name
                                            $search_sql = "SELECT * FROM `subject` WHERE subject_name = '$subject_name'";
                                            $search_result = $conn->query($search_sql);
                                            $search_row = $search_result->fetch_assoc();
                                            $sub_id = $search_row['subject_id'];

                                            // Now Selectin the base of Exam Type and Subject Name
                                            $assignment_sql = "SELECT * FROM `exam` WHERE exam_type = 'Final' AND e_subject_id = '$sub_id' AND e_student_id = '$studet_id'";
                                            $assignment_result = $conn->query($assignment_sql);
                                            $total_per_obtained_marks = 0;
                                            $total_per_marks = 0;

                                            while ($assignment_row = $assignment_result->fetch_assoc()) {

                                                $total_per_obtained_marks += $assignment_row['obtained_marks'];
                                                $total_per_marks += $assignment_row['total_marks'];

                                            ?>
                                                <tr>
                                                    <td><?= $assignment_row['exam_name'] ?></td>
                                                    <td><?= $assignment_row['total_marks'] ?></td>
                                                    <td><?= $assignment_row['obtained_marks'] ?></td>
                                                    <td><?= round(($assignment_row['obtained_marks'] / $assignment_row['total_marks']) * 100) ?>%</td>
                                                </tr>
                                            <?php  } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th><?= $total_per_marks ?></th>
                                                <th><?= $total_per_obtained_marks ?></th>
                                                <th>
                                                    <?php
                                                    if (isset($total_per_marks) && $total_per_marks != 0) {
                                                        echo round(($total_per_obtained_marks / $total_per_marks) * 100) . '%';
                                                    } else {
                                                        $total_per_marks = 0;
                                                        echo $total_per_marks . '%';
                                                    }
                                                    ?>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<!-- MDB JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.js"></script>