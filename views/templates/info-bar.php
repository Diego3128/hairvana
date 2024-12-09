<div class="bar-info">
    <div class="content">
        <p class="user-name">Bienvenid@ <?php echo $username ?></p>
        <a href="/logout"><img class="logout-img" src="/build/img/logout.svg" alt="logout"></a>
    </div>
</div>

<?php if (isset($_SESSION["admin"])): ?>
    <div class="dropdown">
        <button class="dropdown-toggle">Actiones</button>
        <div class="dropdown-menu hide">
            <a class="button" href="/admin">Ver citas</a>
            <a class="button" href="/services">Ver servicios</a>
            <a class="button" href="/services/create">Crear servicio</a>
        </div>
    </div>
<?php endif; ?>