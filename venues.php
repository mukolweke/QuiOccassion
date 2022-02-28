<?php 
require_once "./scripts/db_conn.php";

$name = $email = $contact = $capacity = "";
$name_err = $email_err = $contact_err = $capacity_err = "";
$main_err = $main_succ = "";

// Processing venue form data when submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'book_venue'){
  // Validate name
  $input_name = trim($_POST["name"]);
  if(empty($input_name)){
    $name_err = "Please enter an name.";     
  } else{
    $name = $input_name;
  }

  // Validate email
  $input_email = trim($_POST["email"]);
  if(empty($input_email)){
    $email_err = "Please enter an email.";     
  } else if (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) { // src: w3schools
    $email_err = "Please enter a valid email address";
  } else{
    $email = $input_email;
  }

  // Validate contact
  $input_contact = trim($_POST["contact"]);
  if(empty($input_contact)){
    $contact_err = "Please enter an contact.";     
  } else{
    $contact = $input_contact;
  }

  // Validate capacity
  $input_capacity = trim($_POST["capacity"]);
  if(empty($input_capacity)){
    $capacity_err = "Please enter an capacity.";     
  } else{
    $capacity = $input_capacity;
  }

  if(!empty($name_err) || !empty($email_err) || !empty($contact_err) || !empty($capacity_err)) {
    $main_err = "Ooops! There are errors in venue reserve form you just submitted";
  }

  if(empty($name_err) && empty($email_err) && empty($contact_err) && empty($capacity_err)) {
    $sql = "INSERT INTO user_booking (name, email, contact, venue_id, capacity, type) VALUES (?, ?, ?, ?, ?, ?)";

    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("ssssss", $param_name, $param_email, $param_contact, $param_venue_id, $param_capacity, $param_type);

        // parameters
        $param_name = $name;
        $param_email = $email;
        $param_contact = $contact;
        $param_venue_id = $_POST['form_id'];
        $param_capacity = $capacity;
        $param_type = 'venue';
        //status '0-for verification, 1=confirmed, 2=canceled' 

        if($stmt->execute()){
          ?><script type="text/javascript">
              window.location = "/";
          </script><?php
          $main_succ = "Venue reserved successfully, check your email for details";
        } else{
          $main_err = "Oops! Please check the form.";
        }
    }
  } else{
    $main_err = "Oops! Please check the form.";
  }
}
?>
<div class="venues">
    <div>
        <h2>Venues</h2>
        <p class="section-title-bar" style="width: 10%;"></p>
        <p>List of our venue Venues</p>
    </div>

    <?php include './dash/succ_err_view.php' ?>

    <div class="venues-wrapper">
    <?php

        $sql = "SELECT * FROM venues ORDER BY id DESC";
        $count = 1;

        if($result = $mysqli->query($sql)){
            if($result->num_rows > 0){
            while($row = $result->fetch_array()){
            ?>
            <div class="card venue-card">
                <div class="row m-0 p-0 align-items-center">
                    <div class="col-sm-5 m-0 p-0 venue-img">
                        <img class="d-block w-100" 
                        src="/assets/img/uploads/<?php echo $row['image']?>"
                        alt="Venue Image">
                    </div>
                    <div class="col-sm-7 px-5">
                        <div class="card-block">
                            <h4 class="card-title"><?php echo $row['name']?></h4>
                            <p class="m-0 p-0 venue-description"><?php echo $row['description']?></p>
                            <p class="m-0 p-0 price-tag"><i class="fas fa-tag" style="transform: rotate(90deg);"></i> Price per Hour: Ksh <?php echo $row['rate']?></p>
                            <br>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reserve_<?php echo str_replace(' ', '-', strtolower($row['name'])) ?>">
                                Book Venue
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!--Reserve Modal -->
            <div class="modal fade" id="reserve_<?php echo str_replace(' ', '-', strtolower($row['name']))?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><span class="reserve-title"><?php echo $row['name']; ?> Reserve</span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="<?php echo htmlspecialchars("/"); ?>" method="post" enctype="multipart/form-data">
                                <p style="font-size: 12px;">Please fill in your details correctly to reserve a venue</p>
                                <div class="mb-3">
                                    <label class="form-label">Full Name:</label>
                                    <input type="text" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" 
                                    value="<?php echo $name; ?>" name="name">
                                    <span class="invalid-feedback"><?php echo $name_err;?></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email:</label>
                                    <input type="text" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" name="email">
                                    <span class="invalid-feedback"><?php echo $email_err;?></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone:</label>
                                    <input type="text" class="form-control mb-1 <?php echo (!empty($contact_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contact; ?>" name="contact">
                                    <p style="font-size: 12px;">Format: 2547XXXXXXXX</p>
                                    <span class="invalid-feedback"><?php echo $contact_err;?></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Number of tickets:</label>
                                    <input type="number" min="0" max="<?php echo $row['audience_capacity'];?>" class="form-control <?php echo (!empty($capacity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $capacity ?? 0; ?>" name="capacity">
                                    <span class="invalid-feedback"><?php echo $capacity_err;?></span>
                                </div>
                            
                                <input name="action" value="book_venue" class="hidden">
                                <input name="form_id" value="<?php echo $row['id']?>" class="hidden">

                                <div style="text-align: right;">
                                    <button type="button" class="btn btn-light bg-transparent" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Reserve Event</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } } }?>
    </div>
</div>