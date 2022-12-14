<?php

if (isset($_GET["list"])) { // updating the list
    $list = $_GET["list"];
    $isbn = $_GET["isbn"];

    // external functions
    require_once "dbh_inc.php";
    require_once "functions_inc.php";

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

    // external functions
    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    // update the rating
    $ret = update_rating($isbn, $conn, $rating);
    if ($ret == false)
        header("location: ../login.php"); // el usuario debe iniciar sesión 
    else    
        header("location: ../book.php?isbn=$isbn");
}

if(isset($_POST["comment"])) { // adding a review
    $comment = $_POST["review"];
    $isbn = $_GET["isbn"];

    // external functions
    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    // insert the comment
    $ret = add_review($isbn, $conn, $comment);
    if ($ret == false)
        header("location: ../login.php"); // el usuario debe iniciar sesión 
    else    
        header("location: ../book.php?isbn=$isbn");
}

if(isset($_POST["pages"])) { // updating the pages read
    $pages = $_POST["pages"];
    $isbn = $_GET["isbn"];

    // external functions
    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    //update the number of pages read
    $ret = update_pages_read($isbn, $conn, $pages);
    if ($ret == false)
        header("location: ../login.php"); // el usuario debe iniciar sesión 
    else    
        header("location: ../book.php?isbn=$isbn");
}