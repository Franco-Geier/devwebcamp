<?php 
    include_once __DIR__ . "/conferences.php";
?>

<section class="summary">
    <div class="summary__grid">
        <div <?php aos_animation(); ?> class="summary__block">
            <p class="summary__text summary__text--number"><?php echo $speakers_total; ?></p>
            <p class="summary__text">Ponentes</p>
        </div>

        <div <?php aos_animation(); ?> class="summary__block">
            <p class="summary__text summary__text--number"><?php echo $conferences_total; ?></p>
            <p class="summary__text">Conferencias</p>
        </div>

        <div <?php aos_animation(); ?> class="summary__block">
            <p class="summary__text summary__text--number"><?php echo $workshops_total; ?></p>
            <p class="summary__text">Workshops</p>
        </div>

        <div <?php aos_animation(); ?> class="summary__block">
            <p class="summary__text summary__text--number">500</p>
            <p class="summary__text">Asistentes</p>
        </div>
    </div>
</section>

<section class="speakers">
    <h2 class="speakers__heading">Ponentes</h2>
    <p class="speakers__description">Conoce a nuestros expertos de DevWebCamp</p>

    <div class="speakers__grid">    
        <?php foreach($speakers as $speaker) { ?>
            <div <?php aos_animation(); ?> class="speaker">
                <picture>
                    <source srcset="<?php echo $_ENV["HOST"] . '/img/speakers/' . $speaker->image; ?>.webp" type="image/webp">
                    <source srcset="<?php echo $_ENV["HOST"] . '/img/speakers/' . $speaker->image; ?>.png" type="image/png">
                    <img class="speaker__image" width="200" height="300" src="<?php echo $_ENV["HOST"] . '/img/speakers/' . $speaker->image; ?>.png" alt="Imagen Ponente" loading="lazy">
                </picture>
            

                <div class="speaker__info">
                    <h4 class="speaker__name"><?php echo $speaker->name . " " . $speaker->last_name; ?></h4>
                    <p class="speaker__location"><?php echo $speaker->city . ", ". $speaker->country; ?></p>

                    <nav class="speaker-socials">
                        <?php $social_networks = json_decode($speaker->social_networks); ?>

                        <?php if(!empty($social_networks->facebook)) { ?>
                            <a class="speaker-socials__link" rel="noopener noreferrer" target="_blank" href="<?php echo $social_networks->facebook; ?>">
                                <span class="speaker-socials__hide">Facebook</span>
                            </a>
                        <?php } ?>

                        <?php if(!empty($social_networks->twitter)) { ?>
                            <a class="speaker-socials__link" rel="noopener noreferrer" target="_blank" href="<?php echo $social_networks->twitter; ?>">
                                <span class="speaker-socials__hide">Twitter</span>
                            </a>
                        <?php } ?>

                        <?php if(!empty($social_networks->youtube)) { ?>
                            <a class="speaker-socials__link" rel="noopener noreferrer" target="_blank" href="<?php echo $social_networks->youtube; ?>">
                                <span class="speaker-socials__hide">YouTube</span>
                            </a>
                        <?php } ?>

                        <?php if(!empty($social_networks->instagram)) { ?>
                            <a class="speaker-socials__link" rel="noopener noreferrer" target="_blank" href="<?php echo $social_networks->instagram; ?>">
                                <span class="speaker-socials__hide">Instagram</span>
                            </a>
                        <?php } ?>

                        <?php if(!empty($social_networks->tiktok)) { ?>
                            <a class="speaker-socials__link" rel="noopener noreferrer" target="_blank" href="<?php echo $social_networks->tiktok; ?>">
                                <span class="speaker-socials__hide">Tiktok</span>
                            </a>
                        <?php } ?>

                        <?php if(!empty($social_networks->github)) { ?>
                            <a class="speaker-socials__link" rel="noopener noreferrer" target="_blank" href="<?php echo $social_networks->github; ?>">
                                <span class="speaker-socials__hide">Github</span>
                            </a>
                        <?php } ?>
                    </nav>
                    
                    <ul class="speaker__skill-list">
                        <?php $tags = explode(",", $speaker->tags);
                        foreach($tags as $tag) { ?>
                            <li class="speaker__skill"><?php echo $tag; ?></li>
                        <?php } ?>
                    </ul> 
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<div id="map" class="map"></div>

<section class="tickets">
    <h2 class="tickets__heading">Boletos & Precios</h2>
    <p class="tickets__description">Precios para DevWebCamp</p>

    <div class="tickets__grid">
        <div <?php aos_animation(); ?> class="ticket ticket--in-person">
            <h4 class="ticket__logo">&#60;devWebcamp /></h4>
            <p class="ticket__plan">Presencial</p>
            <p class="ticket__price">$199</p>
        </div>

        <div <?php aos_animation(); ?> class="ticket ticket--virtual">
            <h4 class="ticket__logo">&#60;devWebcamp /></h4>
            <p class="ticket__plan">Virtual</p>
            <p class="ticket__price">$149</p>
        </div>

        <div <?php aos_animation(); ?> class="ticket ticket--free">
            <h4 class="ticket__logo">&#60;devWebcamp /></h4>
            <p class="ticket__plan">Gratis</p>
            <p class="ticket__price">Gratis - $0</p>
        </div>
    </div>

    <div class="ticket__link-container">
        <a href="/packages" class="ticket__link">Ver Paquetes</a>
    </div>
</section>