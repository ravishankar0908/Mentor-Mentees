<?php
include("./navbar.php");
$email = $_SESSION["semail"];
$select = $conn->query("SELECT stuid FROM students WHERE email='$email'");
if ($select->num_rows == 1) {
    $data = $select->fetch_assoc();
    $stuid = $data["stuid"];
}

if (isset($_POST["tasksubmit"])) {

    $taskid = $_POST["taskid"];

    $taskdir = "../task_files/";

    $file = $taskdir . $_FILES["taskfile"]["name"];
    $file_temp = $_FILES["taskfile"]["tmp_name"];
    $file_type = $_FILES["taskfile"]["type"];

    $submitted_date = $_POST["submitted_date"];

    $insert = "INSERT INTO taskstatus(taskid,stuid,taskpdf,submitted_on) VALUES($taskid,$stuid,'$file','$submitted_date')";
}

if (isset($_POST["extend"])) {
    $task_id = $_POST["taskid"];
    $requestdate = date("Y-m-d");

    $insert = "INSERT INTO taskduerequest(taskid,stuid,requestdate) VALUES($task_id,$stuid,'$requestdate')";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <style>
        .card-body {
            min-height: 300px;
            max-height: 300px;
            overflow-y: auto;
        }

        .card-footer {
            min-height: 150px;
        }
    </style>
</head>

<body>
    <?php
    $res = $conn->query("SELECT * FROM mentor INNER JOIN mentormenteeslist ON mentor.menid=mentormenteeslist.menid WHERE mentormenteeslist.stuid=$stuid");

    if ($res->num_rows > 0) {
        $data = $res->fetch_assoc();
        $menid = $data["menid"];
        $mentorname = $data["fname"] . " " . $data["lname"];
    }
    ?>
    <div class="container mt-3">
        <div class="d-flex justify-content-between">
            <h3>Tasks/Assignments</h3>
            <a href="./feed_back.php?menid=<?php echo $menid; ?>" class="btn btn-primary">Mentor Mr/Mrs.<?php echo $mentorname ?></a>
        </div>

        <hr>
        <div class="row g-3">
            <?php
            if (isset($_POST["extend"])) {
                if ($conn->query($insert)) {
            ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>successfull You received 2 more days.</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                } else {
                ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error occurred.</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php
                }
            }



            if (isset($_POST["tasksubmit"])) {
                if ($file_type == "application/pdf") {
                    if ($conn->query($insert)) {
                        move_uploaded_file(
                            $file_temp,
                            $file
                        );
                    ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Assignment has been Uploaded successfully.</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error occurred.</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Only Pdf's are allowed.</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            <?php
                }
            }
            ?>
            <?php
            $query = "SELECT * FROM mentor 
            INNER JOIN task ON task.menid=mentor.menid 
            INNER JOIN mentormenteeslist ON mentormenteeslist.menid=mentor.menid AND mentormenteeslist.stuid=$stuid
            ORDER BY taskid DESC";
            $task = $conn->query($query);
            if ($task->num_rows > 0) {
                $current_date =  date("Y-m-d");
                while ($row = $task->fetch_assoc()) {

            ?>
                    <div class="col-md-3">
                        <form action="./task.php" method="post" enctype="multipart/form-data">
                            <div class="card shadow  mt-3">
                                <div class="card-header">
                                    <?php
                                    echo $row["taskname"];

                                    ?>
                                </div>
                                <div class="card-body">
                                    <p><b>Task Posted Date :</b> <?php echo $row["startdate"]; ?></p>
                                    <p><b>Due Date :</b> <?php echo $row["enddate"]; ?></p>
                                    <p><b>Task Descriptions :</b> <?php echo $row["taskdesc"]; ?></p>
                                    <p><b>Mentor name :</b> <?php echo $row["fname"]; ?></p>
                                    <p><?php if ($current_date > $row["enddate"]) {
                                            echo "<p class='text-danger'><b>Task is Closed</b></p>";
                                        } else {
                                            echo "<p class='text-success'><b>Task is Open</b></p>";
                                        } ?></p>
                                    <?php $taskid = $row["taskid"]; ?>
                                    <input type="hidden" name="taskid" id="taskid" value="<?php echo $taskid ?>">
                                </div>

                                <div class="card-footer">

                                    <?php

                                    $query = "SELECT * FROM task 
                                    INNER JOIN taskduerequest ON task.taskid=taskduerequest.taskid
                                    INNER JOIN taskstatus ON taskstatus.taskid = task.taskid 
                                    WHERE taskduerequest.taskid=$taskid AND taskduerequest.stuid=$stuid";
                                    $res = $conn->query($query);
                                    if ($res->num_rows > 0) {
                                        $_SESSION["extended"] = "yes";
                                        while ($row1 = $res->fetch_assoc()) {

                                            $req_date = $row1["requestdate"];
                                            $date = strtotime("+2 day", strtotime($row1["requestdate"]));
                                            $extended =  date("Y-m-d", $date);
                                        }
                                    } else {
                                        $extended = NULL;
                                    }

                                    $check = $conn->query("SELECT * FROM taskstatus WHERE stuid=$stuid AND taskid=$taskid");
                                    if ($check->num_rows == 1) {
                                        $data = $check->fetch_assoc();
                                        if ($data["mark"] == NULL) {
                                    ?>
                                            <h5 class="text-warning">Mark is in pending State</h5>
                                        <?php
                                        } else {
                                        ?>
                                            <h5 class="text-success">Your Mark is <?php echo $data["mark"] ?></h5>
                                        <?php
                                        }
                                        ?>
                                        <hr>
                                        <p class="text-success mt-4"><b>Your assignment Has been Submitted.</b></p>
                                        <?php
                                    } else {
                                        if ($current_date > $row["enddate"] && $current_date > $extended) {
                                        ?>
                                            <h3 class="text-danger"><b>Due is over</b></h3>
                                            <p class="text-danger">Please Contact Your mentor</p>
                                            <input type="submit" value="Extend Due Date" name="extend" class="btn btn-primary btn-sm">
                                        <?php
                                        } else if (isset($_SESSION["extended"])) {
                                        ?>

                                            <label for="taskfile" class="form-label text-danger">Upload Your Assignment/Task in pdf</label>
                                            <input type="hidden" value="<?php echo $row["taskid"]; ?>" name="taskid">
                                            <input type="file" class="form-control mb-3" name="taskfile" id="taskfile">
                                            <input type="hidden" class="form-control mb-3" name="submitted_date" value="<?php echo date("Y-m-d"); ?>">

                                            <input type="submit" name="tasksubmit" value="Submit Task" class="btn btn-primary">

                                        <?php
                                        } else {
                                        ?>
                                            <label for="taskfile" class="form-label text-danger">Upload Your Assignment/Task in pdf</label>
                                            <input type="hidden" value="<?php echo $row["taskid"]; ?>" name="taskid">
                                            <input type="file" class="form-control mb-3" name="taskfile" id="taskfile">

                                            <input type="hidden" class="form-control mb-3" name="submitted_date" value="<?php echo date("Y-m-d"); ?>">
                                            <input type="submit" name="tasksubmit" value="Submit Task" class="btn btn-primary">
                                    <?php
                                        }
                                    }

                                    ?>
                                </div>

                            </div>
                        </form>
                    </div>
                <?php
                }
            } else {
                ?>
                <hr>
                <h3 class="text-center text-danger">Your mentor have not posted any task</h3>
            <?php
            }
            ?>

        </div>
    </div>


</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>

</html>