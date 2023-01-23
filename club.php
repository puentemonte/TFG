<?php
    include_once "header.php";
    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 
    

    if(isset($_GET['id'])){
        // Conseguimos la informaición del club de lectura
        $name = "Universo Brandon Sanderson";
        $creator = "erik";
        $desc = "Este es un club de lectura dedicado a Brandon Sanderson. Cada ciertas semanas los integrantes del club se encargan de leer un libro de Brandon Sanderson y comentarlo en las siguientes secciones.";
    }
    else {
        header("location: ../index.php");
        exit();

    }
?>


<div class>
    
</div>