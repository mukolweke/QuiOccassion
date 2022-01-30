<?php

// config file
require_once "../scripts/db_conn.php";

// variables and initialize with empty values
$full_name = $email = $password = $password_confirm = "";
$full_name_err = $email_err = $password_err = $password_confirm_err = "";

// processing register form submit
if($_SERVER["REQUEST_METHOD"] == "POST") {
  // full name validation
  if(empty(trim($_POST["full_name"]))) {
    $full_name_err = "Please enter a full name";
  }else if(!preg_match("/^[a-zA-Z-' ]*$/", trim($_POST['full_name']))) { // src: w3schools
    $full_name_err = "Only letters and white space allowed";
  } else {
    $full_name = $_POST["full_name"];
  }

  // email validation
  if(empty(trim($_POST["email"]))) {
    $email_err = "Please enter an email";
  }else if (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) { // src: w3schools
    $email_err = "Please enter a valid email address";
  }else {
    // Checking if email exists
    if($stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?")){
        $stmt->bind_param("s", $param_email);
        $param_email = trim($_POST["email"]);
        if($stmt->execute()){
            $stmt->store_result();
            if($stmt->num_rows == 1){
                $email_err = "This email is already taken.";
            } else{
                $email = trim($_POST["email"]);
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        $stmt->close();
    }
  }

  // password validation
  if(empty(trim($_POST["password"]))){
    $password_err = "Please enter a password.";     
  } elseif(strlen(trim($_POST["password"])) < 6){
    $password_err = "Password must have atleast 6 characters.";
  } else{
    $password = trim($_POST["password"]);
  }

  // confirm password validation
  if(empty(trim($_POST["password_confirm"]))){
    $password_confirm_err = "Please confirm password.";     
  } else{
    $password_confirm = trim($_POST["password_confirm"]);
    if(empty($password_err) && ($password != $password_confirm)){
        $password_confirm_err = "Password did not match.";
    }
  }

  // save user if no errors
  if(empty($full_name_err) && empty($email_err) && empty($password_err) && empty($password_confirm_err)){
    $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
    
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("sss", $param_full_name, $param_email, $param_password);
        
        // Set parameters
        $param_full_name = $full_name;
        $param_email = $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
        
        if($stmt->execute()){
            header("location: login.php");
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }
  }

  // Close connection
  $mysqli->close();
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

          <form class="auth-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-4">
              <label for="full_name" class="form-label">Full Name</label>
              <input
                style="padding: 10px"
                type="text"
                class="form-control <?php echo (!empty($full_name_err)) ? 'is-invalid' : ''; ?>"
                id="full_name"
                name="full_name"
                value="<?php echo $full_name; ?>"
              />
              <span class="invalid-feedback"><?php echo $full_name_err; ?></span>
            </div>
            <div class="mb-4">
              <label for="email" class="form-label">Email</label>
              <input
                style="padding: 10px"
                type="email"
                class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                id="email"
                name="email"
                value="<?php echo $email; ?>"
              />
              <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="mb-4">
              <label for="password" class="form-label">Password</label>
              <input
                style="padding: 10px"
                type="password"
                class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                id="password"
                name="password"
                value="<?php echo $password; ?>"
              />
              <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="mb-5">
              <label for="password_confirm" class="form-label"
                >Confirm Password</label
              >
              <input
                style="padding: 10px"
                type="password"
                class="form-control <?php echo (!empty($password_confirm_err)) ? 'is-invalid' : ''; ?>"
                id="password_confirm"
                name="password_confirm"
                value="<?php echo $password_confirm; ?>"
              />
              <span class="invalid-feedback"><?php echo $password_confirm_err; ?></span>
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
