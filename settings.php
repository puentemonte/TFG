<?php
    include_once 'header.php';
    // user session data
    $fname = $_SESSION["fname"];
    $surname = $_SESSION["surname"];
    $username = $_SESSION["useruid"];
    $email = $_SESSION["email"];
    $pronouns = $_SESSION["pronouns"];
?>

<div class="ajustes">
<nav class="nav nav-pills nav-fill">
    <div class="settings-menu">
        <a class="nav-link active" aria-current="page" href="settings.php">Actualizar perfil</a>
        <a class="nav-link" href="change-pwd.php">Cambiar contraseña</a>
        <a class="nav-link" href="delete-usr.php">Eliminar cuenta</a>
    </div>   
</nav>
<body class="text-center campos">
    <main class="form-signin w-100 m-auto">
    <form action="includes/changedata_inc.php" method="post" novalidate>
    <div class="mt-custom">
        <h2 class="h3 mb-3 fw-normal">Actualizar perfil</h2>
    </div>
    <div class="form-floating">
        <input type="text" class="form-control" name="fname" placeholder="Nombre" value="<?php
        echo ($fname != "NULL") ? $fname : "";?>">
        <label for="floatingInput">Nombre</label>
    </div>
    <div class="form-floating">
        <input type="text" class="form-control" name="surname" placeholder="Apellidos" value="<?php
        echo ($surname != "NULL") ? $surname : "";?>">
        <label for="floatingInput">Apellidos</label>
    </div>
    <div class="form-floating">
        <input type="text" class="form-control" name="uid" placeholder="Nombre de usuario" value="<?php echo $username ?>">
        <label for="floatingInput">Nombre de usuario</label>
    </div>
    <div class="form-floating">
        <input class="form-control" name="email" placeholder="nombre@ejemplo.es" value="<?php echo $email?>">
        <label for="floatingInput">Correo electrónico</label>
    </div>
    <div class="form-floating">
        <select class="custom-select my-1 mr-sm-2 form-control" name = "pronouns" selected="<?php echo $pronouns?>">
            <option value="Él" <?php  if ($pronouns === "Él"){ echo "selected";}?>>Él</option>
            <option value="Ella" <?php if ($pronouns === "Ella"){ echo "selected";}?>>Ella</option>
            <option value="Elle"<?php if ($pronouns === "Elle"){ echo "selected";}?>>Elle</option>
        </select>
        <label for="floatingInput">Pronombres</label>
    </div>
    <button class="w-100 btn btn-lg custom-color-button" name="submit" type="submit">Actualizar</button>
    </form>
    </main>
</body>
</div>

<?php
    if(isset($_GET['error'])){
        if($_GET['error'] == "emptyinput"){
            echo "<p>Rellena todos los campos</p>";
        }
        else if($_GET['error'] == "invalidemail"){
            echo "<p>Email inválido</p>";
        }
        else if($_GET['error'] == "stmtfailed"){
            echo "<p>Algo ha ido mal, por favor inténtalo de nuevo</p>";
        }
        else if($_GET['error'] == "usrnametaken"){
            echo "<p>El nombre de usuario ya está cogido</p>";
        }
        else if($_GET['error'] == "emailtaken"){
            echo "<p>El email ya pertenece a otra cuenta</p>";
        }
        else if($_GET['error'] == "none"){
            echo "<p>Todo ha ido bien</p>";
        }
    }
?>
<?php
    include_once 'footer.php';
?>