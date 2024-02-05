<?php

// Insert notice
if (isset($_POST['create_notice'])) {
  $notice_title = $_POST['notice_title'];
  $notice_desc = $_POST['notice_desc'];
  $notice_class = $_POST['notice_class'];
  $posted_by = $_SESSION['admin_name'];
  $post_id = $_SESSION['admin_id'] . 888;

  if($_POST['notice_class'] == 'all'){
    $sql = "INSERT INTO `notice` (`notice_title`, `notice_desc`, `posted_by`, `n_post_id`, `notice_date`) VALUES ('$notice_title', '$notice_desc', '$posted_by', '$post_id', current_timestamp());";
  } else{
    $sql = "INSERT INTO `notice` (`notice_title`, `notice_desc`, `n_class_id`, `posted_by`, `n_post_id`, `notice_date`) VALUES ('$notice_title', '$notice_desc','$notice_class', '$posted_by', '$post_id',  current_timestamp());";
  }
  if ($conn->query($sql)) {
?>
    <script>
      $(document).ready(function() {
        Swal.fire('Good job!', 'Notice has been Inserted!', 'success');
      });
    </script>
  <?php
  } else {
  ?>
    <script>
      $(document).ready(function() {
        Swal.fire('Error!', 'Notice has not been Inserted!', 'error')
      });
    </script>
  <?php
  }
}

// Delete notice
if (isset($_GET['delete_notice_id'])) {
  $delete_notice_id = $_GET['delete_notice_id'];
  $sql = "DELETE FROM `notice` WHERE notice_id = '$delete_notice_id' ";
  if ($conn->query($sql)) {
  ?>
    <script>
      $(document).ready(function() {
        Swal.fire({
          title: 'Good job!',
          text: 'Notice has been Deleted Successfully!',
          icon: 'success'
        }).then(() => {
          window.location.href = 'index.php?notice';
        });
      })
    </script>
  <?php
  } else {
  ?>
    <script>
      $(document).ready(function() {
        Swal.fire({
          title: 'Good job!',
          text: 'Notice has been Deleted Successfully!',
          icon: 'success',
          onClose: function() {
            window.location.href = 'index.php?notice';
          }
        });
      });
    </script>
<?php
  }
}

?>

<!-- Add notice  -->
<div class="container-fluid">
  <div class="row my-5">
    <div class="col-md-6 mx-auto">
      <h1 class="text-center mt-3 bg-dark bg-gradient p-2 my-heading">Create New Notice</h1>
      <form method="post" enctype='multipart/form-data'>
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
        <div class="mt-2 text-center">
          <button type="submit" class="btn btn-primary" name="create_notice" id="create_notice">Create</button>
          <button type="reset" class="btn btn-warning">Reset</button>
        </div>
        <!-- <h6 class="mt-3">If you don't create notice? <a href="index.php">Go Back</a></h6> -->
      </form>
    </div>
  </div>
  <div class="row col-md-10 mx-auto my-5">
    <h1 class="text-center bg-dark bg-gradient p-2 my-heading">Notices</h1>
    <table class="table mb-5 text-center my-table" id="my-dataTable">
      <thead class="table-info">
        <tr>
          <th scope="col">Sr</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Class</th>
          <th scope="col">Posted By</th>
          <th scope="col">Date/Time</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql1 = "SELECT * FROM `notice` ORDER BY notice_id DESC";
        $result1 = $conn->query($sql1);
        $sno = 1;
        while ($row = $result1->fetch_assoc()) {
        ?>
          <tr>
            <th scope="row"><?= $sno++ ?></th>
            <td> <?= $row['notice_title'] ?> </td>
            <td> <?= $row['notice_desc'] ?> </td>
            <td>
              <?php
              if($row['n_class_id']){
                $notice_class_id = $row['n_class_id'];
                $fetch_class_sql = "SELECT class_name FROM class WHERE class_id = '$notice_class_id' ";
                $class_result = $conn->query($fetch_class_sql);
                $fetch_class_row = $class_result->fetch_assoc();
                echo $fetch_class_row['class_name'];
              }else{
                echo "All";
              }
              ?>
            </td>
            <td> <?= $row['posted_by'] ?> </td>
            <td> <?= $row['notice_date'] ?> </td>
            <td class="mb-3">
              <a class="btn btn-warning mx-1" href="index.php?edit_notice_id=<?= $row['notice_id'] ?>"><i class="fa fa-edit"></i></a>
              <a class="btn btn-danger mx-1" href="index.php?delete_notice_id=<?= $row['notice_id'] ?>"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
        <?php  }  ?>
      </tbody>
    </table>
  </div>
</div>