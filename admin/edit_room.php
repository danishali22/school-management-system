<div class="row">
    <div class="col-md-8 mx-auto">
        <h1 class="text-center my-5 bg-dark bg-gradient p-2 my-heading">Edit Room</h1>
        <form method="post" enctype='multipart/form-data'>
            <?php
            if (isset($_GET['edit_room_id'])) {
                $edit_room_id = $_GET['edit_room_id'];
                $edit_sql = "SELECT * FROM `room` WHERE room_id = '$edit_room_id'";
                $edit_result = $conn->query($edit_sql);
                $edit_row = $edit_result->fetch_assoc();
            ?>
                <div class="mb-3">
                    <label for="room_name" class="form-label">Room Name</label>
                    <input type="text" class="form-control" id="room_name" name="room_name" value="<?= $edit_row['room_name'] ?>">
                </div>
                <div class="mb-3">
                    <label for="room_capacity" class="form-label">Room Capacity</label>
                    <input type="text" class="form-control" id="room_capacity" name="room_capacity" value="<?= $edit_row['room_capacity'] ?>">
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="room_class" class="form-label">Select Class</label>
                        <select id="room_class" class="form-select" name="room_class">
                            <option value="" selected>Select Class</option>
                            <?php
                            $fetch_class_sql = "SELECT * FROM class";
                            $class_result = $conn->query($fetch_class_sql);
                            while ($class_row = $class_result->fetch_assoc()) {
                            ?>
                                <option value="<?= $class_row['class_id'] ?>" <?php if ($edit_row['r_class_id'] == $class_row['class_id']) { ?> selected <?php } ?>> <?php echo $class_row['class_name'] ?></option>

                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select id="room_class_section" class="form-select" name="room_class_section">
                            <label for="room_class_section" class="form-label">Select Section</label>
                            <option value="" selected>Select Section</option>
                            <?php
                            $selected_class_id = $edit_row['r_class_id'];

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
                                    if (in_array($section_id, $selected_section_ids) || $section_id == $edit_row['r_section_id']) {
                                        echo " selected";
                                    }
                                    echo ">$section_title</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            <?php } ?>
            <div class="mt-2 text-center">
                <button type="submit" class="btn btn-primary" name="update_room" id="update_room">Update</button>
                <a href="index.php?room" class="btn btn-danger">Back</a>
            </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['update_room'])) {;
    $room_name = $_POST['room_name'];
    $room_capacity = $_POST['room_capacity'];
    $room_class = $_POST['room_class'];
    $room_class_section = $_POST['room_class_section'];
    $update_sql = "UPDATE `room` SET room_name = '$room_name', room_capacity = '$room_capacity', r_class_id = '$room_class', r_section_id = '$room_class_section', `created_at` = CURRENT_TIME() WHERE room_id = '$edit_room_id' ";
    if ($conn->query($update_sql)) {
?>
        <script>
            $(document).ready(function() {
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Good job!',
                        text: 'Room has been Updated Successfully!',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'index.php?room';
                    });
                })
            });
        </script>
    <?php
    } else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Room has not been Updated', 'error');
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