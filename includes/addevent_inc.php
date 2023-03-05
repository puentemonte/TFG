<?php

if(isset($_POST["submit"])) {
    $uid = $_SESSION["userid"];
    $title = $_POST["title"];
    $date = $_POST["date"];
    $hour = $_POST["hour"];
    $place = $_POST["place"];

    // external functions
    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    // errors for the necessary inputs
    if(emptyInputAddEvent($title, $date, $hour, $place)) {
        header("location: ../addevent.php?error=emptyinput");
        exit();
    }
    if(invalidDate($conn, $date, $hour)){
        header("location: ../addevent.php?error=invaliddate");
        exit();
    }
    
    addEvent($conn, $title, $date, $hour, $place, $uid);

    header("location: ../events.php");
}
else {
    header("location: ../addevent.php");
    exit();
}