<?php 
require_once "./scripts/db_conn.php";

if (isset($_POST['contact_us_email'])) {
  $name = $email = $email_message = "";
  $name_err = $email_err = $email_message_err = "";

  // Full Name validation
  if(empty(trim($_POST["full_name"]))) {
    $name_err = "Please enter a name";
  } else{
    $name = $_POST["full_name"];
  }

  // email validation
  if(empty(trim($_POST["email"]))) {
    $email_err = "Please enter an email";
  }else if (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) { // src: w3schools
    $email_err = "Please enter a valid email address";
  }else{
    $email = $_POST["email"];
  }
  
  // message validation
  if(empty(trim($_POST["msg"]))){
      $email_message_err = "Please enter your  message.";
  } else{
      $email_message = trim($_POST["message"]);
  }

  $subject = ucwords($name) . ' Inquires About the following:';

  $headers = "From: webmaster@quioccassions.com" . "\r\n" . "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $message = "<html>
  <head>
  	<title>Welcome To Our Shop from Any Online website contact form</title>
  </head>
  <body>
  	<h1>" . $subject . "</h1>
  	<p>". $email_message . "</p>
  </body>
  </html>";
  
  if (mail('michaelolukaka@gmail.com', $subject, $message, $headers)) {
   echo "Send Sucessfully, Good Luck Email sent";
  }else{
   echo "sorry, Failed to send email. Please try again later";
  }
}
?>

<div class="contacts" id="contacts">
  <div class="contacts-wrapper">
    <div class="contact-details">
      <h2 class="mb-3">Get a quote</h2>
      <p class="section-title-bar" style="width: 35%;"></p>
      <p class="mb-5">Fill up the form and our Team will get back to you with 24 hours.</p>

      <div class="mb-5" style="width: 280px;">
        <?php 
          $result = $mysqli->query("SELECT * FROM settings WHERE setting_type=1");
          while($row = $result->fetch_array()){
        ?>
          <div class="contact-item">
            <p class="p-0 m-0"><span class="icon"><i class="<?php echo $row['icon']; ?>"></i></span> <span>
              <?php echo $row['value']; ?>
            </span></p>
          </div>
        <?php }?>
      </div>

      <div class="d-flex align-items-center justify-content-between social-links">
        <?php 
          $result = $mysqli->query("SELECT * FROM settings WHERE setting_type=2");
          while($row = $result->fetch_array()){
        ?>
          <p class="m-0 p-0 social-link">
            <a target="_blank" href="<?php echo $row['value'];?>"><i class="<?php echo $row['icon'];?>"></i></a>
          </p>
        <?php }?>
      </div>
    </div>

    <div class="contacts-form">
      <form class="contact-form" method="post" action="<?php echo htmlspecialchars("/"); ?>">
        <div class="mb-4 form-floating">
          <input type="text" class="form-control" placeholder="Enter Full Name" name="full_name" id="floatingFullName">
          <label for="floatingFullName">Your Name</label>
        </div>
        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="floatingInput" name="email" placeholder="Enter Email">
          <label for="floatingInput">Your Email</label>
        </div>
        <div class="form-floating mb-5">
          <textarea class="form-control" placeholder="Enter your comments here" name="message" id="floatingTextarea" style="height: 150px"></textarea>
          <label for="floatingTextarea">Comments</label>
        </div>
        <div class="text-end" style="z-index: 50;">
          <button type="submit" name="contact_us_email" class="btn btn-primary btn-auth">
            Send Message <i class="far fa-paper-plane"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>