<?php
    include_once 'header.php';
?>

<section class="login-form">
    <h2>Iniciar sesión</h2>
    <div class="login-form-form">
        <form action="includes/login_inc.php" method="post">
            <input type="text" name="uid" placeholder="Nombre de usuario o correo electrónico...">
            <input type="password" name="pwd" placeholder="Contraseña...">
            <button type="submit" name="submit">Iniciar sesión</button>
        </form>
    </div> 
    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput"){
            echo "<p>Rellena todos los campos</p>";
        }
        else if ($_GET["error"] == "wronglogin"){
            echo "<p>Usuario o contraseña incorrectos</p>";
        }
    }
    ?>
</section>

<?php
    include_once 'footer.php';
?>