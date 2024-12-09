<?php
include __DIR__ . "/../templates/info-bar.php";
?>

<h1 class="page-name title-plain">Administrar servicios</h1>

<ul class="service-list">
    <?php

    foreach ($services as $service): ?>
        <li class="service">
            <p class="service__name"><?php echo $service->name; ?></p>
            <div class="flex-group">

            </div>
            <p class="service__price"><?php echo $service->price; ?></p>
            <div class="service__options">

                <form action="/services/update" method="get">
                    <input type="hidden" name="id" value="<?php echo $service->id; ?>">
                    <div class="tooltip">
                        <button type="submit"><img src="/build/img/edit.svg" alt="update"></button>
                        <span class="tooltip-text">Editar</span>
                    </div>
                </form>

                <form action="/services/delete" method="post">
                    <input type="hidden" name="id" value="<?php echo $service->id; ?>">
                    <div class="tooltip">
                        <button type="submit"><img src="/build/img/delete.svg" alt="delete"></button>
                        <span class="tooltip-text">Eliminar</span>
                    </div>
                </form>
            </div>
        </li>
    <?php endforeach; ?>

</ul>


<?php $script = "
<script src='/build/js/utils/admin/dropdown.min.js'></script>
";
?>