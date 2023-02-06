<?php

if(isset($_POST["submit"])){
    // data from form
    $topic = $_POST["topic"];
    $cid = $_GET["cid"];

    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    add_discussion($conn, $cid, $topic);
    header("location: ../club.php?id=$cid");
}
else {
    $cid = $_GET["cid"];
    header("location: ../club.php?id=$cid");
    exit();
}