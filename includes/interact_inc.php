<?php

// external functions
require_once "dbh_inc.php";
require_once "functions_inc.php";

if (isset($_GET["list"])) { // updating the list
    $list = $_GET["list"];
    $isbn = $_GET["isbn"];
    
    // update the list
    $ret = update_list($isbn, $conn, $list);

    if ($ret == false)
        header("location: ../login.php"); // el usuario debe iniciar sesión 
    else    
        header("location: ../book.php?isbn=$isbn");
}

if(isset($_GET["rating"])) { // updating the rating
    $isbn = $_GET["isbn"];
    $rating = $_GET["rating"];

    // update the rating
    $ret = update_rating($isbn, $conn, $rating);
    if ($ret == false)
        header("location: ../login.php"); // el usuario debe iniciar sesión 
    else    
        header("location: ../book.php?isbn=$isbn");
}

if(isset($_POST["comment"])) { // adding or removing a review
    $isbn = $_GET["isbn"];
    $comment = $_POST["review"];
    $ret = add_review($isbn, $conn, $comment);
    
    if ($ret == false)
        header("location: ../login.php"); // el usuario debe iniciar sesión 
    else    
        header("location: ../book.php?isbn=$isbn");
}

if(isset($_POST["pages"])) { // updating the pages read
    $pages = $_POST["pages"];
    $isbn = $_GET["isbn"];

    //update the number of pages read
    $ret = update_pages_read($isbn, $conn, $pages);
    if ($ret == false)
        header("location: ../login.php"); // el usuario debe iniciar sesión 
    else    
        header("location: ../book.php?isbn=$isbn");
}

if(isset($_GET["deletecomment"])) {
    $comment = NULL;
    $isbn = $_GET["isbn"];
    $uid = $_GET["uid"];
    $ret = del_review($isbn, $conn, $comment, $uid);
    
    if ($ret == false)
        header("location: ../login.php"); // el usuario debe iniciar sesión 
    else    
        header("location: ../book.php?isbn=$isbn");
}