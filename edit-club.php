<?php
include_once 'header.php';

// external functions and data bases
require_once "includes/dbh_inc.php";
require_once "includes/functions_inc.php";

if (isset($_GET["cid"])) { // add a member to a club
    $cid = $_GET["cid"];

    $club_info = get_info_clubs($conn, $cid);
    $name = $club_info['name'];
    $desc = $club_info['description'];
}
?>

<body class="text-center">
    <div class="settings-btn">
        <div class="center">
            <a class="btn custom-color-sidebar mb-sidebar-custom" aria-current="page" href="edit-club.php?cid=<?php echo $cid?>"><b>Editar club</b></a>  
            <a class="btn sidebar-custom" href="edit-curr-book.php?cid=<?php echo $cid?>"><b>Editar lectura actual</b></a>
            <a class="btn sidebar-custom" href="edit-discussions.php?cid=<?php echo $cid?>"><b>Editar discusiones</b></a>
            <a class="btn sidebar-custom" href="edit-members.php?cid=<?php echo $cid?>"><b>Editar miembros</b></a>
        </div>
    </div>
    <main class="form-signin w-100 m-auto">
        <form action="includes/editclub_inc.php" method="post" novalidate>
            <div class="mt-custom-settings">
                <h2 class="h3 mb-3 fw-normal">Información del club</h2>
            </div>
            <div class="form-floating">
                <input class="form-control" name="name" placeholder="Club de lectura" value="<?php echo $name;?>">
                <label for="floatingInput" class='floating-input'>Nombre</label>
            </div>
            <div class="form-floating">
                <input type="textarea" class="form-control" name="desc" placeholder="Descripción" value="<?php echo $desc;?>">
                <label for="floatingInput" class='floating-input'>Descripción</label>
            </div>
            <button class="w-100 btn btn-lg custom-color-button" name="submit" type="submit">Actualizar</button>
        </form>
    </main>
</body>