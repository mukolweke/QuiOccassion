<?php
require_once "../scripts/db_conn.php";


// Define variables and initialize with empty values
$name = $email = $created_date = "";

if(isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id =  trim($_GET["id"]);
    $sql = "SELECT * FROM USERS WHERE id = ?";
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("i", $param_id);
        $param_id = $id;
        
        if($stmt->execute()){
            $result = $stmt->get_result();
            
            if($result->num_rows == 1){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
                $name = $row["full_name"];
                $email = $row["email"];
                $created_date = $row["created_at"];
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
        <div>
            <h3> Full Name : <?php echo ucwords($name); ?> </h3>
            <p class='mt-5'> Email : <?php echo $email; ?> </p>
            <p> Created :<?php echo date("M d, Y A",strtotime($row['created_at']));?> </p>
        </div>

       <div class="mt-5">
           <h4>User Requests</h4>

           <div class="table-list mt-3">


        </div>
       </div>
    </div>
</div>