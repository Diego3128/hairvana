<h1 class="page-name">Olvidaste tu contraseña?</h1>
<p class="page-description">Crea una contraseña nueva</p>

<!-- alerts -->
<?php include_once __DIR__ . "/../templates/alerts.php";
?>

<form action="/password-request" method="POST" class="form">
    <div class="field">
        <label for="email">Correo</label>
        <input type="email" name="email" id="email" placeholder="Tu correo">
    </div>
    <input type="submit" value="Enviar instrucciones" class="button submit">
</form>

<div class="actions">
    <a href="/">Iniciar sesión</a>
    <a href="/create-account">Crear cuenta</a>

</div>