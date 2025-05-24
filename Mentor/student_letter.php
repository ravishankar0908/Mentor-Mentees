<?php
include "./navbar.php";

$email = $_SESSION["memail"];

$select = $conn->query("SELECT * FROM mentor WHERE email='$email'");
$data = $select->fetch_assoc();
$menid = $data["menid"];

$date = date("Y-m-d");

if (isset($_GET["rejreqid"])) {
    $id = $_GET["rejreqid"];
    $ok = "reject";
    $update = "UPDATE request SET ack_hod='$ok', ack_date='$date' WHERE requestid=$id";

    $_SESSION["success"] = "ok";

    if ($conn->query($update)) {
        $_SESSION["message"] = "Updated Successfully";
        $_SESSION["color"] = "success";
    } else {
        $_SESSION["message"] = "Not Updated error occurred";
        $_SESSION["color"] = "danger";
    }
}

if (isset($_GET["appreqid"])) {
    $id = $_GET["appreqid"];
    $ok = "approved";
    $update = "UPDATE request SET ack_hod='$ok', ack_date='$date' WHERE requestid=$id";

    $_SESSION["success"] = "ok";

    if ($conn->query($update)) {
        $_SESSION["message"] = "Updated Successfully";
        $_SESSION["color"] = "success";
    } else {
        $_SESSION["message"] = "Not Updated error occurred";
        $_SESSION["color"] = "danger";
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
</head>

<body>

    <div class="container mt-3">
        <h3>Letter Request By the Students</h3>
        <hr>

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

        <table class="table">
            <thead class="table-secondary">
                <th>#</th>
                <th>Student name</th>
                <th>Request To</th>
                <th>Subjects</th>
                <th>Request Date</th>
                <th>Comments</th>
                <th>View Letter</th>
                <th colspan="2" class="text-center">Action</th>
            </thead>
            <tbody>
                <?php
                $count = 0;
                $res1 = $conn->query("SELECT * FROM request");
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
                $res = $conn->query("SELECT * FROM request");
                if ($res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) {
                        $count++;
                ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $row["fromname"]; ?></td>
                            <td><?php echo $row["toname"]; ?></td>
                            <td><?php echo $row["subjects"]; ?></td>
                            <td><?php echo $row["request_date"]; ?></td>
                            <td><?php echo $row["messages"]; ?></td>
                            <td><a target="_blank" class="btn btn-sm btn-primary" href="./request_pdf.php?stuid=<?php echo $row["stuid"] ?>&requestid=<?php echo $row["requestid"]; ?>">view</a></td>
                            <?php
                            if ($row["ack_hod"] == "") {
                            ?>
                                <td><a href="./student_letter.php?appreqid=<?php echo $row["requestid"] ?>" class="btn btn-success btn-sm">Approve</a></td>
                                <td><a href="./student_letter.php?rejreqid=<?php echo $row["requestid"] ?>" class="btn btn-danger btn-sm">Rejected</a></td>
                            <?php
                            } else if ($row["ack_hod"] == "approved") {
                            ?>
                                <td colspan="2" class="text-success text-center"><b>Approved</b></td>
                            <?php
                            } else {
                            ?>
                                <td colspan="2" class="text-danger text-center"><b>Rejected</b></td>
                            <?php
                            }
                            ?>

                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td class="text-center text-danger" colspan="8"><b>No one requested yet!</b></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <?php
        for ($i = 1; $i <= $no_of_pages; $i++) {
        ?>
            <a href="./student_letter.php?page=<?php echo $i ?>&count=<?php echo $count ?>" class="btn btn-primary btn-sm"><?php echo $i ?></a>
        <?php
        }
        ?>
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
            if (count >= 5) {
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