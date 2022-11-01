<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Inicio</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="css/reset.css?<?php echo time(); ?>">
        <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    </head>

    <body>
        <nav>
            <div class="menu">
                <ul>
                    <li><a href='index.php'>Inicio</a></li>
                    <?php
                    if (isset($_SESSION["useruid"])){
                        echo"<li><div class='dropdown'>
                        <button class='dropbtn'>Perfil
                            <i class='fa fa-caret-down'></i>
                        </button>
                        <div class='dropdown-content'>
                            <a href='profile.php'>Perfil</a>
                            <a href='settings.php'>Ajustes</a>
                            <a href='includes/logout_inc.php'>Cerrar sesión</a>
                        </div>
                        </div></li>";
                    }
                    else {
                        echo"<li><a href='signup.php'>Registrarse</a></li>";
                        echo"<li><a href='login.php'>Iniciar sesión</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </nav>