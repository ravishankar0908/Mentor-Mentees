<?php
include("./navbar.php");

$email = $_SESSION["semail"];

$select = $conn->query("SELECT * FROM students WHERE email='$email'");
$data = $select->fetch_assoc();
$stuid = $data["stuid"];
$studentname = $data["fname"] . " " . $data["lname"];

if (isset($_GET["menid"])) {
    $menid = $_GET["menid"];

    $res = $conn->query("SELECT * FROM mentor WHERE menid=$menid");
    if ($res->num_rows == 1) {
        $data = $res->fetch_assoc();

        $mentorname = $data["fname"] . " " . $data["lname"];
    }
}

if (isset($_POST["send"])) {
    $stuid = $_POST["stuid"];
    $menid = $_POST["menid"];
    $sendby = $_POST["sendby"];
    $message = $_POST["message"];
    date_default_timezone_set("Asia/Kolkata");
    $dateandtime = date("Y-m-d h:i:s");

    $insert = "INSERT INTO feedback(stuid,menid,feedbacks,sentdetails,sendby) VALUES($stuid,$menid,'$message','$dateandtime','$sendby')";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Mentees Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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

    <div class="container">
        <div class="row">

            <?php
            if (isset($_POST["send"])) {
                if ($conn->query($insert)) {
            ?>
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>successfull inserted.</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                <?php
                    header("Location: ./feed_back.php?menid=$menid");
                } else {
                ?>
                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Not inserted.</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
            <?php
                    header("Location: ./feed_back.php?menid=$menid");
                }
            }
            ?>

            <div class="col-md-6">
                <form action="./feed_back.php" method="post" id="feedback_form">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h3>Mentees Feedback</h3>
                        </div>
                        <div class="card-body">
                            <input type="hidden" class="form-control" name="stuid" id="stuid" value="<?php echo $stuid; ?>">

                            <input type="hidden" class="form-control" name="menid" id="menid" value="<?php echo $menid; ?>">

                            <input type="hidden" class="form-control" name="sendby" id="sendby" value="mentees">

                            <div class="">
                                <label for="" class="form-label">Mentor Name</label>
                                <input type="text" name="mentorname" id="mentorname" class="form-control" placeholder="Student's Name" value="<?php echo $mentorname ?>" disabled>
                            </div>
                            <div class="mt-3">
                                <label class="form-label" for="message">Enter the Message / Feedback</label>
                                <textarea name="message" id="message" class="form-control" placeholder="Message / Feedback" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="submit" class="btn btn-primary" name="send" id="send" value="Send">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <thead class="table-secondary">
                        <tr>
                            <th>#</th>
                            <th>Message / feed back</th>
                            <th>sent details times</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $res1 = $conn->query("SELECT * FROM feedback WHERE stuid=$stuid AND menid=$menid");
                        $total_records = $res1->num_rows;
                        $no_records_per_page = 15;

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
                        $res = $conn->query("SELECT * FROM feedback WHERE stuid=$stuid AND menid=$menid ORDER BY sentdetails DESC LIMIT $start_limit, $no_records_per_page");
                        if ($res->num_rows > 0) {
                            while ($row = $res->fetch_assoc()) {
                                $count++;
                        ?>
                                <tr>
                                    <td><?php echo $count ?></td>
                                    <?php
                                    if ($row["sendby"] == "mentor") {
                                    ?>
                                        <td class="text-success"><b><?php echo $row["feedbacks"] ?></b></td>
                                    <?php
                                    } else {
                                    ?>
                                        <td><b><?php echo $row["feedbacks"] ?></b></td>
                                    <?php
                                    }
                                    ?>
                                    <td><?php echo $row["sentdetails"] ?></td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="3" class="text-center text-danger">No records found</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                for ($i = 1; $i <= $no_of_pages; $i++) {
                ?>
                    <a href="./feed_back.php?menid=<?php echo $menid ?>&page=<?php echo $i ?>&count=<?php echo $count ?>" class="btn btn-primary btn-sm"><?php echo $i ?></a>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

</body>
<script src="../js/lib/jquery.js"></script>
<script src="../js/dist/jquery.validate.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>


<script>
    $(document).ready(function() {
        $("#feedback_form").validate({
            rules: {
                message: {
                    required: true,
                    maxlength: 100

                }
            },
            messages: {
                message: {
                    required: "Please enter the message box",
                    maxlength: "Write within 100 characters"
                }
            }
        })
    })
</script>

</html>