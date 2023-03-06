<?php

if(isset($_POST["submit"])) {
    $name = $_POST["name"];
    $desc = $_POST["desc"];
    $currBook = $_POST["currBook"];
    $nextDate = $_POST["nextDate"];
    $currPages = $_POST["currPages"];

    // external functions
    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    // errors for the necessary inputs
    if(emptyInputNameDesc($name, $desc) !== false) {
        header("location: ../addclub.php?error=emptyinput");
        exit();
    }
    
    $cid = addClub($conn, $name, $desc, $currBook, $nextDate, $currPages);

    header("location: ../club.php?id=$cid");
}
else {
    header("location: ../addclub.php");
    exit();
}