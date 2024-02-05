<!--Insert Modal -->
<div class="modal fade" id="noticeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel my-heading">Add Notice</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype='multipart/form-data' id="noticeForm">
                    <div class="mb-3">
                        <label for="notice_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="notice_title" name="notice_title" required="" placeholder="Notice Title">
                    </div>
                    <div class="mb-3">
                        <label for="notice_desc" class="form-label">Description</label>
                        <textarea type="text" class="form-control" id="notice_desc" name="notice_desc" required="" placeholder="Notice Description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="notice_class" class="form-label">Select Class</label>
                        <select id="notice_class" class="form-select" name="notice_class">
                            <option value="" selected disabled>Select Class</option>
                            <?php
                            $class_sql = "SELECT * FROM `class`";
                            $class_result = $conn->query($class_sql);
                            while ($class_row = $class_result->fetch_assoc()) {
                            ?>
                                <option value="<?= $class_row['class_id'] ?>"><?= $class_row['class_name'] ?></option>
                            <?php
                            }
                            ?>
                            <option value="all">All</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="add_notice" name="add_notice">Add</button>
            </div>
        </div>
    </div>
</div>

<div class="row col-md-8 mx-auto my-5">
    <div class="container">
        <?php
        $post_id = $_SESSION['teacher_id'] . 555;

        $notice_sql = "SELECT * FROM `notice` WHERE `n_post_id` = '$post_id' ORDER BY notice_id DESC";
        $notice_result = $conn->query($notice_sql);
        $sno = 1;
        while ($notice_row = $notice_result->fetch_assoc()) {
            // Limit the text to 100 characters and add ellipsis
            $limited_text = substr($notice_row['notice_desc'], 0, 200);
            $limited_text = strlen($notice_row['notice_desc']) > 200 ? $limited_text . '...' : $limited_text;

            if ($notice_row['n_class_id']) {
                $notice_class_id = $notice_row['n_class_id'];
                $fetch_class_sql = "SELECT class_name FROM class WHERE class_id = '$notice_class_id' ";
                $class_result = $conn->query($fetch_class_sql);
                $fetch_class_row = $class_result->fetch_assoc();
                $class_name =  $fetch_class_row['class_name'];
            } else {
                $class_name = "All";
            }
        ?>
            <div>
                <a href="#" class="btn btn-outline-info my-3" data-bs-toggle="modal" data-bs-target="#noticeModal"> <i class="fas fa-plus-square"> Add Notice</i></a>
            </div>
            <div class="card my-4 shadow">
                <div class="card-header bg-success bg-gradient text-white text-capitalize">
                    <h5 class="card-title text-center" style="text-align: center;"><?= strtoupper($notice_row['notice_title']); ?></h5>
                </div>
                <div class="card-body">
                    <p class="bg-green bg-gradient p-2 d-inline-block"><?= $class_name ?></p>
                    <p class="float-end bg-yellow bg-gradient p-2 d-inline-block rounded-md" style="border-radius: 20px;"><span class="fw-bold">Published Date: </span> <?= $notice_row['notice_date'] ?></p>
                    <p class="card-text"><?= $limited_text ?></p>
                    <hr>
                    <div>
                        <a href="index.php?view_notice_id=<?= $notice_row['notice_id'] ?>" class="btn btn-primary">Read More</a>
                        <a href="index.php?edit_notice_id=<?= $notice_row['notice_id'] ?>" class="btn btn-warning mx-2">Edit</a>
                        <a href="index.php?delete_notice_id=<?= $notice_row['notice_id'] ?>" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#add_notice").click(function(e) {
            e.preventDefault();

            var notice_title = $("#notice_title").val();
            var notice_desc = $("#notice_desc").val();
            var notice_class = $("#notice_class").val(); // Add this line to get the notice_class value

            $.ajax({
                type: "POST",
                url: "handle_notice.php",
                data: {
                    add: true,
                    notice_title: notice_title,
                    notice_desc: notice_desc,
                    notice_class: notice_class // Pass the notice_class to the server
                },
                success: function(response) {
                    if (response === 'success') {
                        Swal.fire('Good job!', 'Notice has been Inserted!', 'success');
                        $("#noticeModal").modal("hide");
                        $("#notice_title").val("");
                        $("#notice_desc").val("");
                        $("#notice_class").val("");
                        location.reload();
                    } else {
                        Swal.fire('Error!', 'Notice has not been Inserted!', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire('Error!', 'An error occurred during the request.', 'error');
                }
            });
        });
    });
</script>