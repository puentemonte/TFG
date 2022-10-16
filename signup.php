<?php
    include_once 'header.php';
?>

<h2>Registrarse</h2>
<form action="includes/signup_inc.php" method="post">
<!--opcional-->
<input type="text" name="fname" placeholder="Nombre">
<input type="text" name="surname" placeholder="Apellidos">
<!---->
<input type="text" name="uid" placeholder="Nombre de usuario">
<input type="text" name="email" placeholder="Correo electrónico">
<input type="password" name="pwd" placeholder="Contraseña">
<input type="password" name="pwdrepeat" placeholder="Repite la contraseña">
<!--opcional-->
<input type="text" name="pronouns" placeholder="Pronombres"> <!--drop-down?-->
<input type="text" name="description" placeholder="Descripción">
<!---->
<button type="submit" name="submit">Crear cuenta</button>
</form>
<?php
    if(isset($_GET['error'])){
        if($_GET['error'] == "emptyinput"){
            echo "<p>Rellena todos los campos</p>";
        }
        else if($_GET['error'] == "invalidemail"){
            echo "<p>Email inválido</p>";
        }
        else if($_GET['error'] == "pwdnomatch"){
            echo "<p>La contraseña no coincide</p>";
        }
        else if($_GET['error'] == "usrnametaken"){
            echo "<p>El nombre de usuario ya está cogido</p>";
        }
        else if($_GET['error'] == "invalidpwd"){
            echo "<p>La contraseña tiene que contener letras mayúsculas, minúsculas, 
            al menos un número y ha de tener una longitud de al menos 8 caracteres</p>";
        }
        else if($_GET['error'] == "stmtfailed"){
            echo "<p>Algo ha ido mal, por favor inténtalo de nuevo</p>";
        }
        else if($_GET['error'] == "none"){
            echo "<p>Yay! Todo ha ido bien :)</p>";
        }
    }
?>

<?php
    include_once 'footer.php';
?>