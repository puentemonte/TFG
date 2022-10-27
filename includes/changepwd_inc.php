<?php

if(isset($_POST["submit"])){
    // data from form
    $pwd = $_POST["pwd"];
    $newpwd = $_POST["newpwd"];
    $newpwdrepeat = $_POST["newpwdrepeat"];

    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    // errors 
    if(emptyInputPwdChange($pwd, $newpwd, $newpwdrepeat) !== false) {
        header("location: ../change-pwd.php?error=emptyinput");
        exit();
    }
    if (wrongPwd($conn, $pwd) !== false){
        header("location: ../change-pwd.php?error=wrongpwd");
        exit();
    }
    if (invalidPwd($newpwd) !== false) {
        header("location: ../change-pwd.php?error=invalidpwd");
        exit();
    }
    if (pwdMatch($newpwd, $newpwdrepeat) !== false){
        header("location: ../change-pwd.php?error=pwdnomatch");
        exit();
    }

    updatePwd($conn, $newpwd);
}
else {
    header("location: ../settings.php");
    exit();
}