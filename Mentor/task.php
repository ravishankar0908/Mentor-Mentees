<?php
include "./navbar.php";
$memail = $_SESSION["memail"];
$res = $conn->query("SELECT * FROM mentor WHERE email = '$memail'");
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $mid = $row["menid"];
    }
} else {
    echo "not found";
}
if (isset($_POST["post"])) {
    $task_name = $_POST["taskname"];
    $start_date = $_POST["startdate"];
    $end_date = $_POST["enddate"];
    $task_desc = $_POST["taskdetails"];
    $menid = $mid;

    $insert = "INSERT INTO task(taskname,startdate,enddate,taskdesc,menid) VALUES('$task_name','$start_date','$end_date','$task_desc',$menid)";
}


if (isset($_GET["edittask"])) {
    $update = true;
    $taskid = $_GET["edittask"];

    $select_task = "SELECT * FROM task WHERE taskid=$taskid";
    $res = $conn->query($select_task);

    if ($res->num_rows == 1) {
        $data = $res->fetch_assoc();

        $taskname = $data["taskname"];
        $startdate = $data["startdate"];
        $enddate = $data["enddate"];
        $taskdesc = $data["taskdesc"];
    }
}

if (isset($_POST["updatepost"])) {
    $taskid = $_POST["taskid"];
    $task_name = $_POST["taskname"];
    $start_date = $_POST["startdate"];
    $end_date = $_POST["enddate"];
    $task_desc = $_POST["taskdetails"];

    $update = "UPDATE task SET taskname='$task_name',startdate='$start_date', enddate='$end_date', taskdesc='$task_desc' WHERE taskid=$taskid";
}


?>


<!doctype html>
<html lang="en">

<head>
    <title>Mentor Task </title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.css" rel="stylesheet">

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
            <div class="col-xl-4 mt-3">
                <h3 class="text-center">Add Tasks to Students</h3>
                <hr>
                <?php
                if (isset($_POST["post"])) {
                    if ($conn->query($insert)) {
                ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Task posted sucessfully.</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Task is not posted error occurred!</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                    }
                }



                if (isset($_POST["updatepost"])) {
                    if ($conn->query($update)) {
                    ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Task updated sucessfully.</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Task is not updated error occurred!</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                <?php
                    }
                }

                ?>
                <div class="card">
                    <div class="card-body">
                        <form action="./task.php" method="post" class="row g-3" id="taskform">
                            <input type="hidden" name="taskid" value="<?php echo $taskid; ?>">
                            <div class="col-md-12">
                                <label for="taskname" class="form-label">Task Name</label>
                                <input type="text" class="form-control" id="taskname" name="taskname" placeholder="Write the task name" value="<?php if (isset($_GET["edittask"])) {
                                                                                                                                                    echo $taskname;
                                                                                                                                                } ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="startdate" class="form-label">Task Start Date</label>
                                <input type="date" class="form-control" id="startdate" name="startdate" value="<?php if (isset($_GET["edittask"])) {
                                                                                                                    echo $startdate;
                                                                                                                } ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="enddate" class="form-label">Task End Date</label>
                                <input type="date" class="form-control" id="enddate" name="enddate" value="<?php if (isset($_GET["edittask"])) {
                                                                                                                echo $enddate;
                                                                                                            } ?>">
                            </div>
                            <div class="col-12">
                                <label for="taskdetails" class="form-label">Task Explanation</label>
                                <textarea type="text" class="form-control" id="taskdetails" name="taskdetails" placeholder="Explain the task details" rows="10"><?php if (isset($_GET["edittask"])) {
                                                                                                                                                                    echo $taskdesc;
                                                                                                                                                                } ?></textarea>
                            </div>

                            <div class="col-12">
                                <?php
                                if (isset($_GET["edittask"])) {
                                ?>
                                    <button type="submit" name="updatepost" class="btn btn-success">Update Task</button>
                                <?php
                                } else {
                                ?>
                                    <button type="submit" name="post" class="btn btn-primary">Post Task</button>
                                <?php
                                }
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 g-3">
                <h3 class="text-center">Uploaded Task</h3>
                <hr>
                <table class="table">
                    <thead class="table-secondary">
                        <tr>
                            <th>#</th>
                            <th>Task Name</th>
                            <th>Posted date</th>
                            <th>Due date</th>
                            <th>Project Description</th>
                            <th colspan="2">Task Manage</th>
                            <th>Task Status</th>
                        </tr>
                    </thead>
                    <?php
                    $count = 0;
                    $res1 = $conn->query("SELECT * FROM task WHERE menid=$mid");
                    $total_records = $res1->num_rows;
                    $no_records_per_page = 6;

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
                    $select = "SELECT * FROM task WHERE menid=$mid  LIMIT $start_limit, $no_records_per_page";
                    $res = $conn->query($select);
                    if ($res->num_rows > 0) {
                        while ($row = $res->fetch_assoc()) {
                            $count++;
                    ?>
                            <tbody>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $row["taskname"]; ?></td>
                                    <td><?php echo $row["startdate"]; ?></td>
                                    <td><?php echo $row["enddate"]; ?></td>
                                    <td><?php echo $row["taskdesc"]; ?></td>
                                    <td><a href="./task.php?edittask=<?php echo $row["taskid"]; ?>" class="btn btn-warning btn-sm">Edit</a></td>

                                    <td><a href=" ./task_completion.php?viewtask=<?php echo $row["taskid"]; ?>" class="btn btn-success btn-sm">View</a></td>

                                    <?php
                                    $curdate = date("Y-m-d");
                                    if ($curdate > $row["enddate"]) {
                                    ?>
                                        <td class="text-danger"><b>Closed</b></td>
                                    <?php
                                    } else {
                                    ?>
                                        <td class="text-success"><b>Open</b></td>
                                    <?php
                                    }
                                    ?>
                                </tr>
                            </tbody>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="7" class="text-center text-danger"><b>No records Found!</b></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
                <?php
                for ($i = 1; $i <= $no_of_pages; $i++) {
                ?>
                    <a href="./task.php?page=<?php echo $i ?>&count=<?php echo $count ?>" class="btn btn-primary btn-sm"><?php echo $i ?></a>
                <?php
                }
                ?>
            </div>
        </div>

    </div>



    <!-- Bootstrap JavaScript Libraries -->
    <script src="../js/lib/jquery.js"></script>
    <script src="../js/dist/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $("#taskform").validate({
                rules: {
                    taskname: "required",
                    startdate: "required",
                    enddate: "required",
                    taskdetails: {
                        required: true,
                        maxlength: 250

                    }
                },
                messages: {
                    taskname: "Please fill the task name",
                    startdate: "please fill the start date",
                    enddate: "please fill the end date",
                    taskdetails: {
                        required: "Please fill the task Details",
                        maxlength: "Please write within 250 characters"
                    }
                }
            })
        })
    </script>
</body>

</html>