<?php 
require_once "./scripts/db_conn.php";

$name = $email = $contact = $capacity = "";
$name_err = $email_err = $contact_err = $capacity_err = "";
$main_err = $main_succ = "";

// Processing venue form data when submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'reserve_event'){
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
    $main_err = "Ooops! There are errors in event reserve form you just submitted";
  }

  if(empty($name_err) && empty($email_err) && empty($contact_err) && empty($capacity_err)) {
    $sql = "INSERT INTO event_reserves (name, email, contact, event_id, capacity) VALUES (?, ?, ?, ?, ?)";

    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("sssss", $param_name, $param_email, $param_contact, $param_event_id, $param_capacity);

        // parameters
        $param_name = $name;
        $param_email = $email;
        $param_contact = $contact;
        $param_event_id = $_POST['event_id'];
        $param_capacity = $capacity;
        //status '0-for verification, 1=confirmed, 2=canceled' 

        if($stmt->execute()){
          ?><script type="text/javascript">
              window.location = "/";
          </script><?php
          $main_succ = "Event reserved successfully, check your email for details";
        } else{
          $main_err = "Oops! Please check the form.";
        }
    }
  } else{
    $main_err = "Oops! Please check the form.";
  }
}
?>
<div id="upcoming_events">
  <div
    class="upcoming-events"
  >
    <div class="d-flex justify-content-between mb-3">
      <div>
        <h2>Upcoming Events</h2>
        <p class="section-title-bar"></p>
        <p style="font-size: 12px;">Scroll right to view more</p>
      </div>
    </div>

    <?php include './dash/succ_err_view.php' ?>

    <div class="carousel-inner">
      <div class="">
        <div class="d-flex carousel-qui-inner" style="overflow-x: scroll;">
          <?php

            $sql = "SELECT events.*, venues.name as venue_name FROM events INNER JOIN venues ON events.venue_id=venues.id ORDER BY events.id DESC";
            $count = 1;
            
            if($result = $mysqli->query($sql)){
                if($result->num_rows > 0){
                  while($row = $result->fetch_array()){
                  ?>
                <div class="col-md-4 mb-3" style="margin-right: 16px;">
                  <div class="card" style="border-radius: 16px">
                    <img
                      class="img-fluid"
                      style="
                        border-top-left-radius: 16px;
                        border-top-right-radius: 16px;
                      "
                      alt="100%x280"
                      src="/assets/img/uploads/<?php echo $row['banner']?>"
                    />
                    <div class="card-body">
                      <h4 class="card-title"><?php echo $row['name']; ?></h4>
                      <p class="card-subtitle"><?php echo $row['venue_name']; ?></p>
                      <p class="card-text"><?php echo $row['description']; ?></p>
                      <p class="card-price"><small><?php echo ($row['payment_type']  == 1 ? 'Free' : 'Ksh '.number_format($row['amount'],2))?></small></p>

                      <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reserve_<?php echo $row['id']?>">Reserve</button>
                      </div>
                    </div>
                  </div>
                </div>

                <!--Reserve Modal -->
                <div class="modal fade" id="reserve_<?php echo $row['id']?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title"><span class="reserve-title"><?php echo $row['name']; ?> Reserve</span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="<?php echo htmlspecialchars("/index.php"); ?>" method="post" enctype="multipart/form-data">
                          <p style="font-size: 12px;">Please fill in your details correctly to reserve a ticket</p>
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
                        
                          <input name="action" value="reserve_event" class="hidden">
                          <input name="event_id" value="<?php echo $row['id']?>" class="hidden">

                          <div style="text-align: right;">
                              <button type="button" class="btn btn-light bg-transparent" data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-primary">Reserve Event</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
            <?php }}} ?>
        </div>
      </div>
    </div>
  </div>
</div>