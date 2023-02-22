<?php
    include_once 'header.php';

    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 

    if(isset($_GET['uid'])) {
        $uid = $_GET['uid'];
        $ret = get_profile_info($uid);
        echo "<div class='container'>
                <div class='row'>
                    <div class='col'> DIFERENTE SI EL USERID COINCIDE CON EL DE LA SESIÓN, EN ESE CASO -> EDITAR PERFIL
                    
                    </div>
                </div>
                <div class='row'>
                </div>
            </div>";
    }