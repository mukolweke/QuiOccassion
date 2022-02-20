<?php 
require_once "../scripts/db_conn.php";

$icon = $icon_err = $name = $name_err = $value = $value_err = "";
$setting_type = null;
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

    // Validate value
    $input_value = trim($_POST["value"]);
    if(empty($input_value)){
        $value_err = "Please enter an value.";     
    } else{
        $value = $input_value;
    }

    // Validate icon
    $input_icon = $_POST["icon"];
    if(empty($input_icon)){
        $icon_err = "Please enter an icon.";     
    } else{
        $icon = $input_icon;
    }

    $setting_type = isset($_POST['setting_type']) ? $_POST['setting_type'] : 0;

    if(!empty($name_err) || !empty($value_err) || !empty($icon_err)) {
        $main_err = "Ooops! There are errors in form you just submitted";
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($value_err) && empty($icon_err)){
        $sql = "INSERT INTO settings (name, value, setting_type, icon) VALUES (?, ?, ?, ?)";

        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("ssss", $param_name, $param_value, $param_setting_type, $param_icon);

            // parameters
            $param_name = $name;
            $param_value = $value;
            $param_setting_type = $setting_type;
            $param_icon = $icon;
            
            if($stmt->execute()){
                ?><script type="text/javascript">
                window.location = "/dash/index.php?page=system_settings";
                </script><?php
                $main_succ = "Setting details saved Successfully";
                exit();
            } else{
                $main_err = "Oops! Something went wrong. Please try again later.";
            }
        }
        // // Close statement
        // $stmt->close();
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'delete'){
    $id = $_POST['setting_id'];

    if($delete = $mysqli->query("DELETE FROM settings where id = " . $id)){
        $main_succ = "Setting record deleted successfully";
    }else {
        $main_err = "Ooops! Deletion process was not successful";
    }
}
?>

<div class="d-flex justify-content-between">
    <h1>System Settings</h1>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSettingModal"><span><i class="fas fa-plus"></i></span> Setting</button>
</div>

<!--Modal -->
<div class="modal fade" id="createSettingModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New Setting</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <form action="<?php echo htmlspecialchars("/dash/index.php?page=system_settings"); ?>" method="post">

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" 
                    value="<?php echo $name; ?>" name="name">
                    <span class="invalid-feedback"><?php echo $name_err;?></span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Value</label>
                    <input type="text" class="form-control <?php echo (!empty($value_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $value; ?>" name="value">
                    <span class="invalid-feedback"><?php echo $value_err;?></span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Icon</label>
                    <input type="text" class="form-control <?php echo (!empty($icon_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $icon; ?>" placeholder="fas fa-phone" name="icon">
                    <small id="emailHelp" class="form-text text-muted">Please use classes from <a class="table-link" href="https://fontawesome.com/">Font Awesome Icons</a></small>
                    <span class="invalid-feedback"><?php echo $icon_err;?></span>
                </div>

                <div class="form-group mb-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="1" id="setting_type" name="setting_type" <?php echo isset($setting_type) && $setting_type == 1 ? "checked" : "" ?>>
                        <label class="form-check-label" for="type">
                        Contact Setting
                        </label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="2" id="setting_type" name="setting_type" <?php echo isset($setting_type) && $setting_type == 2 ? "checked" : "" ?>>
                            <label class="form-check-label" for="type">
                            Social Setting
                            </label>
                    </div>
                </div>
                
                <input name="action" value="save" class="hidden">
                <div style="text-align: right;">
                    <button type="button" class="btn btn-light bg-transparent" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Setting</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>

<?php include 'succ_err_view.php' ?>

<div class="table-wrapper">
    <div class="">
        <h4 class="table-subtitle">Contacts</h4>

        <div class="table-list">

            <?php
            $sql = "SELECT * FROM settings WHERE setting_type=1";
            $count = 1;
            
            if($result = $mysqli->query($sql)){
                if($result->num_rows > 0){
                    echo '<table class="table">';
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Name</th>";
                                echo "<th>Value</th>";
                                echo "<th>Icon</th>";
                                echo "<th>Action</th>";
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while($row = $result->fetch_array()){
                            echo "<tr>";
                                echo "<td>" . $count++ . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['value'] . "</td>";
                                echo "<td>" . $row['icon'] . "</td>";
                                echo "<td style=''>";
                                    echo '<div class="btn-group" role="group">';
                                        echo '<form method="post" action="/dash/index.php?page=system_settings">
                                        <input name="setting_id" value=' . $row['id']. ' class="hidden">
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
          
            ?>

        </div>
    </div>

    <div class="mt-5">
        <h4 class="table-subtitle">Socials</h4>

        <div class="table-list">

            <?php
            $sql = "SELECT * FROM settings WHERE setting_type=2";
            $count = 1;
            
            if($result = $mysqli->query($sql)){
                if($result->num_rows > 0){
                    echo '<table class="table">';
                        echo "<thead>";
                            echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Name</th>";
                                echo "<th>Value</th>";
                                echo "<th>Icon</th>";
                                echo "<th>Action</th>";
                            echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while($row = $result->fetch_array()){
                            echo "<tr>";
                                echo "<td>" . $count++ . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['value'] . "</td>";
                                echo "<td>" . $row['icon'] . "</td>";
                                echo "<td style=''>";
                                    echo '<div class="btn-group" role="group">';
                                        echo '<form method="post" action="/dash/index.php?page=system_settings">
                                        <input name="setting_id" value=' . $row['id']. ' class="hidden">
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

            ?>

        </div>
    </div>
</div>

<?php 
    // Close connection
    $mysqli->close();
?>