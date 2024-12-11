<?php
include __DIR__ . "/../templates/info-bar.php";
?>

<h1 class="page-name title-plain">Administrar servicios</h1>

<h3 class="title-plain">Actualizar servicio</h3>


<?php include_once __DIR__ . "/../templates/alerts.php"; ?>

<form method="post" class="form">
    <?php include_once __DIR__ . "/form.php"; ?>
    <input type="submit" class="button submit" value="Guardar">
</form>


<?php $script = "
<script src='/build/js/utils/admin/dropdown.min.js'></script>
";
?>