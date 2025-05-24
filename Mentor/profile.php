<?php
include "./navbar.php";

$email = $_SESSION["memail"];

$res = $conn->query("SELECT * FROM mentor WHERE email='$email'");

if ($res->num_rows == 1) {
    $data = $res->fetch_assoc();

    $firstname = $data["fname"];
    $lastname = $data["lname"];
    $dob = $data["dob"];
    $menid = $data["menid"];
    $dp = $data["dp"];
    $designation = $data["designation"];
}

$res1 = $conn->query("SELECT * FROM registration WHERE email='$email'");

if ($res1->num_rows == 1) {
    $data = $res1->fetch_assoc();

    $reg_id = $data["id"];
}

if (isset($_POST["updateprofile"])) {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $newdob = $_POST["dob"];
    $dir = "../profile_picture/";
    $image = $dir . $_FILES["image"]["name"];

    if (isset($_POST["designation"])) {
        $designation = $_POST["designation"];
    } else {
        $designation = NULL;
    }

    if ($_FILES["image"]["name"] == "") {
        $image = $dp;
    } else {
        $image = $dir . $_FILES["image"]["name"];
    }

    $reg = "UPDATE registration SET fname='$fname', lname='$lname', dob='$newdob' WHERE id=$reg_id";
    $conn->query($reg);



    $update = "UPDATE mentor SET fname='$fname', lname='$lname', dob='$newdob', designation='$designation', dp='$image' WHERE menid=$menid";

    if ($conn->query($update)) {
        move_uploaded_file($_FILES["image"]["tmp_name"], $image);
        $_SESSION["ok"] = "ok";
    }
    header("Refresh: 0");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Mentor Profile</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <style>
        .circle {
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <?php
        if (isset($_SESSION["ok"])) {
        ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Profile Updated Successfully</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        } else {
        ?>

        <?php
        }

        ?>
        <div class="card">
            <div class="card-header bg-success">
                <h3 class="text-white">Mentor Profile</h3>
            </div>
            <div class="card-body">
                <form class="row g-3" action="./profile.php" method="post" enctype="multipart/form-data">
                    <div class="col-md-12 d-flex justify-content-center">
                        <img src="<?php if ($dp == NULL) {
                                        echo "../Assets/images/user_avatar.png";
                                    } else {
                                        echo $dp;
                                    } ?>" height="200" width="200" class="circle">
                    </div>
                    <div class="col-md-6">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" name="fname" id="fname" class="form-control" value="<?php echo $firstname; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="lname" class="form-label">Last name</label>
                        <input type="text" name="lname" id="lname" class="form-control" value="<?php echo $lastname; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" name="dob" id="dob" class="form-control" value="<?php echo $dob; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address</label>
                        <input disabled type="email" name="email" id="email" class="form-control" value="<?php echo $email; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="designation" class="form-label">Select the Designation</label>
                        <select name="designation" id="designation" class="form-select">

                            <?php
                            if ($designation == NULL) {
                            ?>
                                <option disabled selected>Choose the designation</option>
                                <option value="HOD">Head of the Department</option>
                                <option value="Assistant Professor">Assistant Professor</option>
                                <option value="Associate Professor">Associate Professor</option>
                            <?php
                            } else {
                            ?>
                                <option value="<?php echo $designation; ?>"><?php echo $designation; ?></option>
                                <option value="HOD">Head of the Department</option>
                                <option value="Assistant Professor">Assistant Professor</option>
                                <option value="Associate Professor">Associate Professor</option>
                            <?php
                            }
                            ?>

                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="image" class="form-label">Upload the profile picture</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <input type="submit" value="update" name="updateprofile" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>