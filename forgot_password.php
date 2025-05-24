<?php
session_start();
include "./database/database.php";
if (isset($_SESSION["student"]) || isset($_SESSION["mentor"])) {
    if (isset($_SESSION["student"])) {
        $email = $_SESSION["semail"];
    } else if (isset($_SESSION["mentor"])) {
        $email = $_SESSION["memail"];
    }



    $res = $conn->query("SELECT * FROM registration WHERE email='$email'");
    if ($res->num_rows == 1) {
        $data = $res->fetch_assoc();
        $_SESSION["val"] = $data["email"];
    }
}

if (isset($_POST["change"])) {
    $email = $_POST["email"];
    $newpass = $_POST["newpass"];
    $cnewpass = $_POST["cnewpass"];

    // echo $email;
    $encode_pass = password_hash($newpass, PASSWORD_DEFAULT);
    $encode_cpass = password_hash($cnewpass, PASSWORD_DEFAULT);

    $update = "UPDATE registration SET pass= '$encode_pass', cpass='$encode_cpass' WHERE email='$email'";
    $_SESSION["success"] = "success";

    if ($conn->query($update)) {
        $_SESSION["message"] = "password updated succesfully";
        $_SESSION["color"] = "alert-success";
        if (isset($_SESSION["student"])) {
            header("Location: ./Student/change_password.php");
            exit();
        } else if (isset($_SESSION["mentor"])) {
            header("Location: ./Mentor/change_password.php");
            exit();
        } else {
            header("Location: ./index.php");
            exit();
        }
    } else {
        $_SESSION["message"] = "Error ocurred";
        $_SESSION["color"] = "alert-danger";

        if (isset($_SESSION["student"])) {
            header("Location: ./Student/change_password.php");
            exit();
        } else if (isset($_SESSION["mentor"])) {
            header("Location: ./Mentor/change_password.php");
            exit();
        } else {
            header("Location: ./index.php");
            exit();
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Forgot Password</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="shortcut icon" href="./images/favicon.png" type="image/x-icon">
    <style>
        .vh-80 {
            height: 80vh;
        }

        .error {
            color: red;
        }

        label.error {
            font-size: small;
        }

        input.error {
            border: 1px solid red;
        }

        textarea.error {
            border: 1px solid red;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center vh-80 ">
            <div class="col-xs-6 col-md-8">
                <?php
                if (isset($_SESSION["success"])) {
                ?>
                    <div class="alert <?php echo $_SESSION["color"]; ?> alert-dismissible fade show" role="alert">
                        <strong><?php echo $_SESSION["message"]; ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                    unset($_SESSION["success"]);
                    unset($_SESSION["message"]);
                    unset($_SESSION["color"]);
                }
                ?>
                <form action="./forgot_password.php" method="post" id="changepass">
                    <div class="card shadow">
                        <div class="card-header bg-secondary">
                            <h3 class="text-white">Forgot Password</h3>
                        </div>
                        <div class="card-body">
                            <label for="email" class="form-label">Enter your Email id</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter the Email address" value="<?php if (isset($_SESSION["val"])) {
                                                                                                                                                echo $_SESSION["val"];
                                                                                                                                            } ?>">
                            <br>
                            <label for="newpass" class="form-label">Enter new password</label>
                            <input type="password" name="newpass" id="newpass" class="form-control" placeholder="Enter the new password">
                            <br>
                            <label for="cnewpass" class="form-label">Enter confirm new password</label>
                            <input type="password" name="cnewpass" id="cnewpass" class="form-control" placeholder="Enter confirm new password">
                            <br>
                            <input type="checkbox" name="showpass" id="showpass" class="form-check-input" onclick="Showpassword()">
                            <label for="showpass">Show password</label>
                        </div>
                        <div class="card-footer">
                            <input type="submit" name="change" value="change" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="./js/lib/jquery.js"></script>
    <script src="./js/dist/jquery.validate.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $("#changepass").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    newpass: {
                        required: true,
                        minlength: 6
                    },
                    cnewpass: {
                        required: true,
                        minlength: 6,
                        equalTo: "#newpass"
                    },

                },
                messages: {
                    email: {
                        required: "please fill the Email address",
                        email: "Please enter valid email"
                    },
                    newpass: {
                        required: "please fill the new password",
                        minlength: "Please enter 6 character atleast"
                    },
                    cnewpass: {
                        required: "please fill the confirm new password",
                        minlength: "Please enter 6 character atleast",
                        equalTo: "Passwords are mis-matching"
                    },

                }
            })
        })
    </script>

    <script>
        var showpass = document.getElementById("showpass")
        var newpass = document.getElementById("newpass")
        var cnewpass = document.getElementById("cnewpass")

        function Showpassword() {
            if (showpass.checked) {

                newpass.type = "text";
                cnewpass.type = "text";
            } else {

                newpass.type = "password";
                cnewpass.type = "password";
            }
        }
    </script>
</body>

</html>