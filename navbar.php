<?php
  session_start();
?>

<nav class="navbar navbar-expand-lg navbar-light navbar-qui">
  <div class="container-fluid">
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
        <li class="nav-item">
          <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#venues">Venues</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#events">Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#contacts">Contact</a>
        </li>
        <?php if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){ ?>
          <li class="nav-item" style="margin-left: 10px;">
            <a class="btn btn-primary" href="/auth/login.php"
              >Getting Started</a
            >
          </li>
        <?php }else { ?> 
          <li class="nav-item" style="margin-left: 10px;">
              <div class="dropdown">
                  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                      <?php echo htmlspecialchars($_SESSION["full_name"])?>
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                      <li>
                          <a class="dropdown-item" href="/dash/index.php?page=home">
                              <span><i class="fas fa-tachometer-alt"></i></span>  Dashboard
                          </a>
                      </li>
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
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>