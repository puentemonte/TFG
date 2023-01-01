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
        $list = $ret['list'];
        $rating = $ret['rating'];

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

                            <div class = 'reviews'>
                                <h5 class='h5 fw-normal'>Reseñas</h5>

                                <div class = 'row'>
                                    <div class= 'card p-4 review'>
                                        <div class='d-flex flex-start'>
                                            <div>
                                                <h6 class='fw-bold mb-1'>Betty Walker</h6>
                                                <div class='d-flex align-items-center mb-3'>
                                                    <p class='mb-0'>
                                                        March 30, 2021
                                                    </p>
                                                </div>
                                                <p class='mb-0'>
                                                    It uses a dictionary of over 200 Latin words, combined with a handful of
                                                    model sentence structures, to generate Lorem Ipsum which looks
                                                    reasonable. The generated Lorem Ipsum is therefore always free from
                                                    repetition, injected humour, or non-characteristic words etc.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class = 'row'>
                                    <div class= 'card p-4 review'>
                                        <div class='d-flex flex-start'>
                                            <div>
                                                <h6 class='fw-bold mb-1'>Betty Walker</h6>
                                                <div class='d-flex align-items-center mb-3'>
                                                    <p class='mb-0'>
                                                        March 30, 2021
                                                    </p>
                                                </div>
                                                <p class='mb-0'>
                                                    It uses a dictionary of over 200 Latin words, combined with a handful of
                                                    model sentence structures, to generate Lorem Ipsum which looks
                                                    reasonable. The generated Lorem Ipsum is therefore always free from
                                                    repetition, injected humour, or non-characteristic words etc.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-auto ml-custom special-card'>
                            <div class='row'>
                                <div class='col text-center'>";
                                if($list == "reading")
                                    echo "<button class='icon-btn'><a href='includes/interact_inc.php?list=reading&isbn=$isbn' class='fa-solid fa-book-open-reader icon-filled'></a></button>";
                                else
                                    echo "<button class='icon-btn'><a href='includes/interact_inc.php?list=reading&isbn=$isbn' class='fa-solid fa-book-open-reader icon'></a></button>"; 
                                    
                                echo "<p class='text-icon'>Leyendo</p>
                                </div>
                                <div class='col text-center'>";
                                if($list == "read")
                                    echo "<button class='icon-btn'><a href='includes/interact_inc.php?list=read&isbn=$isbn' class='fa fa-book icon-filled'></a></button>";
                                else
                                    echo "<button class='icon-btn'><a href='includes/interact_inc.php?list=read&isbn=$isbn' class='fa fa-book icon'></a></button>"; 
                                echo "<p class='text-icon'>Leído</p>
                                </div>
                                <div class='col text-center'>";
                                if($list == "pending")
                                    echo "<button class='icon-btn'><a href='includes/interact_inc.php?list=pending&isbn=$isbn' class='fa-solid fa-bookmark icon-filled'></a></button>";
                                else
                                    echo "<button class='icon-btn'><a href='includes/interact_inc.php?list=pending&isbn=$isbn' class='fa-solid fa-bookmark icon'></a></button>";
                                echo "<p class='text-icon'>Pendiente</p>
                                </div>                       
                            </div>
                            <div class='row text-center'>
                                <form method='post' action='includes/interact_inc.php?isbn=$isbn'>
                                    <input type='number' name='pages' id='pages' class='form-control txt-box' value=$pages>
                                    <label>/ $total_pages</label>
                                </form>
                            </div>
                            <div class='row text-center'>
                                <div class='col'>";
                                    if($rating == NULL){
                                        echo "<button class='icon-btn'><a href='includes/interact_inc.php?rating=1&isbn=$isbn' class='fa-solid fa-star icon rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=2&isbn=$isbn' class='fa-solid fa-star icon rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=3&isbn=$isbn' class='fa-solid fa-star icon rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=4&isbn=$isbn' class='fa-solid fa-star icon rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=5&isbn=$isbn' class='fa-solid fa-star icon rating'></a></button>";
                                    }
                                    else if ($rating == '1'){
                                        echo "<button class='icon-btn'><a href='includes/interact_inc.php?rating=1&isbn=$isbn' class='fa-solid fa-star icon-filled rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=2&isbn=$isbn' class='fa-solid fa-star icon rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=3&isbn=$isbn' class='fa-solid fa-star icon rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=4&isbn=$isbn' class='fa-solid fa-star icon rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=5&isbn=$isbn' class='fa-solid fa-star icon rating'></a></button>";
                                    }
                                    else if ($rating == '2'){
                                        echo "<button class='icon-btn'><a href='includes/interact_inc.php?rating=1&isbn=$isbn' class='fa-solid fa-star icon-filled rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=2&isbn=$isbn' class='fa-solid fa-star icon-filled rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=3&isbn=$isbn' class='fa-solid fa-star icon rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=4&isbn=$isbn' class='fa-solid fa-star icon rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=5&isbn=$isbn' class='fa-solid fa-star icon rating'></a></button>";
                                    }
                                    else if ($rating == '3'){
                                        echo "<button class='icon-btn'><a href='includes/interact_inc.php?rating=1&isbn=$isbn' class='fa-solid fa-star icon-filled rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=2&isbn=$isbn' class='fa-solid fa-star icon-filled rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=3&isbn=$isbn' class='fa-solid fa-star icon-filled rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=4&isbn=$isbn' class='fa-solid fa-star icon rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=5&isbn=$isbn' class='fa-solid fa-star icon rating'></a></button>";
                                    }
                                    else if ($rating == '4'){
                                        echo "<button class='icon-btn'><a href='includes/interact_inc.php?rating=1&isbn=$isbn' class='fa-solid fa-star icon-filled rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=2&isbn=$isbn' class='fa-solid fa-star icon-filled rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=3&isbn=$isbn' class='fa-solid fa-star icon-filled rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=4&isbn=$isbn' class='fa-solid fa-star icon-filled rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=5&isbn=$isbn' class='fa-solid fa-star icon rating'></a></button>";
                                    }
                                    else if ($rating == '5'){
                                        echo "<button class='icon-btn'><a href='includes/interact_inc.php?rating=1&isbn=$isbn' class='fa-solid fa-star icon-filled rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=2&isbn=$isbn' class='fa-solid fa-star icon-filled rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=3&isbn=$isbn' class='fa-solid fa-star icon-filled rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=4&isbn=$isbn' class='fa-solid fa-star icon-filled rating'></a></button>
                                        <button class='icon-btn'><a href='includes/interact_inc.php?rating=5&isbn=$isbn' class='fa-solid fa-star icon-filled rating'></a></button>";
                                    }
                                echo "</div>
                            </div>
                        </div>
                    </div>
                </div>
            </body>";
    }

    include_once 'footer.php';
?>