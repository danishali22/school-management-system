<style>
    .d-none {
        display: none !important;
    }
</style>

<div class="row col-md-8 mx-auto my-5">
    <div class="container">
        <?php
        $teacher_id = $_SESSION['teacher_id'];
        $teacher_sql = "SELECT * FROM `teachers` WHERE teacher_id='$teacher_id'";
        $teacher_result = $conn->query($teacher_sql);
        $sno = 1;
        $teacher_row = $teacher_result->fetch_assoc();
        ?>
        <h1 class="text-center fs-1 bg-primary bg-gradient p-2 mt-3 my-heading">Teacher Profile</h1>
        <div class="card shadow mt-3">
            <form method="post" enctype='multipart/form-data'>
                <table class="table mb-5 table-bordered">
                    <tr>
                        <th> Name </th>
                        <td>
                            <div class="d-flex justify-content-between">
                                <span class="mr-2"> <?= $teacher_row['teacher_name'] ?> </span>
                                <span class="btn btn-warning" id="name-edit"><i class="fa fa-edit"></i></span>
                            </div>
                            <div class="d-flex justify-content-start d-none" id="name">
                                <div class="form-group">
                                    <form action="" method="post">
                                        <input type="text" name="name" class="form-control" value="<?= $teacher_row['teacher_name'] ?>">
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
            <td><?= $teacher_row['teacher_email'] ?></td>
        </tr>
        <tr>
            <th> DOB </th>
            <td>
                <div class="d-flex justify-content-between">
                    <span class="mr-2"> <?= $teacher_row['teacher_dob'] ?> </span>
                    <span class="btn btn-warning" id="dob-edit"><i class="fa fa-edit"></i></span>
                </div>
                <div class="d-flex justify-content-start d-none" id="dob">
                    <div class="form-group">
                        <form action="" method="post">
                            <input type="date" name="dob" class="form-control" value="<?= $teacher_row['teacher_dob'] ?>">
                    </div>
                    <div>
                        <button class="btn btn-sm btn-primary m-2 update" id="age-update" name="dob-update">Update</button>
                        <button class="btn btn-sm btn-primary m-2" id="dob-cancel">Cancel</button>
                    </div>
                    </form>
                </div>
            </td>
        </tr>
        <tr>
            <th> Subject </th>
            <td>
                <?php
                $subject_id = $teacher_row['teacher_subject'];
                $fetch_subject_sql = "SELECT subject_name FROM subject WHERE subject_id = '$subject_id' ";
                $subject_result = $conn->query($fetch_subject_sql);
                $fetch_subject_row = $subject_result->fetch_assoc();
                echo $fetch_subject_row['subject_name'];
                ?>
            </td>
        </tr>
        <tr>
            <th> Phone </th>
            <td>
                <div class="d-flex justify-content-between">
                    <span class="mr-2"> <?= $teacher_row['teacher_phone'] ?> </span>
                    <span class="btn btn-warning" id="phone-edit"><i class="fa fa-edit"></i></span>
                </div>
                <div class="d-flex justify-content-start d-none" id="phone">
                    <div class="form-group">
                        <form action="" method="post">
                            <input type="text" name="phone" class="form-control" value="<?= $teacher_row['teacher_phone'] ?>">
                    </div>
                    <div>
                        <button class="btn btn-sm btn-primary m-2 update" id="phone-update" name="phone-update">Update</button>
                        <button class="btn btn-sm btn-primary m-2" id="phone-cancel">Cancel</button>
                    </div>
                    </form>
                </div>
            </td>
        </tr>
        <tr>
            <th> Address </th>
            <td>
                <div class="d-flex justify-content-between">
                    <span class="mr-2"> <?= $teacher_row['teacher_address'] ?> </span>
                    <span class="btn btn-warning" id="address-edit"><i class="fa fa-edit"></i></span>
                </div>
                <div class="d-flex justify-content-start d-none" id="address">
                    <div class="form-group">
                        <form action="" method="post">
                            <input type="text" name="address" class="form-control" value="<?= $teacher_row['teacher_address'] ?>">
                    </div>
                    <div>
                        <button class="btn btn-sm btn-primary m-2 update" id="age-update" name="address-update">Update</button>
                        <button class="btn btn-sm btn-primary m-2" id="address-cancel">Cancel</button>
                    </div>
                    </form>
                </div>
            </td>
        </tr>
        <tr>
            <th> Age </th>
            <td>
                <div class="d-flex justify-content-between">
                    <span class="mr-2"> <?= $teacher_row['teacher_age'] ?> </span>
                    <span class="btn btn-warning" id="age-edit"><i class="fa fa-edit"></i></span>
                </div>
                <div class="d-flex justify-content-start d-none" id="age">
                    <div class="form-group">
                        <form action="" method="post">
                            <input type="text" name="age" class="form-control" value="<?= $teacher_row['teacher_age'] ?>">
                    </div>
                    <div>
                        <button class="btn btn-sm btn-primary m-2 update" id="age-update" name="age-update">Update</button>
                        <button class="btn btn-sm btn-primary m-2" id="age-cancel">Cancel</button>
                    </div>
                    </form>
                </div>
            </td>
        </tr>
        <tr>
            <th> Gender </th>
            <td><?= $teacher_row['teacher_gender'] ?></td>
        </tr>
        </table>
        </form>
    </div>
</div>
</div>


<?php
if (isset($_POST['name-update'])) {
    $name = $_POST['name'];
    $name_sql = "UPDATE `teachers` SET teacher_name = '$name'  WHERE teacher_id = '$teacher_id'";
    if ($conn->query($name_sql)) {
        ?>
        <script>
        $(document).ready(function() {
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Teacher Name has been Updated Successfully!',
                    icon: 'success'
                }).then(() => {
                        window.location.href = 'index.php?teacher_profile';
                });
            })
        });
        </script>
        <?php
            } else {
            ?>
        <script>
        $(document).ready(function() {
            Swal.fire('Oops!', 'Teacher Name has not been Updated', 'error');
        });
        </script>
        <?php
            }
}
if (isset($_POST['dob-update'])) {
    $dob = $_POST['dob'];
    $dob_sql = "UPDATE `teachers` SET teacher_dob = '$dob'  WHERE teacher_id = '$teacher_id'";
    if ($conn->query($dob_sql)) {
        ?>
        <script>
        $(document).ready(function() {
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Teacher DOB has been Updated Successfully!',
                    icon: 'success'
                }).then(() => {
                        window.location.href = 'index.php?teacher_profile';
                });
            })
        });
        </script>
        <?php
            } else {
            ?>
        <script>
        $(document).ready(function() {
            Swal.fire('Oops!', 'Teacher DOB has not been Updated', 'error');
        });
        </script>
        <?php
            }
}
if (isset($_POST['phone-update'])) {
    $phone = $_POST['phone'];
    $phone_sql = "UPDATE `teachers` SET teacher_phone = '$phone'  WHERE teacher_id = '$teacher_id'";
    if ($conn->query($phone_sql)) {
        ?>
        <script>
        $(document).ready(function() {
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Teacher Phone has been Updated Successfully!',
                    icon: 'success'
                }).then(() => {
                        window.location.href = 'index.php?teacher_profile';
                });
            })
        });
        </script>
        <?php
            } else {
            ?>
        <script>
        $(document).ready(function() {
            Swal.fire('Oops!', 'Teacher Phone has not been Updated', 'error');
        });
        </script>
        <?php
            }
}
if (isset($_POST['address-update'])) {
    $address = $_POST['address'];
    $address_sql = "UPDATE `teachers` SET teacher_address = '$address'  WHERE teacher_id = '$teacher_id'";
    if ($conn->query($address_sql)) {
        ?>
        <script>
        $(document).ready(function() {
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Teacher Address has been Updated Successfully!',
                    icon: 'success'
                }).then(() => {
                        window.location.href = 'index.php?teacher_profile';
                });
            })
        });
        </script>
        <?php
            } else {
            ?>
        <script>
        $(document).ready(function() {
            Swal.fire('Oops!', 'Teacher Address has not been Updated', 'error');
        });
        </script>
        <?php
            }
}
if (isset($_POST['age-update'])) {
    $age = $_POST['age'];
    $age_sql = "UPDATE `teachers` SET teacher_age = '$age'  WHERE teacher_id = '$teacher_id'";
    if ($conn->query($age_sql)) {
        ?>
        <script>
        $(document).ready(function() {
            $(document).ready(function() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'Teacher Age has been Updated Successfully!',
                    icon: 'success'
                }).then(() => {
                        window.location.href = 'index.php?teacher_profile';
                });
            })
        });
        </script>
        <?php
            } else {
            ?>
        <script>
        $(document).ready(function() {
            Swal.fire('Oops!', 'Teacher Age has not been Updated', 'error');
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

        $("#dob-edit").click(function(e) {
            $("#dob").removeClass('d-none');
        });
        $("#dob-cancel").click(function(e) {
            $("#dob").addClass('d-none');
        });

        $("#phone-edit").click(function(e) {
            $("#phone").removeClass('d-none');
        });
        $("#phone-cancel").click(function(e) {
            $("#phone").addClass('d-none');
        });

        $("#address-edit").click(function(e) {
            $("#address").removeClass('d-none');
        });
        $("#address-cancel").click(function(e) {
            $("#address").addClass('d-none');
        });

        $("#age-edit").click(function(e) {
            $("#age").removeClass('d-none');
        });
        $("#age-cancel").click(function(e) {
            $("#age").addClass('d-none');
        });


    });

</script>