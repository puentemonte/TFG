<?php
    include_once 'header.php';
?>
<?php
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
            <div class="alignment">
                <p>Nombre: <input type="text" name="fname" placeholder="Nombre" value="<?php
                    echo ($fname != "NULL") ? $fname : "";?>">
                </p>
            </div>
            <p>Apellidos:</p>
            <input type="text" name="surname" placeholder="Apellidos" value="<?php
                echo ($surname != "NULL") ? $surname : "";
            ?>">
            <input type="text" name="uid" placeholder="Nombre de usuario" value="<?php echo $username ?>">
            <input type="text" name="email" placeholder="Correo electrónico" value="<?php echo $email?>">
            <input type="text" name="pronouns" placeholder="Pronombres" value="<?php
                echo ($pronouns != "NULL") ? $pronouns : "";
            ?>">
            <button type="submit" name="submit" class="submit-btn">Guardar cambios</button>
        </form>
    </div>
</div>
<?php
    include_once 'footer.php';
?>