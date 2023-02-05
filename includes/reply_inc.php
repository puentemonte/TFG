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
    $ans = NULL;

    // insert the comment
    if(isset($_GET["reply"])){ 
        $ans = $_GET["reply"];
    }
    $ret = add_comment_discussion($conn, $did, $comment, $ans);
    if ($ret == false)
        header("location: ../login.php"); 
    else    
        header("location: ../discussion.php?did=$did");
}

if(isset($_POST["delete"])){
    $aid = $_GET["msg"];
    delete_comment($conn, $did, $aid);
    header("location: ../discussion.php?did=$did");
}