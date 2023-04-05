<?php
    include_once 'header.php';

    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 

    if(isset($_GET['isbn'])){
        $ret = get_full_info($conn, $_GET['isbn'], $_SESSION['userid']);
        $cover = $ret['image'];
        $session_uid = $_SESSION['userid'];

        $title = $ret['title'];
        $release = $ret['releaseDate'];
        $author = $ret['author'];
        $synopsis = $ret['synopsis'];
        $pages = $ret['pages_read'];
        $total_pages = $ret['pages'];
        $editorial = $ret['editorial'];
        $translator = $ret['translator'];
        $genres = $ret['genres'];
        $isbn = $_GET['isbn'];
        $list = $ret['list'];
        $rating = $ret['rating'];
        $reviews = $ret['reviews'];
        $distribution_rating = $ret['distribution_ratings'];
        $avg_rating = $ret['avg_rating'];
        $five_stars = $distribution_rating['5']; 
        $four_stars = $distribution_rating['4'];
        $three_stars = $distribution_rating['3'];
        $two_stars = $distribution_rating['2'];
        $one_stars = $distribution_rating['1'];

        echo "<body>
                <div class='mt-custom'>
                    <div class='row ml-book mr-book'>
                        <div class='col-md-auto'>
                            <img class='book-cover' alt='$title' src=data:image;base64,".$cover.">
                        </div>
                        <div class='col ml-custom'>
                            <h2 class='h2 fw-normal'>$title</h2>
                            <p class='details'>$release, $author</p>
                            <p class='synopsis'>$synopsis</p>
                            <p><b>Editorial:</b> $editorial</p>";

                            if ($translator != NULL)
                                echo "<p><b>Traductor:</b> $translator</p>";

                      echo "<p><b>Géneros:</b> $genres</p>
                            
                            <div class = 'reviews'>
                                <h5 class='h5 fw-normal'>Reseñas</h5>
                                <div class = 'row'>
                                    <form action='includes/interact_inc.php?isbn=$isbn' method='post'>
                                        <div class='d-flex flex-start w-100'>
                                            <div class='form-outline w-100'>
                                                <textarea class='form-control' placeholder='Escribe tu comentario...' name='review' rows='4'style='background: #fff;'></textarea>
                                            </div>
                                        </div>
                                        <div class='float-end mt-2 pt-1 mb-comment'>
                                            <button type='submit' name='comment' class='btn custom-color-button'><b>Publicar</b></button>
                                        </div>
                                    </form>
                                </div>";

                            if ($reviews != false){
                                // recorremos todos los comentarios
                                foreach($reviews as $rev) {
                                    // conseguir el nombre del usuario utilizando su id
                                    $username = get_username($conn, $rev['userId']);
                                    $uid = $rev['userId'];
                                    $comment = $rev['review'];
                                    if ($comment != NULL) {
                                        echo "<div class ='row'>
                                                <div class= 'card p-4 review'>
                                                    <div class='d-flex flex-start'>
                                                        <div class='row reply-interaction-row'>
                                                            <div class = 'col'>
                                                                <h6 class='fw-bold mb-1'><a class='profile-link' href=profile.php?uid=$session_uid>@$username</a></h6>
                                                                <p class='mb-0'>$comment </p>
                                                            </div>";
                                                            if (isAdmin($conn, $session_uid) || $uid == $session_uid){
                                                                echo "<div class='col-1'>
                                                                        <form action='includes/interact_inc.php?isbn=$isbn&uid=$uid&deletecomment=1' method='POST'>
                                                                            <button type='submit' name='delete' class='icon-btn notif fa-solid fa-trash icon-filled margin-reply'></button>
                                                                        </form>
                                                                    </div>";
                                                            }
                                                    echo "</div>
                                                    </div>
                                                </div>
                                            </div>";
                                    }
                                }
                            }
                        echo "</div>
                        </div>
                        <div class='col-md-auto ml-custom'>
                            <div class = 'special-card'>
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
                            <div class='mt-4'>
                                <h5 class='h5 fw-normal'>Valoraciones</h5>
                                <div class = 'text-center'>
                                    <p class = 'avg-rating'> $avg_rating / 5 </p>
                                </div>
                                <div class='col mt-progress-bar mt-3'>
                                    <div class = 'row'>
                                        <div class = 'col-md-auto'>
                                            <p class = 'no-m'>5 <i class='fa-solid fa-star icon-rating-dis'></i></p>
                                        </div>
                                        <div class = 'col'>
                                            <div class='progress rating-progress'>
                                                <div class='progress-bar bg-progress' role='progressbar' style='width: $five_stars%' aria-valuenow='$five_stars' aria-valuemin='0' aria-valuemax='100'></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='col mt-progress-bar'>
                                    <div class = 'row'>
                                        <div class = 'col-md-auto'>
                                            <p class = 'no-m'>4 <i class='fa-solid fa-star icon-rating-dis'></i></p>
                                        </div>
                                        <div class = 'col'>
                                            <div class='progress rating-progress'>
                                                <div class='progress-bar bg-progress' role='progressbar' style='width: $four_stars%'' aria-valuenow='$four_stars' aria-valuemin='0' aria-valuemax='100'></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='col mt-progress-bar'>
                                    <div class = 'row'>
                                        <div class = 'col-md-auto'>
                                            <p class = 'no-m'>3 <i class='fa-solid fa-star icon-rating-dis'></i></p>
                                        </div>
                                        <div class = 'col'>
                                            <div class='progress rating-progress'>
                                                <div class='progress-bar bg-progress' role='progressbar' style='width: $three_stars%'' aria-valuenow='$three_stars' aria-valuemin='0' aria-valuemax='100'></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='col mt-progress-bar'>
                                    <div class = 'row'>
                                        <div class = 'col-md-auto'>
                                            <p class = 'no-m'>2 <i class='fa-solid fa-star icon-rating-dis'></i></p>
                                        </div>
                                        <div class = 'col'>
                                            <div class='progress rating-progress'>
                                                <div class='progress-bar bg-progress' role='progressbar' style='width: $two_stars%'' aria-valuenow='$two_stars' aria-valuemin='0' aria-valuemax='100'></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='col mt-progress-bar'>
                                    <div class = 'row'>
                                        <div class = 'col-md-auto'>
                                            <p class = 'no-m'>1 <i class='fa-solid fa-star icon-rating-dis one-star'></i></p>
                                        </div>
                                        <div class = 'col'>
                                            <div class='progress rating-progress'>
                                                <div class='progress-bar bg-progress' role='progressbar' style='width: $one_stars%'' aria-valuenow='$one_stars' aria-valuemin='0' aria-valuemax='100'></div>
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

    include_once 'footer.php';
?>