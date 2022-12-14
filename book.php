<?php
    include_once 'header.php';

    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 

    if(isset($_GET['isbn'])){
        $ret = get_full_info($conn, $_GET['isbn']);
        $url_export = get_url_export($ret['image']);

        $title = $ret['title'];
        $release = $ret['releaseDate'];
        $author = $ret['author'];
        $synopsis = $ret['synopsis'];
        echo "<body>
                <div class='mt-custom'>
                    <div class='row ml-book mr-book'>
                        <div class='col-md-auto'>
                            <img class='book-cover' src='$url_export' alt='$title' width='230' height='350'>
                        </div>
                        <div class='col ml-custom'>
                            <h2 class='h2 fw-normal'>$title</h2>
                            <p>$release, $author</p>
                            <p class='synopsis'>$synopsis</p>
                        </div>
                        <div class='col-md-auto ml-custom special-card'>
                        <div class='row'>
                            <div class= 'col-md-auto text-center'>
                                <i class='fa-solid fa-book-open-reader icon'></i>
                                <p class='text-icon'>Leyendo</p>
                            </div>
                            <div class= 'col-md-auto text-center'>
                                <i class='fa-solid fa-bookmark icon'></i>
                                <p class='text-icon'>Guardado</p>
                            </div>
                            <div class= 'col-md-auto text-center'>
                                <i class='fa fa-book icon'></i>
                                <p class='text-icon'>Leído</p>
                            </div>
                            <div class= 'col-md-auto text-center'>
                                <i class='fa-solid fa-trash icon'></i>
                                <p class='text-icon'>Abandonado</p>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </body>";
    }

    include_once 'footer.php';
?>