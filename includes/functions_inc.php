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

function emptyInputPwdChange($pwd, $newpwd, $newpwdrepeat) {
    $result; 
    if (empty($pwd) | empty($newpwd) | empty($newpwdrepeat)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function emptyInputDelete($pwd) {
    $result; 
    if (empty($pwd)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function wrongPwd($conn, $pwd) {
    session_start();
    $username = $_SESSION["useruid"];

    $uidExists = uidExists($conn, $username, $username);

    // Acheck the session pwd
    $pwdHashed = $uidExists["userPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    $result;
    if ($checkPwd === false) {
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
    $pattern = "/^(?=.*[A-Z])(?=.*[0-9]).{8,}$/";
    if(preg_match($pattern, $pwd)) {
        $result = false;
    }
    else {
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

    loginUser($conn, $username, $pwd);
    header("location: ../index.php");
    exit();
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
    session_start();
    $userid = $_SESSION["userid"];
    $sql = "UPDATE users SET userEmail = ?, userUid = ?, userName = ?, userSurname = ?, userPronouns = ? WHERE userId = ?;";

    // preparing the stmt
    $stmt = mysqli_stmt_init($conn);
    // error
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../settings.php?error=stmtfailed");
        exit();
    }
    else { 
        mysqli_stmt_bind_param($stmt, "sssssi", $email, $username, $fname, $surname, $pronouns, $userid);
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

    mysqli_stmt_close($stmt);
    header("location: ../settings.php?error=none");
    exit();
}

function updatePwd($conn, $newpwd){
    session_start();
    $userid = $_SESSION["userid"];
    $sql = "UPDATE users SET userPwd = ? WHERE userId = ?;";

    // preparing the stmt
    $stmt = mysqli_stmt_init($conn);
    // error
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../settings.php?error=stmtfailed");
        exit();
    }
    else { 
        // hashing the pwd
        $hashedPwd = password_hash($newpwd, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "si", $hashedPwd, $userid);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);

    header("location: ../settings.php?error=none");
    exit();
}

function deleteUsr($conn, $pwd) {
    // Obtener la id de la session
    session_start();
    $userid = $_SESSION["userid"];

    $sql = "DELETE FROM users WHERE userId = ?;";
    // preparing the stmt
    $stmt = mysqli_stmt_init($conn);

    // error
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../settings.php?error=stmtfailed");
        exit();
    }
    else { 
        mysqli_stmt_bind_param($stmt, "i", $userid);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);

    header("location: ../includes/logout_inc.php");
    exit();
}