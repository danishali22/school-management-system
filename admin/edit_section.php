<div class="row my-5">
  <div class="col-md-6 mx-auto">
    <h1 class="text-center mt-3 bg-dark bg-gradient p-2 my-heading">Edit Section</h1>
    <form method="post" enctype='multipart/form-data'>
      <?php
      if (isset($_GET['edit_section_id'])) {
        $edit_section_id = $_GET['edit_section_id'];
        $sql = "SELECT * FROM `section` WHERE section_id = '$edit_section_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
      ?>
        <div class="mb-3">
          <label for="section_title" class="form-label">Title</label>
          <input type="text" class="form-control" id="section_title" name="section_title" value="<?= $row['section_title'] ?>">
        </div>
      <?php
      }
      ?>
      <div class="mt-2 text-center">
        <button type="submit" class="btn btn-primary" name="update_section" id="update_section">Update</button>
        <a href="index.php?section" class="btn btn-danger">Back</a>
      </div>
    </form>
  </div>
</div>

<?php
    if (isset($_POST['update_section'])){;
        $section_title = $_POST['section_title'];
        $update_sql = "UPDATE `section` SET section_title = '$section_title', `created_at` = CURRENT_TIME() WHERE section_id = '$edit_section_id' ";
        if($conn->query($update_sql)){
          ?>
    <script> 
      $(document).ready(function() {
        Swal.fire({
            title: 'Good job!',
            text: 'Section has been Updated Successfully!',
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
              Swal.fire('Oops!', 'Section has not been Updated', 'error'); 
            });
            </script>
            <?php
        }
      }
    
?>