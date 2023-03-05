<?php

if(isset($_POST["submit"])){
    // data from form
    $pwd = $_POST["pwd"];

    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    // errors
    if (emptyInputDelete($pwd) !== false){
        header("location: ../delete-usr.php?error=emptyinput");
        exit();
    }
    if (wrongPwd($conn, $pwd) !== false){
        header("location: ../delete-usr.php?error=wrongpwd");
        exit();
    }

    
    deleteUsr($conn, $pwd);
}
else {
    header("location: ../settings.php");
    exit();
}
?>