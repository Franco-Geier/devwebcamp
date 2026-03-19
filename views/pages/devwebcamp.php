<main class="devwebcamp">
    <h2 class="devwebcamp__heading"><?php echo $title; ?></h2>
    <p class="devwebcamp__description">Conoce la conferencia más importante de Latinoamérica</p>

    <div class="devwebcamp__grid">
        <div <?php aos_animation(); ?> class="devwebcamp__image">
            <picture>
                <source srcset="build/img/about_devwebcamp.avif" type="image/avif">
                <source srcset="build/img/about_devwebcamp.webp" type="image/webp">
                <img src="build/img/about_devwebcamp.jpg" alt="Imagen DevWebCamp" width="200" height="300">
            </picture>
        </div>

        <div class="devwebcamp__content">
            <p <?php aos_animation(); ?> class="devwebcamp__text">Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Modi impedit repellat, quasi corrupti tenetur consequatur blanditiis molestias ipsa
            quam in natus ducimus, saepe fugit, magnam ad voluptatum minus eligendi odio.</p>
            
            <p <?php aos_animation(); ?> class="devwebcamp__text">Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Modi impedit repellat, quasi corrupti tenetur consequatur blanditiis molestias ipsa
            quam in natus ducimus, saepe fugit, magnam ad voluptatum minus eligendi odio.</p>
        </div>
    </div>
</main>