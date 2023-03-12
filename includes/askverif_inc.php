<?php

if(isset($_POST["submit"])){
    // data from form
    $fullname = $_POST["fullname"];
    $motivation = $_POST["motivation"];

    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    // errors 
    if(emptyInputAskVerified($fullname) !== false) {
        header("location: ../askverified.php?error=emptyinput");
        exit();
    }

    ask_verified($conn, $fullname, $motivation);
    
    header("location: ../index.php");
}
else {
    header("location: ../index.php");
    exit();
}