<?php
    include_once 'header.php';
?>

<body class="text-center">
<main class="form-signin w-100 m-auto">
  <form action="includes/signup_inc.php" method="post" novalidate>
    <div class="mt-custom">
        <h2 class="h3 mb-3 fw-normal">Registrarse</h2>
    </div>
    <div class="form-floating">
        <input type="text" class="form-control" name="fname" placeholder="Nombre">
        <label for="floatingInput">Nombre</label>
    </div>
    <div class="form-floating">
        <input type="text" class="form-control" name="surname" placeholder="Apellidos">
        <label for="floatingInput">Apellidos</label>
    </div>
    <div class="form-floating">
        <input type="text" class="form-control" name="uid" placeholder="Nombre de usuario">
        <label for="floatingInput">Nombre de usuario</label>
    </div>
    <div class="form-floating">
      <input class="form-control" name="email" placeholder="nombre@ejemplo.es">
      <label for="floatingInput">Correo electrónico</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="pwd" placeholder="Contraseña">
      <label for="floatingPassword">Contraseña</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="pwdrepeat" placeholder="Repite tu contraseña">
      <label for="floatingPassword">Repite tu contraseña</label>
    </div>
    <div class="form-floating">
        <select class="custom-select my-1 mr-sm-2 form-control" name = "pronouns">
            <option selected>No seleccionado</option>
            <option value="Él">Él</option>
            <option value="Ella">Ella</option>
            <option value="Elle">Elle</option>
        </select>
        <label for="floatingInput">Pronombres</label>
    </div>
    <button class="w-100 btn btn-lg custom-color-button" name="submit" type="submit">Registrarse</button>
  </form>
</main>
</body>

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