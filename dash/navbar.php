<nav id="mySidenav" class="sidenav">
    <div class="topnav">
        <a class="d-flex align-items-center sidenav-item" href="/dash/index.php?page=home">
            <span><i class="fas fa-home"></i></span>  Home
        </a>
        <?php if($_SESSION['is_admin']) { ?>
            <a class="d-flex align-items-center sidenav-item" href="/dash/index.php?page=events">
                <span><i class="fas fa-calendar"></i></span>  Events
            </a>
            <a class="d-flex align-items-center sidenav-item" href="/dash/index.php?page=venues">
                <span><i class="fas fa-map-marked-alt"></i></span>  Venues
            </a>
            <a class="d-flex align-items-center sidenav-item" href="/dash/index.php?page=requests">
                <span><i class="fas fa-bell"></i></span>  Requests
            </a>
            <a class="d-flex align-items-center sidenav-item" href="/dash/index.php?page=reports">
                <span><i class="fas fa-file-alt"></i></span>  Reports
            </a>
            <a class="d-flex align-items-center sidenav-item" href="/dash/index.php?page=users">
                <span><i class="fas fa-users"></i></span>  Users
            </a>
            <a class="d-flex align-items-center sidenav-item" href="/dash/index.php?page=system_settings">
                <span><i class="fas fa-cogs"></i></span>  System Settings
            </a>
        <?php } else { ?>
            <a class="d-flex align-items-center sidenav-item" href="/dash/index.php?page=my_events">
                <span><i class="fas fa-calendar"></i></span>  My Events
            </a>
            <a class="d-flex align-items-center sidenav-item" href="/dash/index.php?page=my_requests">
                <span><i class="fas fa-map-marked-alt"></i></span>  My Requests
            </a>
        <?php } ?>
    </div>

    <div class="bottomnav">
        <img src="../assets/img/logo.png" alt="">
    </div>
</nav>