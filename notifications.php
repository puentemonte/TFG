<?php
    include_once 'header.php';

    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 

    if (!session_id()) 
        session_start();

    if(isset($_SESSION['userid'])) {
        $uid = $_SESSION['userid'];
        $notis = get_notifications($conn, $uid);

       echo "<body>
                <div class='mt-custom text-center'>
                    <h2>Notificaciones</h2>
                    <div class='container mt-custom-search'>";
                    foreach($notis as $notification) {
                        $topic = $notification['topic'];
                        if ($topic == "users"){
                            $userSrc = $notification['userSrc'];
                            $username = get_username($conn, $userSrc);
                            $alrdyRead = $notification['alrdyRead'];
                            $nid = $notification['nid'];

                            if ($alrdyRead == '1'){
                                echo "<a class='card shadow-sm notification read-notification' href='profile.php?uid=$userSrc'>
                                        <div class = 'card-text'>
                                            ¡@$username ha comenzado a seguirte!
                                        </div>
                                    </a>";
                            }
                            else {
                                echo "<a class='card shadow-sm notification read-notification' href='profile.php?uid=$userSrc'>
                                        <div class = 'card-text'>
                                            ¡@$username ha comenzado a seguirte!
                                        </div>
                                    </a>";
                            }
                          
                        }
                        else if ($topic == "clubs"){
                            $userSrc = $notification['userSrc'];
                            $username = get_username($conn, $userSrc);
                            $clubname = get_club_name($conn, $cid);
                            $alrdyRead = $notification['alrdyRead'];
                            $nid = $notification['nid'];

                            if ($alrdyRead == '1'){
                                echo "<a class='card shadow-sm notification read-notification' href='profile.php?uid=$userSrc'>       
                                        <div class = 'card-text'>
                                            ¡@$username se ha unido al club $clubname!
                                        </div>
                                    </a>";
                            }
                            else {
                                echo "<a class='card shadow-sm notification read-notification' href='profile.php?uid=$userSrc'>       
                                        <div class = 'card-text'>
                                            ¡@$username se ha unido al club $clubname!
                                        </div>
                                    </a>";
                            }
                        }
                    }
              echo "</div>
                </div>
            </body>";
    }