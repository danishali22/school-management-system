<?php
// Insert Class
if (isset($_POST['create_class'])) {
    $class_name = $_POST['class_name'];
    $subject_name = implode(',', $_POST['subject_name']);
    $teacher_name = $_POST['teacher_name'];
    // Check if any sections are selected
    if (isset($_POST['section_name']) && is_array($_POST['section_name'])) {
        $section_name = implode(',', $_POST['section_name']);
    } else {
        // No sections selected, set section_name to NULL or an appropriate default value
        $section_name = NULL; // Or you can set it to an empty string, for example
    }

    $insert_class_sql = "INSERT INTO `class` (`class_name`, `subject_name`, `section_name`, `c_teacher_id`, `created_at`) VALUES ('$class_name', '$subject_name', '$section_name', '$teacher_name', current_timestamp());";
    if ($conn->query($insert_class_sql)) {

?>
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Class has been Added Successfully!',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'index.php?class';
                });
            });
        </script>
    <?php
    } else {

    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Error!',
                    'Class has not been Inserted! <br> We are facing some technical issue and your entry was not submitted successfully! We regret the inconvinience caused!',
                    'error')
            });
        </script>;
<?php
    }
}
?>
<div class="container-fluid my-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <h1 class="text-center bg-dark bg-gradient p-2 mt-3 my-heading">Create New Class</h1>
            <form method="post" enctype='multipart/form-data'>
                <div class="mb-3">
                    <label for="class_name" class="form-label">Class Name</label>
                    <input type="text" class="form-control" id="class_name" name="class_name" required="" placeholder="Class Title">
                </div>
                <div class="mb-3">
                    <label for="class_name" class="form-label">Section Name</label>
                    <?php
                    $section_sql = "SELECT * FROM `section`";
                    $section_result = $conn->query($section_sql);
                    while ($section_row = $section_result->fetch_assoc()) {
                    ?>
                        <div class="form-check">
                            <?php
                            $section_ids = explode(',', $section_row['section_id']);
                            foreach ($section_ids as $id) :
                            ?>
                                <input class="form-check-input" type="checkbox" value="<?= $id ?>" id="section_name_<?= $id ?>" name="section_name[]">
                            <?php endforeach; ?>
                            <label class="form-check-label" for="flexCheckDefault">
                                <a href="index.php?section" class="link-secondary"><?= $section_row['section_title'] ?></a>
                            </label>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <label for="subject_name" class="form-label">Select Subject</label> <br>
                        <select id="subject_name" class="form-select multi-select" name="subject_name[]" required multiple="multiple">
                            <option value="" selected disabled>Select Subject</option>
                            <?php
                            $subject_sql = "SELECT * FROM `subject`";
                            $subject_result = $conn->query($subject_sql);
                            while ($subject_row = $subject_result->fetch_assoc()) {
                            ?>
                                <option value="<?= $subject_row['subject_id'] ?>"><?= $subject_row['subject_name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="teacher_name" class="form-label">Select Teacher</label>
                        <select id="teacher_name" class="form-select" name="teacher_name" required>
                            <option value="" selected disabled>Select Teacher</option>
                            <?php
                            $teacher_sql = "SELECT teacher_id, teacher_name FROM `teachers`";
                            $teacher_result = $conn->query($teacher_sql);
                            while ($teacher_row = $teacher_result->fetch_assoc()) {
                            ?>
                                <option value="<?= $teacher_row['teacher_id'] ?>"><?= $teacher_row['teacher_name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="mt-2 text-center">
                    <button type="submit" class="btn btn-primary" name="create_class" id="create_class">Create</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                </div>
                <h6 class="mt-3">If you don't create Class? <a href="index.php?class" class="btn btn-danger">Go Back</a>
                </h6>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#subject_name').multiselect({
            templates: {
                button: '<button type="button" class="multiselect dropdown-toggle btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false" style="width: 500px;"><span class="multiselect-selected-text"></span></button>',
            },
        });
    });
</script>