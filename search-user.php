<?php
    include_once 'header.php';
    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 

    // get the search terms from the url
    $k = isset($_GET['k']) ? $_GET['k'] : '';

    // create the base variables for building the search query
    $search_string = "SELECT * FROM users WHERE ";
    $display_words = "";
                        
    // format each of search keywords into the db query to be run
    $keywords = explode(' ', $k);
    foreach ($keywords as $word){
        $search_string .= "userUid LIKE '%".$word."%' OR ";
        $display_words .= $word.' ';
    }
    $search_string = substr($search_string, 0, strlen($search_string)-4);
    $display_words = substr($display_words, 0, strlen($display_words)-1);

    // run the query in the db and search through each of the records returned
    $query = mysqli_query($conn, $search_string);
    $result_count = mysqli_num_rows($query);

    echo "<div class='search-btn mt-custom'>
            <div class='center-search'>
                <a class='btn sidebar-custom' href='search.php?k$k'><b>Buscar libros</b></a>  
                <a class='btn custom-color' href='search-club.php?k=$k'><b>Buscar clubes</b></a>
                <a class='btn custom-color-sidebar' aria-current='page' href='search-user.php?k=$k'><b>Buscar usuarios</b></a>
            </div>
        </div>";
        
    // check if the search query returned any results
    if ($result_count > 0){
        echo "<div class='text-center'>
                <h2 class='h3 mb-3 fw-normal'>Resultados de la búsqueda '$display_words':</h2>
                <div class='container mt-custom-search'>";
        
        // loop though each of the results from the database and display them to the user
        $rows= array();
        while ($row = mysqli_fetch_assoc($query)){
            $rows[] = $row;
        }

        foreach($rows as $user_data) {
            $uid = $user_data['userId'];
            $username = $user_data['userUid'];


            echo "<div class='card shadow-sm user-overview'>
                    <a class='dropdown-item' href='user.php?uid=$uid'>
                        <div class='row'>
                            <div class='col-4'>
                                <img class='search-picture' src='style/img/color-beige.png' alt ='picture'</svg>
                            </div>
                            <div class='col-4 username-overview'>
                                <p class='card-text'><b>$username</b></p>
                            </div>
                        </div>
                    </a>
                </div>";
        }

        echo "</div>
        </div>";
    }
    else
    echo "<div class='text-center'>
            <h2 class='h3 mb-3 fw-normal'>No hay resultados para '$display_words'</h2>
        </div>";

    include_once 'footer.php';
?>