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
    } 
    else {
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

<div class="row col-md-12 mx-auto mt-5">
    <h1 class="text-center fs-1 my-heading" style="background-color: #4598c7; color: white;">Exams</h1>
    <div>
        <a href="index.php?add_exam" class="btn btn-outline-info mb-3"> <i class="fas fa-plus-square"> Add Exam</i></a>
    </div>
    <table class="table mb-5 text-center my-table" id="my-dataTable">
        <thead class="table-info">
            <tr>
                <th scope="col">Sr</th>
                <th scope="col">Class</th>
                <th scope="col">Student Name</th>
                <th scope="col">Subject</th>
                <th scope="col">Exam Name</th>
                <th scope="col">Exam Type</th>
                <th scope="col">Total Marks</th>
                <th scope="col">Obtained Marks</th>
                <th scope="col">Exam Date</th>
                <th scope="col">Action</th>
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
                            $exam_class_id = $exam_row['e_class_id'];
                            $fetch_class_sql = "SELECT class_name FROM class WHERE class_id = '$exam_class_id' ";
                            $class_result = $conn->query($fetch_class_sql);
                            $fetch_class_row = $class_result->fetch_assoc();
                            echo $fetch_class_row['class_name'];
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
                    <td> <?= $exam_row['exam_date'] ?> </td>
                    <td>
                        <a class="btn btn-warning mx-1" href="index.php?edit_exam_id=<?= $exam_row['exam_id'] ?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger mx-1" href="index.php?delete_exam_id=<?= $exam_row['exam_id'] ?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php  }  ?>
        </tbody>
    </table>
</div>