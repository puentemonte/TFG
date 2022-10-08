<?php

$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "TFG";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if (!$conn){
    die("Conexión fallida: " . mysqli_connect_error());
}