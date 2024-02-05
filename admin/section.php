<?php

// Insert Section
if (isset($_POST['create_section'])) {
  $section_title = $_POST['section_title'];

  $sql = "INSERT INTO `section` (`section_title`, `created_at`) VALUES ('$section_title', current_timestamp());";
  if ($conn->query($sql)) {
    ?>
    <script> 
      $(document).ready(function() {
      Swal.fire('Good job!', 'Section has been Inserted!', 'success'); 
    });
    </script>
    <?php
  } else {
    ?>
    <script> 
    $(document).ready(function() {
    Swal.fire('Error!', 'Section has not been Inserted!', 'error')
  });
  </script>;
  <?php 
  }
}

    // Delete Section
    if(isset($_GET['delete_section_id'])){
        $delete_section_id = $_GET['delete_section_id'];
        $sql = "DELETE FROM `section` WHERE section_id = '$delete_section_id' ";
        if($conn->query($sql)){
          ?>
    <script> 
      $(document).ready(function() {
        Swal.fire({
            title: 'Good job!',
            text: 'Notice has been Deleted Successfully!',
            icon: 'success'
        }).then(() => {
                window.location.href = 'index.php?section';
        });
    })
    </script>
    <?php
        }
        else{
            ?>
            <script> 
              $(document).ready(function() {
            Swal.fire({
                title: 'Good job!',
                text: 'Notice has been Deleted Successfully!',
                icon: 'success',
                onClose: function() {
                    window.location.href = 'index.php?section';
                }
            });
        });
            </script>
            <?php
        }
      }

?>

<!-- Add Section  -->
<div class="container-fluid mt-5">
  <div class="row">
    <div class="col-md-6 mx-auto">
        <h1 class="text-center my-3 bg-dark bg-gradient p-2 my-heading">Create New Section</h1>
      <form method="post" enctype='multipart/form-data'>
        <div class="mb-3">
          <label for="section_title" class="form-label">Title</label>
          <input type="text" class="form-control" id="section_title" name="section_title" required="" placeholder="Section Title">
        </div>
        <div class="mt-2 text-center">
          <button type="submit" class="btn btn-primary" name="create_section" id="create_section">Create</button>
          <button type="reset" class="btn btn-warning">Reset</button>
        </div>
        <!-- <h6 class="mt-3">If you don't create Section? <a href="index.php">Go Back</a></h6> -->
      </form>
        </div>
      </div>
    <div class="row col-md-10 mx-auto my-4">
    <h1 class="text-center bg-dark bg-gradient p-2 my-heading">Sections</h1>
    <table class="table mb-5 text-center my-table" id="my-dataTable">
      <thead class="table-info">
        <tr>
          <th scope="col">Sr</th>
          <th scope="col">Title</th>
          <th scope="col">Created At</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php
          $sql1 = "SELECT * FROM `section`";
          $result1 = $conn->query($sql1);
          $sno = 1;
          while($row = $result1->fetch_assoc())
      {
        ?>
        <tr>
          <th scope="row"><?= $sno++ ?></th>
          <td> <?= $row['section_title'] ?> </td>
          <td> <?= $row['created_at'] ?> </td>
          <td>
            <a class="btn btn-warning mx-1" href="index.php?edit_section_id=<?= $row['section_id'] ?>"><i class="fa fa-edit"></i></a>
            <a class="btn btn-danger mx-1" href="index.php?delete_section_id=<?= $row['section_id'] ?>"><i class="fa fa-trash"></i></a>
          </td>
        </tr>
        <?php  }  ?>
      </tbody>
    </table>
  </div>
</div>