<div>
    <h3 class="table-title">Users</h3>

    <div class="table-wrapper">
        <div class="table-header">
            <p class="table-subtitle">List of Users</p>
        </div>

        <div class="table-list">

            <?php
            require_once "../scripts/db_conn.php";

            $sql = "SELECT * FROM users ORDER BY id DESC";
            $count = 1;
            
            if($result = $mysqli->query($sql)){
                if($result->num_rows > 0){
                    echo '<table class="table">';
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Full Name</th>";
                                echo "<th>Email</th>";
                                echo "<th>Created</th>";
                                echo "<th>Action</th>";
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while($row = $result->fetch_array()){
                            echo "<tr>";
                                echo "<td>" . $count++ . "</td>";
                                echo "<td>" . $row['full_name'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . date("M d, Y A",strtotime($row['created_at'])) . "</td>";

                                echo "<td style=''>";
                                    if($row['id'] != $_SESSION['id']) {
                                        echo '<div class="btn-group" role="group">';
                                            echo '<a href="/dash/index.php?page=user&id='. $row['id'] .'" class="btn btn-transparent"><i class="fas fa-eye"></i></a>';
                                        echo '</div>';
                                    }else {
                                        echo '';
                                    }
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