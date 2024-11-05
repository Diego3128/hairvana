<h1 class="page-name">Inicia sesión</h1>
<p class="page-description">Inicia sesión y crea una cita!</p>

<!-- alerts -->
<?php include_once __DIR__ . "/../templates/alerts.php";
?>


<form action="/" method="POST" class="form">
    <div class="field">
        <label for="email">Correo</label>
        <input type="email" name="user[email]" id="email" placeholder="Tu correo">
    </div>
    <div class="field">
        <label for="password">Contraseña</label>
        <input type="password" name="user[password]" id="password" placeholder="Tu contraseña">
    </div>

    <input type="submit" value="Iniciar sesión" class="button submit">
</form>

<div class="actions">
    <a href="/password/request">¿Olvidaste tu contraseña?</a>
    <a href="/create-account">Crear cuenta</a>
</div>