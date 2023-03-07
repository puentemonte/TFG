<?php
    include_once 'header.php';
    $cid = $_GET['cid'];
?>
<div class="form-signin w-100 m-auto text-center">
    <form class="delete-usr-form" action="includes/adddiscussion_inc.php?cid=<?php echo $cid?>" method="post" novalidate>
        <div class="mt-custom">
            <h2 class="h3 mb-3 fw-normal">Crear tema de discusion</h2>
        </div>
        
        <div class="form-floating">
            <input type="text" class="form-control" name="topic" placeholder="Capítulos I y II">
            <label for="floatingPassword" class='floating-input'>Nombre del tema*</label>
        </div>
        <button type="submit" name="submit" class="w-100 btn btn-lg custom-color-button">Crear</button>
    </form>
</div>

<?php
    include_once 'footer.php';
?>