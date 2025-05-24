<?php
session_start();
include "./database/database.php";

if (isset($_SESSION["student"])) {
    $email = $_SESSION["semail"];
} else if (isset($_SESSION["mentor"])) {
    $email = $_SESSION["memail"];
}

echo $email;


if (isset($_POST["change"])) {

    $oldpass = $_POST["oldpass"];
    $newpass = $_POST["newpass"];
    $cnewpass = $_POST["cnewpass"];

    $encode_pass = password_hash($newpass, PASSWORD_DEFAULT);
    $encode_cpass = password_hash($cnewpass, PASSWORD_DEFAULT);

    $select = "SELECT * FROM registration WHERE email='$email'";
    $result = $conn->query($select);

    $_SESSION["success"] = "success";
    if ($result->num_rows == 1) {
        $data = $result->fetch_assoc();

        if (password_verify($oldpass, $data["pass"])) {

            $update = "UPDATE registration SET pass= '$encode_pass', cpass='$encode_cpass' WHERE email='$email'";

            if ($conn->query($update)) {
                $_SESSION["message"] = "password updated succesfully";
                $_SESSION["color"] = "alert-success";
                if (isset($_SESSION["student"])) {
                    echo "updated";
                    header("Location: ./Student/change_password.php");
                    exit();
                } else if (isset($_SESSION["mentor"])) {
                    header("Location: ./Mentor/change_password.php");
                    exit();
                }
            } else {
                $_SESSION["message"] = "Error ocurred";
                $_SESSION["color"] = "alert-danger";
                if (isset($_SESSION["student"])) {
                    echo "updated";
                    header("Location: ./Student/change_password.php");
                    exit();
                } else if (isset($_SESSION["mentor"])) {
                    header("Location: ./Mentor/change_password.php");
                    exit();
                }
            }
        } else {
            $_SESSION["message"] = "invalid old password, click forgot password to change it";
            $_SESSION["color"] = "alert-danger";
            if (isset($_SESSION["student"])) {
                header("Location: ./Student/change_password.php");
                exit();
            } else if (isset($_SESSION["mentor"])) {
                header("Location: ./Mentor/change_password.php");
                exit();
            }
        }
    } else {
        $_SESSION["message"] = "Invalid Email";
        $_SESSION["color"] = "alert-danger";
        if (isset($_SESSION["student"])) {
            header("Location: ./Student/change_password.php");
            exit();
        } else if (isset($_SESSION["mentor"])) {
            header("Location: ./Mentor/change_password.php");

            exit();
        }
    }
}
