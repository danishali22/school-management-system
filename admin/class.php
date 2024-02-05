<?php
// Delete Class
if (isset($_GET['delete_class_id'])) {
    $delete_class_id = $_GET['delete_class_id'];
    $delete_class_sql = "DELETE FROM `class` WHERE class_id = '$delete_class_id' ";
    if ($conn->query($delete_class_sql)) {
    ?>
        <script>
    $(document).ready(function() {
        Swal.fire({
            title: 'Good job!',
            text: 'Class has been Deleted Successfully!',
            icon: 'success'
        }).then(() => {
                window.location.href = 'index.php?class';
        });
    })

        </script>
    <?php
    } 
    else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Class has not been Deleted', 'error');
            });
        </script>
<?php
    }
}

?>

<div class="row col-md-10 mx-auto my-5">
    <h1 class="text-center fs-1 bg-dark bg-gradient mt-3 p-2 my-heading">Classes</h1>
    <div class="mb-3">
        <a href="index.php?add_class" class="btn btn-outline-info mb-3"> <i class="fas fa-plus-square"> Add Class</i></a>
    </div>
    <table class="table mb-5 text-center my-table" id="my-dataTable">
        <thead class="table-info">
            <tr>
                <th scope="col">Sr</th>
                <th scope="col">Class Name</th>
                <th scope="col">Section Name</th>
                <th scope="col">Subject Name</th>
                <th scope="col">Teacher Name</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $class_sql = "SELECT * FROM `class`";
            $class_result = $conn->query($class_sql);
            $sno = 1;
            while ($class_row = $class_result->fetch_assoc()) {
            ?>
                <tr>
                    <th scope="row"><?= $sno++ ?></th>
                    <td> <?= $class_row['class_name'] ?> </td>
                    <td>
                        <?php
                        $section_ids = explode(',', $class_row['section_name']);
                        foreach ($section_ids as $section_id) {
                            $fetch_section_sql = "SELECT `section_title` FROM `section` WHERE section_id = '$section_id'";
                            $fetch_section_result = $conn->query($fetch_section_sql);
                            $fetch_section_row = $fetch_section_result->fetch_assoc();
                            if(isset($fetch_section_row['section_title'])){
                                echo $fetch_section_row['section_title'] . "<br>";
                            }else{
                                echo " ";
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $subject_ids = explode(',', $class_row['subject_name']);
                        foreach ($subject_ids as $subject_id) {
                            $fetch_subject_sql = "SELECT `subject_name` FROM `subject` WHERE subject_id = '$subject_id'";
                            $fetch_subject_result = $conn->query($fetch_subject_sql);
                            $fetch_subject_row = $fetch_subject_result->fetch_assoc();
                            echo $fetch_subject_row['subject_name'] . "<br>";
                        }
                        ?>
                    </td>
                    <td> 
                    <?php
                        $class_teacher_id = $class_row['c_teacher_id'];
                        $fetch_teacher_sql = "SELECT teacher_name FROM teachers WHERE teacher_id = '$class_teacher_id' ";
                        $teacher_result = $conn->query($fetch_teacher_sql);
                        $fetch_teacher_row = $teacher_result->fetch_assoc();
                        echo $fetch_teacher_row['teacher_name'];
                        ?>
                    </td>
                    <td> <?= $class_row['created_at'] ?> </td>
                    <td>
                        <a class="btn btn-warning mx-1" href="index.php?edit_class_id=<?= $class_row['class_id'] ?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger mx-1" href="index.php?delete_class_id=<?= $class_row['class_id'] ?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php  }  ?>
        </tbody>
    </table>
</div>