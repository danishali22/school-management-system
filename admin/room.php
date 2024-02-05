<?php
// Insert Room
if (isset($_POST['create_subject'])) {
    $room_name = $_POST['room_name'];
    $room_capacity = $_POST['room_capacity'];
    $room_class = $_POST['room_class'];
    if (isset($_POST['room_class_section'])) {
        $room_class_section = $_POST['room_class_section'];
    } else {
        $room_class_section = NULL;
    }
    $insert_room_sql = "INSERT INTO `room` (`room_name`, `room_capacity`, `r_class_id`, `r_section_id`, `created_at`)
    VALUES ('$room_name', '$room_capacity', '$room_class', '$room_class_section', current_timestamp())";
    if ($conn->query($insert_room_sql)) {
?>
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Room has been Added Successfully!',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'index.php?room';
                });
            });
        </script>
    <?php
    } else {

    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Error!',
                    'Room has not been Inserted! <br> We are facing some technical issue and your entry was not submitted successfully! We regret the inconvinience caused!',
                    'error')
            });
        </script>
<?php
    }
}


// Delete Room
if (isset($_GET['delete_room_id'])) {
    $delete_room_id = $_GET['delete_room_id'];
    $delete_room_sql = "DELETE FROM `room` WHERE room_id = '$delete_room_id' ";
    if ($conn->query($delete_room_sql)) {
    ?>
        <script>
    $(document).ready(function() {
        Swal.fire({
            title: 'Good job!',
            text: 'Room has been Deleted Successfully!',
            icon: 'success'
        }).then(() => {
                window.location.href = 'index.php?room';
        });
    })

        </script>
    <?php
    } 
    else {
    ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Oops!', 'Room has not been Deleted', 'error');
            });
        </script>
<?php
    }
}

?>
<!-- Add Room  -->
        <div class="row col-md-8 mx-auto my-5">
            <h1 class="text-center my-3 bg-dark bg-gradient p-2 my-heading">Create New Room</h1>
            <form method="post" enctype='multipart/form-data'>
                <div class="mb-3">
                    <label for="room_name" class="form-label">Room Name</label>
                    <input type="text" class="form-control" id="room_name" name="room_name" required="" placeholder="Room Name">
                </div>
                <div class="mb-3">
                    <label for="room_capacity" class="form-label">Room Capacity</label>
                    <input type="number" class="form-control" id="room_capacity" name="room_capacity" required="" placeholder="Room Capacity">
                </div>
                <div class="row mb-3">
                    <div class="col-md-6" id="room_class_container">
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
                    <div class="col-md-6" id="room_class_section_container">
                        <label for="room_class_section" class="form-label">Select Section</label>
                        <select id="room_class_section" class="form-select" name="room_class_section">
                            <option value="" selected>Select Section</option>
                        </select>
                    </div>
                </div>
                <div class="mt-2 text-center">
                    <button type="submit" class="btn btn-primary" name="create_subject" id="create_subject">Create</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                </div>
            </form>
        </div>

 <!-- View Room -->
<div class="row col-md-10 mx-auto mt-5">
    <h1 class="text-center fs-1 bg-dark bg-gradient p-2 my-heading">Rooms</h1>
    <table class="table mb-5 text-center my-table" id="my-dataTable">
        <thead class="table-info">
            <tr>
                <th scope="col">Sr</th>
                <th scope="col">Room Name</th>
                <th scope="col">Room Capacity</th>
                <th scope="col">Room Class</th>
                <th scope="col">Room Class Section</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $room_sql = "SELECT * FROM `room`";
            $room_result = $conn->query($room_sql);
            $sno = 1;
            while ($room_row = $room_result->fetch_assoc()) {
            ?>
                <tr>
                    <th scope="row"><?= $sno++ ?></th>
                    <td> <?= $room_row['room_name'] ?> </td>
                    <td> <?= $room_row['room_capacity'] ?> </td>
                    <td> 
                    <?php
                         $class_id = $room_row['r_class_id'];
                         $fetch_class_sql = "SELECT class_name FROM class WHERE class_id = '$class_id' ";
                         $class_result = $conn->query($fetch_class_sql);
                         $fetch_class_row = $class_result->fetch_assoc();
                         echo $fetch_class_row['class_name'];
                    ?>
                    </td>
                    <td>  
                        <?php
                            if($room_row['r_section_id']){
                                $section_id = $room_row['r_section_id'];
                                $fetch_section_sql = "SELECT section_title FROM section WHERE section_id = '$section_id' ";
                                $section_result = $conn->query($fetch_section_sql);
                                $fetch_section_row = $section_result->fetch_assoc();
                                echo $fetch_section_row['section_title'];
                            }else{
                            }
                        ?>
                    </td>
                    <td> <?= $room_row['created_at'] ?> </td>
                    <td>
                        <a class="btn btn-warning mx-1" href="index.php?edit_room_id=<?= $room_row['room_id'] ?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger mx-1" href="index.php?delete_room_id=<?= $room_row['room_id'] ?>"><i class="fa fa-trash"></i></a>
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