<main class="auth">
    <h2 class="auth__heading"><?php echo $tittle; ?></h2>
    <p class="auth__text">Coloca tu nuevo Password</p>

    <?php 
        require_once __DIR__ . "/../templates/alerts.php";
    ?>

    <?php if($show): ?>
        <form method= "POST" action="/restore" class="form">
            <div class="form__field">
                <label for="password" class="form__label">Nuevo Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form__input"
                    placeholder="Tu Nuevo Password">
            </div>

            <div class="form__field">
                <label for="password2" class="form__label">Repetir Nuevo Password</label>
                <input
                    type="password"
                    name="password2"
                    id="password2"
                    class="form__input"
                    placeholder="Repite Tu Nuevo Password">
            </div>

            <input type="submit" class="form__submit" value="Guardar Password">
        </form>
    <?php endif; ?>

    <div class="actions">
        <a href="/login" class="actions__link">¿Ya tienes una cuenta? Iniciar sesión</a>
        <a href="/register" class="actions__link">¿Aún no tienes una cuenta? Obtenener una</a>
    </div>
</main>