<?php
    include_once 'header.php';
?>

<body class="text-center">
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
        else if ($_GET["error"] == "invaliddate"){
            echo "<div class='mt-custom alert alert-danger d-flex align-items-center' role='alert'>
                        <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                        <div>
                            La fecha introducida no es válida
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
    <form action="includes/addevent_inc.php" method="post" novalidate>
        <div class="mt-custom">
            <h2 class="h3 mb-3 fw-normal">Añadir evento</h2>
        </div>
        <div class="form-floating">
            <input type="text" class="form-control" name="title" placeholder="Título">
            <label for="floatingInput" class='floating-input'>Título</label>
        </div>
        <div class="form-floating">
            <input type="date" class="form-control" name="date" placeholder="Autor">
            <label for="floatingInput" class='floating-input'>Fecha</label>
        </div>
        <div class="form-floating">
            <input type="time" class="form-control" name="hour" placeholder="ISBN">
            <label for="floatingInput" class='floating-input'>Hora</label>
        </div>
        <div class="form-floating">
            <input type="text" class="form-control" name="place" placeholder="Editorial">
            <label for="floatingInput" class='floating-input'>Ubicación</label>
        </div>
        <button class="w-100 btn btn-lg custom-color-button mb-custom" name="submit" type="submit">Añadir evento</button>
  </form>
</main>
</body>

<?php
    include_once 'footer.php';
?>