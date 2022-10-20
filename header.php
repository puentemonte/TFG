<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Inicio</title>
        <!-- Aqui va el link a la fuente -->
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
                        echo "<li><a href='includes/logout_inc.php'>Cerrar sesión</a></li>";
                        echo "<li><a href='settings.php'>Perfil</a></li>";
                    }
                    else {
                        echo "<li><a href='signup.php'>Registrarse</a></li>";
                        echo "<li><a href='login.php'>Iniciar sesión</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </nav>