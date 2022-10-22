<?php
    include_once 'header.php';
?>

<h2>Iniciar sesión</h2>
<form action="includes/login_inc.php" method="post">
    <p class="p">Nombre de usuario o Email</p>
    <input type="text" class="alignment" name="uid" placeholder="Nombre de usuario o correo electrónico...">
    <p class="p">Contraseña</p>
    <input type="password" class="alignment" name="pwd" placeholder="Contraseña...">
    <button type="submit" name="submit" class="submit-btn">Iniciar sesión</button>
</form>
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

<?php
    include_once 'footer.php';
?>