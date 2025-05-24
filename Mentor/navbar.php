<?php
include "../Database/database.php";
ob_start();
session_start();
$email = $_SESSION["memail"];
$res = $conn->query("SELECT * FROM mentor WHERE email='$email'");
if ($res->num_rows == 1) {
    $data = $res->fetch_assoc();
    $menid = $data["menid"];
    $name = $data["fname"] . " " . $data["lname"];
    $designation = $data["designation"];
}

if (isset($_SESSION["mentor"])) {

?>
    <!doctype html>
    <html lang="en">

    <head>

        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="shortcut icon" href="../Assets/images/logo.png" type="image/x-icon">
        <!-- Bootstrap CSS v5.2.1 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <body>

        <nav class="navbar bg-primary navbar-expand-lg bd-navbar sticky-top">
            <div class="container">

                <a class="navbar-brand text-white" href="#">
                    Mentorship
                </a>

                <button class="navbar-toggler " type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon text-white"></span>
                </button>

                <div class="offcanvas offcanvas-end bg-dark" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title text-white" id="offcanvasNavbarLabel">Mentorship</h5>
                        <button type="button text-white" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 ">
                            <li class="nav-item ">
                                <a class="nav-link text-white" aria-current="page" href="./Mentor.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="./task.php">Add a Task</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-white" href="./my_mentees.php">
                                    Mentees
                                </a>
                            </li>


                            <li class="nav-item dropdown">
                                <a class="nav-link  text-white" href="./students_details.php">
                                    Students
                                </a>

                            </li>





                            <?php
                            if ($designation == "HOD") {
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="./student_letter.php">Students Letter Request</a>
                                </li>
                            <?php
                            }
                            ?>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <b><?php echo $name; ?></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="./profile.php">Profile</a></li>
                                    <li><a class="dropdown-item" href="./change_password.php">Change Password</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                                </ul>
                            </li>

                            <!-- <li class="nav-item">
                                <a href="../logout.php" class="btn btn-danger">Logout</a>
                            </li> -->
                        </ul>
                        <!-- <form class="d-flex mt-5-lg" role="search">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-success" type="submit">Search</button>
                        </form> -->
                    </div>
                </div>

            </div>
        </nav>

        <div class="container mt-3">
            <?php
            if (isset($_SESSION["menwelcome"])) {
            ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
                    <strong>Logged In, Welcome Mr/Mrs. <?php echo $name ?> </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
            unset($_SESSION["menwelcome"]);
            ?>

        </div>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
        <script>
            setTimeout(() => {
                $("#alert").alert("close")
            }, 3000)
        </script>
    </body>

    </html>

<?php
} else {
    header("Location: ../index.php");
    exit();
}
?>