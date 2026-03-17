<header class="header">
    <div class="header__container">
        <nav class="header__nav">
            <?php if(isAuth()) { ?>
                <a href="<?php echo isAdmin() ? '/admin/dashboard' : '/end-register'; ?>" class="header__link">Administrar</a>
                <form method="POST" action="/logout" class="header__form">
                    <input type="submit" value="Cerrar Sesión" class="header__submit">
                </form>
            <?php } else { ?>
                <a href="/register" class="header__link">Registro</a>
                <a href="/login" class="header__link">Login</a>
            <?php } ?>
        
        </nav>

        <div class="header__content">
            <a href="/">
                <h1 class="header__logo">&#60;DevWebCamp /></h1>
            </a>

            <p class="header__text">Diciembre 5-6 - 2025</p>
            <p class="header__text header__text--mod">En Linea - Presencial</p>
        
            <a href="/register" class="header__button">Comprar Pase</a>
        </div>
    </div>
</header>

<div class="bar">
    <div class="bar__content">
        <a href="/">
            <h2 class="bar__logo">&#60;DevWebCamp /></h2>
        </a>

        <nav class="nav">
            <a href="/devwebcamp" class="nav__link <?php echo currentPage('/devwebcamp') ? 'nav__link--current' : ''; ?>">Evento</a>
            <a href="/packages" class="nav__link <?php echo currentPage('/packages') ? 'nav__link--current' : ''; ?>">Paquetes</a>
            <a href="/workshops-conferences" class="nav__link <?php echo currentPage('/workshops-conferences') ? 'nav__link--current' : ''; ?>">WorkShops / Conferencias</a>
            <a href="/register" class="nav__link <?php echo currentPage('/register') ? 'nav__link--current' : ''; ?>">Comprar Pase</a>
        </nav>
    </div>
</div>