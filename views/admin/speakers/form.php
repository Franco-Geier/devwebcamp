<fieldset class="form__fieldset">
    <legend class="form__legend">Información Personal</legend>

    <div class="form__field">
        <label for="name" class="form__label">Nombre</label>
        <input
            type="text"
            name="name"
            id="name"
            class="form__input"
            placeholder="Nombre Ponente"
            value="<?php echo $speaker->name ?? ''; ?>">
    </div>

    <div class="form__field">
        <label for="lastName" class="form__label">Apellido</label>
        <input
            type="text"
            name="lastName"
            id="lastName"
            class="form__input"
            placeholder="Apellido Ponente"
            value="<?php echo $speaker->lastName ?? ''; ?>">
    </div>

    <div class="form__field">
        <label for="city" class="form__label">Ciudad</label>
        <input
            type="text"
            name="city"
            id="city"
            class="form__input"
            placeholder="Ciudad Ponente"
            value="<?php echo $speaker->city ?? ''; ?>">
    </div>

    <div class="form__field">
        <label for="country" class="form__label">País</label>
        <input
            type="text"
            name="country"
            id="country"
            class="form__input"
            placeholder="País Ponente"
            value="<?php echo $speaker->country ?? ''; ?>">
    </div>

    <div class="form__field">
        <label for="image" class="form__label">Seleccionar Imagen</label>
        <input
            type="file"
            name="image"
            id="image"
            class="form__input form__input--file">
    </div>
</fieldset>

<fieldset class="form__fieldset">
    <legend class="form__legend">Información Extra</legend>

    <div class="form__field">
        <label for="tags_input" class="form__label">Áreas de Experiencia (separadas por coma)</label>
        <input
            type="text"
            id="tags_input"
            class="form__input"
            placeholder="Ej. Node.js, PHP, CSS, Laravel, UX / UI">
    
            <div id="tags" class="form_list"></div>
            <input type="hidden" name="tags" vlaue="<?php echo $spaekers->tags ?? ''; ?>">
    </div>
</fieldset>

<fieldset class="form__fieldset">
    <legend class="form__legend">Redes Sociales</legend>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-facebook"></i>
            </div>
            <input
                type="text"
                name="networks[facebook]"
                class="form__input--socials"
                placeholder="Facebook"
                value="<?php echo $speaker->facebook ?? ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-x-twitter"></i>
            </div>
            <input
                type="text"
                name="networks[twitter]"
                class="form__input--socials"
                placeholder="Twitter"
                value="<?php echo $speaker->twitter ?? ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <input
                type="text"
                name="networks[youtube]"
                class="form__input--socials"
                placeholder="YouTube"
                value="<?php echo $speaker->youtube ?? ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-instagram"></i>
            </div>
            <input
                type="text"
                name="networks[instagram]"
                class="form__input--socials"
                placeholder="Instagram"
                value="<?php echo $speaker->instagram ?? ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-tiktok"></i>
            </div>
            <input
                type="text"
                name="networks[tiktok]"
                class="form__input--socials"
                placeholder="Tiktok"
                value="<?php echo $speaker->tiktok ?? ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-github"></i>
            </div>
            <input
                type="text"
                name="networks[github]"
                class="form__input--socials"
                placeholder="GitHub"
                value="<?php echo $speaker->github ?? ''; ?>">
        </div>
    </div>
</fieldset>