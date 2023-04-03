<?php
    include_once 'header.php';
    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 
?>

<div class="mt-custom text-center">
    <h2 class="h3 mb-3 fw-normal">Inicio</h2>
</div>
<div class="container">
    <?php
        // Libros general
    echo "<div class='row'>
            <div class='col'>
                <h4 class='h4 mb-3 fw-normal'>La gente está leyendo...</h4>
                <div class='row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-md-4 row-cols-md-5 g-5 text-center'>";
    $popular_books = get_popular_books($conn);
    foreach($popular_books as $book) {
    $book_info = get_book_info($conn, $book);
    $isbn = $book;
    $title = $book_info['title'];
    $author = $book_info['author'];
    $cover = $book_info['cover'];

    echo "<div class='col'>
            <div class='row'>
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
        </div>";
    }
    echo "</div>
    </div>
</div>";

    // Clubes general
    echo "<div class='row'>
        <div class='col'>
            <h4 class='h4 mb-3 fw-normal mt-custom'>Clubes populares</h4>
                <div class='row ml-club mr-club club-desc'>
                    <div class='col text-center'>
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th scope='col'>Nombre</th>
                                    <th scope='col'>Creador</th>
                                    <th scope='col'>Número de miembros</th>
                                    <th scope='col'>Última publicación</th>
                                </tr>
                            </thead>
                            <tbody>";
        $popular_clubs = get_popular_clubs($conn);

        foreach($popular_clubs as $club) {
            $club_data = get_info_clubs($conn, $club);
            $cid = $club;
            $name = $club_data['cname'];
            $creator = get_username($conn, $club_data['uidCreator']);
            $creator_uid = $club_data['uidCreator'];
            $num_members= $club_data['numMembers'];
            $last_modification = get_last_modification_club($conn, $cid);
            if ($last_modification == NULL)
                $last_modification = "-";

            echo "<tr>
                <td><a class='profile-link' href='club.php?id=$cid'>$name</a></td>
                <td><a class='profile-link' href='profile.php?uid=$creator_uid'>@$creator</a></td>
                <td>$num_members</td>
                <td>$last_modification</td>
            </tr>";
        }

            echo "</tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>";
?>

<?php
include_once 'footer.php';
?>