<?php

// external functions
require_once "dbh_inc.php";
require_once "functions_inc.php";

if (isset($_GET["cid"])) { // add a member to a club
    $cid = $_GET["cid"];

    // update the members list
    $ret = join_club($conn, $cid);
    if ($ret == false)
        header("location: ../login.php"); // the user must log in 
    else
        header("location: ../club.php?id=$cid");
}