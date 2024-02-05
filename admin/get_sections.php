<?php
require_once('../partials/_connection.php'); // Include your connection code

// Assuming you have a database connection established here
if (isset($_POST['class_id'])) {
    $classId = $_POST['class_id'];

    // Fetch section data based on the section_name column
    $class_sql = "SELECT `section_name` FROM `class` WHERE `class_id` = '$classId'";
    $class_result = $conn->query($class_sql);

    if ($class_result->num_rows > 0) {
        $class_row = $class_result->fetch_assoc();
        $section_ids = explode(',', $class_row['section_name']);
        
        // Fetch section data from the database using section IDs
        $section_sql = "SELECT `section_id`, `section_title` FROM `section` WHERE `section_id` IN ('" . implode("', '", $section_ids) . "')";
        $section_result = $conn->query($section_sql);

        // Populate the section_data array
        $section_data = array();
        while ($section_row = $section_result->fetch_assoc()) {
            $section_data[] = $section_row;
        }

        // Return the sections data as JSON
        header('Content-Type: application/json');
        echo json_encode($section_data);
    } else {
        // No matching class found
        header("HTTP/1.0 404 Not Found");
    }
}
?>
