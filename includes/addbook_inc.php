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

    // external functions
    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    // errors for the necessary inputs
    if(emptyInputAddBook($title, $author, $isbn, $editorial, $pages, $releaseDate, $genres, $synopsis) !== false) {
        header("location: ../add-book.php?error=emptyinput");
        exit();
    }
    if(isbnExists($conn, $isbn) !== false){
        header("location: ../add-book.php?error=isbnexists");
        exit();
    }
    
    addBook($conn, $title, $author, $isbn, $editorial, $translator, $pages, $releaseDate, $genres, $synopsis);

    header("location: ../book.php?isbn=$isbn");
}
else {
    header("location: ../add-book.php");
    exit();
}