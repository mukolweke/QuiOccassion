<?php
require_once "../scripts/db_conn.php";

?>

<div>
    <h3 class="table-title">Requests</h3>

    <div class="table-wrapper">
        <div class="table-header">
            <p class="table-subtitle">List of My Requests</p>

            <div>
                <a href="/dash/index.php?page=my_requests_history" style="margin-right: 10px;" class="text-danger"> History</a>

                <a href="/dash/index.php?page=manage_my_requests" class="btn btn-primary"><span><i class="fas fa-plus"></i></span> Request for an Event</a>
            </div>
        </div>
        
        <?php include 'succ_err_view.php' ?>

        <div class="table-list">

            <?php
            $sql = "SELECT user_requests.*, users.full_name as user_name FROM user_requests INNER JOIN users ON user_requests.user_id=users.id AND user_requests.status=0 AND user_requests.user_id=".$_SESSION['id']." ORDER BY user_requests.id DESC";
            $count = 1;
            $date_now = date("d/m/Y");

            if($result = $mysqli->query($sql)){
                if($result->num_rows > 0){
                    echo '<table class="table">';
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Name</th>";
                                echo "<th>Description</th>";
                                echo "<th>Status</th>";
                                echo "<th>Scheduled</th>";
                                echo "<th>Created</th>";
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while($row = $result->fetch_array()){
                            echo "<tr>";
                                echo "<td>" . $count++ . "</td>";
                                echo "<td>" . $row['user_name'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                if($row['status'] == 1) { // status 1
                                    echo "<td><span class='badge rounded-pill bg-success'>Confirmed</span></td>";
                                }elseif ($row['status'] == 2) { // status 2
                                    echo "<td><span class='badge rounded-pill bg-danger'>Canceled</span></td>";
                                }else { // status 0
                                    echo "<td><span class='badge rounded-pill bg-info'>Verification</span></td>";
                                }
                                echo "<td>" . date("M d, Y A",strtotime($row['schedule_date'])) . "</td>";
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