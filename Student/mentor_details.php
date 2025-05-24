<?php
include "./navbar.php";
?>
<!doctype html>
<html lang="en">

<head>
    <title>Mentor Details</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <div class="container mt-3">
        <h3>Mentor Details</h3>
        <hr>
        <div class="d-flex justify-content-center">
            <table class="table mt-3">
                <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>Staff Name</th>
                        <th>Staff Email Id</th>
                        <th>Staff Date of Birth</th>
                        <th>Designation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = $conn->query("SELECT * FROM mentor ORDER BY fname ASC");
                    $count = 0;
                    if ($res->num_rows > 0) {
                        while ($row = $res->fetch_assoc()) {
                            $count++;
                    ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $row["fname"] . " " . $row["lname"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td><?php echo $row["dob"]; ?></td>
                                <?php
                                if ($row["designation"] == NULL) {
                                ?>
                                    <td class="text-danger">Not Updated</td>
                                <?php
                                } else {
                                ?>
                                    <td><?php echo $row["designation"]; ?></td>
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
    </div>






    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>