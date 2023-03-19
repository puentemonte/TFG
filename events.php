<?php
    include_once 'header.php';
    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 

        echo "<div>
                <h2 class='text-center h3 mt-custom mb-3 fw-normal'>Próximos eventos</h2>
                <div class='container'>";
        
        // loop though each of the events
        $events = get_all_events($conn);

        if (!session_id()) session_start();

        if (!isset($_SESSION['userid'])) // not logged
            $uid = 0; 
        else 
            $uid = $_SESSION['userid'];

        foreach($events as $e) {
            $eid = $e['eid'];
            $title = $e['title'];
            $dateStamp = $e['dateStamp'];
            $place =  $e['place'];
            $creator =  $e['uidCreator'];
            $username = get_username($conn, $creator);

            echo "<div class='ml-club mr-club mb-event'>
                    <div class='card w-100'>
                        <div class='card-body'>
                            <div class='row'>
                                <div class='col-md'>
                                    <p>
                                        <b>$title</b><br/>
                                        <i class='fa-solid fa-calendar-days icon-event'></i> $dateStamp<br/>
                                        <i class='fa-solid fa-location-dot icon-event'></i> $place<br/>
                                        <i class='fa-solid fa-at icon-event'></i> <a class='profile-link' href='profile.php?uid=$creator'>$username</a>
                                    </p>
                                </div>";

                                if ($uid != 0){
                                    if (is_assistant($conn, $eid, $uid)){
                                        echo "<div class='col-md-auto'>
                                                <a href='./includes/quit_event_inc.php?eid=$eid&uid=$uid' class='btn custom-color-button'><b>Desuscribirse</b></a>    
                                            </div>";
                                    }
                                    else {
                                        echo "<div class='col-md-auto'>
                                                <a href='./includes/assist_event_inc.php?eid=$eid&uid=$uid' class='btn custom-color-button'><b>Suscribirse</b></a>
                                            </div>";
                                    }
                                }
                        echo "</div>
                        </div>
                    </div>
                </div>";
        }

        echo "</div>
        </div>";

    include_once 'footer.php';
?>