<?php
require_once "../scripts/db_conn.php";

?>

<div>
    <h3 class="table-title">Events</h3>

    <div class="table-wrapper">
        <div class="table-header">
            <p class="table-subtitle">List of My Scheduled Events</p>
        </div>
        
        <?php include 'succ_err_view.php' ?>

        <div class="table-list">

            <?php
            $sql = "SELECT events.*, venues.name as venue_name FROM events INNER JOIN venues ON events.venue_id=venues.id AND events.completed=0 AND events.user_id=".$_SESSION['id']." ORDER BY events.id DESC";
            $count = 1;
            $date_now = date("d/m/Y");

            if($result = $mysqli->query($sql)){
                if($result->num_rows > 0){
                    echo '<table class="table">';
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Schedule</th>";
                                echo "<th>Venue</th>";
                                echo "<th>Event Info</th>";
                                echo "<th>Description</th>";
                                echo "<th>Status</th>";
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while($row = $result->fetch_array()){
                            echo "<tr>";
                                echo "<td>" . $count++ . "</td>";
                                echo "<td>" . date("M d, Y A",strtotime($row['schedule'])) . "</td>";
                                echo "<td><a class='table-link' href='/dash/index.php?page=venue&id=". $row['venue_id'] ."'>".$row['venue_name']." </a></td>";
                                echo "<td>" . 
                                    "<p><b>Event Name: </b>" . $row['name'] . "</p>" .
                                    "<p><small><b>Event Type: </b><span style='color: var(--aux)'>" . ($row['type'] == 1 ? 'Private' : 'Public') . "</span></small></p>" .
                                    "<p><small><b>Fee: </b> ". ($row['payment_type']  == 1 ? 'Free' : 'Ksh '.number_format($row['amount'],2)) ." </small></p>" .
                                "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                if($row['completed'] == 1) { // status 1
                                    echo "<td><span class='badge rounded-pill bg-success'>Completed</span></td>";
                                }else { // status 0
                                    echo "<td><span class='badge rounded-pill bg-info'>Ongoing</span></td>";
                                }
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
            
            // Close connection
            $mysqli->close();
            ?>

        </div>
    </div>
</div>

<script>
$('#datepicker').datepicker({
    uiLibrary: 'bootstrap'
});
</script>