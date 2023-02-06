<?php

// external functions
require_once "dbh_inc.php";
require_once "functions_inc.php";

/* Two cases:
    1. Post a comment
    2. Reply
}
*/

if(isset($_POST["comment"])){
    $comment = $_POST["content"];
    $did = $_GET["did"];
    $cid = $_GET["cid"];
    $ans = NULL;

    // insert the comment
    if(isset($_GET["reply"])){ 
        $ans = $_GET["reply"];
    }
    $ret = add_comment_discussion($conn, $did, $comment, $ans, $cid);
    if ($ret == false)
        header("location: ../login.php"); 
    else    
        header("location: ../discussion.php?cid=$cid&did=$did");
}

if(isset($_POST["delete"])){
    $aid = $_GET["msg"];
    $did = $_GET["did"];
    $cid = $_GET["cid"];
    delete_comment($conn, $aid);
    header("location: ../discussion.php?did=$did&cid=$cid");
}