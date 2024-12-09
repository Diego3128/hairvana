<div class="field">
    <label for="name">Nombre</label>
    <input
        type="name"
        name="service[name]"
        id="name"
        placeholder="Nombre del servicio"
        required
        maxlength="50"
        value="<?php echo $service->name ?? '' ?>">
</div>

<div class="field">
    <label for="price">Precio</label>
    <input
        type="price"
        name="service[price]"
        id="price"
        placeholder="Precio del servicio"
        maxlength="3"
        required
        value="<?php echo explode(".", $service->price)[0] ?? ''; //delete dot and numbers after it 
                ?>">

</div>