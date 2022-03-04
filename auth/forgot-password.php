<?php
require_once "../scripts/db_conn.php";

$email = $email_err = $full_name = $main_succ = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
  // email validation
  if(empty(trim($_POST["email"]))) {
    $email_err = "Please enter an email";
  }else if (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) { // src: w3schools
    $email_err = "Please enter a valid email address";
  }else {
    // Checking if email exists
    if($stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?")){
        $stmt->bind_param("s", $param_email);
        $param_email = trim($_POST["email"]);
        if($stmt->execute()){
            $result = $stmt->get_result();
            if($result->num_rows == 1){
              $row = $result->fetch_array(MYSQLI_ASSOC);
                
              $full_name = $row["full_name"];
              $email = $row["email"];
            } else{
              $email_err = "The email provided doesn't exists in our records please register to continue";
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
  }

  if(empty($email_err)) {
    $subject = 'Reset '. ucwords($full_name) . ' Password';

    $headers = "From: webmaster@quioccassions.com" . "\r\n" . "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $message = "<html>
    <body>
      <p> Hello Admin, </p>
      <p> Please reset my password.</p>
      <p>Email: " . $email . "</p>
    </body>
    </html>";
  
    mail('michaelolukaka@gmail.com', $subject, $message, $headers);

    $main_succ = "Email Sent Successfully Please check";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <title>Qui Occasions - Reset Person</title>

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
            <p class="m-0 fw-bold">Amnesia gone?</p>

            <a
              href="/auth/login.php"
              class="btn btn-primary btn-auth"
              style="width: 184px"
            >
              Login <i class="fas fa-arrow-right"></i>
            </a>
          </div>

          <form class="auth-form" method="post" action="<?php echo htmlspecialchars("/auth/forgot-password.php"); ?>">
            <?php 
              if(!empty($main_err)) {
                  echo '<div class="alert alert-danger"><em>' . $main_err .'</em></div>';
              }

              if(!empty($main_succ)) {
                  echo '<div class="alert alert-success"><em>' . $main_succ .'</em></div>';
              }
            ?>
            <div class="mb-5">
              <label for="email" class="form-label">Email</label>
              <input
                style="padding: 10px"
                type="text"
                class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                id="email"
                name="email"
                value="<?php echo $email; ?>"
              />
              <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="text-end">
              <button type="submit" class="btn btn-primary btn-auth" style="">
                Reset Password <i class="fas fa-arrow-right"></i>
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
