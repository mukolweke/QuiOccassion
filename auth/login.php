<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <title>Qui Occasions - Login</title>

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">


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
        <nav class="navbar navbar-expand-lg navbar-light" style="border-bottom: 1px solid #dadce0; height: 100px">
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
                          <a class="nav-link" href="/events.php">Events</a>
                      </li>
                  </ul>
              </div>
          </div>
        </nav>

        <section class="auth-page-wrapper">
          
          <div class="d-flex justify-content-center align-items-center">
            <p class="m-0 fw-bold">Don't have an account?</p>

            <a href="/auth/register.php" class="btn btn-primary btn-auth" style="width: 184px;">
              Register <i class="fas fa-arrow-right"></i>
            </a>
          </div>

          <form class="auth-form">
            <div class="mb-4">
              <label for="email" class="form-label">Email</label>
              <input style="padding: 10px 0;" type="email" class="form-control" id="email">
            </div>
            <div class="mb-5">
              <label for="password" class="form-label">Password</label>
              <input style="padding: 10px 0;" type="password" class="form-control" id="password">
            </div>
            <div class="text-end">
              <button type="submit" class="btn btn-primary btn-auth" style="width: 200px;">
                Login <i class="fas fa-sign-in-alt"></i>
              </button>

              <p class="mt-3" style="font-size: 14px;">
                <a href="/auth/forgot-password.php" class="text-decoration-none" style="color: inherit;">Forgot Password ?</a>
              </p>
            </div>
          </form>

        </section>
      </div>
    </section>

    <!-- Template Main JS File -->
    <script src="/assets/js/main.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
  </body>
</html>
