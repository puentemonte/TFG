<?php
session_start();

if(isset($_POST["namedesc"])){ // update the name and description
    // data from form
    $name = $_POST["name"];
    $desc = $_POST["desc"];
    $cid = $_GET['cid'];

    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    // error
    if(emptyInputNameDesc($name, $desc) !== false) {
        header("location: ../edit-club.php?cid=$cid&error=emptyinput");
        exit();
    }

    update_name_desc($conn, $cid, $name, $desc);
    header("location: ../club.php?id=$cid");
}
else if(isset($_POST["currentbook"])){
    // data from form
    $currBook= $_POST["currBook"];
    $nextDate = $_POST["nextDate"];
    $pages= $_POST["currPages"];
    $cid = $_GET['cid'];

    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    update_current_book($conn, $cid, $currBook, $nextDate, $pages);
    header("location: ../club.php?id=$cid");
}
else if(isset($_GET["opendiscussion"])){
    // data from form
    $did = $_GET['did'];
    $cid = $_GET['cid'];

    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    open_discussion($conn, $did);
    header("location: ../edit-discussions.php?cid=$cid");
}
else if(isset($_GET["closediscussion"])){
    // data from form
    $did = $_GET['did'];
    $cid = $_GET['cid'];

    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    close_discussion($conn, $did);
    header("location: ../edit-discussions.php?cid=$cid");
}
else if(isset($_GET["type"])){
    // data from form
    $type = $_GET['type'];
    $mid = $_GET['mid'];
    $cid = $_GET['cid'];

    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    update_member_type($conn, $mid, $type);
    header("location: ../edit-members.php?cid=$cid");
}
else if(isset($_GET["deletemember"])){
    // data from form
    $mid = $_GET['mid'];
    $cid = $_GET['cid'];

    require_once "dbh_inc.php";
    require_once "functions_inc.php";

    delete_member($conn, $mid);
    header("location: ../edit-members.php?cid=$cid");
}
else {
    header("location: ../edit-club.php?cid=$cid");
    exit();
}