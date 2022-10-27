
<?php
    include_once 'header.php';
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
        <form action="includes/changepwd_inc.php" method="post">
            <p class="p">Contraseña actual</p>
            <input type="password" class="aligment" name="pwd" placeholder="Contraseña actual">
            <p class="p">Contraseña nueva</p>
            <input type="password" class="alignment" name="newpwd" placeholder="Contraseña nueva">
            <p class="p">Repite la contraseña nueva</p>
            <input type="password" class="alignment" name="newpwdrepeat" placeholder="Repite la contraseña nueva">
            <button type="submit" name="submit" class="submit-btn">Guardar cambios</button>
        </form>
    </div>
</div>
<?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput"){
            echo "<p>Rellena todos los campos</p>";
        }
        else if ($_GET["error"] == "wrongpwd"){
            echo "<p>Contraseña actual incorrecta</p>";
        }
        else if ($_GET["error"] == "invalidpwd"){
            echo "<p>La contraseña tiene que contener letras mayúsculas, minúsculas, 
            al menos un número y ha de tener una longitud de al menos 8 caracteres</p>";
        }
        else if($_GET["error"] == "pwdnomatch"){
            echo "<p>La contraseña no coincide</p>";
        }
        else if($_GET["error"] == "none") {
            echo "<p>Todo ha salido bien</p>";
        }
    }
?>
<?php
    include_once 'footer.php';
?>