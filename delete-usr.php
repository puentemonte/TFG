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
        <form action="includes/deleteusr_inc.php" method="post">
            <p class="advise">Aviso: este proceso es definitivo, por lo que si borra la cuenta no podrá recuperarla.</p>
            <p class="p">Contraseña actual</p>
            <input type="password" class="aligment" name="pwd" placeholder="Contraseña actual">
            <button type="submit" name="submit" class="submit-btn">Eliminar cuenta</button>
        </form>
    </div>
</div>
<?php
    if(isset($_GET['error'])){
        if($_GET['error'] == "emptyinput"){
            echo "<p>Rellena todos los campos</p>";
        }
        else if ($_GET['error'] == "wrongpwd"){
            echo "<p>Contraseña incorrecta</p>";
        }
        else if($_GET['error'] == "none"){
            echo "<p>Todo ha ido bien</p>";
        }
    }
?>
<?php
    include_once 'footer.php';
?>