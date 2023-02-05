<?php
    include_once 'header.php';

    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 
    require_once "./includes/reply_inc.php";

    if(isset($_GET['did'])){ // discussion id is set
        $userId = $_SESSION['userid'];
        $did = $_GET['did'];
        //$cid = $_GET['cid'];
        $cid = 2147483640;
        $ret = get_discussion($conn, $_GET['did']);
        $name = $ret['name'];
        $creator_name = get_username($conn, $ret['creatorId']);
        $ans = NULL;
        if(isset($_GET['reply'])){
            $ans = $_GET['reply'];
        }
        

        echo "<body>
                <div class='mt-custom'>
                    <div class='row ml-book mr-book'>
                        <div class='col ml-custom'>
                            <h2 class='h2 fw-normal'>$name</h2>
                            <p class='details'>Creado por <b>$creator_name</b></p>

                            <div class='answers'>
                                <h5 class='h5 fw-normal'>Respuestas</h5>
                                <div class='row'>
                                    <form action='includes/reply_inc.php?did=$did&reply=$ans' method='POST'>
                                        <div class='d-flex flex-start w-100'>
                                            <div class='form-outline w-100'>
                                                <textarea class='form-control' placeholder='Escribe tu comentario...' name='content' rows='4'style='background: #fff;'></textarea>
                                            </div>
                                        </div>
                                        <div class='float-end mt-2 pt-1 mb-comment'>
                                            <button type='submit' name='comment' class='btn custom-color-button'><b>Publicar</b></button>
                                        </div>
                                    </form>
                                </div>";

                            $all_answers = get_all_answers($conn, $_GET['did']);
                            // the discussions cannot be empty because a discussion starts with a commet with the user
                            foreach($all_answers as $answer_data){
                                $aid = $answer_data['aid'];
                                $username = get_username($conn, $answer_data['userUid']); // user id who answered
                                $comment = $answer_data['comment'];
                                $answer = $answer_data['answer'];
                                $date = $answer_data['dateStamp'];

                                echo "<div class ='row'>
                                                <div class= 'card p-4 review'>
                                                    <div class='d-flex flex-start'>
                                                        <div>
                                                            <h6 class='fw-bold mb-1'>$username</h6>";
                                                            if($answer != NULL){
                                                                echo "<small class='text-muted'>En respuesta a <b>$answer</b></small>";
                                                            }
                                                            echo "<p class='mb-0'>
                                                            $comment 
                                                            </p>";
                                                            if(is_moderator($conn, $cid, $userId)){
                                                                echo "<form action='reply_inc.php?did=$did&msg=$aid' method='POST'>
                                                                        <button type='submit' name='delete' class='icon-btn ml-reply'><i class='fa-solid fa-trash icon-filled reply'></i></button>
                                                                    </form>";
                                                            }
                                                            echo "<form action='discussion.php?did=$did&reply=$username' method='POST'>
                                                                <button type='submit' name='reply' class='icon-btn ml-reply'><i class='fa-solid fa-reply icon-filled reply'></i></button>
                                                            </form>
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
        /*$cid = $_GET["cid"];
        header("location: ../club?cid=$cid.php"); // go back to the club*/
        exit();
    }
?>