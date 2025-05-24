<?php
include "./navbar.php";
?>

<!doctype html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Change Password</title>
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />\

    <style>
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

    <div class="container mt-3">
        <div class="row ">
            <h3>Change Password</h3>
            <hr>
            <div class="d-flex justify-content-center">
                <div class="col-md-6">
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
                    <div class="card shadow">
                        <div class="card-header bg-info">
                            <h3 class="text-white">Change Password</h3>
                        </div>
                        <div class="card-body">
                            <form action="../change_password_db.php" method="post" class="row g-3" id="changepass">
                                <div class="col-md-12">
                                    <label for="oldpass" class="form-label">Enter the Old password.</label>
                                    <input type="password" name="oldpass" id="oldpass" class="form-control" placeholder="Enter the Old password">
                                </div>
                                <div class="col-md-12">
                                    <label for="newpass" class="form-label">Enter the New password.</label>
                                    <input type="password" name="newpass" id="newpass" class="form-control" placeholder="Enter the New password">
                                </div>
                                <div class="col-md-12">
                                    <label for="confirmnewpass" class="form-label">Enter Confirm New password.</label>
                                    <input type="password" name="cnewpass" id="confirmnewpass" class="form-control" placeholder="Enter Confirm New password">
                                </div>
                                <div class="col-md-12 d-flex justify-content-between">

                                    <div>
                                        <input type="checkbox" name="showpass" id="showpass" class="form-check-input" onclick="Showpassword()">
                                        <label for="showpass">Show password</label>

                                    </div>
                                    <a href="../forgot_password.php" class="link">Forgot Password?</a>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" name="change" class="btn btn-primary" value="Change">
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/lib/jquery.js"></script>
    <script src="../js/dist/jquery.validate.js"></script>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $("#changepass").validate({
                rules: {
                    oldpass: {
                        required: true,
                        minlength: 6
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
                    oldpass: {
                        required: "please fill the old password",
                        minlength: "Please enter 6 character atleast"
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
        var cnewpass = document.getElementById("confirmnewpass")

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