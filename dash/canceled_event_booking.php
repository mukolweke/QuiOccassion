<?php
require_once "../scripts/db_conn.php";

?>

<div>
    <h3 class="table-title">Event Requests</h3>

    <div class="table-wrapper">
        <div class="table-header">
            <p class="table-subtitle">List of Cancelled Scheduled Events</p>
        </div>
        
        <div class="table-list">

            <?php
            $sql = "SELECT user_booking.*, events.name as event_name, events.schedule as event_schedule, events.amount as event_amount, events.payment_type as event_payment_type, events.audience_capacity as event_audience_capacity  FROM user_booking INNER JOIN events ON user_booking.event_id=events.id AND user_booking.status=2 ORDER BY user_booking.id DESC";

            $count = 1;
            
            if($result = $mysqli->query($sql)){
                if($result->num_rows > 0){
                    echo '<table class="table">';
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>User Info</th>";
                                echo "<th>Event Info</th>";
                                echo "<th>Capacity</th>";
                                echo "<th>Status</th>";
                                echo "<th>Created</th>";
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while($row = $result->fetch_array()){
                            echo "<tr>";
                                echo "<td>" . $count++ . "</td>";
                                echo "<td>" . 
                                    "<p><b>Name: </b>" . $row['name'] . "</p>" .
                                    "<p><small><b>Email: </b>" . $row['email'] . "</small></p>" .
                                    "<p><small><b>Contact: </b> ". $row['contact'] ." </small></p>" .
                                "</td>";
                                echo "<td>" . 
                                    "<p><b>Event: </b>" . $row['event_name'] . "</p>" .
                                    "<p><small><b>Schedule: </b>" . $row['event_schedule'] . "</small></p>" .
                                    "<p><small><b>Fee Amount: </b> ". ($row['event_payment_type']  == 1 ? 'Free' : 'Ksh '.number_format($row['event_amount'],2)) ." </small></p>" .
                                    "<p><small><b>Event Capacity: </b>" . $row['event_audience_capacity'] . "</small></p>" .
                                "</td>";
                                echo "<td>" . $row['capacity'] . "</td>";

                                if($row['status'] == 1) { // status 1
                                    echo "<td><span class='badge rounded-pill bg-success'>Confirmed</span></td>";
                                }elseif ($row['status'] == 2) { // status 2
                                    echo "<td><span class='badge rounded-pill bg-danger'>Canceled</span></td>";
                                }else { // status 0
                                    echo "<td><span class='badge rounded-pill bg-info'>Verification</span></td>";
                                }

                                echo "<td>" . date("M d, Y A",strtotime($row['created_at'])) . "</td>";

                            echo "</tr>";
                            ?>

                            <!-- Confirm Modal -->
                            <div class="modal fade" id="<?php echo 'confirm_modal_'. $row['id']?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <h5 class="modal-title" id="exampleModalLabel">Confirm <span style="color: var(--primary)"><?php echo $row['name']?></span> User Request</h5>

                                            <div class="mt-5">
                                                <form action="<?php echo htmlspecialchars("/dash/index.php?page=event_requests");?>" method="post">
                                                    <div class="mb-5">
                                                        <label for="exampleInputEmail1" class="form-label">Additional Confirmation Notes</label>
                                                        <textarea class="form-control <?php echo (!empty($notes_err)) ? 'is-invalid' : ''; ?>" placeholder="Add additional request notes here" name="notes" style="height: 300px;"><?php echo $notes; ?></textarea>
                                                        <span class="invalid-feedback"><?php echo $notes_err;?></span>
                                                    </div>

                                                    <input name="action" value="confirm_event" class="hidden">
                                                    <input name="booking_id" value="<?php echo $row['id']?>" class="hidden">

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
                                                <form action="<?php echo htmlspecialchars("/dash/index.php?page=event_requests")?>" method="post">
                                                    <span class="text-danger mb-3" style="font-size: 100px;">
                                                        <i class="far fa-times-circle"></i>
                                                    </span>

                                                    <h3 class="mb-3">Are you sure?<h3>

                                                    <p class="mb-5" style="font-weight: 100; font-size: 18px">Do you really want to cancel user venue booking? This process cannot be undone.</p>

                                                    <input name="action" value="cancel_booking" class="hidden">
                                                    <input name="booking_id" value="<?php echo $row['id']?>" class="hidden">

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