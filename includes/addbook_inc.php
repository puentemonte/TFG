<?php

if(isset($_POST["submit"])) {
    $title = $_POST["title"];
    $author = $_POST["author"];
    $isbn = $_POST["isbn"];
    $editorial = $_POST["editorial"];
    $translator = $_POST["translator"];
    $pages = $_POST["pages"];
    $releaseDate = $_POST["releaseDate"];
    $genres = $_POST["genres"];
    $synopsis = $_POST["synopsis"];
    
    $image_name = $_FILES['cover']['name'];
    $image_tmpname  = $_FILES['cover']['tmp_name'];
    $image_size = $_FILES['cover']['size'];
    $file_type = strtolower(end(explode('.', $image_name)));
    $cover = base64_encode(file_get_contents(addslashes($image_tmpname)));

    // external functions
    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    // errors for the necessary inputs
    if(emptyInputAddBook($title, $author, $isbn, $editorial, $pages, $releaseDate, $genres, $synopsis, $image_size)) {
        header("location: ../addbook.php?error=emptyinput");
        exit();
    }
    if(isbnExists($conn, $isbn)){
        header("location: ../addbook.php?error=isbnexists");
        exit();
    }
    if(invalidTypeImage($file_type)){
        header("location: ../addbook.php?error=invalidtype");
        exit();
    }
    
    addBook($conn, $title, $author, $isbn, $editorial, $translator, $pages, $releaseDate, $genres, $synopsis, $cover);

    header("location: ../book.php?isbn=$isbn");
}
else {
    header("location: ../addbook.php");
    exit();
}