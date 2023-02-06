<?php
include_once 'header.php';

// external functions and data bases
require_once "includes/dbh_inc.php";
require_once "includes/functions_inc.php";

if (isset($_GET["cid"])) { // add a member to a club
    $cid = $_GET["cid"];

    // Get the discussions
    $discussions = get_discussions($conn, $cid);
}
?>

<body class="text-center">
    <div class="settings-btn">
        <div class="center">
            <a class="btn sidebar-custom"  href="edit-club.php?cid=<?php echo $cid?>"><b>Editar club</b></a>  
            <a class="btn sidebar-custom" href="edit-curr-book.php?cid=<?php echo $cid?>"><b>Editar lectura actual</b></a>
            <a class="btn custom-color-sidebar mb-sidebar-custom" aria-current="page" href="edit-discussions.php?cid=<?php echo $cid?>"><b>Editar discusiones</b></a>
            <a class="btn sidebar-custom" href="edit-members.php?cid=<?php echo $cid?>"><b>Editar miembros</b></a>
        </div>
    </div>
    <main class="form-signin w-100 m-auto">
        <div class="mt-custom-settings">
            <h2 class="h3 mb-3 fw-normal">Discusiones</h2>
        </div>
        <div class='row ml-club mr-club club-desc'>
            <div class='col'>
                <table class='table'>
                    <thead>
                        <tr>
                            <th scope='col'>Nombre</th>
                            <th scope='col'>Creador</th>
                            <th scope='col'>Última publicación</th>
                            <th scope='col'>Abierto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($discussions as $dis){
                            $did = $dis['did'];
                            $dis_name = $dis['topic'];
                            $dis_open = $dis['opendis'];
                            $dis_creator = get_username($conn, $dis['creatorId']);
                            $last_update = get_last_modification_discussion($conn, $dis['did']);
                            if ($last_update === false)
                                $last_update = "-";
                            
                            echo "<tr>
                                    <td>$dis_name</td>
                                    <td>@$dis_creator</td>
                                    <td>$last_update</td>";

                            if($dis_open == 1){
                                echo "<td><button class='icon-btn'><a href='includes/editclub_inc.php?cid=$cid&did=$did&closediscussion=1' class='fa-solid fa-square-check notif'></a></button></td>";
                            }
                            else {
                                echo "<td><button class='icon-btn'><a href='includes/editclub_inc.php?cid=$cid&did=$did&opendiscussion=1' class='fa-regular fa-square-check notif'></a></button></td>";
                            }

                            echo "</tr>";
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>