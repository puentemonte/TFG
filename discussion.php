<?php
    include_once 'header.php';

    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php";

    if(isset($_GET['did'])){ // discussion id is set
        $userId = $_SESSION['userid'];
        $did = $_GET['did'];
        $cid = $_GET['cid'];
        $ret = get_discussion($conn, $_GET['did']);
        $name = $ret['topic'];
        $creator_name = get_username($conn, $ret['creatorId']);
        $creator_uid = $ret['creatorId'];
        $ans = NULL;

        if(isset($_GET['reply'])){
            $ans = $_GET['reply'];
        }

        echo "<body>
                <div class='mt-custom'>
                    <div class='row ml-book mr-book'>
                        <div class='col ml-custom'>
                            <h2 class='h2 fw-normal'>$name</h2>
                            <p class='details'>Creado por <a class='profile-link' href='profile.php?uid=$creator_uid'><b>@$creator_name</b></a></p>
                            <div class='answers'>";
                            if(is_open_discussion($conn, $did)){
                                echo "<div class='row'>
                                        <form action='includes/disinteract_inc.php?did=$did&reply=$ans&cid=$cid' method='POST'>
                                            <div class='d-flex flex-start w-100'>
                                                <div class='form-outline w-100'>";
                                                if(isset($_GET['reply'])){
                                                    $ans_username = get_username($conn, $ans);
                                                    echo "<textarea class='form-control' placeholder='Responder a @$ans_username' name='content' rows='4'style='background: #fff;'></textarea>";
                                                }
                                                else{
                                                    echo "<textarea class='form-control' placeholder='Escribe tu comentario...' name='content' rows='4'style='background: #fff;'></textarea>";
                                                }
                                                    
                                                echo "</div>
                                            </div>
                                            <div class='float-end mt-2 pt-1 mb-comment'>
                                                <button type='submit' name='comment' class='btn custom-color-button'><b>Publicar</b></button>
                                            </div>
                                        </form>
                                    </div>";
                            }
                            echo "<h5 class='h5 fw-normal'>Respuestas</h5>";
                            $all_answers = get_all_answers($conn, $_GET['did']);
                            // the discussions cannot be empty because a discussion starts with a commet with the user
                            foreach($all_answers as $answer_data){
                                $aid = $answer_data['aid'];
                                $uid = $answer_data['userUid'];
                                $username = get_username($conn, $uid); // user id who answered
                                $comment = $answer_data['comment'];

                                // not answering
                                $answer = NULL;
                                if ($answer_data['answer'] != 0){ // answering
                                    $answer = get_username($conn, $answer_data['answer']);
                                }
                                $date = $answer_data['dateStamp'];

                                echo "<div class ='row'>
                                        <div class= 'card p-4 review'>
                                            <div class='d-flex flex-start'>
                                                <div>
                                                    <h6 class='fw-bold mb-1'><a class='profile-link' href=profile.php?uid=$uid>@$username</a></h6>";
                                                    if($answer != NULL){
                                                        echo "<small class='text-muted'>En respuesta a <b>@$answer</b></small>";
                                                    }
                                                    echo "<p class='mb-0'>$comment </p>
                                                    <div class='row'>";
                                                    if(is_club_mod($conn, $cid)){
                                                        echo " <div class='col-1'>
                                                                    <form action='includes/disinteract_inc.php?did=$did&cid=$cid&msg=$aid' method='POST'>
                                                                        <button type='submit' name='delete' class='icon-btn notif fa-solid fa-trash icon-filled margin-reply'></button>
                                                                    </form>
                                                                </div>";
                                                    }
                                                    echo "<div class='col-1'>
                                                            <form action='discussion.php?did=$did&reply=$uid&cid=$cid' method='POST'>
                                                                <button type='submit' name='reply' class='icon-btn notif fa-solid fa-reply icon-filled margin-reply'></button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                            }
                        echo "</div>
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