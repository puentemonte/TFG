<?php
    include_once 'header.php';

    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 

    if(isset($_GET['uid'])) {
        $uid = $_GET['uid'];
        $ret = get_profile_info($conn, $uid);

        $username = $ret["username"];
        $reading = $ret["reading"];
        $read = $ret["read"];
        $pending = $ret["pending"];
        $followers = $ret["followers"];
        $followed = $ret["followed"];
        $n_pending = count($pending);
        $n_read = count($read);
        $n_reading = count($reading);  
        $picture = $ret["picture"];

        echo "<body>
                <div class='mt-custom'>
                    <div class='row ml-profile mr-profile'>
                        <div class = 'col-md-auto profile-left-column'>
                            <div class = 'text-center'>
                            <img class='rounded-circle' width='128' height='128' alt='$nickname' src=data:image;base64,".$picture.">
                            </div>
                            <div class = 'profile-user-info text-center'>";
                            if (isVerified($conn, $uid)){
                                echo "<h2>$username <i class = 'fa-solid fa-circle-check icon-verified'></i></h2>";
                            }
                            else{
                                echo "<h2>$username</h2>";
                            }
                                echo "<p class = 'profile-follow'>$followers seguidores</p>
                                        <p class = 'profile-follow'>$followed seguidos</p>
                            </div>
                            ";
                            if (same_user($uid) === false){ // not the same user
                                if (!session_id()) session_start();

                                $fuid = $_SESSION['userid'];

                                if (!is_following($conn, $uid, $fuid)){
                                    echo "<div class = 'text-center mt-3'>
                                            <a href='./includes/follow_inc.php?follower=$fuid&followed=$uid' class='btn custom-color-button'><b>Seguir</b></a>
                                        </div>";
                                }
                                else {
                                    echo "<div class = 'text-center mt-3'>
                                            <a href='./includes/follow_inc.php?unfollow=1&follower=$fuid&followed=$uid' class='btn custom-color-button'><b>Dejar de seguir</b></a>
                                        </div>";
                                }
                            }
                            else { // same user
                                echo "<div class = 'text-center mt-3'>
                                    <a href='settings.php' class='btn custom-color-button'><b>Editar perfil</b></a>
                                </div>";
                            }
                        echo "<div class = 'mt-5'>
                                <p><i class = 'fa-solid fa-book-open-reader profile-icon'></i>Está leyendo $n_reading libros</p>
                                <p><i class = 'fa fa-book profile-icon'></i>Ha leído $n_read libros</p>
                                <p><i class = 'fa-solid fa-bookmark profile-icon'></i> Ha guardado $n_pending libros</p>
                            </div>
                        </div>
                        <div class = 'col'>
                            <div class='container'>
                                <h5 class='h5 fw-normal'>Leyendo</h5>";
                                
                                if ($n_reading === 0){
                                    echo "<p>¡Vaya! Todo está muy tranquilo por aquí</p>";
                                }

                          echo "<div class='row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-md-4 row-cols-md-5 g-5'>";
                                    foreach($reading as $book) {
                                        $isbn = $book['isbn'];
                                        $book_data = get_overview_partial_info($conn, $isbn);
                                        $title = $book_data['title'];
                                        $author = $book_data['author'];
                                        $cover = $book_data['image'];
                        
                                        echo "<div class='col'>
                                                    <a class='dropdown-item' href='book.php?isbn=$isbn'>
                                                        <div class='card shadow-sm'>
                                                            <img class='bd-placeholder-img card-img-top' alt ='$title' src=data:image;base64,".$cover.">
                                                            <div class='card-body'>
                                                                <p class='card-text'>$title</p>
                                                                <small class='text-muted'>$author</small>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            ";
                                    }
                          echo "</div>
                                <h5 class='h5 fw-normal mt-5'>Leídos</h5>";
                                
                                if ($n_read === 0){
                                    echo "<p>¡Vaya! Todo está muy tranquilo por aquí</p>";
                                }

                          echo "<div class='row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-md-4 row-cols-md-5 g-5'>";
                                    foreach($read as $book) {
                                        $isbn = $book['isbn'];
                                        $book_data = get_overview_partial_info($conn, $isbn);
                                        $title = $book_data['title'];
                                        $author = $book_data['author'];
                                        $cover = $book_data['image'];
                        
                                        echo "<div class='col'>
                                                    <a class='dropdown-item' href='book.php?isbn=$isbn'>
                                                        <div class='card shadow-sm'>
                                                        <img class='bd-placeholder-img card-img-top' alt ='$title' src=data:image;base64,".$cover.">
                                                            <div class='card-body'>
                                                                <p class='card-text'>$title</p>
                                                                <small class='text-muted'>$author</small>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            ";
                                    }
                          echo "</div>
                                <h5 class='h5 fw-normal mt-5'>Guardados</h5>";

                                if ($n_pending === 0){
                                    echo "<p>¡Vaya! Todo está muy tranquilo por aquí</p>";
                                }

                          echo "<div class='row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-md-4 row-cols-md-5 g-5'>";
                                    foreach($pending as $book) {
                                        $isbn = $book['isbn'];
                                        $book_data = get_overview_partial_info($conn, $isbn);
                                        $title = $book_data['title'];
                                        $author = $book_data['author'];
                                        $cover = $book_data['image'];
                        
                                        echo "<div class='col'>
                                                    <a class='dropdown-item' href='book.php?isbn=$isbn'>
                                                        <div class='card shadow-sm'>
                                                        <img class='bd-placeholder-img card-img-top' alt ='$title' src=data:image;base64,".$cover.">
                                                            <div class='card-body'>
                                                                <p class='card-text'>$title</p>
                                                                <small class='text-muted'>$author</small>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            ";
                                    }
                          echo "</div>
                            </div>
                        </div>
                    </div>
                </div>
            </body>";
    }