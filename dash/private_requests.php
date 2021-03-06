<?php
require_once "../scripts/db_conn.php";

$notes = $notes_err = "";
$main_err = $main_succ = "";
$venue_id = null;
$booking_name = $booking_email = $booking_contact = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'confirm_request'){
    // Validate notes
    $input_notes = trim($_POST["notes"]);
    if(empty($input_notes)){
        $notes_err = "Please enter some confirmation notes.";     
    } else{
        $notes = $input_notes;
    }

    if(!empty($notes_err)) {
        $main_err = "Please check the form again before submitting";
    }

    if(empty($notes_err)) {
        $sql = "UPDATE user_requests SET status=?, notes=? WHERE id=?";

        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("ssi", $param_status, $param_notes, $param_id);

            $param_status = 1; // confirmed
            $param_notes = $notes;
            $param_id = $_POST['request_id'];

            if($stmt->execute()) {
                $subject = 'Event Request Confirmed';

                $headers = "From: webmaster@quioccassions.com" . "\r\n" . "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $message = "<html>
                <body>
                <p> Hello </p>
                <p> Your private request is approved and an event is created for it</p>
                <p>Please login and check the details and status of your event. Thank you.</p>
                </body>
                </html>";
            
                mail('shannellenjeru@gmail.com', $subject, $message, $headers);

                ?><script type="text/javascript">
                window.location = "/dash/index.php?page=private_requests";
                </script><?php
                $main_succ = "User requests approved successfully";
                exit();
            } else{
                $main_err = "Oops! Something went wrong. Please try again later.";
            }
        }
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'cancel_request'){
    $id = $_POST['request_id'];

    $sql = "UPDATE user_requests SET status=? WHERE id=?";

    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("si", $param_status, $param_id);

        $param_status = 2; // Cancelled
        $param_id = $id;
        
        if($stmt->execute()) {
            $subject = 'Event Request Cancelled';

            $headers = "From: webmaster@quioccassions.com" . "\r\n" . "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $message = "<html>
            <body>
            <p> Hello </p>
            <p> Your private request has been cancelled.</p>
            <p> If you have further questions please don't hesitate but to call us. Thank you.</p>
            </body>
            </html>";
        
            mail('shannellenjeru@gmail.com', $subject, $message, $headers);

            ?><script type="text/javascript">
            window.location = "/dash/index.php?page=private_requests";
            </script><?php
            $main_succ = "User requests cancelled successfully";
            exit();
        } else{
            $main_err = "Oops! Something went wrong. Please try again later.";
        }
    }
}

?>

<div>
    <h3 class="table-title">Private Requests</h3>

    <div class="table-wrapper">
        <div class="table-header">
            <div>
                <a class="text-success" href="/dash/index.php?page=confirmed_private_requests">Confirmed Requests</a>
                <a class="text-danger" href="/dash/index.php?page=canceled_private_requests">Cancelled Requests</a>
            </div>
        </div>
        
        <?php include 'succ_err_view.php' ?>

        <div class="table-list">

            <?php
            $sql = "SELECT user_requests.*, users.full_name as full_name, users.email as email FROM user_requests INNER JOIN users ON user_requests.user_id=users.id AND user_requests.status=0 ORDER BY user_requests.id DESC";

            $count = 1;
            
            if($result = $mysqli->query($sql)){
                if($result->num_rows > 0){
                    echo '<table class="table">';
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>User Info</th>";
                                echo "<th>Event Description</th>";
                                echo "<th>Status</th>";
                                echo "<th>Created</th>";
                                echo "<th>Action</th>";
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while($row = $result->fetch_array()){
                            echo "<tr>";
                                echo "<td>" . $count++ . "</td>";
                                echo "<td>" . 
                                    "<p><b>Name: </b>" . $row['full_name'] . "</p>" .
                                    "<p><small><b>Email: </b>" . $row['email'] . "</small></p>" .
                                "</td>";
                                echo "<td style='width: 500px;'>". $row['description'] ."</td>";

                                if($row['status'] == 1) { // status 1
                                    echo "<td><span class='badge rounded-pill bg-success'>Confirmed</span></td>";
                                }elseif ($row['status'] == 2) { // status 2
                                    echo "<td><span class='badge rounded-pill bg-danger'>Canceled</span></td>";
                                }else { // status 0
                                    echo "<td><span class='badge rounded-pill bg-info'>Verification</span></td>";
                                }

                                echo "<td>" . date("M d, Y A",strtotime($row['created_at'])) . "</td>";

                                echo "<td style=''>";
                                    if($row['status'] == 0) {
                                        echo '<div class="btn-group" role="group">';
                                            echo '<button class="btn btn-transparent"><span class="text-success" style="font-size: 20px;" data-bs-toggle="modal" data-bs-target="#confirm_modal_'. $row['id'].'"><i class="far fa-check-square"></i></span></button>';
                                            echo '<button class="btn btn-transparent"><span class="text-danger" style="font-size: 20px;" data-bs-toggle="modal" data-bs-target="#cancel_modal_'. $row['id'].'"><i class="far fa-window-close"></i></span></button>';
                                        echo '</div>';
                                    } else if($row['status'] == 1){
                                        echo '<div class="badge rounded-pill bg-success" style="padding: 10px;">Create Event</div>';
                                    } else if($row['status'] == 2){
                                        echo '';
                                    }
                                echo "</td>";
                                
                            echo "</tr>";

                            ?>

                            <!-- Confirm Modal -->
                            <div class="modal fade" id="<?php echo 'confirm_modal_'. $row['id']?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <h5 class="modal-title" id="exampleModalLabel">Confirm <span style="color: var(--primary)"><?php echo $row['full_name']?></span> Private Request</h5>

                                            <small style="color: var(--aux)">***Once Approved please create an event for it</small>
                                            <div class="mt-5">
                                                <form action="<?php echo htmlspecialchars("/dash/index.php?page=private_requests")?>" method="post">
                                                    <div class="mb-5">
                                                        <label for="exampleInputEmail1" class="form-label">Additional Confirmation Notes</label>
                                                        <textarea class="form-control <?php echo (!empty($notes_err)) ? 'is-invalid' : ''; ?>" placeholder="Add additional request notes here" name="notes" style="height: 300px"><?php echo $notes; ?></textarea>
                                                        <span class="invalid-feedback"><?php echo $notes_err;?></span>
                                                    </div>

                                                    <input name="action" value="confirm_request" class="hidden">
                                                    <input name="request_id" value="<?php echo $row['id']?>" class="hidden">

                                                    <div class="text-right">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Confirm Booking</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cancel Modal -->
                            <div class="modal fade" id="<?php echo 'cancel_modal_'. $row['id']?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="text-center">
                                                <form action="<?php echo htmlspecialchars("/dash/index.php?page=private_requests")?>" method="post">
                                                    <span class="text-danger mb-3" style="font-size: 100px;">
                                                        <i class="far fa-times-circle"></i>
                                                    </span>

                                                    <h3 class="mb-3">Are you sure?<h3>

                                                    <p class="mb-5" style="font-weight: 100; font-size: 18px">Do you really want to cancel user venue booking? This process cannot be undone.</p>

                                                    <input name="action" value="cancel_request" class="hidden">
                                                    <input name="request_id" value="<?php echo $row['id']?>" class="hidden">

                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Cancel Request</button>
                                                </form>
                                            </div>
                                        </div>
                                
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        echo "</tbody>";                            
                    echo "</table>";
                    // Free result set
                    $result->free();
                } else{
                    echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                }
            } else{
                echo '<div class="alert alert-danger"><em>Oops! Something went wrong. Please try again later.</em></div>';
            }
            
            ?>

        </div>
    </div>
</div>