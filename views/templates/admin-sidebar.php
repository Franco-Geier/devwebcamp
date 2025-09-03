<aside class="dashboard__sidebar">
    <nav class="dashboard__menu">
        <a href="/admin/dashboard" class="dashboard__link <?php echo currentPage("/dashboard") ? "dashboard__link--current" : ""; ?>">
            <i class="fa-solid fa-house dashboard__icon"></i>
            <span class="dashboard__menu-text">
                Inicio
            </span>
        </a>

        <a href="/admin/speakers" class="dashboard__link <?php echo currentPage("/speakers") ? "dashboard__link--current" : ""; ?>">
            <i class="fa-solid fa-microphone dashboard__icon"></i>
            <span class="dashboard__menu-text">
                Ponentes
            </span>
        </a>

        <a href="/admin/events" class="dashboard__link <?php echo currentPage("/events") ? "dashboard__link--current" : ""; ?>">
            <i class="fa-solid fa-calendar dashboard__icon"></i>
            <span class="dashboard__menu-text">
                Events
            </span>
        </a>

        <a href="/admin/registered" class="dashboard__link <?php echo currentPage("/registered") ? "dashboard__link--current" : ""; ?>">
            <i class="fa-solid fa-users dashboard__icon"></i>
            <span class="dashboard__menu-text">
                Registrados
            </span>
        </a>

        <a href="/admin/gifts" class="dashboard__link <?php echo currentPage("/gifts") ? "dashboard__link--current" : ""; ?>">
            <i class="fa-solid fa-gift dashboard__icon"></i>
            <span class="dashboard__menu-text">
                Regalos
            </span>
        </a>
    </nav>
</aside>