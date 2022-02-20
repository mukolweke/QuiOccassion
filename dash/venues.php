<?php 
require_once "../scripts/db_conn.php";
 
// Define variables and initialize with empty values
$name = $address = $description = $rate = $image = "";
$name_err = $address_err = $description_err = $rate_err = $image_err = "";
$image_name = $tmp_img_name = "";
$main_err = $main_succ = "";

// Processing venue form data when submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'save'){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }

    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }

    // Validate description
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Please enter an description.";     
    } else{
        $description = $input_description;
    }

    // Validate rate
    $input_rate = trim($_POST["rate"]);
    if(empty($input_rate)){
        $rate_err = "Please enter the rate amount.";     
    } elseif(!ctype_digit($input_rate)){
        $rate_err = "Please enter a positive integer value.";
    } else{
        $rate = $input_rate;
    }
    
    // Validate image
    if(empty($_FILES['venue_image']['name'])){
        $image_err = "Please upload the venue image.";     
    } else{
        list($txt, $ext) = explode(".", $_FILES['venue_image']['name']);
        $image_name = time().".".$ext;
        $tmp_img_name = $_FILES['venue_image']['tmp_name'];
    }

    if(!empty($name_err) || !empty($address_err) || !empty($description_err) || !empty($rate_err) || !empty($image_err)) {
        $main_err = "Ooops! There are errors in form you just submitted";
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($description_err) && empty($rate_err) && empty($image_err)){
        if(move_uploaded_file($tmp_img_name, '../assets/img/uploads/'.$image_name)){

            $sql = "INSERT INTO venues (name, address, description, rate, image) VALUES (?, ?, ?, ?, ?)";

            if($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param("sssss", $param_name, $param_address, $param_description, $param_rate, $param_image);

                // parameters
                $param_name = $name;
                $param_address = $address;
                $param_description = $description;
                $param_rate = $rate;
                $param_image = $image_name;
                
                if($stmt->execute()){
                    ?><script type="text/javascript">
                    window.location = "/dash/index.php?page=venues";
                    </script><?php
                    $main_succ = "Venue details saved Successfully";
                    exit();
                } else{
                    $main_err = "Oops! Something went wrong. Please try again later.";
                }
            }
        }else{
            $main_err = "Oops! Something went wrong. Please try again later.";
        }
     
        // Close statement
        $stmt->close();
        
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'delete'){
    $id = $_POST['venue_id'];

    if($delete = $mysqli->query("DELETE FROM venues where id = " . $id)){
        $main_succ = "Venue record deleted successfully";
    }else {
        $main_err = "Ooops! Deletion process was not successful";
    }
}
?>

<div>
    <h3 class="table-title">Venues</h3>

    <div class="table-wrapper">
        <div class="table-header">
            <p class="table-subtitle">List of Venues</p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><span><i class="fas fa-plus"></i></span> Venue</button>
        </div>

        <?php include 'succ_err_view.php' ?>

        <div class="table-list">

            <?php
            require_once "../scripts/db_conn.php";

            $sql = "SELECT * FROM venues";
            $count = 1;
            
            if($result = $mysqli->query($sql)){
                if($result->num_rows > 0){
                    echo '<table class="table">';
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Image</th>";
                                echo "<th>Name</th>";
                                echo "<th>Address</th>";
                                echo "<th>Description</th>";
                                echo "<th>Rate</th>";
                                echo "<th>Action</th>";
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while($row = $result->fetch_array()){
                            echo "<tr>";
                                echo "<td>" . $count++ . "</td>";
                                echo "<td><img class='table_img' src='/assets/img/uploads/". $row['image'] ."' alt='Venue Image' /></td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['address'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "<td> Ksh " . $row['rate'] . "</td>";
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

        <!--Modal -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Venue</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="<?php echo htmlspecialchars("/dash/index.php?page=venues"); ?>" method="post" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" 
                            value="<?php echo $name; ?>" name="name">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>" name="address">
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>" name="description" rows="3"><?php echo $description; ?></textarea>
                            <span class="invalid-feedback"><?php echo $description_err;?></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rate Per Hour</label>
                            <input type="number" min="0" class="form-control <?php echo (!empty($rate_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $rate ?? 0; ?>" name="rate" aria-describedby="rateHelp">
                            <div id="rateHelp" class="form-text">Rate is in Ksh</div>
                            <span class="invalid-feedback"><?php echo $rate_err;?></span>
                        </div>
                        <div class="mb-5">
                            <label class="form-label">Venue Image</label>
                            <input type="file" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $image; ?>" name="venue_image" id="formFile">
                            <span class="invalid-feedback"><?php echo $image_err;?></span>
                        </div>
                        <input name="action" value="save" class="hidden">
                        <div style="text-align: right;">
                            <button type="button" class="btn btn-light bg-transparent" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create Venue</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>