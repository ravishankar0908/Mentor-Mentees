<?php
include "./navbar.php";

$email = $_SESSION["memail"];

$select = $conn->query("SELECT * FROM mentor WHERE email='$email'");
$data = $select->fetch_assoc();
$menid = $data["menid"];

// $per_page = 10;
// $newcount = 0;
// $count = 0;
// if (isset($_GET["page"])) {
//     $page_num = $_GET["page"];
// } else {
//     $page_num = 1;
// }

// $start = ($page_num - 1) * 10;


if (isset($_POST['submit'])) {
    // Insert selected values into destination_table
    if (!empty($_POST['mentees'])) {
        foreach ($_POST['mentees'] as $selected) {

            $_SESSION["ok"] = "ok";

            $sql = "INSERT INTO mentormenteeslist (menid,stuid) VALUES ($menid,'$selected')";
            if ($conn->query($sql) === TRUE) {
                $_SESSION["mes"] = "mentees Selected successfully";
                $_SESSION["color"] = "success";
            } else {
                $_SESSION["mes"] = "error occurred";
                $_SESSION["color"] = "danger";
            }
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <title>Student Details</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="container mt-3">

        <form action="./students_details.php" method="post">

            <div class="d-flex justify-content-between">
                <div>
                    <h1>List of the students</h1>

                </div>

                <div class="mt-3 align-items-center d-flex justify-space-between">
                    <div>
                        <input disabled type="submit" value="Get My mentees" id="submit_button" class="btn btn-primary shadow w-100" name="submit">
                    </div>

                    <div>
                        <a target="_blank" class="btn btn-success mx-2" href="./print_student_list.php" class="btn">
                            student <i class="fa-solid fa-print"></i>
                        </a>
                    </div>

                    <div disabled id="counts">

                    </div>

                </div>


            </div>

            <hr>
            <?php
            if (isset($_SESSION["ok"])) {
            ?>
                <div class="alert alert-<?php echo $_SESSION["color"] ?> alert-dismissible fade show" role="alert">
                    <strong><?php echo $_SESSION["mes"] ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
            unset($_SESSION["ok"]);
            unset($_SESSION["mes"]);
            unset($_SESSION["color"]);
            ?>


            <div class="d-flex justify-content-center">
                <table class="table mt-3" id="row">
                    <thead class="table-secondary">
                        <tr>
                            <th>#</th>
                            <th>Name of the student</th>
                            <th>Email of the student</th>
                            <th>Date of Birth</th>
                            <th>Select Your Mentees</th>
                        </tr>
                    </thead>
                    <tbody id="">
                        <?php
                        $select = "SELECT * FROM students ORDER BY fname";
                        $count = 0;
                        $res = $conn->query($select);
                        if ($res->num_rows > 0) {
                            while ($row = $res->fetch_assoc()) {
                                $count++;
                                $stuid = $row["stuid"];
                        ?>


                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $row["fname"] . " " . $row["lname"]; ?></td>
                                    <td><?php echo $row["email"]; ?></td>
                                    <td><?php echo $row["dob"]; ?></td>
                                    <?php


                                    $select1 = "SELECT * FROM mentormenteeslist mms INNER JOIN mentor ON mms.menid=mentor.menid WHERE stuid=$stuid";
                                    $res1 = $conn->query($select1);
                                    if ($res1->num_rows == 1) {
                                        while ($mms = $res1->fetch_assoc()) {
                                    ?>
                                            <td class="text-success"><b>Mentored by <?php echo $mms["fname"] . " " . $mms["lname"] ?></b></td>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <td class=""><input type="checkbox" class="form-check-input" name="mentees[]" id="mentee" value="<?php echo $row["stuid"] ?>" onclick="limitSelection(this)">
                                            <span>Select the checkbox</span>
                                        </td>
                                    <?php
                                    }
                                    ?>

                                </tr>

                            <?php
                            }
                        } else {
                            ?>
                            <tr class="text-center">
                                <th colspan=4 class="text-danger">
                                    No records found!
                                </th>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script>
        function limitSelection(checkbox) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');

            var count = 0;
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    count++;

                }
            }

            document.getElementById("counts").innerHTML = "Selected Students = " + count
            document.getElementById("counts").style.backgroundColor = "grey"
            document.getElementById("counts").style.padding = "6px"
            document.getElementById("counts").style.color = "white"
            document.getElementById("counts").style.borderRadius = "5px"

            if (count >= 20) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (!checkboxes[i].checked) {
                        checkboxes[i].disabled = true;

                    }
                }

            } else if (count >= 1) {
                document.getElementById("submit_button").disabled = false;
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].disabled = false;

                }
                document.getElementById("submit_button").disabled = true;
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $("#search").keyup(function() {
                var input = $(this).val()
                if (input != "") {
                    $.ajax({
                        url: "ajax_search.php",
                        method: "POST",
                        data: {
                            input: input
                        },

                        success: function(response) {
                            $("#search_result").html(response)
                        }
                    })
                }
            })
        })
    </script>
</body>

</html>