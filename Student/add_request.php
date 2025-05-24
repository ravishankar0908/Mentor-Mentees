<?php
include "./navbar.php";

$email = $_SESSION["semail"];

$res = $conn->query("SELECT * FROM students WHERE email='$email'");

if ($res->num_rows == 1) {
    $data = $res->fetch_assoc();

    $stuid = $data["stuid"];
    $stuname = $data["fname"] . " " . $data["lname"];
}

if (isset($_POST["send"])) {
    $from = $_POST["from"];

    if (isset($_POST["to"]) && $_POST["to"] != "others") {
        $to = $_POST["to"];
    } else if (isset($_POST["newto"])) {
        $to = $_POST["newto"];
    }

    $collegename = $_POST["college"];
    $city = $_POST["city"];
    $zipcode = $_POST["zip"];
    $year = $_POST["year"];
    $subject = $_POST["sub"];
    $message = $_POST["message"];
    $request_date = date("Y-m-d");




    $_SESSION["success"] = "ok";

    if ($from === "" || $to === "" || $subject === "" || $message === "" || $request_date === "" || $collegename == "" || $city == "" || $zipcode == "" || $year == "") {
        $_SESSION["message"] = "Fill All the Fields";
        $_SESSION["color"] = "danger";
    } else {

        $insert = "INSERT INTO request(fromname,toname,subjects,messages,stuid,request_date,collegename,city,zipcode,years) VALUES('$from','$to','$subject','$message',$stuid,'$request_date','$collegename','$city',$zipcode,'$year')";


        if ($conn->query($insert)) {
            $_SESSION["message"] = "Request Added Successfully";
            $_SESSION["color"] = "success";
        } else {
            $_SESSION["message"] = "Error occurred";
            $_SESSION["color"] = "danger";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Request Page</title>
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
            <h3>Add Request</h3>
            <hr>
            <div class="d-flex">
                <div class="col-md-4">

                    <?php
                    if (isset($_SESSION["success"])) {
                    ?>
                        <div class="alert alert-<?php echo $_SESSION["color"]; ?> alert-dismissible fade show" role="alert">
                            <strong><?php echo $_SESSION["message"]; ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                        unset($_SESSION["success"]);
                        unset($_SESSION["message"]);
                        unset($_SESSION["color"]);
                    }
                    ?>

                    <form action="" method="post" id="requestform">
                        <div class="card shadow">
                            <div class="card-header bg-primary">
                                <h5 class="text-white">Add Request Form</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div>
                                        <label for="from" class="form-label">From</label>
                                        <input type="text" id="from" name="from" class="form-control" placeholder="From Name" value="<?php echo $stuname; ?>">
                                    </div>
                                    <div id="selects">
                                        <label for="to" class="form-label">To</label>
                                        <select name="to" id="to" class="form-select" id="to">
                                            <option selected disabled>Select the receiver</option>
                                            <option value="Class Adviser">Class Adviser</option>
                                            <option value="HOD">Head of the Department</option>
                                            <option value="Principal">Principal</option>
                                            <option value="CEO">CEO</option>
                                            <option value="Dean">Dean</option>
                                            <option value="others">others... </option>
                                        </select>
                                    </div>

                                    <div id="text_box" style="display: none;">
                                        <label for="to" class="form-label">To</label>
                                        <input type="text" id="newto" name="newto" class="form-control" placeholder="To Name">
                                    </div>

                                    <div>
                                        <label for="year" class="form-label">Select the Year Studying</label>
                                        <select name="year" id="year" class="form-select">
                                            <option selected disabled>Select the year of studying</option>
                                            <option value="1st year">1st year</option>
                                            <option value="2st year">2st year</option>
                                            <option value="3st year">3st year</option>
                                            <option value="4st year">4st year</option>

                                        </select>
                                    </div>

                                    <div>
                                        <label for="sub" class="form-label">Enter the Subjects</label>
                                        <select name="sub" id="sub" class="form-select">
                                            <option selected disabled>Select the Subjects</option>
                                            <option value="Bonafide certificate for passport verfication">Bonafide certificate for passport verfication</option>
                                            <option value="Bonafide certficate for applying loan">Bonafide certficate for applying loan</option>
                                            <option value="Bonafide certficate for applying Scholarships">Bonafide certficate for applying Scholarships</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="college" class="form-label">Enter the College name</label>
                                        <input type="text" id="college" name="college" class="form-control" placeholder="College Name">
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-8">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" id="city" name="city" class="form-control" placeholder="Enter City">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="zip" class="form-label">Zip code</label>
                                            <input type="number" id="zip" name="zip" class="form-control" placeholder="Zip Code">
                                        </div>
                                    </div>

                                    <div>
                                        <label for="message" class="form-label">Comments regarding the certificate</label>
                                        <textarea class="form-control" name="message" id="message" cols="30" rows="3" placeholder="Comments..."></textarea>
                                    </div>
                                    <div>
                                        <input type="submit" value="Send" name="send" class="btn btn-primary w-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-8 mx-3">
                    <table class="table">
                        <thead class="table-secondary">
                            <th>#</th>
                            <th>Request To</th>
                            <th>Subjects</th>
                            <th>Request Date</th>
                            <th>View Letter</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            $res1 = $conn->query("SELECT * FROM request WHERE stuid=$stuid");
                            $total_records = $res1->num_rows;
                            $no_records_per_page = 10;

                            $no_of_pages = ceil($total_records / $no_records_per_page);
                            $page = 1;
                            if (isset($_GET["page"])) {
                                $page = $_GET["page"];
                            }
                            $start_limit = ($page - 1) * $no_records_per_page;
                            if (isset($_GET["count"])) {
                                $count = $_GET['count'];
                                if ($count > $start_limit) {
                                    $count = $start_limit;
                                }
                            }
                            $res1 = $conn->query("SELECT * FROM request WHERE stuid=$stuid LIMIT $start_limit,$no_records_per_page");
                            if ($res1->num_rows > 0) {
                                while ($row = $res1->fetch_assoc()) {
                                    $count++;
                            ?>
                                    <tr>
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $row["toname"]; ?></td>
                                        <td><?php echo $row["subjects"]; ?></td>
                                        <td><?php echo $row["request_date"]; ?></td>
                                        <td><a target="_blank" class="btn btn-sm btn-primary" href="./request_pdf.php?stuid=<?php echo $stuid ?>&requestid=<?php echo $row["requestid"]; ?>">view</a></td>
                                        <?php
                                        if ($row["ack_hod"] == "") {
                                        ?>
                                            <td class="text-warning"><b>Pending</b> </td>
                                        <?php
                                        } else if ($row["ack_hod"] == "approved") {
                                        ?>
                                            <td class="text-success"><b>Accepted </b><a target="_blank" href="./certificate.php?reqid=<?php echo $row["requestid"] ?>">download Your certificate</a></td>
                                        <?php
                                        } else {
                                        ?>
                                            <td class="text-danger"><b>your request is rejected</b> Contact HOD</td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="6" class="text-danger text-center"><b>You does not applied for anything</b></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    for ($i = 1; $i <= $no_of_pages; $i++) {
                    ?>
                        <a href="./add_request.php?page=<?php echo $i ?>&count=<?php echo $count ?>" class="btn btn-success btn-sm"><?php echo $i ?></a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>


    <script src="../js/lib/jquery.js"></script>
    <script src="../js/dist/jquery.validate.js"></script>
    <!-- Bootstrap JavaScript Libraries -->

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $("#requestform").validate({
                rules: {
                    from: "required",
                    to: "required",
                    newto: "required",
                    year: "required",
                    sub: "required",
                    college: "required",
                    city: "required",
                    zip: "required",
                    message: "required"
                },
                messages: {
                    from: "Please fill the from",
                    to: "Please select the To",
                    newto: "Please fill the To",
                    year: "Please select the Year",
                    sub: "Please fill the subject",
                    college: "Please fill the college Details",
                    city: "Please fill the city",
                    zip: "Please fill the the zip code",
                    message: "Please fill the comments"
                }
            })
        })
    </script>

    <script>
        var select = document.getElementById("to");
        var select_field = document.getElementById("selects");
        var text = document.getElementById("text_box");


        select.addEventListener("change", () => {
            if (select.value === "others") {
                select_field.style.display = "none"
                text.style.display = "block"
            } else {
                select_field.style.display = "block"
                text.style.display = "none"
            }
        })
    </script>
</body>

</html>