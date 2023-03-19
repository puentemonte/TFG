<?php

// external functions
require_once "dbh_inc.php";
require_once "functions_inc.php";

if (isset($_GET["eid"]) && isset($_GET["uid"])) {
    $eid = $_GET["eid"];
    $uid = $_GET["uid"];

    asssit_event($conn, $eid, $uid);

    header("location: ../events.php");
}