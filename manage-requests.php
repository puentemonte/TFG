<?php
    include_once 'header.php';
    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 
?>

<div class='text-center'>
    <div class="mt-custom">
        <h2 class="h3 mb-3 fw-normal">Administrar verificados</h2>
    </div>
    <div class='row ml-club mr-club club-desc'>
        <div class='col'>
            <table class='table'>
                <thead>
                    <tr>
                        <th scope='col'>Usuario</th>
                        <th scope='col'>Nombre completo</th>
                        <th scope='col'>Motivo</th>
                        <th scope='col'>Denegar</th> 
                        <th scope='col'>Aceptar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $all_requests = get_all_requests($conn);
                        foreach($all_requests as $req) {
                            $rid = $req['rid'];
                            $uid = $req['userid'];
                            $fullname = $req['fullname'];
                            $username = get_username($conn, $uid);
                            $motivation = $req['motivation'];

                            echo "<tr>
                                <td><a class='profile-link' href='profile.php?uid=$uid'>$username</a></td>
                                <td>$fullname</td>
                                <td>$motivation</td>
                                <td><button class='icon-btn'><a href='includes/managereq_inc.php?rid=$rid&type=denied' class='fa-solid fa-xmark notif'></a></button></td>
                                <td><button class='icon-btn'><a href='includes/managereq_inc.php?rid=$rid&type=accepted&uid=$uid' class='fa-solid fa-check notif'></a></button></td>
                            </tr>";
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