<?php
require_once "../scripts/db_conn.php";

// Define variables and initialize with empty values
/**
 * Event Types: Private & Public.
 * Payment Type: Free & Payable.
 */
$name = $schedule_date = $venue_id = $description = $event_type = $banner = $payment_type = "" ;
$name_err = $schedule_date_err = $venue_id_err = $description_err = $event_type_err = $banner_err = $audience_capacity_err = $payment_type_err = $amount_err = "";
$audience_capacity = $amount = 0;
$payment_type = 0; // payable;
$event_type = 0; // public;
$banner_image_name = $tmp_img_name = "";
$main_err = $main_succ = "";


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'save'){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }

    // Validate schedule date
    $input_schedule_date = trim($_POST["schedule_date"]);
    if(empty($input_schedule_date)){
        $schedule_date_err = "Please enter a schedule date.";     
    } else{
        $schedule_date = $input_schedule_date;
    }

    // Validate description
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Please enter an description.";     
    } else{
        $description = $input_description;
    }

    // Validate venue
    $input_venue_id = trim($_POST["venue_id"]);
    if(empty($input_venue_id)){
        $venue_id_err = "Please select a venue.";     
    } else{
        $venue_id = $input_venue_id;
    }

    // Validate audience capacity
    $input_audience_capacity = trim($_POST["audience_capacity"]);
    if($input_audience_capacity < 1){
        $audience_capacity_err = "Please enter the audience capacity.";     
    } elseif(!ctype_digit($input_audience_capacity)){
        $audience_capacity_err = "Please enter a positive integer value.";
    } else{
        $audience_capacity = $input_audience_capacity;
    }

     // Validate amount
     $input_payment_status = isset($_POST['payment_status']) ? $_POST['payment_status'] : 0;

     if($input_payment_status === 0) { // if not free
        $input_amount = trim($_POST["amount"]);
        if($input_amount < 1){
            $amount_err = "Please enter the fee amount.";     
        } elseif(!ctype_digit($input_amount)){
            $amount_err = "Please enter a positive integer value.";
        } else{
            $amount = $input_amount;
        }
     }else {
        $amount = trim($_POST["amount"]);
     }
    
    // Validate banner image
    if(empty($_FILES['banner_image']['name'])){
        $banner_err = "Please upload the banner image.";     
    } else{
        list($txt, $ext) = explode(".", $_FILES['banner_image']['name']);
        $banner_image_name = time().".".$ext;
        $tmp_img_name = $_FILES['banner_image']['tmp_name'];
    }

    // update the payment status
   $payment_type = $input_payment_status;
    // update the event type
   $event_type = isset($_POST['event_type']) ?trim($_POST["event_type"]) : 0 ;

    // Check input errors before inserting in database
    if(empty($name_err) && empty($description_err) && empty($schedule_date_err) && empty($amount_err) && empty($venue_id_err) && empty($banner_err) && empty($audience_capacity_err)){
        if(move_uploaded_file($tmp_img_name, '../assets/img/uploads/'.$banner_image_name)){

            $sql = "INSERT INTO events (venue_id, name, description, schedule, type, audience_capacity, payment_type, amount, banner) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            if($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param("sssssssss", $param_venue_id, $param_name, $param_description, $param_schedule, $param_type, $param_audience_capcity, $param_payment_type,  $param_amount, $param_banner);

                // parameters
                $param_name = $name;
                $param_description = $description;
                $param_venue_id = $venue_id;
                $param_type = $event_type;
                $param_payment_type = $payment_type;
                $param_audience_capcity = $audience_capacity;
                $param_schedule = $schedule_date;
                $param_amount = $amount;
                $param_banner = $banner_image_name;

                if($stmt->execute()){
                    ?><script type="text/javascript">
                    window.location = "/dash/index.php?page=events";
                    </script><?php
                    $main_succ = "Venue details saved Successfully";
                    exit();
                } else{
                    $main_err = "Oops! Something went wrong. Please try again later.";
                }
            }
        }else{
            $main_err = "Oops! Something went wrong. Please try again later.";
        }
     
        // Close statement
        $stmt->close();
    }else {
        $main_err = "Oops! Something went wrong. Please check the form.";
    }
}
?>

<div>
    <h3 class="table-title">Events</h3>

    <div class="table-wrapper">
        <div class="table-header">
            <p class="table-subtitle">Schedule New Event</p>
        </div>

        <div class="form_body">
            <?php include 'succ_err_view.php' ?>

            <form action="<?php echo htmlspecialchars("/dash/index.php?page=manage_events"); ?>" method="post" enctype="multipart/form-data">

                <div class="d-flex justify-content-between">
                    <div class="mb-3 w-280px">
                        <label class="form-label">Event Name</label>
                        <input type="text" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" 
                        value="<?php echo $name; ?>" name="name">
                        <span class="invalid-feedback"><?php echo $name_err;?></span>
                    </div>
                    <div class="mb-3 w-280px">
                        <label class="form-label">Schedule Date</label>
                        <input type="text" id="datepicker" class="form-control <?php echo (!empty($schedule_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo isset($schedule_date) ? $schedule_date :'' ?>"name="schedule_date">
                        <span class="invalid-feedback"><?php echo $schedule_date_err;?></span>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div class="mb-3 w-280px">
                        <label class="form-label">Venue</label>
                        <select class="form-select <?php echo (!empty($venue_id_err)) ? 'is-invalid' : ''; ?>" name="venue_id" id="">
                            <option value="" selected>Please select a venue</option>
                            <?php
                                require_once "../scripts/db_conn.php";

                                $sql = "SELECT * FROM venues ORDER BY name ASC";
                                if($result = $mysqli->query($sql)){
                                    if($result->num_rows > 0){
                                        while($row = $result->fetch_array()){
                                            ?>
                                            <option value="<?php echo $row['id'] ?>" <?php echo isset($venue_id) && $venue_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
                                            <?php
                                        } $result->free();
                                    }
                                }?>
                        </select>
                        <span class="invalid-feedback"><?php echo $venue_id_err;?></span>
                    </div>

                    <div class="mb-3 w-280px">
                        <label class="form-label">Banner Image</label>
                        <input type="file" class="form-control <?php echo (!empty($banner_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $banner; ?>" name="banner_image" id="formFile">
                        <span class="invalid-feedback"><?php echo $banner_err;?></span>
                    </div>
                    
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>" name="description" rows="3"><?php echo $description; ?></textarea>
                    <span class="invalid-feedback"><?php echo $description_err;?></span>
                </div>
                
                <div class="form-group mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="2" id="event_type" name="event_type" <?php echo isset($event_type) && $event_type == 1 ? "checked" : "" ?>>
                        <label class="form-check-label" for="type">
                        Private Event (<i>Do not show in website</i>)
                        </label>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="payment_status" name="payment_status" <?php echo isset($payment_type) && $payment_type == 1 ? "checked" : '' ?>>
                        <label class="form-check-label" for="payment_status">
                        Free For All
                        </label>
                    </div>
                </div>

                <div class="mb-3" id="registration_fee" <?php echo isset($payment_type) && $payment_type == 1 ? "style='display:none'" : ''; ?>>
                    <label class="form-label">Registration Fee</label>
                    <input type="number" step="any" min="0"  class="form-control text-right <?php echo (!empty($amount_err)) ? 'is-invalid' : ''; ?>" name="amount" id ='amount'  value="<?php echo $amount ?? 0; ?>" autocomplete="off">

                    <span class="invalid-feedback"><?php echo $amount_err;?></span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Audience Capacity</label>

                    <input type="number" step="any" min="0" class="form-control text-right <?php echo (!empty($audience_capacity_err)) ? 'is-invalid' : ''; ?>" name="audience_capacity" id ='audience_capacity'  value="<?php echo $audience_capacity ?? 0; ?>" autocomplete="off">

                    <span class="invalid-feedback"><?php echo $audience_capacity_err;?></span>
                </div>
                
                <input name="action" value="save" class="hidden">

                <div style="text-align: right;">
                    <button type="submit" class="btn btn-primary">Create Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$('#datepicker').datepicker({
    uiLibrary: 'bootstrap'
});

let paymentCheck = document.getElementById('payment_status');
let feeInput = document.getElementById("registration_fee");

paymentCheck.addEventListener('change', e => {
  if(e.target.checked === true) {
    feeInput.style.display = "none";
  }
if(e.target.checked === false) {
    feeInput.style.display = "block";
  }
});
</script>