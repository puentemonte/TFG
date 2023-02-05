<?php
    include_once 'header.php';
    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 

    // get the search terms from the url
    $k = isset($_GET['k']) ? $_GET['k'] : '';

    // create the base variables for building the search query
    $search_string = "SELECT * FROM clubs WHERE ";
    $display_words = "";
                        
    // format each of search keywords into the db query to be run
    $keywords = explode(' ', $k);
    foreach ($keywords as $word){
        $search_string .= "name LIKE '%".$word."%' OR ";
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
                        <a class='btn sidebar-custom' href='search.php?k$k'><b>Buscar libros</b></a>  
                        <a class='btn custom-color-sidebar' aria-current='page'  href='search-club.php?k=$k'><b>Buscar clubes</b></a>
                    </div>
                </div>
                <div class='container'>
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
                 </div>";
        
        // loop though each of the results from the database and display them to the user
        $rows= array();
        while ($row = mysqli_fetch_assoc($query)){
            $rows[] = $row;
        }

        foreach($rows as $club_data) {
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
    }
    else
    echo "<div class='text-center'>
            <div class='mt-custom'>
                <h2 class='h3 mb-3 fw-normal'>No hay resultados para '$display_words'</h2>
            </div>
        </div>";

    include_once 'footer.php';
?>