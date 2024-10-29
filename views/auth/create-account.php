<h1 class="page-name">crear cuenta</h1>
<p class="page-description">Llena el siguiente formulario para crear una cuenta</p>

<form action="/create-account" method="POST" class="form">
    <div class="field">
        <label for="nombre">Nombre</label>
        <input type="text" name="name" id="nombre" placeholder="Tu nombre">
    </div>
    <div class="field">
        <label for="apellido">Apellido</label>
        <input type="text" name="lastname" id="apellido" placeholder="Tu apellido">
    </div>
    <div class="field">
        <label for="telefono">Telefono</label>
        <input type="tel" name="phone" id="telefono" placeholder="Tu telefono">
    </div>
    <div class="field">
        <label for="email">Correo</label>
        <input type="email" name="email" id="email" placeholder="Tu correo">
    </div>
    <div class="field">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" placeholder="Tu contraseña">
    </div>

    <input type="submit" value="Crear cuenta" class="button submit">
</form>

<div class="actions">
    <a href="/">Iniciar sesión</a>
</div>