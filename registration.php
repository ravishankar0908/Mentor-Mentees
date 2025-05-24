<?php
include "./Database/database.php";

if ($conn->connect_error) {
    echo "not connected";
} else {
    if (isset($_POST["submit"])) {

        $fname = $_POST["fname"];

        if (isset($_POST["lname"])) {
            $lname = $_POST["lname"];
        } else {
            $lname = "NULL";
        }
        $dob = $_POST["dob"];
        $email = $_POST["email"];
        $pass = $_POST["pass"];
        $cpass = $_POST["cpass"];
        $gender = $_POST["gender"];

        $enode_pass = password_hash($pass, PASSWORD_DEFAULT);
        $encode_cpass = password_hash($cpass, PASSWORD_DEFAULT);


        $select = "SELECT email FROM registration WHERE email='$email'";

        $res = $conn->query($select);
        if ($res->num_rows > 0) {
?>
            <script>
                alert("Email is Already Registered.Try a different one.")
                window.location.replace("./registration.php");
            </script>
<?php

            exit("Email is already registered.");
        } else {

            if (isset($_POST["category"])) {
                $category = 1; //Students
                $conn->query("INSERT INTO students(fname,lname,dob,gender,email) VALUES('$fname','$lname','$dob','$gender','$email')");
            } else {
                $category = 0; //Mentor
                $conn->query("INSERT INTO mentor(fname,lname,dob,gender,email) VALUES('$fname','$lname','$dob','$gender','$email')");
            }

            $insert = "INSERT INTO registration(fname,lname,dob,email,pass,cpass,category) VALUES('$fname','$lname','$dob','$email','$enode_pass','$encode_cpass','$category')";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Registration Page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="./Assets/images/logo.png" type="image/x-icon">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

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

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-4 shadow">
            <?php

            if (isset($_POST["submit"])) {

                if ($conn->query($insert)) {
            ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Registration Successfull</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                } else {
                ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Registration not Successfull.</strong>Try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            <?php
                }
            }
            ?>

            <div id="error" class="">

            </div>

            <div class="col-md-6 d-flex left-box justify-content-center flex-column align-items-center">
                <div class="login-image mb-3 mt-3">
                    <img src="./Assets/images/login_page_image.jpg" alt="login image!" class="img-fluid rounded-5">
                </div>
            </div>

            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
                <form action="./registration.php" method="POST" id="form">
                    <div class="row mb-3 w-100">
                        <div class="text-center mb-3">
                            <h3>Register Here!</h3>
                            <p>Welcome to the new world</p>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" required>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class=" mb-2">
                                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name">
                            </div>

                        </div>
                    </div>

                    <div class="row mb-3 w-100">
                        <div class="col-md-6">
                            <div class=" mb-2">
                                <input type="date" class="form-control" id="dob" name="dob">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class=" mb-2">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email id">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 w-100">
                        <div class="col-md-6">
                            <div class=" mb-2">
                                <input type="password" class="form-control" id="pass" name="pass" placeholder="Password">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class=" mb-2">
                                <input type="password" class="form-control" id="cpass" name="cpass" placeholder="Confirm-password">
                            </div>
                        </div>
                    </div>


                    <div class="row mb-3 w-100">
                        <div class="col-md-12">
                            <label for="">Select your Gender</label>
                            <div class="col-md-12" id="genders">
                                <div class="form-check mt-2 form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                                    <label class="form-check-label" for="male">Male</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                    <label class="form-check-label" for="female">Female</label>
                                </div>

                                <div class="form-check mb-3 form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="others" value="others">
                                    <label class="form-check-label" for="others">Others</label>
                                </div>
                            </div>
                            <label for="gender" class="error"></label>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3 w-100">
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="form-check">
                                    <input type="checkbox" name="category" id="category" class="form-check-input">
                                    <label for="category" class="form-check-label text-secondary">click if you are an student not mentor</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="input-group">
                                <div class="form-check">
                                    <input type="checkbox" name="spass" id="spass" class="form-check-input" onclick="ShowPassword()">
                                    <label for="spass" class="form-check-label text-secondary">Show password</label>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3 d-grid gap-2">
                            <input type="submit" value="Register" class="btn btn-primary" name="submit">
                        </div>
                    </div>

                    <div class="row">
                        <p>Already have an account? <a href="./index.php">Sign in!</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <script src="./js/lib/jquery.js"></script>
    <script src="./js/dist/jquery.validate.js"></script>
    <!-- Bootstrap JavaScript Libraries -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {

            $("#form").validate({
                rules: {
                    fname: "required",
                    lname: "required",
                    email: {
                        required: true,
                        email: true
                    },
                    dob: {
                        required: true,

                    },
                    pass: {
                        required: true,
                        minlength: 6,
                    },
                    cpass: {
                        required: true,
                        minlength: 6,
                        equalTo: "#pass"
                    },
                    gender: "required"
                },
                messages: {
                    fname: "Please enter the first name",
                    lname: "Please enter the first name",
                    email: {
                        required: "Please enter the email address",
                        email: "Please enter Valid email address"
                    },
                    dob: {
                        required: "please Select the dob",

                    },
                    pass: {
                        required: "please enter the password",
                        minlength: "please enter minimum 6 characters"

                    },
                    cpass: {
                        required: "please enter the confirm password",
                        minlength: "please enter minimum 6 characters",
                        equalTo: "password mis-matching"
                    },
                    gender: "Please select your gender"
                }
            })
        })
    </script>

    <script>
        var pass = document.getElementById('pass')
        var cpass = document.getElementById('cpass')
        var spass = document.getElementById('spass')

        function ShowPassword() {
            if (spass.checked) {
                pass.type = "text"
                cpass.type = "text"
            } else {
                pass.type = "password"
                cpass.type = "password"
            }
        }
    </script>
</body>

</html>