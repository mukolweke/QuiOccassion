<?php 
require_once "../scripts/db_conn.php";

?>

<div>
    <h3 class="table-title">Venue Requests</h3>

    <div class="table-wrapper">
        <div class="table-header">
            <p class="table-subtitle">List of Cancelled Booked Venues</p>
        </div>
        
        <div class="table-list">

            <?php
            $sql = "SELECT user_booking.*, venues.name as venue_name, venues.address as venue_address, venues.rate as venue_rate FROM user_booking INNER JOIN venues ON user_booking.venue_id=venues.id AND user_booking.status=2 ORDER BY user_booking.id DESC";

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
                                    "<p><b>Event: </b>" . $row['venue_name'] . "</p>" .
                                    "<p><small><b>Address: </b>" . $row['venue_address'] . "</small></p>" .
                                    "<p><small><b>Fee Rate: </b> Ksh " . $row['venue_rate'] . " </small></p>" .
                                    "<p><a href='/dash/index.php?page=venue&id=". $row['venue_id'] ."'>View Details</a></p>" .
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