<?php

// external functions
require_once "dbh_inc.php";
require_once "functions_inc.php";

if (isset($_GET["cid"])) { // remove a club's member
    $cid = $_GET["cid"];

    if(isset($_GET["creator"])){
        delete_club($conn, $cid);
        header("location: ../index.php");
    }
    else {
        quit_club($conn, $cid);
        header("location: ../club.php?id=$cid");
    }
}