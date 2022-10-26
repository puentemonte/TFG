<?php

if(isset($_POST["submit"])){
    // data from form
    $fname = $_POST["fname"];
    $surname = $_POST["surname"];
    $username = $_POST["uid"];
    $email = $_POST["email"];
    $pronouns = $_POST["pronouns"];

    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    // errors (username or email)
    if(emptyInputUpdate($username, $email) !== false) {
        header("location: ../settings.php?error=emptyinput");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../settings.php?error=invalidemail");
        exit();
    }

    updateUser2($conn, $fname, $surname, $username, $email, $pronouns);
}
else {
    header("location: ../settings.php");
    exit();
}