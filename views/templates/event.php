<div class="event swiper-slide">
    <p class="event__hour"><?php echo $event->hour_name; ?></p>

    <div class="event__information">
        <h4 class="event__name"><?php echo $event->name; ?></h4>

        <p class="event__introduction"><?php echo $event->description; ?></p>

        <div class="event__autor-info">
            <picture>
                <source srcset="<?php echo $_ENV["HOST"] . '/img/speakers/' . $event->speaker_image; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV["HOST"] . '/img/speakers/' . $event->speaker_image; ?>.png" type="image/png">
                <img class="event__image-autor" width="200" height="300" src="<?php echo $_ENV["HOST"] . '/img/speakers/' . $event->speaker_image; ?>.png" alt="Imagen Ponente" loading="lazy">
            </picture>
            <p class="event__autor-name"><?php echo $event->speaker_name . ' ' . $event->last_name; ?></p>
        </div>
    </div>
</div>