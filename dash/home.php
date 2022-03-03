<h1>Welcome <?php echo htmlspecialchars($_SESSION["full_name"])?></h1>

<div class="py-5">
    <?php if($_SESSION['is_admin']) { ?>
        <?php 
        require_once "../scripts/db_conn.php";    
        $todays_user_count = $todays_event_total = $todays_venue_total = $todays_requests_total = 0;
        // New Users
        $sql1 = "SELECT COUNT(*) AS todays_user_total FROM `users` WHERE `created_at` >= DATE_SUB(DATE_SUB(CURDATE(), INTERVAL DAY(CURDATE()) - 1 DAY), INTERVAL 1 MONTH) AND `created_at` < DATE_SUB(CURDATE(), INTERVAL DAY(CURDATE()) - 1 DAY)";

        // New Event Booking
        $sql2 = "SELECT COUNT(*) AS todays_event_total FROM `user_booking` WHERE `type`='event' AND `status`= 0 AND `created_at` >= DATE_SUB(DATE_SUB(CURDATE(), INTERVAL DAY(CURDATE()) - 1 DAY), INTERVAL 1 MONTH) AND `created_at` < DATE_SUB(CURDATE(), INTERVAL DAY(CURDATE()) - 1 DAY)";

        // New Venue Booking
        $sql3 = "SELECT COUNT(*) AS todays_venue_total FROM `user_booking` WHERE `type`='venue' AND `status`= 0 AND `created_at` >= DATE_SUB(DATE_SUB(CURDATE(), INTERVAL DAY(CURDATE()) - 1 DAY), INTERVAL 1 MONTH) AND `created_at` < DATE_SUB(CURDATE(), INTERVAL DAY(CURDATE()) - 1 DAY)";

        // New User Requests
        $sql4 = "SELECT COUNT(*) AS todays_requests_total FROM `user_requests` WHERE `status`=0 AND `created_at` >= DATE_SUB(DATE_SUB(CURDATE(), INTERVAL DAY(CURDATE()) - 1 DAY), INTERVAL 1 MONTH) AND `created_at` < DATE_SUB(CURDATE(), INTERVAL DAY(CURDATE()) - 1 DAY)";

        if($stmt = $mysqli->prepare($sql1)){
            if($stmt->execute()){
                $result = $stmt->get_result();
                if($result->num_rows == 1){
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    $todays_user_count = $row["todays_user_total"];
                }
            }
        }

        if($stmt = $mysqli->prepare($sql2)){
            if($stmt->execute()){
                $result = $stmt->get_result();
                if($result->num_rows == 1){
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    $todays_event_total = $row["todays_event_total"];
                }
            }
        }

        if($stmt = $mysqli->prepare($sql3)){
            if($stmt->execute()){
                $result = $stmt->get_result();
                if($result->num_rows == 1){
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    $todays_venue_total = $row["todays_venue_total"];
                }
            }
        }

        if($stmt = $mysqli->prepare($sql4)){
            if($stmt->execute()){
                $result = $stmt->get_result();
                if($result->num_rows == 1){
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    $todays_requests_total = $row["todays_requests_total"];
                }
            }
        }

        ?>
        <div class="">
            <div class="card" style="width: 50%;">
                <div class="card-block">
                    <h4 class="card-title">Notifications</h4>
                    <ul class="mt-5">
                        <li class="card-text mb-5">New Event Requests: <span style="font-weight: 700;color: var(--aux);"><?php echo $todays_requests_total; ?> today</span></li>
                        <li class="card-text mb-5">New Event Booking: <span style="font-weight: 700;color: var(--aux);"><?php echo $todays_event_total; ?> today</span></li>
                        <li class="card-text mb-5">New Venue Booking: <span style="font-weight: 700;color: var(--aux);"><?php echo $todays_venue_total; ?> today</span></li>
                        <li class="card-text">New Users: <span style="font-weight: 700;color: var(--aux);"><?php echo $todays_user_count; ?> today</span></li>
                    </ul>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="">

            <h4 class="mb-3">What can you do</h4>

            <div class="row hidden-md-up">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Book an Event</h4>
                            <ul class="mt-5">
                                <li class="card-text">Reserve an event on homepage, from one of the listed public events</li>
                                <li class="card-text">Reserve an event on admin page, from the events page</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Monitor your requests</h4>
                        <ul class="mt-5">
                            <li class="card-text">After booking, the event planner will reach out. You can go to my requests checking updates</li>
                            <li class="card-text">Also check your email for notifications</li>
                        </ul>
                    </div>
                </div>
                </div>
                <div class="col-md-4">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Check Profile and Update</h4>
                        <ul class="mt-5">
                            <li class="card-text">From the top navigation you can see your name. Click on profile where you are able to update your details</li>
                        </ul>
                    </div>
                </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>