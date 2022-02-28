<?php 
require_once "../scripts/db_conn.php";

?>
<div>
    <h3 class="table-title">Requests</h3>
    <p style="font-size: 12px;">** click Heading to expand</p>

    <div class="accordion" id="accordionExample">
        <!-- Events Requests Tab -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                Event Requests
            </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="table-wrapper">
                    <div class="table-list">
                        <?php
                        $sql = "SELECT user_booking.*, events.name as event_name, events.schedule as event_schedule, events.amount as event_amount, events.payment_type as event_payment_type, events.audience_capacity as event_audience_capacity  FROM user_booking INNER JOIN events ON user_booking.event_id=events.id ORDER BY user_booking.id DESC";

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
                                            echo "<th>Notes</th>";
                                            echo "<th>Action</th>";
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

                                            if($row['capacity'] == 1) { // status 1
                                                echo "<td><span class='badge rounded-pill bg-success'>Confirmed</span></td>";
                                            }elseif ($row['capacity'] == 2) { // status 2
                                                echo "<td><span class='badge rounded-pill bg-danger'>Canceled</span></td>";
                                            }else { // status 0
                                                echo "<td><span class='badge rounded-pill bg-info'>Verification</span></td>";
                                            }

                                            echo "<td>" . date("M d, Y A",strtotime($row['created_at'])) . "</td>";
                                            echo "<td>" . $row['notes'] . "</td>";

                                            echo "<td style=''>";
                                                echo '<div class="btn-group" role="group">';
                                                    echo '<button class="btn btn-transparent"><span class="text-success" style="font-size: 20px;" data-bs-toggle="modal" data-bs-target="#confirm_modal_'. $row['id'].'"><i class="far fa-check-square"></i></span></button>';
                                                    echo '<button class="btn btn-transparent"><span class="text-danger" style="font-size: 20px;" data-bs-toggle="modal" data-bs-target="#cancel_modal_'. $row['id'].'"><i class="far fa-window-close"></i></span></button>';
                                                echo '</div>';
                                            echo "</td>";
                                            
                                        echo "</tr>";
                                        ?>

                                        <!-- Confirm Modal -->
                                        <div class="modal fade" id="<?php echo 'confirm_modal_'. $row['id']?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <h5 class="modal-title" id="exampleModalLabel">Confirm <span style="color: var(--primary)"><?php echo $row['name']?></span> User Request</h5>

                                                        <div class="mt-3">
                                                            <form>
                                                                <div class="mb-5">
                                                                    <label for="exampleInputEmail1" class="form-label">Additional Notes</label>
                                                                    <textarea class="form-control" placeholder="Add additional request notes here" style="height: 300px"></textarea>
                                                                </div>
                                                                <div class="text-right">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary">Confirm Request</button>
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
                                                            <span class="text-danger mb-3" style="font-size: 100px;">
                                                                <i class="far fa-times-circle"></i>
                                                            </span>

                                                            <h3 class="mb-3">Are you sure?<h3>

                                                            <p class="mb-5" style="font-weight: 100; font-size: 18px">Do you really want to cancel use event request? This process cannot be undone.</p>

                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-danger">Cancel Request</button>
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
            </div>
        </div>

        <!-- Venue Requests Tab -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Venue Requests
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="table-wrapper">
                    <div class="table-list">
                        <?php
                        $sql = "SELECT user_booking.*, venues.name as venue_name, venues.address as venue_address, venues.rate as venue_rate FROM user_booking INNER JOIN venues ON user_booking.venue_id=venues.id ORDER BY user_booking.id DESC";

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
                                            echo "<th>Action</th>";
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
                                                "<p><b>Event: </b>" . $row['venue_name'] . "</p>" .
                                                "<p><small><b>Address: </b>" . $row['venue_address'] . "</small></p>" .
                                                "<p><small><b>Fee Rate: </b> Ksh " . $row['venue_rate'] . " </small></p>" .
                                                "<p><a href='/dash/index.php?page=venue&id=". $row['venue_id'] ."'>View Details</a></p>" .
                                            "</td>";
                                            echo "<td>" . $row['capacity'] . "</td>";

                                            if($row['capacity'] == 1) { // status 1
                                                echo "<td><span class='badge rounded-pill bg-success'>Confirmed</span></td>";
                                            }elseif ($row['capacity'] == 2) { // status 2
                                                echo "<td><span class='badge rounded-pill bg-danger'>Canceled</span></td>";
                                            }else { // status 0
                                                echo "<td><span class='badge rounded-pill bg-info'>Verification</span></td>";
                                            }

                                            echo "<td>" . date("M d, Y A",strtotime($row['created_at'])) . "</td>";

                                            echo "<td style=''>";
                                                echo '<div class="btn-group" role="group">';
                                                    echo '<button class="btn btn-transparent"><span class="text-success" style="font-size: 20px;" data-bs-toggle="modal" data-bs-target="#confirm_modal_'. $row['id'].'"><i class="far fa-check-square"></i></span></button>';
                                                    echo '<button class="btn btn-transparent"><span class="text-danger" style="font-size: 20px;" data-bs-toggle="modal" data-bs-target="#cancel_modal_'. $row['id'].'"><i class="far fa-window-close"></i></span></button>';
                                                echo '</div>';
                                            echo "</td>";
                                            
                                        echo "</tr>";

                                        ?>

                                        <!-- Confirm Modal -->
                                        <div class="modal fade" id="<?php echo 'confirm_modal_'. $row['id']?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <h5 class="modal-title" id="exampleModalLabel">Confirm <span style="color: var(--primary)"><?php echo $row['name']?></span> Venue Booking</h5>

                                                        <div class="mt-3">
                                                            <form>
                                                                <div class="mb-5">
                                                                    <label for="exampleInputEmail1" class="form-label">Additional Notes</label>
                                                                    <textarea class="form-control" placeholder="Add additional request notes here" style="height: 300px"></textarea>
                                                                </div>
                                                                <div class="text-right">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary">Confirm Booking</button>
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
                                                            <span class="text-danger mb-3" style="font-size: 100px;">
                                                                <i class="far fa-times-circle"></i>
                                                            </span>

                                                            <h3 class="mb-3">Are you sure?<h3>

                                                            <p class="mb-5" style="font-weight: 100; font-size: 18px">Do you really want to cancel user venue booking? This process cannot be undone.</p>

                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-danger">Cancel Request</button>
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
        </div>
    </div>
</div>