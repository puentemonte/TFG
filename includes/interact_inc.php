<?php

if (isset($_GET["list"])) { // updating the list
    $list = $_GET["list"];
    $isbn = $_GET["isbn"];

    // external functions
    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    // update de list
    $ret = update_list($isbn, $conn, $list);
    header("location: ../book.php?isbn=$isbn");
}

if(isset($_GET["rating"])) { // updating the rating

}

if(isset($_GET["review"])) { // adding a review

}

if(isset($_POST["pages"])) { // updating the pages read
    $pages = $_POST["pages"];
    $isbn = $_GET["isbn"];

    // external functions
    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    //update the number of pages read
    update_pages_read($isbn, $conn, $pages);

    header("location: ../book.php?isbn=$isbn");
}