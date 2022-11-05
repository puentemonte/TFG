<?php
    include_once 'header.php';
?>

<div class="ajustes">
<nav class="nav nav-pills nav-fill">
    <div class="settings-menu">
        <a class="nav-link" href="settings.php">Actualizar perfil</a>
        <a class="nav-link" href="change-pwd.php">Cambiar contraseña</a>
        <a class="nav-link active" aria-current="page" href="delete-usr.php">Eliminar cuenta</a>
    </div>   
</nav>
<body class="text-center campos">
    <main class="form-signin w-100 m-auto">
    <form action="includes/deleteusr_inc.php" method="post" novalidate>
    <div class="mt-custom">
        <h2 class="h3 mb-3 fw-normal">Eliminar cuenta</h2>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="pwd" placeholder="Contraseña actual">
      <label for="floatingPassword">Contraseña actual</label>
    </div>
    <button class="w-100 btn btn-lg custom-color-button" name="submit" type="submit">Eliminar</button>
    </form>
    </main>
</body>
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