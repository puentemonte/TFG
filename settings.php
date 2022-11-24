<?php
    include_once 'header.php';
    // user session data
    $fname = $_SESSION["fname"];
    $surname = $_SESSION["surname"];
    $username = $_SESSION["useruid"];
    $email = $_SESSION["email"];
    $pronouns = $_SESSION["pronouns"];
?>

<div class="ajustes text-center">
    <nav class="nav nav-pills nav-fill">
        <div class="settings-menu">
            <a class="btn custom-color-sidebar mb-sidebar-custom" aria-current="page" href="settings.php">Actualizar perfil</a>
            <a class="btn sidebar-custom" href="change-pwd.php">Cambiar contraseña</a>
            <a class="btn sidebar-custom" href="delete-usr.php">Eliminar cuenta</a>
        </div>   
    </nav>
    <div class="campos">
        <main class="form-signin w-100 m-auto">
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </symbol>
            </svg>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput"){
                    echo "<div class='mt-custom alert alert-danger d-flex align-items-center' role='alert'>
                                <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                                <div>
                                    Rellena todos los campos
                                </div>
                        </div>";
                }
                else if ($_GET["error"] == "invalidemail"){
                    echo "<div class='mt-custom alert alert-danger d-flex align-items-center' role='alert'>
                                <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                                <div>
                                    El email introducido no es válido
                                </div>
                        </div>";
                }
                else if ($_GET["error"] == "usrnametaken"){
                    echo "<div class='mt-custom alert alert-danger d-flex align-items-center' role='alert'>
                                <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                                <div>
                                    El nombre de usuario introducido se encuentra en uso
                                </div>
                        </div>";
                }
                else if ($_GET["error"] == "stmtfailed"){
                    echo "<div class='mt-custom alert alert-danger d-flex align-items-center' role='alert'>
                                <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                                <div>
                                    Algo ha salido mal, inténtalo más tarde
                                </div>
                        </div>";
                }
            }
            ?>
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
                <button class="w-100 btn btn-lg custom-color-button mb-custom" name="submit" type="submit">Actualizar</button>
            </form>
        </main>
    </div>
</div>

<?php
    include_once 'footer.php';
?>