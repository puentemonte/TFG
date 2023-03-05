<?php

if(isset($_POST["submit"])) {
    $eid = $_GET['eid'];

    require_once "dbh_inc.php";
    require_once "functions_inc.php";
    
    deleteEvent($conn, $eid);
}
else {
    header("location: ../myevents.php");
    exit();
}
?>