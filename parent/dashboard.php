<style>
    .student-card {
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease-in-out;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        margin: 10px;
        background-color: #fff;
        width: 90%;
    }

    .student-card:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    }

    /* Additional styling for student images */
    .student-image {
        width: 100%;
        height: 400px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    /* Additional styling for student info */
    .student-info {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 10px;
        text-align: center;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .student-card:hover .student-info {
        opacity: 1;
    }

    /* Additional animation for student cards */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* Apply animation */
    .student-card {
        animation: fadeIn 0.5s ease-out;
    }

    .my-h1 {
        text-align: center;
        font-size: 2rem;
        /* Adjustable font size */
        color: #fff;
        /* Text color */
        background-color: #007bff;
        /* Background color */
        padding: 20px 0;
        margin: 0;
        transition: transform 0.3s ease-in-out;
    }

    /* Animation on hover */
    .my-h1:hover {
        transform: scale(1.1);
        /* Increase size on hover */
        background-color: #0056b3;
        /* Change background color on hover */
    }
</style>

<div class="container my-5">
    <div class="row my-5">
        <div class="my-h1">Your Kids Account</div>
        <?php
        $my_kids = $_SESSION['kids'];
        $students = explode(',', $my_kids);

        // Assuming you have fetched student information and stored it in an array called $students
        foreach ($students as $student_id) {
            $fetch_student_sql = "SELECT * FROM `students` WHERE student_id = '$student_id'";
            $fetch_student_result = $conn->query($fetch_student_sql);

            if ($fetch_student_result && $fetch_student_result->num_rows > 0) {
                $fetch_student_row = $fetch_student_result->fetch_assoc();
                $student_name = $fetch_student_row['student_name'];
                $student_pic = $fetch_student_row['student_pic'];
        ?>
                <div class="col-md-4">
                    <div class="student-card">
                        <a href="direct_access.php?student_id=<?= $student_id ?>">
                            <img src="../admin/admin_images/registration/<?= $student_pic ?>" alt="<?= $student_name ?>" class="student-image">
                        </a>
                        <div class="student-info">
                            <h3><?= $student_name ?></h3>
                            <!-- Add other student information here -->
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>