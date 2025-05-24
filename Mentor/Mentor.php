<?php
include "./navbar.php";

$email = $_SESSION["memail"];

$res = $conn->query("SELECT * FROM mentor WHERE email='$email'");
if ($res->num_rows == 1) {
    $data = $res->fetch_assoc();

    $menid = $data["menid"];
}

?>

<!doctype html>
<html lang="en">

<head>
    <title>Mentor Home Page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

</head>

<body>
    <div class="container mt-3">
        <form action="./Mentor.php" method="post" id="myform">
            <div class="row d-flex">
                <div class="col-md-7 justify-content-between">
                    <h3>Graphical representation</h3>
                </div>
                <div class="col-md-4">
                    <select name="choose" id="choose" class="form-select">
                        <option selected value="overall">Overall</option>
                        <option value="mine">My Mentees</option>
                    </select>
                </div>
                <div class="col-md-1 align-items-center">
                    <input type="submit" name="submit" id="sub" class="btn btn-primary">
                </div>
            </div>
        </form>


        <hr>
        <div class="row">
            <div class="col-md-6">
                <div id="chart1"></div>
            </div>

            <div class="col-md-6">
                <div id="chart2"></div>
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div id="chart4"></div>
            </div>

            <div class="col-md-6">
                <div id="chart3"></div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener("DOMContentLoaded", () => {
            var button = document.getElementById("sub")
            document.getElementById("myform").submit()
        })
    </script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <?php

    if (isset($_POST["submit"])) {
        $value = $_POST["choose"];
    } else {
        $value = null;
    }

    if ($value == "overall") {
        $male = $conn->query("SELECT * FROM students WHERE gender='male'");
        $female = $conn->query("SELECT * FROM students WHERE gender='female'");

        $task = $conn->query("SELECT * FROM task");
        $taskstatus = $conn->query("SELECT * FROM taskstatus");
        $taskdue = $conn->query("SELECT * FROM taskduerequest");

        $req = $conn->query("SELECT * FROM request");
        $reqapp = $conn->query("SELECT * FROM request WHERE ack_hod='approved'");
        $reqrej = $conn->query("SELECT * FROM request WHERE ack_hod='reject'");
    } elseif ($value == "mine") {
        $male = $conn->query("SELECT * FROM mentormenteeslist AS mms INNER JOIN students ON mms.stuid=students.stuid WHERE mms.menid=$menid AND students.gender='male'");
        $female = $conn->query("SELECT * FROM mentormenteeslist AS mms INNER JOIN students ON mms.stuid=students.stuid WHERE mms.menid=$menid AND students.gender='female'");

        $task = $conn->query("SELECT * FROM task WHERE menid=$menid");
        $taskstatus = $conn->query("SELECT * FROM taskstatus INNER JOIN mentormenteeslist AS mms ON taskstatus.stuid=mms.stuid WHERE mms.menid=$menid");
        $taskdue = $conn->query("SELECT * FROM taskduerequest AS tqr INNER JOIN mentormenteeslist AS mms ON tqr.stuid=mms.stuid WHERE mms.menid=$menid");

        $req = $conn->query("SELECT * FROM request AS tqr INNER JOIN mentormenteeslist AS mms ON tqr.stuid=mms.stuid WHERE mms.menid=$menid");
        $reqapp = $conn->query("SELECT * FROM request AS tqr INNER JOIN mentormenteeslist AS mms ON tqr.stuid=mms.stuid WHERE mms.menid=$menid AND tqr.ack_hod='approved'");
        $reqrej = $conn->query("SELECT * FROM request AS tqr INNER JOIN mentormenteeslist AS mms ON tqr.stuid=mms.stuid WHERE mms.menid=$menid AND tqr.ack_hod='reject'");
    } else {
        $male = $conn->query("SELECT * FROM students WHERE gender='male'");
        $female = $conn->query("SELECT * FROM students WHERE gender='female'");

        $task = $conn->query("SELECT * FROM task");
        $taskstatus = $conn->query("SELECT * FROM taskstatus");
        $taskdue = $conn->query("SELECT * FROM taskduerequest");

        $req = $conn->query("SELECT * FROM request");
        $reqapp = $conn->query("SELECT * FROM request WHERE ack_hod='approved'");
        $reqrej = $conn->query("SELECT * FROM request WHERE ack_hod='reject'");
    }

    ?>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        var check = document.getElementById("choose")
        google.charts.load('current', {
            'packages': ['corechart']
        });


        google.charts.setOnLoadCallback(StudentList);
        google.charts.setOnLoadCallback(StaffList);
        google.charts.setOnLoadCallback(TaskList);
        google.charts.setOnLoadCallback(LetterList);



        function StudentList() {

            var data = new google.visualization.DataTable();
            data.addColumn('string', '');
            data.addColumn('number', '');
            data.addRows([
                ['Males', <?php echo $male->num_rows ?>],
                ['Females', <?php echo $female->num_rows ?>],
            ]);

            var options = {
                'title': 'Total Student List',
                'width': 400,
                'height': 300,
                'is3D': true,
                'colors': ['dodgerblue', 'f765af'],
                'fontName': 'Helvetica',
                'fontSize': 13
            };

            var chart = new google.visualization.PieChart(document.getElementById('chart1'));
            chart.draw(data, options);
        }


        function TaskList() {

            var data = google.visualization.arrayToDataTable([
                ["Element", "Density", {
                    role: "style"
                }],

                ["Total Task", <?php echo $task->num_rows ?>, "#b87333"],
                ["Total Submission", <?php echo $taskstatus->num_rows ?>, "green"],
                ["Total task Due request", <?php echo $taskdue->num_rows ?>, "yellow"],
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {
                    calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"
                },
                2
            ]);

            var options = {
                title: "Task Details",
                width: 400,
                height: 300,
                fontName: 'Helvetica',
                fontSize: 13,
                bar: {
                    groupWidth: "55%"
                },
                legend: {
                    position: "none"
                },
            };
            var chart = new google.visualization.BarChart(document.getElementById("chart2"));
            chart.draw(view, options);
        }

        function StaffList() {
            <?php
            $male = $conn->query("SELECT * FROM mentor WHERE gender='male'");
            $female = $conn->query("SELECT * FROM mentor WHERE gender='female'");
            ?>
            var data = new google.visualization.DataTable();
            data.addColumn('string', '');
            data.addColumn('number', '');
            data.addRows([
                ['Males', <?php echo $male->num_rows ?>],
                ['Females', <?php echo $female->num_rows ?>],
            ]);

            var options = {
                'title': 'Total Staff / Professors List',
                'width': 400,
                'height': 300,
                'is3D': true,
                'colors': ['dodgerblue', 'f765af'],
                'fontName': 'Helvetica',
                'fontSize': 13
            };

            var chart = new google.visualization.PieChart(document.getElementById('chart3'));
            chart.draw(data, options);
        }


        function LetterList() {
            <?php



            ?>
            var data = google.visualization.arrayToDataTable([
                ["Element", "Density", {
                    role: "style"
                }],

                ["Total Request", <?php echo $req->num_rows ?>, "#b87333"],
                ["Approved Letters", <?php echo $reqapp->num_rows ?>, "green"],
                ["Rejected Letters", <?php echo $reqrej->num_rows ?>, "yellow"],
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {
                    calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"
                },
                2
            ]);

            var options = {
                title: "Request Letter Details",
                width: 400,
                height: 300,
                fontName: 'Helvetica',
                fontSize: 13,
                bar: {
                    groupWidth: "55%"
                },
                legend: {
                    position: "none"
                },
            };
            var chart = new google.visualization.BarChart(document.getElementById("chart4"));
            chart.draw(view, options);
        }
    </script>
</body>

</html>