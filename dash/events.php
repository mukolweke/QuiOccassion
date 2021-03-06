<?php
require_once "../scripts/db_conn.php";

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'delete'){
    $id = $_POST['event_id'];

    if($delete = $mysqli->query("DELETE FROM events where id = " . $id)){
        $main_succ = "Event record deleted successfully";
    }else {
        $main_err = "Ooops! Deletion process was not successful";
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'mark_complete'){
    $id = $_POST['event_id'];

    if($delete = $mysqli->query("UPDATE events SET completed=1 where id = " . $id)){
        $main_succ = "Event record updated successfully";
    }else {
        $main_err = "Ooops! Update process was not successful";
    }
}
?>

<div>
    <h3 class="table-title">Events</h3>

    <div class="table-wrapper">
        <div class="table-header">
            <p class="table-subtitle">List of Scheduled Events</p>
            <a href="/dash/index.php?page=manage_events" class="btn btn-primary"><span><i class="fas fa-plus"></i></span> Schedule an Event</a>
        </div>
        
        <?php include 'succ_err_view.php' ?>

        <div class="table-list">

            <?php
            require_once "../scripts/db_conn.php";

            $sql = "SELECT events.*, venues.name as venue_name FROM events INNER JOIN venues ON events.venue_id=venues.id AND events.completed=0 ORDER BY events.id DESC";
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
                                echo "<th>Action</th>";
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
                                echo "<td style=''>";
                                    echo '<div class="btn-group" role="group">';
                                        if($date_now > $row['schedule']) {
                                            echo '<form method="post" action="/dash/index.php?page=events">
                                            <input name="event_id" value=' . $row['id']. ' class="hidden">
                                            <input name="action" value="mark_complete" class="hidden">
                                            <button type="submit" class="btn btn-transparent btn-sm">Mark Complete</button>
                                            </form>';
                                        }else {
                                            echo '<a href="/dash/index.php?page=manage_events&id='. $row['id'] .'" class="btn btn-transparent"><i class="fas fa-edit"></i></a>';
                                            echo '<form method="post" action="/dash/index.php?page=events">
                                            <input name="event_id" value=' . $row['id']. ' class="hidden">
                                            <input name="action" value="delete" class="hidden">
                                            <button type="submit" class="btn btn-transparent btn-sm"><i class="fas fa-trash"></i></button>
                                            </form>';
                                        }
                                    echo '</div>';
                                echo "</td>";
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