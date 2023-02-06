<?php
    include_once "header.php";
    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 
    

    if(isset($_GET['id'])){
        // Get the club's info
        $cid = $_GET['id'];
        $club_info = get_info_clubs($conn, $cid);
        $name = $club_info['cname'];
        $creator = get_username($conn, $club_info['uidCreator']);
        $desc = $club_info['descrip'];
        $current_book = $club_info['currBook'];

        // Get the discussions
        $discussions = get_discussions($conn, $cid);

        // Get the members
        $members = get_members($conn, $cid);

        // Get the admins
        $admins = get_admins($conn, $cid);

        echo "<body>
                <div class='mt-custom'>
                    <div class='row ml-club mr-club'>
                        <div class='col-md-auto'>
                            <h2 class='h2 fw-normal'>$name</h2>
                        </div>";

                        if (is_club_mod($conn, $cid) == true) {
                            echo "<div class = 'col'>
                                    <a href='edit-club.php?cid=$cid' class='icon-btn notif fa-solid fa-pen-to-square'></a>
                                </div>
                                <div class = 'col'>
                                    <a href='add-discussion.php?cid=$cid' class='btn custom-color-button'><b>Añadir discusion</b></a>
                                </div>";
                        }

                        if (is_club_member($conn, $cid) != true){
                            echo "<div class='col-md-auto'>
                                        <a href='./includes/joinclub_inc.php?cid=$cid' class='btn custom-color-button'><b>Unirse</b></a>
                                </div>";
                        }
                        else {
                            echo "<div class='col-md-auto'>
                                        <a href='./includes/quitclub_inc.php?cid=$cid' class='btn custom-color-button'><b>Abandonar club</b></a>
                                </div>";
                        }

                    echo "
                    </div>
                    <div class='row ml-club mr-club'>
                        <div class='col'>                        
                            <p class='details'>Creado por @$creator</p>
                            <p class='club-desc'>$desc</p>
                        </div>
                    </div>";

                    if ($current_book != 0) {
                        $ret = get_book_info($conn, $current_book);

                        // Get the book info
                        $url_export = get_url_export($ret['cover']);
                        $title = $ret['title'];
                        $author = $ret['author'];
                        $total_pages = $ret['pages'];

                        // Get the book's progress
                        $pages = $club_info['currPages'];
                        $progress = ($pages/$total_pages)*100;
                        $next_date = $club_info['nextDate'];

                        echo "<div class='row ml-club mr-club club-desc'>
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
                                                    $author</p>";
                                                    if ($next_date == '0000-00-00'){
                                                        echo "<p class='club-author'>
                                                            ¡No hay actualizaciones de progreso proximamente!
                                                        </p>";
                                                    }
                                                    else{
                                                        echo "<p class='club-author'>
                                                            ¡La próxima actualización de progreso tendrá lugar el día $next_date!
                                                        </p>";
                                                    }
                                                    echo "<div class='row'>
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
                            </div>";
                    }
                    echo    "<div class='row ml-club mr-club club-desc'>
                                <div class='col'>
                                    <h5 class='h5 fw-normal'>Discusiones</h5>
                                    <table class='table'>
                                        <thead>
                                            <tr>
                                                <th scope='col'>Nombre</th>
                                                <th scope='col'>Creador</th>
                                                <th scope='col'>Última publicación</th>
                                            </tr>
                                        </thead>
                                        <tbody>";

                                    foreach($discussions as $dis){
                                        $dis_name = $dis['topic'];
                                        $dis_creator = get_username($conn, $dis['creatorId']);
                                        $last_update = get_last_modification_discussion($conn, $dis['did']);
                                        $did = $dis['did'];
                                        if ($last_update === false)
                                            $last_update = "-";
                                        
                                        echo "<tr>
                                                <td><a href='discussion.php?did=$did&cid=$cid'>$dis_name</a></td>
                                                <td>@$dis_creator</td>
                                                <td>$last_update</td>
                                            </tr>";
                                    }

                                    echo "</tbody>
                                    </table>
                                </div>
                            </div>
                    <div class='row ml-club mr-club club-desc'>
                        <h5 class='h5 fw-normal'>Participantes</h5>
                        <div class='accordion' id='accordionExample'>
                            <div class='accordion-item'>
                                <h2 class='accordion-header' id='headingOne'>
                                <button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#collapseOne' aria-expanded='true' aria-controls='collapseOne'>
                                    Miembros
                                </button>
                                </h2>
                                <div id='collapseOne' class='accordion-collapse collapse show' aria-labelledby='headingOne' data-bs-parent='#accordionExample'>
                                <div class='accordion-body'>";

                                    foreach($members as $memb){
                                        $username = get_username($conn, $memb['userid']);
                                        echo "@$username ";
                                    }
                            echo "</div>
                                </div>
                            </div>
                            <div class='accordion-item'>
                                <h2 class='accordion-header' id='headingTwo'>
                                <button class='accordion-button collapsed type='button' data-bs-toggle='collapse' data-bs-target='#collapseTwo' aria-expanded='false' aria-controls='collapseTwo'>
                                    Administradores
                                </button>
                                </h2>
                                <div id='collapseTwo' class='accordion-collapse collapse' aria-labelledby='headingTwo' data-bs-parent='#accordionExample'>
                                <div class='accordion-body'>";
                                    foreach($admins as $adm){
                                        $username = get_username($conn, $adm['userid']);
                                        echo "@$username ";
                                    }
                            echo "</div>
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