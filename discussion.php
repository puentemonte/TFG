<?php
    include_once 'header.php';

    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 

    if(isset($_GET['did'])){ // discussion id is set
        $userId = $_SESSION['userid'];
        $ret = get_discussion($conn, $_GET['did']);
        $name = $ret['name'];
        $creator_name = get_username($conn, $ret['creatorId']);
        // get creator name

        echo "<body>
                <div class='mt-custom'>
                    <div class='row ml-book mr-book'>
                        <div class='col ml-custom'>
                            <h2 class='h2 fw-normal'>$name</h2>
                            <p class='details'>Creado por <b>$creator_name</b></p>

                            <div class='answers'>
                                <h5 class='h5 fw-normal'>Respuestas</h5>
                                <div class='row'>
                                    <form action='includes/interact_inc.php?did=$did' method='post'>
                                        <div class='d-flex flex-start w-100'>
                                            <div class='form-outline w-100'>
                                                <textarea class='form-control' placeholder='Escribe tu comentario...' name='content' rows='4'style='background: #fff;'></textarea>
                                            </div>
                                        </div>
                                        <div class='float-end mt-2 pt-1 mb-comment'>
                                            <button type='submit' name='reply' class='btn custom-color-button'><b>Publicar</b></button>
                                        </div>
                                    </form>
                                </div>";

                            $all_answer = get_all_answers($conn, $_GET['did']);
                            // the discussions cannot be empty because a discussion starts with a commet with the user
                            foreach($all_answer as $answer_data){
                                $username = get_username($conn, $answer_data['userUid']); // user id who answered
                                // get user id
                                $comment = $answer_data['comment'];
                                $answer = $answer_data['answer'];
                                $date = $answer_data['dateStamp'];

                                echo "<div class ='row'>
                                                <div class= 'card p-4 review'>
                                                    <div class='d-flex flex-start'>
                                                        <div>
                                                            <h6 class='fw-bold mb-1'>$username</h6>
                                                            <p class='mb-0'>
                                                            $comment 
                                                            </p>
                                                            <button class='icon-btn ml-reply'><a href='#top' class='fa-solid fa-reply icon-filled reply'></a></button>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>";
                            }
                        echo "</div>
                    </div>
                </div>
            </div>
        </body>";
    }
    else {
        $cid = $_GET["cid"];
        header("location: ../club?cid=$cid.php"); // go back to the club
        exit();
    }
?>