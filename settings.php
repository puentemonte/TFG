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
    <div class="menu-ajustes">
        <button type="button" name="change-pwd" class="submit-btn">Cambiar contraseña</button>
        <button type="button" name="delete-usr" class="submit-btn">Eliminar cuenta</button>
    </div>
    <div class="campos">
        <form action="includes/settings_inc.php" method="post">
            <input type="text" name="fname" placeholder="Nombre" value="<?php
                if($fname != "NULL"){
                    echo $fname;
                }
                else{
                    echo "";
                }
            ?>">
            <input type="text" name="surname" placeholder="Apellidos" value="<?php
                if($surname != "NULL"){
                    echo $surname;
                }
                else{
                    echo "";
                }
            ?>">">
            <input type="text" name="uid" placeholder="Nombre de usuario" value="<?php echo $username ?>">
            <input type="text" name="email" placeholder="Correo electrónico" value="<?php echo $email?>">
            <input type="password" name="pwd" placeholder="Contraseña">
            <input type="password" name="pwdrepeat" placeholder="Repite la contraseña">
            <input type="text" name="pronouns" placeholder="Pronombres" value="<?php
                if($pronouns != "NULL"){
                    echo $pronouns;
                }
                else{
                    echo "";
                }
            ?>">
            <button type="submit" name="submit" class="submit-btn">Guardar cambios</button>
        </form>
    </div>
</div>
<?php
    include_once 'footer.php';
?>