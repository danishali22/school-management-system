<div class="row my-5">
    <div class="col-md-8 mx-auto">
        <h1 class="text-center mt-3 bg-dark bg-gradient p-2 my-heading">Edit Class</h1>
        <form method="post" enctype='multipart/form-data'>
            <?php
            if (isset($_GET['edit_class_id'])) {
                $edit_class_id = $_GET['edit_class_id'];
                $sql = "SELECT * FROM `class` WHERE class_id = '$edit_class_id'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $section_name = $row['section_name'];
            ?>
                <div class="mb-3">
                    <label for="class_name" class="form-label">Class Name</label>
                    <input type="text" class="form-control" id="class_name" name="class_name" value="<?= $row['class_name'] ?>">
                </div>
                <?php
                $section_ids = explode(',', $row['section_name']);
                $available_sections = array();
                $fetch_sections_sql = "SELECT `section_id`, `section_title` FROM `section`";
                $fetch_sections_result = $conn->query($fetch_sections_sql);
                while ($fetch_section_row = $fetch_sections_result->fetch_assoc()) {
                    $available_sections[$fetch_section_row['section_id']] = $fetch_section_row['section_title'];
                }

                // Initialize an array to store selected section names
                $selected_section_names = array();

                foreach ($section_ids as $section_id) {
                    if (isset($available_sections[$section_id])) {
                        $selected_section_names[] = $available_sections[$section_id];
                    }
                }
                ?>
                <div class="mb-3">
                    <label for="section_<?= $section_id ?>" class="form-label">Section Name</label>
                    <?php
                    // Loop through available sections to generate checkboxes
                    foreach ($available_sections as $section_id => $section_title) {
                        $checked = in_array($section_title, $selected_section_names) ? 'checked' : '';

                        echo '<div class="form-check">';
                        echo '<input type="checkbox" ' . $checked . ' class="form-check-input" name="section_name[]" id="section_name_' . $section_id . '" value="' . $section_id . '">';
                        echo '<label class="form-check-label" for="section_name_' . $section_id . '">' . $section_title . '</label>';
                        echo '</div>';
                    }
                    ?>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="subject_name" class="form-label">Select Subject</label>
                        <select id="subject_name" class="form-select multi-select" name="subject_name[]" multiple="multiple">
                            <option value="" disabled>Select Subject</option>
                            <?php
                            $fetch_subject_sql = "SELECT * FROM `subject`";
                            $subject_result = $conn->query($fetch_subject_sql);
                            $selected_subjects = explode(',', $row['subject_name']); // Convert comma-separated subject IDs to an array
                            while ($subject_row = $subject_result->fetch_assoc()) {
                                $subject_id = $subject_row['subject_id'];
                                $subject_name = $subject_row['subject_name'];
                                $selected = in_array($subject_id, $selected_subjects) ? 'selected' : '';
                            ?>
                                <option value="<?= $subject_id ?>" <?= $selected ?>> <?= $subject_name ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="edit_timetable_teacher" class="form-label">Select Teacher</label>
                        <select id="edit_timetable_teacher" class="form-select" name="edit_timetable_teacher">
                            <option value="" selected>Select Teacher</option>
                            <?php
                            $fetch_teacher_sql = "SELECT * FROM teachers";
                            $teacher_result = $conn->query($fetch_teacher_sql);
                            while ($teacher_row = $teacher_result->fetch_assoc()) {
                            ?>
                                <option value="<?= $teacher_row['teacher_id'] ?>" <?php if ($row['c_teacher_id'] == $teacher_row['teacher_id']) { ?> selected <?php } ?>> <?= $teacher_row['teacher_name'] ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            <?php } ?>
            <div class="mt-2 text-center">
                <button type="submit" class="btn btn-primary" name="update_class" id="update_class">Update</button>
                <a href="index.php?class" class="btn btn-danger">Back</a>
            </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['update_class'])) {;
    $class_name = $_POST['class_name'];
    // Check if any sections are selected
    if (isset($_POST['section_name']) && is_array($_POST['section_name'])) {
        $section_name = implode(',', $_POST['section_name']);
    } else {
        // No sections selected, set section_name to NULL or an appropriate default value
        $section_name = NULL; // Or you can set it to an empty string, for example
    }
    $teacher_name = $_POST['edit_timetable_teacher'];
    $subject_name = implode(',', $_POST['subject_name']);
    $update_sql = "UPDATE `class` SET class_name = '$class_name', section_name = '$section_name', subject_name = '$subject_name', c_teacher_id = '$teacher_name', `created_at` = CURRENT_TIME() WHERE class_id = '$edit_class_id' ";
    if ($conn->query($update_sql)) {
?>
        <script>
            $(document).ready(function() {
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Good job!',
                        text: 'Class has been Updated Successfully!',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'index.php?class';
                    });
                })
            });
        </script>
    <?php
    } else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Class has not been Updated', 'error');
            });
        </script>
<?php
    }
}
?>

<script>
    $(document).ready(function() {
        $('#subject_name').multiselect({
            templates: {
                button: '<button type="button" class="multiselect dropdown-toggle btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false" style="width: 400px;"><span class="multiselect-selected-text"></span></button>',
            },
        });
    });
</script>