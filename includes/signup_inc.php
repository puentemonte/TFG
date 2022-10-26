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
    if(emptyInputSignup($username, $email, $pwd, $pwdRepeat) !== false){ // error = anything else than false
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if (invalidEmail($email) !== false){ // no internal error
        header("location: ../signup.php?error=invalidemail");
        exit();
    }
    if(pwdMatch($pwd, $pwdRepeat) !== false){  // no invalid error
        header("location: ../signup.php?error=pwdnomatch");
        exit();
    }
    if(uidExists($conn, $username, $email) !== false){
        header("location: ../signup.php?error=usrnametaken");
        exit();
    }
    if(invalidPwd($pwd) !== false){ //no internal error
        header("location: ../signup.php?error=invalidpwd");
        exit();
    }
    
    createUser($conn, $fname, $surname, $username, $email, $pwd, $pronouns, $descr);
    loginUser($conn, $username, $pwd);
}
else {
    header("location: ../signup.php");
    exit();
}