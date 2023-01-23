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
    <div class="container">
        <?php
            $all_clubs = get_all_clubs($conn);
            foreach($all_clubs as $club_data) {
                $name = $club_data['name'];
                $creator = $book_data['creator'];
                $desc = $book_data['description'];

                echo "<div class ='row'>
                        <div class= 'card p-4 review'>
                            <div class='d-flex flex-start'>
                                <div>
                                    <h6 class='fw-bold mb-1'>$name</h6>
                                    <p class='mb-0'>
                                    <b>$creator</b>
                                    <br>
                                    $desc 
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>";
            }
        ?>
    </div>
</div>

<?php
    include_once 'footer.php';
?>