<?php
include_once 'header.php';

// external functions and data bases
require_once "includes/dbh_inc.php";
require_once "includes/functions_inc.php";

if (isset($_GET["cid"])) { // add a member to a club
    $cid = $_GET["cid"];

    // Get the members
    $members = get_members($conn, $cid);
}
?>

<body class="text-center">
    <div class="settings-btn">
        <div class="center">
            <a class="btn sidebar-custom"  href="edit-club.php?cid=<?php echo $cid?>"><b>Editar club</b></a>  
            <a class="btn sidebar-custom" href="edit-curr-book.php?cid=<?php echo $cid?>"><b>Editar lectura actual</b></a>
            <a class="btn sidebar-custom" href="edit-discussions.php?cid=<?php echo $cid?>"><b>Editar discusiones</b></a>
            <a class="btn custom-color-sidebar mb-sidebar-custom" aria-current="page" href="edit-members.php?cid=<?php echo $cid?>"><b>Editar miembros</b></a>
        </div>
    </div>
    <main class="form-signin w-100 m-auto">
        <form action="includes/editclub_inc.php" method="post" novalidate>
            <div class="mt-custom-settings">
                <h2 class="h3 mb-3 fw-normal">Miembros</h2>
            </div>
            <div class='row ml-club mr-club club-desc'>
                <div class='col-md-auto'>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th scope='col'>Nombre</th>
                                <th scope='col'>Administrador</th>
                                <th scope='col'>Borrar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($members as $memb){
                                $username = get_username($conn, $memb['userid']);
                                $type = $memb['typeMember'];
                                $mid = $memb['mid'];
                                
                                echo "<tr>
                                        <td>@$username</td>";

                                if($type == "moderator"){
                                    echo "<td><button class='icon-btn'><a href='includes/editclub_inc.php?cid=$cid&mid=$mid&type=member' class='fa-solid fa-square-check notif'></a></button></td>";
                                }
                                else {
                                    echo "<td><button class='icon-btn'><a href='includes/editclub_inc.php?cid=$cid&mid=$mid&type=moderator' class='fa-regular fa-square-check notif'></a></button></td>";
                                }
                                echo "<td><button class='icon-btn'><a href='includes/editclub_inc.php?cid=$cid&mid=$mid&deletemember=1' class='fa-regular fa-trash-can notif'></a></button></td>";

                                echo "</tr>";
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </main>
</body>