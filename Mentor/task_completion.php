<?php

include("./navbar.php");



$taskid = $_GET["viewtask"];

if (isset($viewtask)) {
}

if (isset($_GET["mark"])) {
    $mark = $_GET["mark"];
    $stuid = $_GET["stuid"];

    $_SESSION["ok"] = "ok";
    $update = "UPDATE taskstatus SET mark=$mark WHERE stuid=$stuid AND taskid=$taskid";

    if ($conn->query($update)) {
        $_SESSION["mes"] = "Mark is updated";
        $_SESSION["color"] = "success";
    } else {
        $_SESSION["mes"] = "Mark is not updated";
        $_SESSION["color"] = "danger";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Completion Page</title>
</head>

<body>
    <div class="container mt-3">

        <div class="d-flex justify-content-between">
            <h3>Task Submitted Details</h3>

        </div>

        <hr>
        <?php
        if (isset($_SESSION["ok"])) {
        ?>
            <div class="alert alert-<?php echo $_SESSION["color"]; ?> alert-dismissible fade show" role="alert">
                <strong><?php echo $_SESSION["mes"]; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php

        }
        unset($_SESSION["ok"]);
        unset($_SESSION["mes"]);
        unset($_SESSION["color"]);
        ?>
        <table class="table">
            <thead class="table-secondary">
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Task Description</th>
                    <th>Submitted Date</th>
                    <th>Task File</th>
                    <th>Marks</th>
                    <th>Extention request</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM taskstatus 
                INNER JOIN task ON task.taskid=taskstatus.taskid
                INNER JOIN students ON taskstatus.stuid=students.stuid WHERE task.taskid=$taskid
                ORDER BY students.fname";
                $count = 0;
                $res = $conn->query($query);

                if ($res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) {
                        $count++;
                ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $row["fname"] . " " . $row["lname"]; ?></td>
                            <td><?php echo $row["taskdesc"]; ?></td>
                            <td><?php echo $row["submitted_on"]; ?></td>
                            <td><button class="btn btn-sm btn-primary"><a class="nav-link" href="<?php echo $row["taskpdf"]; ?>" target="_blank">View</a></button></td>


                            <?php
                            if ($row["mark"] == NULL) {
                            ?>
                                <td>
                                    <a href="./task_completion.php?mark=1&stuid=<?php echo $row["stuid"] ?>&viewtask=<?php echo $taskid; ?>" class="btn btn-sm btn-success">1</a>
                                    <a href="./task_completion.php?mark=2&stuid=<?php echo $row["stuid"] ?>&viewtask=<?php echo $taskid; ?>" class="btn btn-sm btn-success">2</a>
                                    <a href="./task_completion.php?mark=3&stuid=<?php echo $row["stuid"] ?>&viewtask=<?php echo $taskid; ?>" class="btn btn-sm btn-success">3</a>
                                    <a href="./task_completion.php?mark=4&stuid=<?php echo $row["stuid"] ?>&viewtask=<?php echo $taskid; ?>" class="btn btn-sm btn-success">4</a>
                                    <a href="./task_completion.php?mark=5&stuid=<?php echo $row["stuid"] ?>&viewtask=<?php echo $taskid; ?>" class="btn btn-sm btn-success">5</a>

                                </td>
                            <?php
                            } else {
                            ?>
                                <td class="text-success bold"><?php echo "Given mark is " . $row["mark"]; ?></td>
                            <?php
                            }
                            $stuid = $row["stuid"];
                            $taskreq = "SELECT * FROM taskduerequest WHERE taskid=$taskid AND stuid=$stuid";
                            $result = $conn->query($taskreq);

                            ?>
                            <td>
                                <b> <?php echo $result->num_rows . " " . "Times"; ?></b>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7">
                            <h5 class="text-danger text-center">No one is submitted for this task</h5>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</html>