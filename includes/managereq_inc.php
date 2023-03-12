<?php

if(isset($_GET["rid"])){
    $rid = $_GET["rid"];
    $type = $_GET["type"];

    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    if($type == 'accepted'){
        $uid = $_GET["uid"];
        accept_request($conn, $rid, $uid);
    }
    else if ($type == 'denied'){
        delete_request($conn, $rid);
    }

    header("location: ../manage-requests.php");
}
else {
    header("location: ../manage-requests.php");
    exit();
}
?>