<?php

function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE userUid = ? OR userEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function emptyInputLogin($username, $pwd) {
    $result; 
    if (empty($username) | empty($pwd)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["userPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if ($checkPwd === true){
        session_start();
        // retrieve data from db
        $email;
        $fname;
        $surname;
        $pronouns;

        $sql = "SELECT * FROM users WHERE userUid = ? OR userEmail = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $username, $username);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($resultData)) {
            $email = $row["userEmail"];
            $fname = $row["userName"];
            $surname = $row["userSurname"];
            $pronouns = $row["userPronouns"];
        }
        else {
            header("location: ../login.php?error=wronglogin");
            exit();
        }
        mysqli_stmt_close($stmt);
        $_SESSION["userid"] =  $uidExists["userId"];
        $_SESSION["useruid"] =  $uidExists["userUid"];
        $_SESSION["email"] = $email;
        $_SESSION["fname"] = $fname;
        $_SESSION["surname"] = $surname;
        $_SESSION["pronouns"] = $pronouns;
        header("location: ../index.php");
        exit();
    }
}

function emptyInputSignup($username, $email, $pwd, $pwdRepeat){
    $result;
    if(empty($username) | empty($email) | empty($pwd) | empty($pwdRepeat)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email){
    $result;
    !filter_var($email, FILTER_VALIDATE_EMAIL) ? $result = true : $result = false;
    return $result;
}

function pwdMatch($pwd, $pwdRepeat){
    $result;
    $pwd !== $pwdRepeat ? $result = true : $result = false;
    return $result;
}

function invalidPwd($pwd){
    $result;
    // contraseña válida: mínimo una mayúscula, un número, long 8
    $pattern = "/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,}$/";
    if(preg_match($pattern, $pwd)){
        $result = false;
    }
    else{
        $result = true;
    }
    return $result;
}

function createUser($conn, $fname, $surname, $username, $email, $pwd, $pronouns, $descr){
    $sql ="INSERT INTO users (userEmail, userUid, userPwd, userName, userSurname, userDescription, userPronouns) VALUES (?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }     

    // security
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    // check optional fields
    $fname = !empty($fname) ? $fname : "NULL";
    $surname = !empty($surname) ? $surname : "NULL";
    $descr = !empty($descr) ? $descr : "NULL";
    $pronouns = !empty($pronouns) ? $pronouns : "NULL";
    
    mysqli_stmt_bind_param($stmt, "sssssss", $email, $username, $hashedPwd, $fname, $surname, $descr, $pronouns);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    loginUserAfterSignUp($conn, $fname, $surname, $username, $email, $pwd, $pronouns, $descr);
    header("location: ../signup.php?error=none");
    exit();
}

function loginUserAfterSignUp($conn, $fname, $surname, $username, $email, $pwd, $pronouns, $descr) {
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["userPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if ($checkPwd === true){
        session_start();
        // save session data of user
        $_SESSION["userid"] =  $uidExists["userId"];
        $_SESSION["useruid"] =  $uidExists["userUid"];
        $_SESSION["fname"] = $fname;
        $_SESSION["surname"] = $surname;
        $_SESSION["email"] = $email;
        $_SESSION["pronouns"] = $pronouns;
        $_SESSION["descr"] = $descr;
        header("location: ../index.php");
        exit();
    }
}

function emptyInputUpdate($username, $email){
    $result;
    if(empty($username) || empty($email)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function updateUser($conn, $fname, $surname, $username, $email, $pronouns) {
    $prev_uid = $_SESSION["useruid"];
    $prev_email = $_SESSION["email"];
    $sql = "UPDATE users SET userEmail=?, userUid=? WHERE userUid = ? OR userEmail = ?;";
    //, userName=?, userSurname=?, userPronouns=? 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../settings.php?error=stmtfailed");
        exit();
    }

    // check changes
    if($prev_uid != $username){
        if(uidExists($conn, $username, $username) === false){ // check uid
            header("location: ../settings.php?error=usrnametaken");
            exit();
        }
        else { // the user changed their uid/email correctly
            // update the data
            mysqli_stmt_bind_param($stmt, "ssss", $email, $username, $prev_uid, $prev_email);
            //, $fname, $surname, $pronouns
            mysqli_stmt_execute($stmt);

            // update session data
            session_start();
            $_SESSION["useruid"] =  $username;
            $_SESSION["fname"] = $fname;
            $_SESSION["surname"] = $surname;
            $_SESSION["email"] = $email;
            $_SESSION["pronouns"] = $pronouns;
        }
    }
    if ($prev_email != $email){
        if(uidExists($conn, $email, $email) === false){ // check email
            header("location: ../settings.php?error=emailtaken");
            exit();
        }
        else { // the user changed their uid/email correctly
            // update the data
            mysqli_stmt_bind_param($stmt, "ssss", $email, $username, $prev_uid, $prev_email);
            //, $fname, $surname, $pronouns
            mysqli_stmt_execute($stmt);

            // update session data
            session_start();
            $_SESSION["useruid"] =  $username;
            $_SESSION["fname"] = $fname;
            $_SESSION["surname"] = $surname;
            $_SESSION["email"] = $email;
            $_SESSION["pronouns"] = $pronouns;
        }
    }
    if($prev_uid == $username && $prev_email == $email) {
        // otherwise the changes are saved with prev data and optionaly new data
        mysqli_stmt_bind_param($stmt, "ssss", $prev_email, $prev_uid, $fname, $surname, $pronouns, $prev_uid, $prev_email);
        mysqli_stmt_execute($stmt);

        // update session data
        session_start();
        $_SESSION["useruid"] =  $prev_uid;
        $_SESSION["fname"] = $fname;
        $_SESSION["surname"] = $surname;
        $_SESSION["email"] = $prev_email;
        $_SESSION["pronouns"] = $pronouns;
    }
    mysqli_stmt_close($stmt);

    header("location: ../settings.php?error=none");
    exit();
}