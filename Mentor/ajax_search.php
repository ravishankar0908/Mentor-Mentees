<?php

include "../Database/database.php";

if (isset($_POST["input"])) {
    $input = $_POST["input"];
    $select = "SELECT * FROM students WHERE fname LIKE '$input%'";
    $res = $conn->query($select);

    $data = "";


    $count = 0;
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $count++;
            $data = "<tr><td>" . $count . "</td><td>" . $row["fname"] . "</td> <td>" . $row["email"] . "</td> <td>" . $row["dob"] . "</td></tr>";
        }
        echo $data;
    } else {
        $data = "NO record";
        echo $data;
    }
}


if (isset($_POST["getmentees"])) {
    $data = "";
    $data .=  $_POST["getmentees"] . " " . $_POST["menid"];

    echo $data;
}
