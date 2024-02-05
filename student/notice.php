<div class="my-5"></div>
<div class="row col-md-8 mx-auto my-5">
    <div class="container">
        <?php
        $student_class = $_SESSION['student_class'];
        $check_result = $conn->query("SELECT * FROM `notice`");
        if ($check_result) {
            $check_row = $check_result->fetch_assoc();
        
            // Check if 'n_class_id' exists in the result
            // if (isset($check_row['n_class_id'])) {
                $notice_sql = "SELECT * FROM `notice` WHERE `n_class_id` = $student_class OR `n_class_id` IS NULL ORDER BY notice_id DESC";
        //     } 
        //     else {
        //         $notice_sql = "SELECT * FROM `notice` ORDER BY notice_id DESC";
        //     }
        } else {
            // Handle query execution error here
            echo "Error executing query: " . $conn->error;
        }       
        $notice_result = $conn->query($notice_sql);
        $sno = 1;

        while ($notice_row = $notice_result->fetch_assoc()) {
            // Limit the text to 100 characters and add ellipsis
            $limited_text = substr($notice_row['notice_desc'], 0, 200);
            $limited_text = strlen($notice_row['notice_desc']) > 200 ? $limited_text . '...' : $limited_text;

            if($notice_row['n_class_id']){
                $notice_class_id = $notice_row['n_class_id'];
                $fetch_class_sql = "SELECT class_name FROM class WHERE class_id = '$notice_class_id' ";
                $class_result = $conn->query($fetch_class_sql);
                $fetch_class_row = $class_result->fetch_assoc();
                $class_name =  $fetch_class_row['class_name'];
            } else{
                $class_name = "All";
            }
        ?>
            <div class="card my-4 shadow">
                <div class="card-header bg-primary bg-gradient text-white text-capitalize">
                    <h5 class="card-title text-center my-heading" style="text-align: center;"><?= strtoupper($notice_row['notice_title']); ?></h5>
                </div>
                <div class="card-body">
                    <p class="bg-green bg-gradient p-2 d-inline-block"><?= $class_name ?></p>
                    <p class="float-end bg-yellow bg-gradient p-2 d-inline-block rounded-md" style="border-radius: 20px;"><span class="fw-bold">Published Date: </span> <?= $notice_row['notice_date'] ?></p>
                    <p class="card-text"><?= $limited_text ?></p>
                    <hr>
                    <p class="float-end bg-info-subtle bg-gradient p-2 d-inline-block"><span class="fw-bold">Posted By: </span> <?= $notice_row['posted_by'] ?></p>
                    <div>
                        <a href="index.php?view_notice_id=<?= $notice_row['notice_id'] ?>" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>
