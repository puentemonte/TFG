<?php
    include_once 'header.php';
    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 
?>

<div class='text-center'>
    <div class="mt-custom">
        <h2 class="h3 mb-3 fw-normal">Mis eventos</h2>
    </div>
    <div class='row ml-club mr-club club-desc'>
        <div class='col'>
            <table class='table'>
                <thead>
                    <tr>
                        <th scope='col'>Título</th>
                        <th scope='col'>Fecha y hora</th>
                        <th scope='col'>Ubicación</th>
                        <th scope='col'>Más opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $uidCreator = $_SESSION['userid'];
                        $my_events = get_my_events($conn, $uidCreator);
                        foreach($my_events as $event_data) {
                            $eid = $event_data['eid'];
                            $title = $event_data['title'];
                            $date = $event_data['dateStamp'];
                            $place = $event_data['place'];
                        
                            echo "<tr>
                                <td>$title</td>
                                <td>$date</td>
                                <td>$place</td>
                                <td>
                                    <form action='includes/deleteevent_inc.php?eid=$eid' method='POST' novalidate>
                                        <button class='btn custom-color-sidebar' aria-current='page' name='submit' type='submit'>Borrar</button>
                                    </form>
                                </td>
                            </tr>"; // ESTO DEBERÍA SER UN FORM CON POST
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
    include_once 'footer.php';
?>