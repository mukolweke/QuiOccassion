<?php 
require_once "../scripts/db_conn.php";
 
// Define variables and initialize with empty values
$name = $address = $description = $rate = $image = "";
$name_err = $address_err = $description_err = $rate_err = $image_err = "";
$image_name = $tmp_img_name = "";
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

// Processing venue form data when submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'update'){
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

            $sql = "UPDATE venues SET name=?, address=?, description=?, rate=?, image=? WHERE id=?";

            if($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param("sssssi", $param_name, $param_address, $param_description, $param_rate, $param_image, $param_id);

                // parameters
                $param_name = $name;
                $param_address = $address;
                $param_description = $description;
                $param_rate = $rate;
                $param_image = $image_name;
                $param_id = $_GET['id'];
                
                if($stmt->execute()){
                    header("location: /dash/index.php?page=venues");
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

?>

<div>
    <h3 class="table-title">Venues</h3>

    <div class="table-wrapper">
        <div class="table-header">
            <p class="table-subtitle">Update Venue Record</p>
        </div>

        <p>Please edit the input values and submit to update the venue record.</p>

        <?php 
            if(!empty($main_err)) {
                echo '<div class="alert alert-danger"><em>' . $main_err .'</em></div>';
            }

            if(!empty($main_succ)) {
                echo '<div class="alert alert-success"><em>' . $main_succ .'</em></div>';
            }
        ?>

        <div class="edit_body">
            <form action="<?php echo htmlspecialchars("/dash/index.php?page=venues_update&id=" . $_GET['id']); ?>" method="post" enctype="multipart/form-data">

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
                    <textarea class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>" name="description" rows="3"><?php echo $description; ?>
                    </textarea>
                    <span class="invalid-feedback"><?php echo $description_err;?></span>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rate Per Hour</label>
                    <input type="number" min="0" class="form-control <?php echo (!empty($rate_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $rate; ?>" name="rate" aria-describedby="rateHelp">
                    <div id="rateHelp" class="form-text">Rate is in Ksh</div>
                    <span class="invalid-feedback"><?php echo $rate_err;?></span>
                </div>
                <div class="mb-5">
                    <label class="form-label">Venue Image</label>
                    <div class="d-flex flex-column mb-3">
                        <img class='table_img mb-1' src='/assets/img/uploads/<?php echo $image?>' alt='Venue Image' />
                        <small id="emailHelp" class="form-text text-muted">Please upload a new/same image upon edit</small>
                    </div>
                    <input type="file" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $image; ?>" name="venue_image" id="formFile">
                    <span class="invalid-feedback"><?php echo $image_err;?></span>
                </div>

                <input name="action" value="update" class="hidden">

                <div style="text-align: right;">
                    <button type="submit" class="btn btn-primary">Update Venue</button>
                </div>
            </form>
        </div>
    </div>
</div>