<?= $title = "Timetable"?>
<div class="row col-md-11 mx-auto my-4">
    <h1 class="text-center fs-1 bg-primary bg-gradient p-2 my-heading">Timetable</h1>
    <table class="table mb-5 text-center table-bordered">
        <thead>
            <?php
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            ?>
            <tr>
                <th scope="col">Timing</th>
                <?php foreach ($days as $day) : ?>
                    <th><?= $day ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $timetable = array();

            $fetch_period_sql = "SELECT * FROM `period`";
            $period_result = $conn->query($fetch_period_sql);

            while ($fetch_period_row = $period_result->fetch_assoc()) {
                $period_start_time = date('h:i A', strtotime($fetch_period_row['period_start_time']));
                $period_end_time = date('h:i A', strtotime($fetch_period_row['period_end_time']));
                $break = $fetch_period_row['period_name'];

                if ($break === "Lunch Break") {
                    // This is a break
                    $timetable[] = $break;
                } else {
                    // This is a regular period
                    $timetable[] = $period_start_time . " - " . $period_end_time;
                }
            }

            foreach ($timetable as $period_time) : ?>
                <tr>
                    <?php
                    if ($period_time === 'Lunch Break') {
                    ?>
                <tr>
                    <td class="fw-bold text-center bg-warning" colspan="7"> Lunch Break </td>
                </tr>
            <?php  } else {
            ?>
                <td class="fw-bold"><?= $period_time ?></td>
            <?php
                    } ?>

            <?php foreach ($days as $day) : ?>
                <td>
                    <?php
                    if ($period_time === 'Lunch Break') {
                        echo '';
                    } else {
                        // Retrieve foreign key IDs from the timetable table
                        $sql = "SELECT t.t_class_id, t.t_section_id, t.t_teacher_id, t.t_room_id, t.t_subject_id
                        FROM timetable AS t
                        INNER JOIN `period` AS p ON t.t_period_id = p.period_id
                        WHERE t.timetable_day = '$day' AND p.period_start_time <= '$period_time' AND p.period_end_time >= '$period_time'";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();

                            // Fetch the names using the foreign key IDs from their respective tables
                            $t_class_id = $row['t_class_id'];
                            $t_section_id = $row['t_section_id'];
                            $t_teacher_id = $row['t_teacher_id'];
                            $t_room_id = $row['t_room_id'];
                            $t_subject_id = $row['t_subject_id'];

                            // Fetch the names from their respective tables
                            $class_name = fetchNameFromTable($t_class_id, 'class', 'class_id', 'class_name');
                            $section_name = fetchNameFromTable($t_section_id, 'section', 'section_id', 'section_title');
                            $teacher_name = fetchNameFromTable($t_teacher_id, 'teachers', 'teacher_id', 'teacher_name');
                            $room_name = fetchNameFromTable($t_room_id, 'room', 'room_id', 'room_name');
                            $subject_name = fetchNameFromTable($t_subject_id, 'subject', 'subject_id', 'subject_name');

                            // Display the names
                            echo '<strong> Class: </strong>' . $class_name . '<br>';
                            if ($section_name) {
                                echo '<strong> Section: </strong>' . $section_name . '<br>';
                            }
                            echo '<strong> Teacher: </strong>' . $teacher_name . '<br>';
                            echo '<strong> Room: </strong>' . $room_name . '<br>';
                            echo '<strong> Subject: </strong>' . $subject_name;
                        } else {
                            echo 'Unscheduled';
                        }
                    }
                    ?>
                </td>
            <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>

        <?php
        // Function to fetch name from a table using the ID
        function fetchNameFromTable($id, $table, $idColumn, $nameColumn)
        {
            global $conn;

            $sql = "SELECT $nameColumn FROM $table WHERE $idColumn = '$id'";
            $result = $conn->query($sql);

            if (!$result) {
                // Display an error message if the query fails
                die("Error in SQL query: " . $conn->error);
            }

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row[$nameColumn];
            }

            return 'Name not found';
        }

        ?>