<style>
    .d-none {
        display: none !important;
    }
</style>

<div class="row col-md-8 mx-auto my-5">
    <div class="container">
        <?php
        $parent_id = $_SESSION['parent_id'];
        $parent_sql = "SELECT * FROM `parent` WHERE parent_id='$parent_id'";
        $parent_result = $conn->query($parent_sql);
        $sno = 1;
        $parent_row = $parent_result->fetch_assoc();
        ?>
        <h1 class="text-center fs-1 bg-primary bg-gradient p-2 mt-3 my-heading">Parent Profile</h1>
        <div class="card shadow mt-3">
            <form method="post" enctype='multipart/form-data'>
                <table class="table mb-5 table-bordered">
                    <tr>
                        <th> Name </th>
                        <td>
                            <div class="d-flex justify-content-between">
                                <span class="mr-2"> <?= $parent_row['parent_name'] ?> </span>
                                <span class="btn btn-warning" id="name-edit"><i class="fa fa-edit"></i></span>
                            </div>
                            <div class="d-flex justify-content-start d-none" id="name">
                                <div class="form-group">
                                    <form action="" method="post">
                                        <input type="text" name="name" class="form-control" value="<?= $parent_row['parent_name'] ?>">
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-primary m-2 update" id="age-update" name="name-update">Update</button>
                                    <button class="btn btn-sm btn-primary m-2" id="name-cancel">Cancel</button>
                                </div>
            </form>
        </div>
        </td>
        </tr>
        <tr>
            <th> Email </th>
            <td><?= $parent_row['parent_email'] ?></td>
        </tr>
        <tr>
        <tr>
            <th> CNIC </th>
            <td>
                <div class="d-flex justify-content-between">
                    <span class="mr-2"> <?= $parent_row['cnic'] ?> </span>
                    <span class="btn btn-warning" id="cnic-edit"><i class="fa fa-edit"></i></span>
                </div>
                <div class="d-flex justify-content-start d-none" id="cnic">
                    <div class="form-group">
                        <form action="" method="post">
                            <input type="text" name="cnic" class="form-control" value="<?= $parent_row['cnic'] ?>">
                    </div>
                    <div>
                        <button class="btn btn-sm btn-primary m-2 update" id="age-update" name="cnic-update">Update</button>
                        <button class="btn btn-sm btn-primary m-2" id="cnic-cancel">Cancel</button>
                    </div>
                    </form>
                </div>
            </td>
        </tr>
        </table>
        </form>
    </div>
</div>
</div>


<?php
if (isset($_POST['name-update'])) {
    $name = $_POST['name'];
    $name_sql = "UPDATE `parent` SET parent_name = '$name'  WHERE parent_id = '$parent_id'";
    if ($conn->query($name_sql)) {
        ?>
        <script>
        $(document).ready(function() {
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Parent Name has been Updated Successfully!',
                    icon: 'success'
                }).then(() => {
                        window.location.href = 'index.php?parent_profile';
                });
            })
        });
        </script>
        <?php
            } else {
            ?>
        <script>
        $(document).ready(function() {
            Swal.fire('Oops!', 'Parent Name has not been Updated', 'error');
        });
        </script>
        <?php
            }
}
if (isset($_POST['cnic-update'])) {
    $cnic = $_POST['cnic'];
    $cnic_sql = "UPDATE `parent` SET cnic = '$cnic'  WHERE parent_id = '$parent_id'";
    if ($conn->query($cnic_sql)) {
        ?>
        <script>
        $(document).ready(function() {
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Parent CNIC has been Updated Successfully!',
                    icon: 'success'
                }).then(() => {
                        window.location.href = 'index.php?parent_profile';
                });
            })
        });
        </script>
        <?php
            } else {
            ?>
        <script>
        $(document).ready(function() {
            Swal.fire('Oops!', 'Parent CNIC has not been Updated', 'error');
        });
        </script>
        <?php
            }
}
?>

<script>
    $(document).ready(function() {
        $("#name-edit").click(function(e) {
            $("#name").removeClass('d-none');
        });
        $("#name-cancel").click(function(e) {
            $("#name").addClass('d-none');
        });

        $("#cnic-edit").click(function(e) {
            $("#cnic").removeClass('d-none');
        });
        $("#cnic-cancel").click(function(e) {
            $("#cnic").addClass('d-none');
        });


    });

</script>