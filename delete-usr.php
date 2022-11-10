<?php
    include_once 'header.php';
?>

<div class="ajustes text-center">
    <nav class="nav nav-pills nav-fill">
        <div class="settings-menu">
            <a class="btn sidebar sidebar-custom" href="settings.php">Actualizar perfil</a>
            <a class="btn sidebar sidebar-custom" href="change-pwd.php">Cambiar contraseña</a>
            <a class="btn sidebar custom-color-sidebar  mb-sidebar-custom" aria-current="page" href="delete-usr.php">Eliminar cuenta</a>
        </div>   
    </nav>

    <body class="text-center campos">
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
                else if ($_GET["error"] == "wrongpwd"){
                    echo "<div class='mt-custom alert alert-danger d-flex align-items-center' role='alert'>
                                <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                                <div>
                                    La contraseña actual es incorrecta
                                </div>
                        </div>";
                }
            }
            ?>
            <form class="delete-usr-form" action="includes/deleteusr_inc.php" method="post" novalidate>
                <div class="mt-custom">
                    <h2 class="h3 mb-3 fw-normal">Eliminar cuenta</h2>
                </div>
                
                <div class="form-floating">
                    <input type="password" class="form-control" name="pwd" placeholder="Contraseña actual">
                    <label for="floatingPassword">Contraseña actual</label>
                </div>
                <button type="submit" name="submit" class="w-100 btn btn-lg custom-color-button" onclick="clicked(event)">Eliminar</button>
            </form>

            <script>
                function clicked(e) {
                    if(!confirm('Estas seguro de eliminar tu cuenta?')) {
                        e.preventDefault();
                    }
                }
            </script>
        </main>
    </body>
</div>

<?php
    include_once 'footer.php';
?>