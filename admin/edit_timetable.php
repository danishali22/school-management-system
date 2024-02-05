<div class="row my-5">
    <div class="col-md-8 mx-auto">
        <h1 class="text-center mt-3 bg-dark bg-gradient p-2 my-heading">Edit Timetable</h1>
        <form method="post" enctype='multipart/form-data'>
            <?php
            if (isset($_GET['edit_timetable_id'])) {
                $edit_timetable_id = $_GET['edit_timetable_id'];
                $edit_sql = "SELECT * FROM `timetable` WHERE timetable_id = '$edit_timetable_id'";
                $edit_result = $conn->query($edit_sql);
                $edit_row = $edit_result->fetch_assoc();
            ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <select id="room_class" class="form-select" name="room_class">
                        <option value="" selected>Select Class</option>
                        <?php
                        $fetch_class_sql = "SELECT * FROM class";
                        $class_result = $conn->query($fetch_class_sql);
                        while ($class_row = $class_result->fetch_assoc()) {
                        ?>
                            <option value="<?= $class_row['class_id'] ?>" <?php if ($edit_row['t_class_id'] == $class_row['class_id']) { ?> selected <?php } ?>> <?php echo $class_row['class_name'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                <select id="room_class_section" class="form-select" name="room_class_section">
                        <option value="" selected>Select Section</option>
                        <?php
                        $selected_class_id = $edit_row['t_class_id'];
                        
                        // Fetch selected class's section IDs
                        $fetch_section_sql = "SELECT section_name FROM class WHERE class_id = '$selected_class_id'";
                        $section_result = $conn->query($fetch_section_sql);
                        
                        if ($section_result->num_rows > 0) {
                            $section_row = $section_result->fetch_assoc();
                            $selected_section_ids = explode(',', $section_row['section_name']);
                            
                            // Fetch all sections
                            $fetch_all_sections_sql = "SELECT section_id, section_title FROM section";
                            $all_sections_result = $conn->query($fetch_all_sections_sql);
                            
                            while ($section_row = $all_sections_result->fetch_assoc()) {
                                $section_id = $section_row['section_id'];
                                $section_title = $section_row['section_title'];

                                echo "<option value='$section_id'";
                                if (in_array($section_id, $selected_section_ids) || $section_id == $edit_row['t_section_id']) {
                                    echo " selected";
                                }
                                echo ">$section_title</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <select id="edit_timetable_teacher" class="form-select" name="edit_timetable_teacher">
                        <option value="" selected>Select Teacher</option>
                        <?php
                        $fetch_teacher_sql = "SELECT * FROM teachers";
                        $teacher_result = $conn->query($fetch_teacher_sql);
                        while ($teacher_row = $teacher_result->fetch_assoc()) {
                            ?>
                            <option value="<?= $teacher_row['teacher_id'] ?>" <?php if ($edit_row['t_teacher_id'] == $teacher_row['teacher_id']) { ?> selected <?php } ?>> <?= $teacher_row['teacher_name'] ?> </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <select id="edit_timetable_period" class="form-select" name="edit_timetable_period">
                        <option value="" selected>Select Room</option>
                        <?php
                        $fetch_period_sql = "SELECT * FROM `period`";
                        $period_result = $conn->query($fetch_period_sql);
                        while ($period_row = $period_result->fetch_assoc()) {
                            ?>
                            <option value="<?= $period_row['period_id'] ?>" <?php if ($edit_row['t_period_id'] == $period_row['period_id']) { ?> selected <?php } ?>>  <?= $period_row['period_name'] ?>  </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <select id="edit_timetable_room" class="form-select" name="edit_timetable_room">
                        <option value="" selected>Select Room</option>
                        <?php
                        $fetch_room_sql = "SELECT * FROM room";
                        $room_result = $conn->query($fetch_room_sql);
                        while ($room_row = $room_result->fetch_assoc()) {
                            ?>
                            <option value="<?= $room_row['room_id'] ?>" <?php if ($edit_row['t_room_id'] == $room_row['room_id']) { ?> selected <?php } ?>> <?= $room_row['room_name'] ?> </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <select id="edit_timetable_subject" class="form-select" name="edit_timetable_subject">
                        <option value="" selected>Select Subject</option>
                        <?php
                        $fetch_subject_sql = "SELECT * FROM `subject`";
                        $subject_result = $conn->query($fetch_subject_sql);
                        while ($subject_row = $subject_result->fetch_assoc()) {
                            ?>
                            <option value="<?= $subject_row['subject_id'] ?>" <?php if ($edit_row['t_subject_id'] == $subject_row['subject_id']) { ?> selected <?php } ?>>  <?= $subject_row['subject_name'] ?>  </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                    <select id="edit_timetable_day" class="form-select" name="edit_timetable_day">
                        <option value="" selected>Select Timetable Day</option>
                        <?php
                         $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                         for ($i = 0; $i < 7; $i++) {
                         ?>
                            <option value="<?= $days[$i] ?>" <?php if ($edit_row['timetable_day'] == $days[$i]) { ?> selected <?php } ?>>
                                <?= $days[$i] ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    </div>
                </div>
            </div>
            <?php }?>
            <div class="mt-2 text-center">
                <button type="submit" class="btn btn-primary" name="update_timetable" id="update_timetable">Update</button>
                <a href="index.php?timetable" class="btn btn-danger">Back</a>
            </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['update_timetable'])) {;
    $timetable_teacher = $_POST['edit_timetable_teacher'];
    $room_class = $_POST['room_class'];
    if (isset($_POST['room_class_section'])) {
        $room_class_section = $_POST['room_class_section'];
    } else {
        $room_class_section = NULL;
    }
    $timetable_period = $_POST['edit_timetable_period'];
    $timetable_subject = $_POST['edit_timetable_subject'];
    $timetable_room = $_POST['edit_timetable_room'];
    $timetable_day = $_POST['edit_timetable_day'];
    $update_sql = "UPDATE `timetable` SET t_teacher_id = '$timetable_teacher', t_class_id = '$room_class', t_section_id = '$room_class_section', t_period_id = '$timetable_period', t_subject_id = '$timetable_subject', t_room_id = '$timetable_room', timetable_day = '$timetable_day', `created_at` = CURRENT_TIME() WHERE timetable_id = '$edit_timetable_id' ";
    if ($conn->query($update_sql)) {
?>
<script>
$(document).ready(function() {
    $(document).ready(function() {
        Swal.fire({
            title: 'Good job!',
            text: 'Timetable has been Updated Successfully!',
            icon: 'success'
        }).then(() => {
                window.location.href = 'index.php?timetable';
        });
    })
});
</script>
<?php
    } else {
    ?>
<script>
$(document).ready(function() {
    Swal.fire('Oops!', 'Timetable has not been Updated', 'error');
});
</script>
<?php
    }
}
?>

<script>
    $(document).ready(function() {
        $('#room_class').on('change', function() {
            var classId = $(this).val();
            if (classId !== '') {
                $.ajax({
                    url: 'get_sections.php',
                    method: 'POST',
                    data: {
                        class_id: classId
                    },
                    dataType: 'json',
                    success: function(data) {
                        var sectionContainer = $('#room_class_section_container');
                        var sectionSelect = $('#room_class_section');

                        sectionSelect.empty().append($('<option>', {
                            value: '',
                            text: 'Select Class Section'
                        }));

                        if (data.length > 0) {
                            $.each(data, function(index, section) {
                                sectionSelect.append($('<option>', {
                                    value: section.section_id,
                                    text: section.section_title
                                }));
                            });

                            // Show the section selection container
                            sectionContainer.show();
                        } else {
                            // Hide the section selection container
                            sectionContainer.hide();
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.log('Error:', errorThrown);
                    }
                });
            } else {
                // Hide the section selection container
                $('#room_class_section_container').hide();
                $('#room_class_section').empty().append($('<option>', {
                    value: '',
                    text: 'Select Class Section'
                }));
            }
        });
    });
</script>