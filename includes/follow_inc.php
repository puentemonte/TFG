<?php

// external functions
require_once "dbh_inc.php";
require_once "functions_inc.php";

// unfollow
if(isset($_GET["unfollow"])){
    $follower = $_GET["follower"];
    $followed = $_GET["followed"];

    unfollow_user($conn, $follower, $followed);

    header("location: ../profile.php?uid=$followed");
}
// follow
else {
    $follower = $_GET["follower"];
    $followed = $_GET["followed"];

    follow_user($conn, $follower, $followed);

    header("location: ../profile.php?uid=$followed");
}