<h1 class="page-name">crear cuenta</h1>
<p class="page-description">Llena el siguiente formulario para crear una cuenta</p>

<!-- alerts -->
<?php include_once __DIR__ . "/../templates/alerts.php";
?>

<form action="/create-account" method="POST" class="form">
    <div class="field">
        <label for="nombre">Nombre</label>
        <input
            type="text"
            name="user[name]"
            id="nombre"
            maxlength="60"
            placeholder="Tu nombre"
            value="<?php echo stzr($user->name) ?>">
    </div>
    <div class="field">
        <label for="apellido">Apellido</label>
        <input
            type="text"
            name="user[lastname]"
            id="apellido"
            placeholder="Tu apellido"
            maxlength="60"
            value="<?php echo stzr($user->lastname) ?>">
    </div>
    <div class="field">
        <label for="telefono">Telefono</label>
        <input
            type="tel"
            name="user[phone]"
            id="telefono"
            placeholder="Tu telefono"
            maxlength="10"
            minlength="10"
            value="<?php echo stzr($user->phone) ?>">
    </div>
    <div class="field">
        <label for="email">Correo</label>
        <input
            type="email"
            name="user[email]"
            id="email"
            maxlength="40"
            placeholder="Tu correo"
            value="<?php echo stzr($user->email) ?>">

    </div>
    <div class="field">
        <label for="password">Contraseña</label>
        <input
            type="password"
            name="user[password]"
            id="password"
            maxlength="40"
            placeholder="Tu contraseña">
    </div>

    <input type="submit" value="Crear cuenta" class="button submit">
</form>

<div class="actions">
    <a href="/">Iniciar sesión</a>
</div>