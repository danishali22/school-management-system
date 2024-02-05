<div class="my-5"></div>
<div class="row col-md-8 mx-auto my-5">
    <div class="container">
        <?php
        $student_id = $_SESSION['student_id'];
        $student_class = $_SESSION['student_class'];
        $feedback_sql = "SELECT * FROM `feedback` WHERE `f_class_id` = $student_class AND `f_student_id` = $student_id ORDER BY feedback_id DESC";
        $feedback_result = $conn->query($feedback_sql);

        while ($feedback_row = $feedback_result->fetch_assoc()) {
        $feedback_teacher_id = $feedback_row['f_teacher_id'];
        $status = $feedback_row['status'];
        $fetch_teacher_sql = "SELECT teacher_name, teacher_gender FROM teachers WHERE teacher_id = '$feedback_teacher_id' ";
        $teacher_result = $conn->query($fetch_teacher_sql);
        $fetch_teacher_row = $teacher_result->fetch_assoc();
        $teacher_name = $fetch_teacher_row['teacher_name'];
        $teacher_gender = $fetch_teacher_row['teacher_gender'];
        $gender = ($teacher_gender === 'Male') ? 'Sir ' : (($teacher_gender === 'Female') ? 'Miss ' : '');
        $teacher =  $gender . $teacher_name;
        ?>
            <div class="card my-4 shadow">
                <div class="card-header bg-primary bg-gradient text-white text-capitalize">
                    <h5 class="card-title text-center my-heading" style="text-align: center;"><?= strtoupper($teacher); ?></h5>
                </div>
                <div class="card-body">
                    <?php if($status === "Positive") { ?>
                    <p class="bg-success bg-gradient p-2 d-inline-block"><?= $feedback_row['remarks'] ?></p>
                    <?php } else if($status === "Negative") {  ?>
                        <p class="bg-danger bg-gradient p-2 d-inline-block"><?= $feedback_row['remarks'] ?></p>
                    <?php } ?>
                    <hr>
                    <p class="float-end bg-info-subtle bg-gradient p-2 d-inline-block"><span class="fw-bold">Date: </span> <?= $feedback_row['created_at'] ?></p>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>