<?php
    include_once "header.php";
    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 
    

    if(isset($_GET['id'])){
        // Conseguimos la informaición del club de lectura
        $name = "Universo Brandon Sanderson";
        $creator = "erik";
        $desc = "Este es un club de lectura dedicado a Brandon Sanderson. Cada ciertas semanas los integrantes del club se encargan de leer un libro de Brandon Sanderson y comentarlo en las siguientes secciones.";
        $progress = 60;
        $photo_url = "https://drive.google.com/file/d/1ujtFvroDM-C8kpZaRlRDCE64a3qyiabZ/view?usp=share_link";
        $url_export = get_url_export($photo_url);
        $pages = 393;
        $total_pages = 656;
        $title = "Elantris";
        $author = "Brandon Sanderson";
        $next_date = "10/02/2023";

        echo "<body>
                <div class='mt-custom'>
                    <div class='row ml-club mr-club'>
                        <div class='col'>
                            <h2 class='h2 fw-normal'>$name</h2>
                        </div>
                        <div class='col-md-auto'>
                            <a href='#' class='btn custom-color-button'><b>Unirse</b></a>
                        </div>
                    </div>
                    <div class='row ml-club mr-club'>
                        <div class='col'>                        
                            <p class='details'>Creado por @$creator</p>
                            <p class='club-desc'>$desc</p>
                        </div>
                    </div>
                    <div class='row ml-club mr-club'>
                        <h5 class='h5 fw-normal'>Lectura actual</h5>
                        <div class='card w-100'>
                            <div class='card-body'>
                                <div class='row'>
                                    <div class='col-md-auto'>
                                        <img class='book-cover-club' src='$url_export' alt='$title'>
                                    </div>
                                    <div class='col'>
                                        <div class='row'>
                                            <p><b>$title</b><br/>
                                               $author</p>
                                            <p class='club-author'>
                                               ¡La próxima actualización de progreso tendrá lugar el día $next_date!
                                            </p>
                                            <div class='row'>
                                                <div class='col mt-progress-bar'>
                                                    <div class='progress'>
                                                        <div class='progress-bar bg-progress' role='progressbar' style='width: $progress%'' aria-valuenow='$progress' aria-valuemin='0' aria-valuemax='100'></div>
                                                    </div>
                                                </div>
                                                <div class='col-md-auto'>
                                                    <p>$pages/$total_pages</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </body>";
    }
    else {
        header("location: ../index.php");
        exit();
    }
?>


<div class>
    
</div>