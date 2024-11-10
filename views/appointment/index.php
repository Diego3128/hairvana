<h1 class="page-name">Crea una nueva cita</h1>
<p class="page-description">Elije los servicios</p>


<div id="app">

    <nav class="tabs" id="tabs">
        <button class="tab tab-current" data-step="1">servicios</button>
        <button class="tab" data-step="2">información</button>
        <button class="tab" data-step="3">resumen</button>
    </nav>

    <div id="step-1" class="section hide">
        <h2>servicios</h2>
        <p class="text-center">Elije los servicios a continuación</p>
        <div id="service-container" class="service-list"></div>
    </div>

    <div id="step-2" class="section hide">
        <h2>Tus datos y cita</h2>
        <p class="text-center">Agrega tus datos y la fecha de la cita</p>

        <form class="form visible">
            <div class="field">
                <label for="nombre">Nombre</label>
                <input
                    type="text"
                    name="name"
                    id="nombre"
                    maxlength="60"
                    value="<?php echo stzr($username) ?>"
                    readonly
                    placeholder="Tu nombre" />
            </div>

            <div class="field">
                <label for="date">Fecha</label>
                <input
                    type="date"
                    name="date"
                    id="date" />
            </div>

            <div class="field">
                <label for="time">Hora</label>
                <input
                    type="time"
                    name="time"
                    id="time" />
            </div>

        </form>
    </div>

    <div id="step-3" class="section hide">
        <h2>Resumen</h2>
        <p class="text-center">Verifica la información:</p>
    </div>

    <div class="pagination">
        <button id="previous" class="button">&laquo; Anterior</button>
        <button id="next" class="button"> Siguiente &raquo;</button>
    </div>

</div>

<?php $script = "<script src='/build/js/app.min.js'></script>" ?>