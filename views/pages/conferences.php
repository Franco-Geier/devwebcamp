<main class="schedule">
    <h2 class="schedule__heading"><?php echo $title; ?></h2>
    <p class="schedule__description">Talleres y Conferencias dictados por expertos en desarrollo web</p>

    <div class="events">
        <h3 class="events__heading">&lt;Conferencias /></h3>
        <p class="events__date">Viernes 5 de Diciembre</p>
        <div class="events__list slider swiper">
            <div class="swiper-wrapper">
                <?php if(isset($events[1][1])) {
                    foreach($events[1][1] as $event) { ?>
                        <?php include __DIR__ . "../../templates/event.php"; ?>
                    <?php }
                } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <p class="events__date">Sábado 6 de Diciembre</p>
        <div class="events__list slider swiper">
            <div class="swiper-wrapper">
                <?php if(isset($events[2][1])) {
                    foreach($events[2][1] as $event) { ?>
                        <?php include __DIR__ . "../../templates/event.php"; ?>
                    <?php }
                } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>

    <div class="events events--workshops">
        <h3 class="events__heading">&lt;Workshops /></h3>

        <p class="events__date">Viernes 5 de Diciembre</p>
        <div class="events__list slider swiper">
            <div class="swiper-wrapper">
                <?php if(isset($events[1][2])) {
                    foreach($events[1][2] as $event) { ?>
                        <?php include __DIR__ . "../../templates/event.php"; ?>
                    <?php }
                } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <p class="events__date">Sábado 6 de Diciembre</p>

        <div class="events__list slider swiper">
            <div class="swiper-wrapper">
                <?php if(isset($events[2][2])) {
                    foreach($events[2][2] as $event) { ?>
                        <?php include __DIR__ . "../../templates/event.php"; ?>
                    <?php }
                } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</main>