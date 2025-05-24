<?php
include "./navbar.php";

$email = $_SESSION["semail"];

$res = $conn->query("SELECT * FROM students WHERE email='$email'");
if ($res->num_rows == 1) {
    $data = $res->fetch_assoc();

    $menid = $data["stuid"];
    $gender = $data["gender"];
}

?>

<!doctype html>
<html lang="en">

<head>
    <title>Student Home Page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <style>
        .img {
            background-image: url("../Assets/images/student-1.jpg");
            transition: transform 0.5s ease;
        }

        .img:hover {
            transform: rotate(360deg);
        }

        .img-1 {
            background-image: url("../Assets/images/student-2.jpeg");
            transition: transform 0.5s ease;
        }

        .img-1:hover {
            transform: rotate(360deg);
        }
    </style>

</head>

<body>
    <div class="container mt-3">


        <div class="row d-flex">
            <div class="col-md-7 justify-content-between">
                <?php
                if ($gender == "male") {
                ?>

                    <h3>Welcome Mr. <?php echo $name ?></h3>
                <?php
                } else {
                ?>
                    <h3>Welcome Mrs. <?php echo $name ?></h3>
                <?php
                }
                ?>
            </div>
        </div>
        <hr>

    </div>


    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <img class="img-fluid mx-auto d-block img rounded" width="800" height="450">

            </div>
            <div class="col-lg-6 ">
                <h1 class="text-center" style="text-decoration: underline;">Motivational Quotes</h1>
                <div class="d-flex justify-content-center align-items-center g-3 h-75">
                    <h1 class="quote">"A little progress each day adds up to big result"</h1>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-lg-6">
                <img class="img-fluid mx-auto d-block img-1 rounded" style="object-fit: fill;" width="900" height="500">

            </div>
            <div class="col-lg-6 ">
                <h1 class="text-center" style="text-decoration: underline;">Motivational Quotes</h1>
                <div class="d-flex justify-content-center align-items-center g-3 h-75">
                    <h1 class="quote">"Teachers can open the but you must enter it yourself"</h1>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>

</html>