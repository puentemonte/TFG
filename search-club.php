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
        $search_string .= "cname LIKE '%".$word."%' OR ";
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
                <a class='btn custom-color-sidebar' aria-current='page'  href='search-club.php?k=$k'><b>Buscar clubes</b></a>
                <a class='btn sidebar-custom' href='search-user.php?k=$k'><b>Buscar usuarios</b></a>
            </div>
        </div>";
        
    // check if the search query returned any results
    if ($result_count > 0){
        echo "<div class='text-center'>
                <h2 class='h3 mb-3 fw-normal'>Resultados de la búsqueda '$display_words':</h2>
                
                <div class='row ml-club mr-club club-desc'>
                    <div class='col'>
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

                            $rows= array();
                            while ($row = mysqli_fetch_assoc($query)){
                                $rows[] = $row;
                            }
                    
                            foreach($rows as $club_data) {
                                $cid = $club_data['cid'];
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
            </div>";
    }
    else
    echo "<div class='text-center'>
            <h2 class='h3 mb-3 fw-normal'>No hay resultados para '$display_words'</h2>
        </div>";

    include_once 'footer.php';
?>