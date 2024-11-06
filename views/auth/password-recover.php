<h1 class="page-name">Restablecer contraseña</h1>
<p class="page-description">Crea una contraseña nueva:</p>

<!-- alerts -->
<?php
include_once __DIR__ . "/../templates/alerts.php";
?>

<?php if (!$accessError): ?>
    <form method="POST" class="form">
        <div class="field">
            <label for="password">Nueva contraseña</label>
            <input
                type="password"
                name="password"
                id="password"
                placeholder="Tu nueva contraseña">
        </div>
        <input type="submit" value="Actualizar" class="button submit">
    </form>
<?php endif; ?>
<div class="actions">
    <a href="/">Iniciar sesión</a>
    <a href="/create-account">Crear cuenta</a>
</div>