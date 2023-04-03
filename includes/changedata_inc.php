<?php
require_once "dbh_inc.php";
require_once "functions_inc.php";

session_start();
if(isset($_POST["submit"])){
    // data from form
    $fname = $_POST["fname"];
    $surname = $_POST["surname"];
    $username = $_POST["uid"];
    $email = $_POST["email"];
    $pronouns = $_POST["pronouns"];

    if(isset($_FILES['picture'])) {
        $image_name = $_FILES['picture']['name'];
        $image_tmpname  = $_FILES['picture']['tmp_name'];
        $image_size = $_FILES['picture']['size'];
        $file_type = strtolower(end(explode('.', $image_name)));
        $picture = base64_encode(file_get_contents(addslashes($image_tmpname)));
        if(invalidTypeImage($file_type)){
            header("location: ../settings.php?error=invalidtype");
            exit();
        }
        if($image_size > 800000){
            header("location: ../settings.php?error=maximumsize");
            exit();
        }
    }
    else {
        $picture = 0;
    }

    // errors (username or email)
    if(emptyInputUpdate($username, $email) !== false) {
        header("location: ../settings.php?error=emptyinput");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../settings.php?error=invalidemail");
        exit();
    }
    if($_SESSION["useruid"] != $username && uidExists($conn, $username, $username)){
        header("location: ../settings.php?error=usrnametaken");
        exit();
    }
    if($_SESSION["email"] != $email && uidExists($conn, $email, $email)){
        header("location: ../settings.php?error=emailtaken");
        exit();
    }
    updateUser($conn, $fname, $surname, $username, $email, $pronouns, $picture);
}
else {
    header("location: ../settings.php");
    exit();
}