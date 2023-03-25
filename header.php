<?php
    session_start();

    require_once "./includes/dbh_inc.php";
    require_once "./includes/functions_inc.php";
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Libeer</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> 
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v6.2.1/css/all.css">
        <link rel="icon" href="icons/favicon.ico" type="image/ico">
        <link rel="stylesheet" href="style/style.css?<?php echo time(); ?>">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      </head>

    <body>
    <header class="p-3 mb-3 custom-color-header fixed-top">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-light text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="index.php" class="nav-link px-2 mr-custom"><b>Inicio</b></a></li>
          <li><a href="social.php" class="nav-link px-2 mr-custom"><b>Social</b></a></li>
          <li><a href="clubs.php" class="nav-link px-2 mr-custom"><b>Clubs de Lectura</b></a></li>
          <li><a href="events.php" class="nav-link px-2 mr-custom"><b>Eventos</b></a></li>
        </ul>

        <form action = "search.php" class="d-flex" method="GET" role="search">
          <input class="form-control me-2" name="k" value="<?php echo isset($_GET['k']) ? $_GET['k'] : ''; ?>" type="search" placeholder="Título, autor, ISBN..." aria-label="Search">
          <button class="btn custom-color-button" type="submit"><b>Buscar</b></button>
        </form>
        
        <?php
        if (isset($_SESSION["useruid"])){
            $nickname = $_SESSION['useruid'];
            $uid = $_SESSION['userid'];
            set_event_notifications($conn, $uid);
            $num_notis = get_unread_notifications($conn, $uid);

            echo "
            <div class='icon-btn'>
              <a href='notifications.php' class = 'notif'>
                <i class='fa-solid fa-bell'>";
              if ($num_notis > 0)
                echo "<span class='badge rounded-pill badge-notification notif-badge'>$num_notis</span>";
            echo "
                </i>
              </a>
            </div>
            <div class='dropdown text-end'>
            <a href='#' class='d-block link-dark text-decoration-none dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
              <b>$nickname</b>
              <img src='style/img/color-beige.png' alt='mdo' width='32' height='32' class='rounded-circle'>
            </a>
            <ul class='dropdown-menu text-small'>
              <li><a class='dropdown-item' href='profile.php?uid=$uid'>Mi perfil</a></li>
              <li><a class='dropdown-item' href='library.php'>Mi biblioteca</a></li>
              <li><a class='dropdown-item' href='clubs.php'>Mis clubes</a></li>
              <li><a class='dropdown-item' href='myevents.php'>Mis eventos</a></li>
              <li><hr class='dropdown-divider'></li>";

              if(isVerified($conn, $uid)) {
                echo "<li><a class='dropdown-item' href='addbook.php'>Añadir libro</a></li>
                <li><a class='dropdown-item' href='addclub.php'>Crear club</a></li>
                <li><a class='dropdown-item' href='addevent.php'>Crear evento</a></li>
                <li><hr class='dropdown-divider'></li>";
              }
              else {
                echo "<li><a class='dropdown-item' href='askverified.php'>Solicitar verificado</a></li>
                <li><hr class='dropdown-divider'></li>";
              }

              echo "<li><a class='dropdown-item' href='settings.php'>Ajustes</a></li>
              <li><a class='dropdown-item' href='includes/logout_inc.php'>Cerrar sesión</a></li>";

              if(isAdmin($conn, $uid)){
                echo "<li><hr class='dropdown-divider'></li>
                <li><a class='dropdown-item' href='manage-requests.php'>Administrar verificados</a></li>";
              }

            echo "</ul>
          </div>";
        }
        else {
            echo"<div class='text-end'>
            <a href='login.php' class='btn me-2 custom-color-button-2'><b>Iniciar sesión</b></a>
            <a href='signup.php' class='btn custom-color-button'><b>Registrarse</b></a>
          </div>";
        }
        ?>
      </div>
    </div>
  </header>
</body>