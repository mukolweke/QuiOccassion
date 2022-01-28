<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <title>Qui Occasions - Register</title>

    <!-- Icons -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
      rel="stylesheet"
    />

    <!-- Styles -->
    <!-- Bootsrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Custom -->
    <link href="/assets/css/main.css" rel="stylesheet" />
  </head>
  <body>
    <section class="landing-page auth-page">
      <div class="left-page">
        <div class="logo-wrapper">
          <img src="/assets/img/logo.png" alt="Main Logo" />
        </div>
      </div>
      <div class="right-page">
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
              </ul>
            </div>
          </div>
        </nav>
        
        <section class="auth-page-wrapper" style="position: relative; margin-top: 100px; z-index: 1;">
          <div class="d-flex justify-content-center align-items-center">
            <p class="m-0 fw-bold">Have an account?</p>

            <a
              href="/auth/login.php"
              class="btn btn-primary btn-auth"
              style="margin-left: 60px; width: 184px"
            >
              Login <i class="fas fa-arrow-right"></i>
            </a>
          </div>

          <form class="auth-form">
            <div class="mb-4">
              <label for="full_name" class="form-label">Full Name</label>
              <input
                style="padding: 10px"
                type="text"
                class="form-control"
                id="full_name"
              />
            </div>
            <div class="mb-4">
              <label for="email" class="form-label">Email</label>
              <input
                style="padding: 10px"
                type="email"
                class="form-control"
                id="email"
              />
            </div>
            <div class="mb-4">
              <label for="password" class="form-label">Password</label>
              <input
                style="padding: 10px"
                type="password"
                class="form-control"
                id="password"
              />
            </div>
            <div class="mb-5">
              <label for="password_confirm" class="form-label"
                >Confirm Password</label
              >
              <input
                style="padding: 10px"
                type="password"
                class="form-control"
                id="password_confirm"
              />
            </div>
            <div class="text-end">
              <button
                type="submit"
                class="btn btn-primary btn-auth"
                style="width: 200px"
              >
                Register <i class="fas fa-sign-in-alt"></i>
              </button>
            </div>
          </form>
        </section>

        <img src="/assets/img/bg-hero.png" class="bg-image" alt="Banner Image">

      </div>
    </section>

    <!-- Template Main JS File -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/assets/js/main.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
  </body>
</html>
