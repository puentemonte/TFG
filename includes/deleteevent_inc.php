<?php

if(isset($_POST["submit"])) {
    $eid = $_GET['eid'];

    require_once "dbh_inc.php";
    require_once "functions_inc.php";
    
    deleteEvent($conn, $eid);
}
header("location: ../myevents.php");
exit();

?>