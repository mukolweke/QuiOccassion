<div>
    <h3 class="table-title">Events</h3>

    <div class="table-wrapper">
        <div class="table-header">
            <p class="table-subtitle">List of Scheduled Events</p>
            <a href="/dash/index.php?page=manage_events" class="btn btn-primary"><span><i class="fas fa-plus"></i></span> Schedule an Event</a>
        </div>

        <div class="table-list">

            <?php
            require_once "../scripts/db_conn.php";

            $sql = "SELECT * FROM events";
            $count = 1;
            
            if($result = $mysqli->query($sql)){
                if($result->num_rows > 0){
                    echo '<table class="table">';
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Name</th>";
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
                                echo "<td>" . $count . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['schedule'] . "</td>";
                                echo "<td>" . $row['venue'] . "</td>";
                                echo "<td> Ksh " . $row['info'] . "</td>";
                                echo "<td> Ksh " . $row['description'] . "</td>";
                                echo "<td style=''>";
                                    echo '<div class="btn-group" role="group">';
                                        echo '<a href="/dash/index.php?page=venues_update&id='. $row['id'] .'" class="btn btn-transparent"><i class="fas fa-edit"></i></a>';
                                        echo '<form method="post" action="/dash/index.php?page=venues">
                                        <input name="venue_id" value=' . $row['id']. ' class="hidden">
                                        <input name="action" value="delete" class="hidden">
                                        <button type="submit" class="btn btn-transparent btn-sm"><i class="fas fa-trash"></i></button>
                                        </form>';
                                    echo '</div>';
                                echo "</td>";
                            echo "</tr>";
                            $count++;
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