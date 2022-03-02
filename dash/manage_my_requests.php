<?php
require_once "../scripts/db_conn.php";

$schedule_date = $description = $payment_type = $event_type = "" ;
$schedule_date_err = $description_err = $payment_type_err = $event_type_err = "";
$main_err = $main_succ = "";
$formUrl = "/dash/index.php?page=manage_my_requests" ;
$user_id = $status = NULL;


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'save'){

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

    // Check input errors before inserting in database
    if(empty($description_err) && empty($schedule_date_err)){
        $sql = "INSERT INTO user_requests (user_id, description, status, schedule_date) VALUES (?, ?, ?, ?)";

        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("ssss", $param_user_id, $param_description, $param_status, $param_schedule_date);

            // parameters
            $param_description = $description;
            $param_schedule = $schedule_date;
            $param_user_id = $_SESSION['id'];
            $param_status = 0;

            if($stmt->execute()){
                ?><script type="text/javascript">
                window.location = "/dash/index.php?page=my_requests";
                </script><?php
                $main_succ = "Requests details saved Successfully";
                exit();
            } else{
                $main_err = "Oops! Something went wrong. Please try again later.";
            }
        }
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

        <div class="d-flex align-items-start">
            <div class="form_body">
                <?php include 'succ_err_view.php' ?>

                <form action="<?php echo htmlspecialchars($formUrl); ?>" method="post">

                    <div class="mb-3">
                        <label class="form-label">Schedule Date</label>
                        <input type="text" id="datepicker" class="form-control <?php echo (!empty($schedule_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo isset($schedule_date) ? $schedule_date :'' ?>"name="schedule_date">
                        <span class="invalid-feedback"><?php echo $schedule_date_err;?></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>" name="description" rows="3"><?php echo $description; ?></textarea>
                        <span class="invalid-feedback"><?php echo $description_err;?></span>
                        <small class="form-text text-muted">Please detailed details for the event</small>
                    </div>
                    
                    <div class="form-group mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="event_type" name="event_type" <?php echo isset($event_type) && $event_type == 1 ? "checked" : "" ?>>
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
                        <button type="submit" class="btn btn-primary">
                            Request Event    
                        <button>
                    </div>
                </form>
            </div>
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