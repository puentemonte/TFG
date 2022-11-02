<?php
    include_once 'header.php';
?>

<body class="text-center">
<main class="form-signin w-100 m-auto">
  <form action="includes/login_inc.php" method="post" novalidate>
    <div class="mt-custom">
        <h2 class="h3 mb-3 fw-normal">Iniciar sesión</h2>
    </div>
    <div class="form-floating">
      <input class="form-control" name="uid" placeholder="nombre@ejemplo.es">
      <label for="floatingInput">Nombre de usuario o correo electrónico</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="pwd" placeholder="Password">
      <label for="floatingPassword">Contraseña</label>
    </div>
    <button class="w-100 btn btn-lg custom-color-button" name="submit" type="submit">Iniciar sesión</button>
  </form>
</main>
</body>

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