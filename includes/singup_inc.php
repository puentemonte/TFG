<?php

if(isset($_POST["submit"])){
    // grab the data for the script
    $fname = $_POST["fname"];
    $surname = $_POST["surname"];
    $username = $_POST["uid"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];
    $pronouns = $_POST["pronouns"];
    $descr = $_POST["description"];

    // external functions
    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    // errors for the necessary inputs
    if(emptyInputSingup($username, $email, $pwd, $pwdRepeat) !== false){ // error = anything else than false
        header("location : ../singup.php?error=emptyinput");
        exit();
    }
    if(invalidEmail($email) !== false){
        header("location: ../singup.php?error=invalidemail");
        exit();
    }
    if(pwdMatch($pwd, $pwdRepeat) !== false){
        header("location: ../singup.php?error=pwdnomatch");
        exit();
    }
    if(uidExists($conn, $username, $email) !== false){
        header("location: ../singup.php?error=usrnametaken");
        exit();
    }
    if(invalidPwd($pwd) !== false){
        header("location: ../singup.php?error=invalidpwd");
        exit();
    }
    
    createUser($conn, $fname, $surname, $username, $email, $pwd, $pronouns, $descr);

}
else {
    header("location: ../singup.php");
    exit();
}