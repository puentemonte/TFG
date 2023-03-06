<?php
include_once 'header.php';

// external functions and data bases
require_once "includes/dbh_inc.php";
require_once "includes/functions_inc.php";
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
                                Rellena los campos requeridos
                            </div>
                    </div>";
            }
        }
        ?>
        <form action="includes/addclub_inc.php" method="post" novalidate>
            <div class="mt-custom">
                <h2 class="h3 mb-3 fw-normal">Crear club</h2>
            </div>
            <div class="form-floating">
                <input class="form-control" name="name" placeholder="Club de lectura">
                <label for="floatingInput" class='floating-input'>Nombre</label>
            </div>
            <div class="form-floating">
                <input type="textarea" class="form-control" name="desc" placeholder="Descripción">
                <label for="floatingInput" class='floating-input'>Descripción</label>
            </div>
            <div class="form-floating">
                <datalist id="suggestions">
                    <?php 
                        $all_books = get_all_books($conn);
                        foreach($all_books as $book_data) {
                            $title = $book_data['title'];
                            $author = $book_data['author'];
                            $isbn= $book_data['isbn'];

                            echo "<option value='$isbn'>$title, $author</option>";
                        }
                    ?>
                </datalist>
                <input autoComplete="on" list="suggestions" class="form-control" name="currBook" placeholder="Lectura actual">
                <label for="floatingInput" class='floating-input'>Lectura actual</label> 
            </div>
            <div class="form-floating">
                <input type="date" class="form-control" name="nextDate" placeholder="Próxima fecha">
                <label for="floatingInput" class='floating-input'>Próxima fecha</label>
            </div>
            <div class="form-floating">
                <input type="number" class="form-control" name="currPages" placeholder="Páginas Leídas">
                <label for="floatingInput" class='floating-input'>Páginas leídas</label>
            </div>
            <button class="w-100 btn btn-lg custom-color-button" name="namedesc" type="submit">Crear</button>
        </form>
    </main>
</body>