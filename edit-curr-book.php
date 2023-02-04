<?php
include_once 'header.php';

// external functions and data bases
require_once "includes/dbh_inc.php";
require_once "includes/functions_inc.php";

if (isset($_GET["cid"])) { // add a member to a club
    $cid = $_GET["cid"];

    $club_info = get_info_clubs($conn, $cid);
    $current_book = $club_info['currBook'];

    $pages = 0;
    $next_date = NULL;
    if ($current_book != 0) {
        $ret = get_book_info($conn, $current_book);

        // Get the book's progress
        $pages = $club_info['currPages'];
        $next_date = $club_info['nextDate'];
    }
    if($current_book == 0){
        $current_book = NULL;
    }
}
?>

<body class="text-center">
    <div class="settings-btn">
        <div class="center">
            <a class="btn sidebar-custom"  href="edit-club.php?cid=<?php echo $cid?>"><b>Editar club</b></a>  
            <a class="btn custom-color-sidebar mb-sidebar-custom" aria-current="page" href="edit-curr-book.php?cid=<?php echo $cid?>"><b>Editar lectura actual</b></a>
            <a class="btn sidebar-custom" href="edit-discussions.php?cid=<?php echo $cid?>"><b>Editar discusiones</b></a>
            <a class="btn sidebar-custom" href="edit-members.php?cid=<?php echo $cid?>"><b>Editar miembros</b></a>
        </div>
    </div>
    <main class="form-signin w-100 m-auto">
        <form action="includes/editclub_inc.php?cid=<?php echo $cid?>" method="post" novalidate>
            <div class="mt-custom-settings">
                <h2 class="h3 mb-3 fw-normal">Lectura actual</h2>
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
                <input autoComplete="on" list="suggestions" class="form-control" name="currBook" placeholder="Frankenstein" value="<?php echo $current_book;?>">
                <label for="floatingInput" class='floating-input'>Lectura actual</label> 
            </div>
            <div class="form-floating">
                <input type="date" class="form-control" name="nextDate" value="<?php echo $next_date;?>">
                <label for="floatingInput" class='floating-input'>Próxima fecha</label>
            </div>
            <div class="form-floating">
                <input type="number" class="form-control" name="currPages" value="<?php echo $pages;?>">
                <label for="floatingInput" class='floating-input'>Páginas leídas</label>
            </div>
            <button class="w-100 btn btn-lg custom-color-button" name="currentbook" type="submit">Actualizar</button>
        </form>
    </main>
</body>