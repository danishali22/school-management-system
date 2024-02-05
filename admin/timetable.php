<?php
// Insert Timetable
if (isset($_POST['create_timetable'])) {
    $timetable_teacher = $_POST['timetable_teacher'];
    $room_class = $_POST['room_class'];
    if (isset($_POST['room_class_section'])) {
        $room_class_section = $_POST['room_class_section'];
    } else {
        $room_class_section = 0;
    }
    $timetable_period = $_POST['timetable_period'];
    $timetable_subject = $_POST['timetable_subject'];
    $timetable_room = $_POST['timetable_room'];
    $timetable_day = $_POST['timetable_day'];


    $check_duplicate_sql = "SELECT * FROM `timetable` WHERE `t_teacher_id` = '$timetable_teacher' AND `t_period_id` = '$timetable_period' AND `timetable_day` = '$timetable_day'";

    $cresult = $conn->query($check_duplicate_sql);

    if ($cresult->num_rows > 0) {
        // Display an error message for duplicate entry
?>
        <script>
            $(document).ready(function() {
                Swal.fire('Duplicate entry!',
                    'This Teacher is already allocation for this Period.',
                    'error')
            });
        </script>;
        <?php
    } else {

        $check_sql = "SELECT * FROM `timetable` WHERE `t_class_id` = '$room_class' AND `t_section_id` = '$room_class_section' AND `t_teacher_id` = '$timetable_teacher' AND `t_period_id` = '$timetable_period' AND `t_room_id` = '$timetable_room' AND `t_subject_id` = '$timetable_subject' AND `timetable_day` = '$timetable_day'";
        $result = $conn->query($check_sql);
        if ($result->num_rows > 0) {
            // Display an error message for duplicate entry
        ?>
            <script>
                $(document).ready(function() {
                    Swal.fire('Duplicate entry!',
                        'The timetable record already exists for this entry.',
                        'error')
                });
            </script>;
            <?php
        } else {
            $insert_timetable_sql = "INSERT INTO `timetable` (`t_teacher_id`, `t_class_id`, `t_section_id`, `t_period_id`,`t_subject_id`, `t_room_id`,`timetable_day`, `created_at`)
    VALUES ('$timetable_teacher', '$room_class', '$room_class_section', '$timetable_period', '$timetable_subject', '$timetable_room', '$timetable_day', current_timestamp())";
            // echo $insert_timetable_sql;
            // exit;
            if ($conn->query($insert_timetable_sql)) {
            ?>
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Good job!',
                            text: 'Timetable has been Added Successfully!',
                            icon: 'success'
                        }).then(() => {
                            window.location.href = 'index.php?timetable';
                        });
                    });
                </script>
            <?php
            } else {

            ?>
                <script>
                    $(document).ready(function() {
                        Swal.fire('Error!',
                            'Timetable has not been Inserted!',
                            'error')
                    });
                </script>
        <?php
            }
        }
    }
}


// Delete Timetable
if (isset($_GET['delete_timetable_id'])) {
    $delete_timetable_id = $_GET['delete_timetable_id'];
    $delete_timetable_sql = "DELETE FROM `timetable` WHERE timetable_id = '$delete_timetable_id' ";
    // echo $delete_timetable_id;
    // exit;
    if ($conn->query($delete_timetable_sql)) {
        ?>
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Timetable has been Deleted Successfully!',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'index.php?timetable';
                });
            })
        </script>
    <?php
    } else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Timetable has not been Deleted', 'error');
            });
        </script>
<?php
    }
}

?>
<!-- Add Timetable  -->
<div class="row col-md-10 mx-auto my-5">
    <h1 class="text-center my-3 bg-dark bg-gradient p-2 my-heading">Create New Timetable</h1>
    <form method="post" enctype='multipart/form-data'>
        <div class="row mb-5">
            <div class="col-md" id="room_class_container">
                <label for="room_class" class="form-label">Select Class</label>
                <select id="room_class" class="form-select" name="room_class" required>
                    <option value="" selected>Select Class</option>
                    <?php
                    $class_sql = "SELECT * FROM `class`";
                    $class_result = $conn->query($class_sql);
                    while ($class_row = $class_result->fetch_assoc()) {
                    ?>
                        <option value="<?= $class_row['class_id'] ?>"><?= $class_row['class_name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md" id="room_class_section_container">
                <label for="room_class_section" class="form-label">Select Section</label>
                <select id="room_class_section" class="form-select" name="room_class_section">
                    <option value="" selected>Select Section</option>
                </select>
            </div>
            <div class="col-md">
                <label for="timetable_teacher" class="form-label">Select Teacher</label>
                <select id="timetable_teacher" class="form-select" name="timetable_teacher" required>
                    <option value="" selected>Select Teacher</option>
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
            <div class="col-md">
                <label for="timetable_period" class="form-label">Select Period</label>
                <select id="timetable_period" class="form-select" name="timetable_period" required>
                    <option value="" selected>Select Period</option>
                    <?php
                    $period_sql = "SELECT * FROM `period`";
                    $period_result = $conn->query($period_sql);
                    while ($period_row = $period_result->fetch_assoc()) {
                    ?>
                        <option value="<?= $period_row['period_id'] ?>"><?= $period_row['period_name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md">
                <label for="timetable_room" class="form-label">Select Room</label>
                <select id="timetable_room" class="form-select" name="timetable_room" required>
                    <option value="" selected>Select Room</option>
                    <?php
                    $room_sql = "SELECT * FROM `room`";
                    $room_result = $conn->query($room_sql);
                    while ($room_row = $room_result->fetch_assoc()) {
                    ?>
                        <option value="<?= $room_row['room_id'] ?>"><?= $room_row['room_name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md">
                <label for="timetable_subject" class="form-label">Select Subject</label>
                <select id="timetable_subject" class="form-select" name="timetable_subject" required>
                    <option value="" selected>Select Subject</option>
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
            <div class="col-md">
                <label for="timetable_day" class="form-label">Select Day</label>
                <select id="timetable_day" class="form-select" name="timetable_day" required>
                    <option value="" selected>Select Day</option>
                    <?php
                    $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                    for ($i = 0; $i < 7; $i++) {
                    ?>
                        <option value="<?= $days[$i] ?>"><?= $days[$i] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="mt-2 text-center">
            <button type="submit" class="btn btn-primary" name="create_timetable" id="create_timetable">Create</button>
            <button type="reset" class="btn btn-warning">Reset</button>
        </div>
    </form>
    
    <div>
        <a href="index.php?view_timetable" class="btn btn-outline-info mb-3"> <i class="fas fa-plus-square"> View Timetable</i></a>
    </div>
</div>

<!-- View Timetable -->
<div class="row col-md-10 mx-auto">
    <h1 class="text-center fs-1 bg-dark bg-gradient p-2 my-heading">Timetable</h1>
    <table class="table mb-5 text-center my-table" id="my-dataTable">
        <thead>
            <tr>
                <th scope="col">Sr</th>
                <th scope="col">Class</th>
                <th scope="col">Section</th>
                <th scope="col">Teacher</th>
                <th scope="col">Period</th>
                <th scope="col">Room</th>
                <th scope="col">Subject</th>
                <th scope="col">Day</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $timetable_sql = "SELECT * FROM `timetable`";
            $timetable_result = $conn->query($timetable_sql);
            $sno = 1;
            while ($timetable_row = $timetable_result->fetch_assoc()) {
            ?>
                <tr>
                    <th scope="row"><?= $sno++ ?></th>
                    <td>
                        <?php
                        $timetable_class_id = $timetable_row['t_class_id'];
                        $fetch_class_sql = "SELECT class_name FROM class WHERE class_id = '$timetable_class_id' ";
                        $class_result = $conn->query($fetch_class_sql);
                        $fetch_class_row = $class_result->fetch_assoc();
                        echo $fetch_class_row['class_name'];
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($timetable_row['t_section_id']) {
                            $timetable_section_id = $timetable_row['t_section_id'];
                            $fetch_section_sql = "SELECT section_title FROM section WHERE section_id = '$timetable_section_id' ";
                            $section_result = $conn->query($fetch_section_sql);
                            $fetch_section_row = $section_result->fetch_assoc();
                            echo $fetch_section_row['section_title'];
                        } else {
                            echo "";
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $timetable_teacher_id = $timetable_row['t_teacher_id'];
                        $fetch_teacher_sql = "SELECT teacher_name FROM teachers WHERE teacher_id = '$timetable_teacher_id' ";
                        $teacher_result = $conn->query($fetch_teacher_sql);
                        $fetch_teacher_row = $teacher_result->fetch_assoc();
                        echo $fetch_teacher_row['teacher_name'];
                        ?>
                    </td>
                    <td>
                        <?php
                        $timetable_period_id = $timetable_row['t_period_id'];
                        $fetch_period_sql = "SELECT period_name FROM `period` WHERE period_id = '$timetable_period_id' ";
                        $period_result = $conn->query($fetch_period_sql);
                        $fetch_period_row = $period_result->fetch_assoc();
                        echo $fetch_period_row['period_name'];
                        ?>
                    </td>
                    <td>
                        <?php
                        $timetable_room_id = $timetable_row['t_room_id'];
                        $fetch_room_sql = "SELECT room_name FROM `room` WHERE room_id = '$timetable_room_id' ";
                        $room_result = $conn->query($fetch_room_sql);
                        $fetch_room_row = $room_result->fetch_assoc();
                        echo $fetch_room_row['room_name'];
                        ?>
                    </td>
                    <td>
                        <?php
                        $timetable_subject_id = $timetable_row['t_subject_id'];
                        $fetch_subject_sql = "SELECT subject_name FROM `subject` WHERE subject_id = '$timetable_subject_id' ";
                        $subject_result = $conn->query($fetch_subject_sql);
                        $fetch_subject_row = $subject_result->fetch_assoc();
                        echo $fetch_subject_row['subject_name'];
                        ?>
                    </td>
                    <td> <?= $timetable_row['timetable_day'] ?> </td>
                    <td> <?= $timetable_row['created_at'] ?> </td>
                    <td>
                        <a class="btn btn-warning mx-1" href="index.php?edit_timetable_id=<?= $timetable_row['timetable_id'] ?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger mx-1" href="index.php?delete_timetable_id=<?= $timetable_row['timetable_id'] ?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php  }  ?>
        </tbody>
    </table>
</div>

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