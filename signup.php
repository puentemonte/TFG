<?php
    include_once 'header.php';
?>

<h2>Registrarse</h2>
<form action="includes/signup_inc.php" method="post">
    <!--opcional-->
    <p class="p">Nombre <input type="text" class="alignment" name="fname" placeholder="Nombre"></p>
    <p class="p">Apellidos</p>
    <input type="text" class="alignment" name="surname" placeholder="Apellidos">
    <!---->
    <p class="p">Nombre de usuario</p>
    <input type="text" class="alignment" name="uid" placeholder="Nombre de usuario">
    <p class="p">Email</p>
    <input type="text" class="alignment" name="email" placeholder="Correo electrónico">
    <p class="p">Contraseña</p>
    <input type="password" class="alignment" name="pwd" placeholder="Contraseña">
    <p class="p">Repite la contraseña</p>
    <input type="password" class="alignment" name="pwdrepeat" placeholder="Repite la contraseña">
    <!--opcional-->
    <p class="p">Pronombres</p>
    <input type="text" class="alignment" name="pronouns" placeholder="Pronombres"> <!--drop-down?-->
    <!--<input type="text" name="description" class="descr" placeholder="Descripción">-->
    <!---->
    <button type="submit" name="submit" class="submit-btn">Crear cuenta</button>
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
            echo "<p>Todo ha ido bien</p>";
        }
    }
?>

<?php
    include_once 'footer.php';
?>