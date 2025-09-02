<main class="auth">
    <h2 class="auth__heading"><?php echo $tittle; ?></h2>
    <p class="auth__text">Recupera tu acceso a DevWebcamp</p>

    <?php 
        require_once __DIR__ . "/../templates/alerts.php";
    ?>

    <form method= "POST" action="/forgot" class="form">
        <div class="form__field">
            <label for="email" class="form__label">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                class="form__input"
                placeholder="Tu Email">
        </div>

        <input type="submit" class="form__submit" value="Enviar Instrucciones">
    </form>

    <div class="actions">
        <a href="/login" class="actions__link">¿Ya tienes una cuenta? Iniciar sesión</a>
        <a href="/register" class="actions__link">¿Aún no tienes una cuenta? Obtenener una</a>
    </div>
</main>