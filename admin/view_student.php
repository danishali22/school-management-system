<?php
if (isset($_GET['view_student_id'])) {
    $view_student_id = $_GET['view_student_id'];
    $view_sql = "SELECT * FROM `students` WHERE student_id = '$view_student_id'";
    $view_result = $conn->query($view_sql);
    if (!$view_result) {
        echo "Error. $conn->error;";
    } else {
        $student_row = $view_result->fetch_assoc();
?>
        <div class="container mt-5">
            <div class="card">
                <div class="card-header bg-dark bg-gradient text-white">
                    <h3 class="text-center my-3 my-heading">View Student All Record</h3>
                </div>
                <div class="card-body fs-5">
                    <?php foreach ($student_row as $field => $value) {
                        if ($field !== 'student_class' && $field !== 'student_section' && $field !== 'student_pic' && $field !== 'student_verify') {
                    ?>
                            <div class="row mb-2">
                                <div class="col-md-4 fw-bold">
                                    <?= ucwords(str_replace('_', ' ', $field)) ?>
                                </div>
                                <div class="col-md-8">
                                    <?= $value ?>
                                </div>
                            </div>
                        <?php } }?>
                </div>
            </div>
            <a href="index.php?student" class="btn btn-danger mb-5">Back</a>
        </div>
<?php
                    }
            }
?>