<?php
include_once 'header.php';

// external functions and data bases
require_once "includes/dbh_inc.php";
require_once "includes/functions_inc.php";

if (isset($_GET["cid"])) { // add a member to a club
    $cid = $_GET["cid"];

    $club_info = get_info_clubs($conn, $cid);
    $name = $club_info['cname'];
    $desc = $club_info['descrip'];
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
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </symbol>
        </svg>
        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyinput"){
                echo "<div class='mt-custom alert alert-danger d-flex align-items-center' role='alert'>
                            <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                            <div>
                                Rellena todos los campos
                            </div>
                    </div>";
            }
        }
        ?>
        <form action="includes/editclub_inc.php?cid=<?php echo $cid?>" method="post" novalidate>
            <div class="mt-custom-settings">
                <h2 class="h3 mb-3 fw-normal">Información del club</h2>
            </div>
            <div class="form-floating">
                <input class="form-control" name="name" placeholder="Club de lectura" value="<?php echo $name;?>">
                <label for="floatingInput" class='floating-input'>Nombre*</label>
            </div>
            <div class="form-floating">
                <input type="textarea" class="form-control" name="desc" placeholder="Descripción" value="<?php echo $desc;?>">
                <label for="floatingInput" class='floating-input'>Descripción*</label>
            </div>
            <button class="w-100 btn btn-lg custom-color-button" name="namedesc" type="submit">Actualizar</button>
        </form>
    </main>
</body>