<?php 
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: ../dash/index.php");
  exit;
}

require_once "../scripts/db_conn.php";

// variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Processing login form data when submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
  // email validation
  if(empty(trim($_POST["email"]))) {
    $email_err = "Please enter an email";
  }else if (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) { // src: w3schools
    $email_err = "Please enter a valid email address";
  }else{
    $email = $_POST["email"];
  }
  
  // password validation
  if(empty(trim($_POST["password"]))){
      $password_err = "Please enter your password.";
  } else{
      $password = trim($_POST["password"]);
  }
  
  // Validate credentials
  if(empty($username_err) && empty($password_err)){
      if($stmt = $mysqli->prepare("SELECT id, full_name, password FROM users WHERE email = ?")){
          $stmt->bind_param("s", $param_email);
          $param_email = $email;
          
          // Attempt to execute the prepared statement
          if($stmt->execute()){
              // Store result
              $stmt->store_result();
              
              // Check if email exists, if yes then verify password
              if($stmt->num_rows == 1){                    
                  $stmt->bind_result($id, $full_name, $hashed_password);
                  if($stmt->fetch()){
                      if(password_verify($password, $hashed_password)){
                          // Password is correct, so start a new session
                          session_start();
                          
                          // Store data in session variables
                          $_SESSION["loggedin"] = true;
                          $_SESSION["id"] = $id;
                          $_SESSION["full_name"] = $full_name;
                          
                          // Redirect user to dash index page
                          header("location: ../dash/index.php");
                      } else{
                          // Password is not valid, display a generic error message
                          $login_err = "Invalid email or password.";
                      }
                  }
              } else{
                  // Email doesn't exist, display a generic error message
                  $login_err = "Invalid email or password.";
              }
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

    <title>Qui Occasions - Login</title>

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

        <section class="auth-page-wrapper" style="position: relative; margin-top: 150px; z-index: 1;">
          
          <div class="d-flex justify-content-center align-items-center">
            <p class="m-0 fw-bold">Don't have an account?</p>

            <a href="/auth/register.php" class="btn btn-primary btn-auth" style="width: 184px;">
              Register <i class="fas fa-arrow-right"></i>
            </a>
          </div>

          <form class="auth-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php 
            if(!empty($login_err)) {
                echo '<div class="mb-4 alert alert-danger">' . $login_err . '</div>';
            }        
            ?>
            
            <div class="mb-4">
              <label for="email" class="form-label">Email</label>
              <input style="padding: 10px;" 
                type="email" 
                id="email" 
                name="email" 
                class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" 
                value="<?php echo $email; ?>">
            </div>
            <div class="mb-5">
              <label for="password" class="form-label">Password</label>
              <input
                style="padding: 10px"
                type="password"
                class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                id="password"
                name="password"
                value="<?php echo $password; ?>"
              />
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
