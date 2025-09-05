<main class="auth">
    <h2 class="auth__heading"><?php echo $tittle; ?></h2>
    <p class="auth__text">Registrate en DevWebCamp</p>

    <?php 
        require_once __DIR__ . "/../templates/alerts.php";
    ?>

    <form method="POST" action="/register" class="form">
        <div class="form__field">
            <label for="name" class="form__label">Nombre</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form__input"
                placeholder="Tu Nombre"
                value="<?php echo $user->name; ?>">
        </div>

        <div class="form__field">
            <label for="last_name" class="form__label">Apellido</label>
            <input
                type="text"
                name="last_name"
                id="last_name"
                class="form__input"
                placeholder="Tu Apellido"
                value="<?php echo $user->last_name; ?>">
        </div>

        <div class="form__field">
            <label for="email" class="form__label">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                class="form__input"
                placeholder="Tu Email"
                value="<?php echo $user->email; ?>">
        </div>

        <div class="form__field">
            <label for="password" class="form__label">Password</label>
            <input
                type="password"
                name="password"
                id="password"
                class="form__input"
                placeholder="Tu Password">
        </div>

        <div class="form__field">
            <label for="password2" class="form__label">Repetir Password</label>
            <input
                type="password"
                name="password2"
                id="password2"
                class="form__input"
                placeholder="Repite Tu Password">
        </div>

        <input type="submit" class="form__submit" value="Crear Cuenta">
    </form>

    <div class="actions">
        <a href="/login" class="actions__link">¿Ya tienes una cuenta? Iniciar sesión</a>
        <a href="/forgot" class="actions__link">¿Olvidaste tu Password?</a>
    </div>
</main>