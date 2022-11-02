<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Inicio</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> 
        <link rel="stylesheet" href="style/style1.css?<?php echo time(); ?>">
    </head>

    <body>
    <header class="p-3 mb-3 custom-color-header">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-light text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="index.php" class="nav-link px-2 link-light mr-custom">Inicio</a></li>
          <li><a href="#" class="nav-link px-2 link-light mr-custom">Social</a></li>
          <li><a href="#" class="nav-link px-2 link-light mr-custom">Eventos</a></li>
        </ul>
        
        <?php
        if (isset($_SESSION["useruid"])){
            echo"<div class='dropdown text-end'>
            <a href='#' class='d-block link-light text-decoration-none dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
              <img src='style/img/color-beige.png' alt='mdo' width='32' height='32' class='rounded-circle'>
            </a>
            <ul class='dropdown-menu text-small'>
              <li><a class='dropdown-item' href='profile.php'>Mi perfil</a></li>
              <li><a class='dropdown-item' href='settings.php'>Ajustes</a></li>
              <li><hr class='dropdown-divider'></li>
              <li><a class='dropdown-item' href='includes/logout_inc.php'>Cerrar sesión</a></li>
            </ul>
          </div>";
        }
        else {
            echo"<div class='text-end'>
            <a href='login.php' class='btn btn-outline-light me-2'>Iniciar sesión</a>
            <a href='signup.php' class='btn custom-color-button'>Registrarse</a>
          </div>";
        }
        ?>
      </div>
    </div>
  </header>
</body>

