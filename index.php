<?php
include "./Database/database.php";
session_start();

if ($conn->connect_error) {
    echo "Not Connected";
} else {
    if (isset($_POST["login"])) {
        $email = $_POST["username"];
        $password = $_POST["password"];

        $select = "SELECT * FROM registration WHERE email='$email'";
        $res = $conn->query($select);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="./Assets/images/logo.png" type="image/x-icon">
    <style>
        .error {
            color: red;
        }

        label.error {
            font-size: small;
        }

        input.error {
            border: 1px solid red
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100 ">
        <div class="row border rounded-5 p-4 shadow">

            <?php
            if (isset($_POST["login"])) {
                if ($res->num_rows > 0) {
                    $data = $res->fetch_assoc();

                    if (password_verify($password, $data['pass'])) {
                        // print_r(gettype($data["category"]));
                        if ($data['category'] === "1") {
                            $_SESSION["student"] = "student";
                            $_SESSION["semail"] = $data["email"];
                            $_SESSION["stuwelcome"] = "yes";
                            $_SESSION["name"] = $data["fname"] . " " . $data["lname"];
                            header("Location: ./Student/home.php");
                        } else if ($data['category'] === "0") {
                            $_SESSION["mentor"] = "mentor";
                            $_SESSION["memail"] = $data["email"];
                            $_SESSION["menwelcome"] = "yes";
                            header("Location: ./Mentor/Mentor.php");
                        }
                    } else {
            ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Invalid Password.</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Invalid Email address.</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            <?php
                }
            }
            ?>

            <!-- Left box -->
            <div class="col-md-6 d-flex left-box justify-content-center flex-column align-items-center">
                <div class="login-image mb-3 mt-3">
                    <img src="./Assets/images/login_page_image.jpg" alt="login image!" class="img-fluid rounded-5">
                </div>
            </div>

            <!-- right box -->

            <div class="col-md-6 right-box d-flex justify-content-center align-items-center">
                <form action="./index.php" method="POST" id="loginform">
                    <div class="row">
                        <div class="login-image mb-4">
                            <img src="./Assets/images/login_page_2.jpg" alt="image" class="img-fluid rounded-5">
                        </div>
                        <div class="text-center header-text mb-">
                            <h1>Login Here!</h1>
                            <p>We are happy to have you back.</p>
                        </div>

                        <div class="mb-4">
                            <input type="email" name="username" id="username" class="form-control form-control-lg bg-light" placeholder="Enter Your Email Id">
                        </div>
                        <div class="mb-4">
                            <input type="password" name="password" id="password" class="form-control form-control-lg bg-light" placeholder="Enter the Password">
                        </div>

                        <div class="input-group mb-4 d-flex justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input" onclick="ShowPassword()">
                                <label for="remember" class="form-check-label text-secondary">Show password</label>
                            </div>
                            <div class="forgot-password">
                                <a href="./forgot_password.php">Forgot Password?</a>
                            </div>
                        </div>

                        <div class="input-group mb-4 d-grid gap-2">
                            <input type="submit" value="Login" class="btn btn-primary" name="login">
                        </div>

                        <div class="row">
                            <p>Don't Have an account? <a href="./registration.php">Sign up!</a></p>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="./js/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {

        $("#loginform").validate({
            rules: {
                username: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },

            messages: {
                username: "please enter the email id",
                password: {
                    required: "Please enter the password",
                    minlength: "Please enter minimum 6 characters"
                }
            }
        })
    })
</script>

<script>
    var password = document.getElementById('password') //password input box
    var show = document.getElementById('remember') //check box

    function ShowPassword() {
        if (show.checked) {
            password.type = "text"
        } else {
            password.type = "password"
        }
    }
</script>

</html>