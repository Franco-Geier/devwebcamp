<h2 class="page__heading"><?php echo $title; ?></h2>
<p class="page__description">Elige hasta 5 eventos para asistir de fomra presencial.</p>

<div class="events-register">
    <main class="events-register__list">
        <h3 class="events-register__heading--conferences">&lt;Conferencias /></h3>
        <p class="events-register__date">Viernes 5 de Diciembre</p>
        
        <div class="events-register__grid">
            <?php if(isset($events[1][1])) {
                foreach($events[1][1] as $event) { ?>
                    <?php include __DIR__ . "/event.php"; ?>
                <?php }
            } ?>
        </div>

        <p class="events-register__date">Sábado 6 de Diciembre</p>
        <div class="events-register__grid">
            <?php if(isset($events[2][1])) {
                foreach($events[2][1] as $event) { ?>
                    <?php include __DIR__ . "/event.php"; ?>
                <?php }
            } ?>
        </div>

        <h3 class="events-register__heading--workshops">&lt;Workshops /></h3>
        <p class="events-register__date">Viernes 5 de Diciembre</p>
        
        <div class="events-register__grid events--workshops">
            <?php if(isset($events[1][2])) {
                foreach($events[1][2] as $event) { ?>
                    <?php include __DIR__ . "/event.php"; ?>
                <?php }
            } ?>
        </div>

        <p class="events-register__date">Sábado 6 de Diciembre</p>
        <div class="events-register__grid events--workshops">
            <?php if(isset($events[2][2])) {
                foreach($events[2][2] as $event) { ?>
                    <?php include __DIR__ . "/event.php"; ?>
                <?php }
            } ?>
        </div>
    </main>

    <aside class="register">
        <h2 class="register__heading">Tu Registro</h2>
        <div class="register__summary" id="register-summary"></div>

        <div class="register__gift">
            <label for="gift" class="register__label">Selecciona un regalo</label>
            <select id="gift" class="register__select">
                <option value="">-- Selecciona tu tarjeta --</option>
                <?php foreach($gifts as $gift) { ?>
                    <option value="<?php echo $gift->id; ?>"><?php echo $gift->name; ?></option>
                <?php } ?>
            </select>
        </div>

        <form id="register" class="form">
            <div class="form__field">
                <input type="submit" class="form__submit form__submit--full" value="Registrarme">
            </div>
        </form>
    </aside>
</div>
