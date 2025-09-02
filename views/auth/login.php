<main class="auth">
    <h2 class="auth__heading"><?php echo $tittle; ?></h2>
    <p class="auth__text">Inicia Sesión en DevWebCamp</p>

    <?php 
        require_once __DIR__ ."/../templates/alerts.php";
    ?>

    <form method="POST" action="/login" class="form">
        <div class="form__field">
            <label for="email" class="form__label">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                class="form__input"
                placeholder="Tu Email">
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

        <input type="submit" class="form__submit" value="Iniciar Sesión">
    </form>

    <div class="actions">
        <a href="/register" class="actions__link">¿Aún no tienes una cuenta? Obtenener una</a>
        <a href="/forgot" class="actions__link">¿Olvidaste tu Password?</a>
    </div>
</main>