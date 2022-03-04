<?php
require_once "../scripts/db_conn.php";


// Define variables and initialize with empty values
$name = $address = $description = $rate = $image = "";
$main_err = $main_succ = "";

if(isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id =  trim($_GET["id"]);
    $sql = "SELECT * FROM venues WHERE id = ?";
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("i", $param_id);
        $param_id = $id;
        
        if($stmt->execute()){
            $result = $stmt->get_result();
            
            if($result->num_rows == 1){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
                $name = $row["name"];
                $address = $row["address"];
                $rate = $row["rate"];
                $description = $row['description'];
                $image = $row['image'];
            } else{
                $main_err = "Oops! URL doesn't contain valid id.";
                exit();
            }
            
        } else{
            $main_err = "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    $stmt->close();
}

?>

<div>
    <!-- <h3 class="table-title">Venue Details</h3> -->

    <div class="table-wrapper">
       <div class="d-flex justify-content-between">
            <div>
                <h3> Name : <?php echo ucwords($name); ?> </h3>
                <p class='mt-5'> Address : <?php echo ucwords($address); ?> </p>
                <p> Rate : Ksh <?php echo $rate; ?> </p>
                <p> Description : <?php echo $description; ?> </p>
            </div>

            <div>
                <div style="width:200px;height:200px;">
                    <img style="object-fit: cover;width:100%;height:100%;border-radius:16px;" src='/assets/img/uploads/<?php echo $image?>' alt='Venue Image' />
                </div>
            </div>
       </div>

       <div class="mt-5">
           <h4>Booked Events</h4>

           <div class="table-list mt-3">

            <?php
            require_once "../scripts/db_conn.php";

            $venue_id = $_GET['id'];
            $sql = "SELECT events.* FROM events INNER JOIN venues ON events.venue_id=venues.id WHERE venue_id=$venue_id ORDER BY events.id DESC";
            $count = 1;
            
            if($result = $mysqli->query($sql)){
                if($result->num_rows > 0){
                    echo '<table class="table">';
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Schedule</th>";
                                echo "<th>Event Info</th>";
                                echo "<th>Description</th>";
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while($row = $result->fetch_array()){
                            echo "<tr>";
                                echo "<td>" . $count++ . "</td>";
                                echo "<td>" . date("M d, Y A",strtotime($row['schedule'])) . "</td>";
                                echo "<td>" . 
                                    "<p><b>Event Name: </b>" . $row['name'] . "</p>" .
                                    "<p><small><b>Event Type: </b>" . ($row['type'] == 1 ? 'Private' : 'Public') . "</small></p>" .
                                    "<p><small><b>Fee: </b> ". ($row['payment_type']  == 1 ? 'Free' : 'Ksh '.number_format($row['amount'],2)) ." </small></p>" .
                                "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";                            
                    echo "</table>";
                    // Free result set
                    $result->free();
                } else{
                    echo '<div class="alert alert-danger"><em>No events linked to this venue.</em><br><br><a href="/dash/index.php?page=manage_events" class="table-link"><span><i class="fas fa-plus"></i></span> Schedule an Event</a></div>';
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
</div>