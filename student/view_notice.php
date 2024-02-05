<div class="row col-md-12 mx-auto my-5">
    <div class="container">
        <?php
        if (isset($_GET['view_notice_id'])) {
            $view_notice_id = $_GET['view_notice_id'];
            $notice_sql = "SELECT * FROM `notice` WHERE `notice_id` = $view_notice_id ORDER BY notice_id DESC";
            $notice_result = $conn->query($notice_sql);
            $notice_row = $notice_result->fetch_assoc();

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
            <div class="card my-4">
                <div class="card-header bg-primary bg-gradient text-white text-capitalize">
                    <h5 class="card-title text-center my-heading" style="text-align: center;"><?= strtoupper($notice_row['notice_title']); ?></h5>
                </div>
                <div class="card-body">
                    <p class="bg-green bg-gradient p-2 d-inline-block"><?= $class_name ?></p>
                    <p class="float-end bg-yellow bg-gradient p-2 d-inline-block rounded-md" style="border-radius: 20px;"><span class="fw-bold">Published Date: </span> <?= $notice_row['notice_date'] ?></p>
                    <p class="card-text"><?= $notice_row['notice_desc'] ?></p>
                    <hr>
                    <p class="float-end bg-info-subtle bg-gradient p-2 d-inline-block"><span class="fw-bold">Posted By: </span> <?= $notice_row['posted_by'] ?></p>
                    <div>
                        <a href="index.php?notice" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </div>
        <?php  }  ?>
    </div>
</div>