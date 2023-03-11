<?php

if(isset($_GET["nid"])){
    $nid = $_GET["nid"];

    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    delete_notification($conn, $nid);

    header("location: ../notifications.php");
}
else {
    header("location: ../notification.php");
    exit();
}
?>