<?php
    include_once 'header.php';
    // user session data
    $fname = $_SESSION["fname"];
    $surname = $_SESSION["surname"];
    $username = $_SESSION["useruid"];
    $email = $_SESSION["email"];
    $pronouns = $_SESSION["pronouns"];
?>
<div class="ajustes">
    <div class="change-pwd-div">
        <form action="change-pwd.php">
            <button type="submit" name="change-pwd" class="submit-btn">Cambiar contraseña</button>
        </form>
    </div>
    <div class="change-data-div">
        <form action="settings.php" method="post">
            <button type="submit" name="change-data" class="submit-btn">Actualizar perfil</button>
        </form>
    </div>
    <div class="delete-usr-div">
        <form action="delete-usr.php">
            <button type="submit" name="delete-usr" class="submit-btn">Eliminar cuenta</button>
        </form>
    </div>
    <div class="campos">
        <form action="includes/changedata_inc.php" method="post">
            <p class="p">Nombre</p>
            <input type="text" class="alignment" name="fname" placeholder="Nombre" value="<?php
                echo ($fname != "NULL") ? $fname : "";?>">
            <p class="p">Apellidos</p>
            <input type="text" class="alignment" name="surname" placeholder="Apellidos" value="<?php
                echo ($surname != "NULL") ? $surname : "";
            ?>">
            <p class="p">Nombre de usuario</p>
            <input type="text" class="alignment" name="uid" placeholder="Nombre de usuario" value="<?php echo $username ?>">
            <p class="p">Email</p>
            <input type="text" class="alignment" name="email" placeholder="Correo electrónico" value="<?php echo $email?>">
            <p class="p">Pronombres</p>
            <input type="text" class="alignment" name="pronouns" placeholder="Pronombres" value="<?php
                echo ($pronouns != "NULL") ? $pronouns : "";
            ?>">
            <button type="submit" name="submit" class="submit-btn">Guardar cambios</button>
        </form>
    </div>
</div>
<?php
    if(isset($_GET['error'])){
        if($_GET['error'] == "emptyinput"){
            echo "<p>Rellena todos los campos</p>";
        }
        else if($_GET['error'] == "invalidemail"){
            echo "<p>Email inválido</p>";
        }
        else if($_GET['error'] == "stmtfailed"){
            echo "<p>Algo ha ido mal, por favor inténtalo de nuevo</p>";
        }
        else if($_GET['error'] == "usrnametaken"){
            echo "<p>El nombre de usuario ya está cogido</p>";
        }
        else if($_GET['error'] == "emailtaken"){
            echo "<p>El email ya pertenece a otra cuenta</p>";
        }
        else if($_GET['error'] == "none"){
            echo "<p>Todo ha ido bien</p>";
        }
    }
?>
<?php
    include_once 'footer.php';
?>