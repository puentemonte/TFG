
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
            <p class="p">Contraseña</p>
            <input type="password" class="alignment" name="pwd" placeholder="Contraseña">
            <p class="p">Repite la contraseña</p>
            <input type="password" class="alignment" name="pwdrepeat" placeholder="Repite la contraseña">
            <button type="submit" name="submit" class="submit-btn">Guardar cambios</button>
        </form>
    </div>
</div>
<?php
    include_once 'footer.php';
?>