
<?php
    include_once 'header.php';
?>

<div class="ajustes">
<nav class="nav nav-pills nav-fill">
    <div class="settings-menu">
        <a class="nav-link" href="settings.php">Actualizar perfil</a>
        <a class="nav-link active" aria-current="page" href="change-pwd.php">Cambiar contraseña</a>
        <a class="nav-link" href="delete-usr.php">Eliminar cuenta</a>
    </div>   
</nav>
<body class="text-center campos">
    <main class="form-signin w-100 m-auto">
    <form action="includes/changepwd_inc.php" method="post" novalidate>
    <div class="mt-custom">
        <h2 class="h3 mb-3 fw-normal">Cambiar contraseña</h2>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="pwd" placeholder="Contraseña actual">
      <label for="floatingPassword">Contraseña actual</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="newpwd" placeholder="Contraseña nueva">
      <label for="floatingPassword">Contraseña nueva</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="newpwdrepeat" placeholder="Repite tu contraseña nueva">
      <label for="floatingPassword">Repite tu contraseña nueva</label>
    </div>
    <button class="w-100 btn btn-lg custom-color-button" name="submit" type="submit">Cambiar</button>
    </form>
    </main>
</body>
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