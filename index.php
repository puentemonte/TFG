<?php
    include_once 'header.php';
    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 
?>

<div class="text-center">
    <div class="mt-custom">
        <h2 class="h3 mb-3 fw-normal">Inicio</h2>
    </div>
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-md-4 row-cols-md-5 g-5">
        <?php
            $all_books = get_all_books($conn);
            foreach($all_books as $book_data) {
                $title = $book_data['title'];
                $author = $book_data['author'];
                $isbn= $book_data['isbn'];
                $cover = get_url_export($book_data['cover']);

                echo "<div class='col'>
                            <a class='dropdown-item' href='book.php?isbn=$isbn'>
                                <div class='card shadow-sm'>
                                    <img class='bd-placeholder-img card-img-top' src='$cover' alt ='$title'</svg>
                                    <div class='card-body'>
                                        <p class='card-text'>$title</p>
                                        <small class='text-muted'>$author</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    ";
            }
        ?>
      </div>
    </div>
    <div class="container mt-custom">
        <div class='row row-cols-1 g-1'>
            <div class='col'>
                <div class='card-group'>
                    <div class='card shadow-sm'>
                        <div class='card-body'>
                            <h5 class='card-title'>Club</h5>
                        </div>
                    </div>
                    <div class='card shadow-sm'>
                        <div class='card-body'>
                            <h5 class='card-title'>Número de miembros</h5>
                        </div>
                    </div>
                    <div class='card shadow-sm'>
                        <div class='card-body'>
                            <h5 class='card-title'>Última modificación</h5>
                        </div>
                    </div>
                </div>
            </div>
        <?php 

        $all_clubs = get_all_clubs($conn);
        foreach($all_clubs as $club_data) {
            $cid = $club_data['cid'];
            $name = $club_data['name'];
            $creator = $club_data['creator'];
            $num_members= get_num_members($conn, $cid);
            $last_modification = get_last_modification_club($conn, $cid);

            echo "<a class='dropdown-item' href='club.php?id=$cid'>
                            <div class='card-group'>
                                <div class='card shadow-sm'>
                                    <div class='card-body'>
                                        <p class='card-text'>$name</p>
                                        <small class='text-muted'>Creado por $creator</small>
                                    </div>
                                </div>
                                <div class='card shadow-sm'>
                                    <div class='card-body'>
                                        
                                        <p class='card-text'>$num_members</p>
                                    </div>
                                </div>
                                <div class='card shadow-sm'>
                                    <div class='card-body'>
                                        <p class='card-text'>$last_modification</p>
                                    </div>
                                </div>
                            </div>
                        </a>";
        }
        echo "      </div>
                </div>
            </div>
        </div>";
    include_once 'footer.php';
?>