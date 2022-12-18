<?php
    include_once 'header.php';

    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 

    if(isset($_GET['isbn'])){
        $ret = get_full_info($conn, $_GET['isbn'], $_SESSION['userid']);
        $url_export = get_url_export($ret['image']);

        $title = $ret['title'];
        $release = $ret['releaseDate'];
        $author = $ret['author'];
        $synopsis = $ret['synopsis'];
        $pages = $ret['pages_read'];
        $total_pages = $ret['pages'];
        $isbn = $_GET['isbn'];

        echo "<body>
                <div class='mt-custom'>
                    <div class='row ml-book mr-book'>
                        <div class='col-md-auto'>
                            <img class='book-cover' src='$url_export' alt='$title'>
                        </div>
                        <div class='col ml-custom'>
                            <h2 class='h2 fw-normal'>$title</h2>
                            <p class='details'>$release, $author</p>
                            <p class='synopsis'>$synopsis</p>
                        </div>
                        <div class='col-md-auto ml-custom special-card'>
                            <div class='row'>
                                <div class='col text-center'>
                                    <button class='icon-btn'><a href='includes/interact_inc.php?list=reading&isbn=$isbn' class='fa-solid fa-book-open-reader icon'></a></button>
                                    <p class='text-icon'>Leyendo</p>
                                </div>
                                <div class='col text-center'>
                                    <button class='icon-btn'><a href='includes/interact_inc.php?list=read&isbn=$isbn' class='fa fa-book icon'></a></button>
                                    <p class='text-icon'>Leído</p>
                                </div>
                                <div class='col text-center'>
                                    <button class='icon-btn'><a href='includes/interact_inc.php?list=pending&isbn=$isbn' class='fa-solid fa-bookmark icon'></a></button>
                                    <p class='text-icon'>Pendiente</p>
                                </div>                       
                            </div>
                            <div class='row text-center'>
                                <form method='post' action='includes/interact_inc.php?isbn=$isbn'>
                                    <input type='number' name='pages' id='pages' class='form-control txt-box'  value=$pages>
                                    <label>/ $total_pages</label>
                                </form>
                            </div>
                            <div class='row text-center'>
                                <div class='col'>
                                    <button class='icon-btn'><i class='fa-solid fa-star icon rating'></i></button>
                                    <button class='icon-btn'><i class='fa-solid fa-star icon rating'></i></button>
                                    <button class='icon-btn'><i class='fa-solid fa-star icon rating'></i></button>
                                    <button class='icon-btn'><i class='fa-solid fa-star icon rating'></i></button>
                                    <button class='icon-btn'><i class='fa-solid fa-star icon rating'></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </body>";
    }

    include_once 'footer.php';
?>