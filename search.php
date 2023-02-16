<?php
    include_once 'header.php';
    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 

    // get the search terms from the url
    $k = isset($_GET['k']) ? $_GET['k'] : '';

    // create the base variables for building the search query
    $search_string = "SELECT * FROM books WHERE ";
    $display_words = "";
                        
    // format each of search keywords into the db query to be run
    $keywords = explode(' ', $k);
    foreach ($keywords as $word){
        $search_string .= "title LIKE '%".$word."%' OR ";
        $search_string .= "isbn LIKE '%".$word."%' OR ";
        $search_string .= "author LIKE '%".$word."%' OR ";
        $display_words .= $word.' ';
    }
    $search_string = substr($search_string, 0, strlen($search_string)-4);
    $display_words = substr($display_words, 0, strlen($display_words)-1);

    // run the query in the db and search through each of the records returned
    $query = mysqli_query($conn, $search_string);
    $result_count = mysqli_num_rows($query);
    
    // check if the search query returned any results
    if ($result_count > 0){
        echo "<div class='text-center'>
                <div class='mt-custom'>
                     <h2 class='h3 mb-3 fw-normal'>Resultados de la búsqueda '$display_words':</h2>
                </div>
                <div class='search-btn'>
                    <div class='center-search'>
                        <a class='btn custom-color-sidebar' aria-current='page' href='search.php?k$k'><b>Buscar libros</b></a>  
                        <a class='btn sidebar-custom' href='search-club.php?k=$k'><b>Buscar clubes</b></a>
                        <a class='btn sidebar-custom' href='search-user.php?k=$k'><b>Buscar usuarios</b></a>
                    </div>
                </div>
                <div class='container'>
                    <div class='row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-md-4 row-cols-md-5 g-5'>";
        
        // loop though each of the results from the database and display them to the user
        $rows= array();
        while ($row = mysqli_fetch_assoc($query)){
            $rows[] = $row;
        }

        foreach($rows as $book_data) {
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
                    </div>";
        }

        echo "</div>
            </div>
        </div>";
    }
    else
    echo "<div class='text-center'>
            <div class='mt-custom'>
                <h2 class='h3 mb-3 fw-normal'>No hay resultados para '$display_words'</h2>
            </div>
        </div>";

    include_once 'footer.php';
?>