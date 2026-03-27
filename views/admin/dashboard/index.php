<h2 class="dashboard__heading"><?php echo $title; ?></h2>

<main class="blocks">
    <div class="blocks__grid">
        <div class="block">
            <h3 class="block__heading">Últimos registros</h3>
            <?php foreach ($registers as $register) { ?>
                <div class="block__content">
                    <p class="block__text">
                        <?php echo $register->user->name . " " . $register->user->last_name; ?>
                    </p>
                </div>
            <?php } ?>
        </div>

        <div class="block">
            <h3 class="block__heading">Ingresos</h3>
            <p class="block__text--quantity">$ <?php echo $income; ?></p>
        </div>

        <div class="block">
            <h3 class="block__heading">Eventos con menos lugares disponibles</h3>
            <?php foreach($fewer_available as $event) { ?>
                <div class="block__content">
                    <p class="block__text">
                        <?php echo $event->name . " - " . $event->available . " Disponibles"; ?>
                    </p>
                </div>
            <?php } ?>
        </div>

        <div class="block">
            <h3 class="block__heading">Eventos con más lugares disponibles</h3>
            <?php foreach($more_available as $event) { ?>
                <div class="block__content">
                    <p class="block__text">
                        <?php echo $event->name . " - " . $event->available . " Disponibles"; ?>
                    </p>
                </div>
            <?php } ?>
        </div>
    </div>
</main>