<?php
include("./navbar.php");
ob_start();
ob_clean();
$email = $_SESSION["memail"];

$select = $conn->query("SELECT * FROM mentor WHERE email='$email'");
$data = $select->fetch_assoc();
$menid = $data["menid"];


if (isset($_GET["mmid"])) {
    $mmid = $_GET["mmid"];

    //    echo $mmid;
    $query = "DELETE FROM mentormenteeslist WHERE mmid=$mmid";
    $_SESSION["ok"] = "ok";

    if ($conn->query($query)) {
        $_SESSION["mes"] = "mentee removed successfully";
        $_SESSION["color"] = "success";
    } else {
        $_SESSION["mes"] = "error occurred";
        $_SESSION["color"] = "danger";
    }
}



// $start = 0;
// $ends = $conn->query("SELECT * FROM mentormenteeslist ORDER BY stuid DESC");
// if ($ends->num_rows > 0) {
//     $res = $ends->fetch_assoc();
//     $end = $res["stuid"];
// } else {
//     $end = 5;
// }

// created for selecting mentees automatically but not needed only five mentees are selected.

// if (isset($_POST["getmentees"])) {
//     $list = $conn->query("SELECT * FROM mentormenteeslist WHERE menid=$menid");
//     if ($list->num_rows == 0) {
//         $stu = $conn->query("SELECT * FROM students ORDER BY stuid LIMIT $start,$end");
//         if ($stu->num_rows  > 0) {
//             while ($row = $stu->fetch_assoc()) {
//                 $stuid = $row["stuid"];
//                 //echo $stuid;
//                 $check = $conn->query("SELECT * FROM mentormenteeslist WHERE stuid=$stuid");
//                 if ($check->num_rows > 0) {
//                     $start = $end;
//                     $stu = $conn->query("SELECT * FROM students ORDER BY stuid LIMIT $start,$end");
//                     if ($stu->num_rows > 0) {
//                         while ($row = $stu->fetch_assoc()) {
//                             $stuid = $row["stuid"];
//                             $insert = "INSERT INTO mentormenteeslist(menid,stuid) VALUES($menid,$stuid)";
//                             $conn->query($insert);
//                         }
//                     }
//                 } else {
//                     $insert = "INSERT INTO mentormenteeslist(menid,stuid) VALUES($menid,$stuid)";
//                     $conn->query($insert);
//                 }
//             }
//         }
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Mentees Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mt-3">Mentees List</h3>
            </div>
            <div>
                <a target="_blank" class="btn btn-primary" href="./print_mentees_list.php?menid=<?php echo $menid ?>" class="btn">
                    My Mentees <i class="fa-solid fa-print"></i>
                </a>
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
        <form action="./my_mentees.php" method="post">
            <table class="table mt-3" id="table">
                <thead class="table-secondary">
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Student Email</th>
                    <th>Student D.O.B</th>
                    <th>Student Gender</th>
                    <th colspan="2" class="text-center">Action</th>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    $res1 = $conn->query("SELECT * FROM mentormenteeslist
                    INNER JOIN students ON students.stuid=mentormenteeslist.stuid
                    WHERE mentormenteeslist.menid=$menid ORDER BY fname");
                    $total_records = $res1->num_rows;
                    $no_records_per_page = 13;

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
                    $query = "SELECT * FROM mentormenteeslist
                    INNER JOIN students ON students.stuid=mentormenteeslist.stuid
                    WHERE mentormenteeslist.menid=$menid ORDER BY fname LIMIT $start_limit,$no_records_per_page";

                    $student = $conn->query($query);


                    if ($student->num_rows > 0) {
                        while ($row = $student->fetch_assoc()) {
                            $count++;
                    ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $row["fname"] . " " . $row["lname"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td><?php echo $row["dob"]; ?></td>
                                <td><?php echo $row["gender"]; ?></td>
                                <td class="text-center"><a href="./my_mentees.php?mmid=<?php echo $row["mmid"] ?>" class="btn btn-danger btn-sm">remove</a></td>

                                <td class="text-center"><a href="./feed_back.php?stuid=<?php echo $row["stuid"] ?>" class="btn btn-success btn-sm">Feed back</a></td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="6" class="text-danger text-center">
                                <b>You have no mentees</b>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
            for ($i = 1; $i <= $no_of_pages; $i++) {
            ?>
                <a href="./my_mentees.php?page=<?php echo $i ?>&count=<?php echo $count ?>" class="btn btn-primary btn-sm"><?php echo $i ?></a>
            <?php
            }
            ?>
        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>



</html>