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
        $_SESSION["userid"] =  $uidExists["userId"];
        $_SESSION["useruid"] =  $uidExists["userUid"];
        header("location: ../index.php");
        exit();
    }
}

function emptyInputSingup($username, $email, $pwd, $pwdRepeat){
    $result;
    if(empty($username) || empty($email) || empty($pwd) || empty($pwdRepeat)){
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
        header("location: ../singup.php?error=stmtfailed");
        exit();
    }

    // security duhhh
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    // check optional fields
    $fname = !empty($fname) ? $fname : "NULL";
    $surname = !empty($surname) ? $surname : "NULL";
    $descr = !empty($descr) ? $descr : "NULL";
    $pronouns = !empty($pronouns) ? $pronouns : "NULL";
    
    mysqli_stmt_bind_param($stmt, "sssssss", $email, $username, $hashedPwd, $fname, $surname, $descr, $pronouns);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../singup.php?error=none");
    exit();
}