<fieldset class="form__fieldset">
    <legend class="form__legend">Información Evento</legend>
    <div class="form__field">
        <label for="name" class="form__label">Nombre Evento</label>
        <input
            type="text"
            autocomplete="name"
            name="name"
            id="name"
            class="form__input"
            placeholder="Nombre Ponente"
            value="<?php echo $event->name; ?>">
    </div>

    <div class="form__field">
        <label for="description" class="form__label">Descripción</label>
        <textarea
            name="description"
            id="description"
            class="form__input"
            rows="8"
            placeholder="Descripción Evento"><?php echo $event->description; ?></textarea>
    </div>

    <div class="form__field">
        <label for="category_id" class="form__label">Categoría o Tipo de Evento</label>
        <select class="form__select" name="category_id" id="category_id">
            <option disabled selected value="">- Seleccionar -</option>
            <?php foreach($categories as $category) { ?>
                <option <?php echo ($event->category_id == $category->id) ? 'selected' : '' ?> value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form__field">
    

        <fieldset class="form__fieldset--invisible">
            <legend class="form__legend--extra">Selecciona el Día</legend>
            <div class="form__radio">
                <!-- contenido -->
                <?php foreach($days as $day) { ?>
                    <div>
                        <label for="<?php echo strtolower($day->name); ?>"><?php echo $day->name; ?></label>
                        <input
                            type="radio"
                            name="day"
                            id="<?php echo strtolower($day->name); ?>"
                            value="<?php echo $day->id; ?>">
                    </div>
                <?php } ?> 
            </div>
        </fieldset>
        <input type="hidden" name="day_id" value="">
    </div>

    <div class="form__field">


        <fieldset class="form__fieldset--invisible">
            <legend class="form__legend--extra">Seleccionar hora</legend>
            <ul id="hours" class="hours">
                <?php foreach ($hours as $hour) { ?>
                    <li data-hour-id="<?php echo $hour->id; ?>" class="hours__hour hours__hour--disabled"><?php echo $hour->hour; ?></li>
                <?php } ?>
            </ul>
        </fieldset>
        <input type="hidden" name="hour_id" value="">
    </div>
</fieldset>

<fieldset class="form__fieldset">
    <legend class="form__legend">Información Extra</legend>
    <div class="form__field">
        <label for="speakers" class="form__label">Ponente</label>
        <input
            type="text"
            id="speakers"
            class="form__input"
            placeholder="Buscar Ponente">
    </div>

    <div class="form__field">
        <label for="available" class="form__label">Lugares Disponibles</label>
        <input
            type="number"
            min="1"
            id="available"
            name="available"
            class="form__input"
            placeholder="Ej. 20"
            value="<?php echo $event->available; ?>">
    </div>
</fieldset>