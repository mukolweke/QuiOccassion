<nav class="navbar navbar-expand-lg navbar-light navbar-dash">
    <div class="container-fluid" style="margin-right: 60px;">
        <div>
            <h3 style="color: var(--primary);">Qui Occassions</h3>
        </div>
        <button
              class="navbar-toggler"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarNav"
              aria-controls="navbarNav"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="navbar-toggler-icon"></span>
        </button>
        <div
            class="collapse navbar-collapse justify-content-end"
            id="navbarNav"
        >
            <ul class="navbar-nav">
                <li class="nav-item" style="margin-right: 10px;">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo htmlspecialchars($_SESSION["full_name"])?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <a class="dropdown-item" href="/dash/index.php?page=profile">
                                    <span><i class="far fa-user"></i></span>  Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>