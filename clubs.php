<?php
    include_once 'header.php';
    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php"; 
?>

<div class='text-center'>
    <div class="mt-custom">
        <h2 class="h3 mb-3 fw-normal">Clubs de lectura</h2>
    </div>
    <div class='row ml-club mr-club club-desc'>
        <div class='col'>
            <table class='table'>
                <thead>
                    <tr>
                        <th scope='col'>Nombre</th>
                        <th scope='col'>Creador</th>
                        <th scope='col'>Número de miembros</th>
                        <th scope='col'>Última publicación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $all_clubs = get_all_clubs($conn);
                        foreach($all_clubs as $club_data) {
                            $cid = $club_data['cid'];
                            $name = $club_data['cname'];
                            $creator = get_username($conn, $club_data['uidCreator']);
                            $creator_uid = $club_data['uidCreator'];
                            $num_members= get_num_members($conn, $cid);
                            $last_modification = get_last_modification_club($conn, $cid);
                            if ($last_modification == NULL)
                                $last_modification = "-";

                            echo "<tr>
                                <td><a class='profile-link' href='club.php?id=$cid'>$name</a></td>
                                <td><a class='profile-link' href=profile.php?uid=$creator_uid>@$creator</a></td>
                                <td>$num_members</td>
                                <td>$last_modification</td>
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