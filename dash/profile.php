<?php
require_once "../scripts/db_conn.php";

// Define variables and initialize with empty values
$name = $email = $created_date = "";
$new_password = $new_password_err = $prev_password = $prev_password_err = $confirm_new_password = $confirm_new_password_err= "";
$main_err = $main_succ = "";

$id =  trim($_SESSION["id"]);
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

/**
 * Updating Password -----------------------------------------------------
 */
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'update' && $_POST['form'] == 'password'){
    // password validation
    if(empty(trim($_POST["prev_password"]))){
        $prev_password_err = "Please enter your previous password.";
    } else{
        // Checking if old password matches one provided
        if($stmt = $mysqli->prepare("SELECT password FROM users WHERE id != ?")){
            $stmt->bind_param("i", $param_id);
            
            $param_id = $_SESSION["id"];

            if($stmt->execute()){
                $stmt->store_result();
                if($stmt->num_rows == 1){                    
                    $stmt->bind_result($hashed_password);
                    if($stmt->fetch()){
                        if(password_verify(trim($_POST["prev_password"]), $hashed_password)){
                            // Password is correct
                            $prev_password = trim($_POST["prev_password"]);
                        } else{
                            $prev_password_err = "Invalid previous password.";
                        }
                    }
                } else{
                    $main_err = "Ooops! User details not found";
                }
            } else{
                $main_err = "Ooops! There are errors in form you just submitted";
            }
            $stmt->close();
        }
    }

    // password validation
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter a new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }

    // confirm password validation
    if(empty(trim($_POST["confirm_new_password"]))){
        $confirm_new_password_err = "Please confirm new password.";     
    } else{
        $confirm_new_password = trim($_POST["confirm_new_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_new_password)){
            $confirm_new_password_err = "Password did not match.";
        }
    }

    if(!empty($prev_password_err) || !empty($new_password_err) || !empty($confirm_new_password_err)){
        $main_err = "Ooops! There are errors in form you just submitted";
    }

    if(empty($prev_password_err) && empty($new_password_err) && empty($confirm_new_password_err)){
        if($stmt = $mysqli->prepare("UPDATE users SET password=? WHERE id=?")){
            $stmt->bind_param("si", $param_password, $param_id);

            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION['id'];
           
            if($stmt->execute()){
                $subject = 'Reset '. ucwords($full_name) . ' Password Successfully';

                $headers = "From: webmaster@quioccassions.com" . "\r\n" . "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $message = "<html>
                <body>
                <p> Hello, ". $name." </p>
                <p> Your password has been Successfully reset temporarily to <b>". $new_password. "</b>.</p>
                <p>Please login and head to your profile to reset.</p>
                </body>
                </html>";
            
                mail('shannellenjeru@gmail.com', $subject, $message, $headers);
                ?>
                <script type="text/javascript">
                    window.location = "/dash/index.php?page=profile";
                </script><?php
                $main_succ = "Profile details saved Successfully";
                exit();
            } else{
                $main_err = "Oops! Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    }
}

/**
 * Updating Profile -----------------------------------------------------
 */
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'update' && $_POST['form'] == 'profile'){
    // name validation
    if(empty(trim($_POST["name"]))) {
        $name_err = "Please enter a full name";
    }else if(!preg_match("/^[a-zA-Z-' ]*$/", trim($_POST['name']))) { // src: w3schools
        $name_err = "Only letters and white space allowed";
    } else {
        $name = $_POST["name"];
    }

    // email validation
    if(empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email";
    }else if (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) { // src: w3schools
        $email_err = "Please enter a valid email address";
    }else {
        // Checking if email exists
        if($stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ? AND id != ?")){
            $stmt->bind_param("si", $param_email, $param_id);
            $param_email = trim($_POST["email"]);
            $param_id = $_SESSION["id"];

            if($stmt->execute()){
                $stmt->store_result();
                if($stmt->num_rows == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    }

    if(!empty($name_err) || !empty($email_err)){
        $main_err = "Ooops! There are errors in form you just submitted";
    }

    if(empty($name_err) && empty($email_err)){

        if($stmt = $mysqli->prepare("UPDATE users SET full_name=?, email=? WHERE id=?")){
            $stmt->bind_param("ssi", $param_name, $param_email, $param_id);
            // parameters
            $param_name = $name;
            $param_email = $email;
            $param_id = $_SESSION['id'];

            if($stmt->execute()){
                $_SESSION["full_name"] = $name;
                ?>
                <script type="text/javascript">
                    window.location = "/dash/index.php?page=profile";
                </script><?php
                $main_succ = "Profile details saved Successfully";
                exit();
            } else{
                $main_err = "Oops! Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    }
}
?>

<div>
    <div class="table-wrapper">
        <div>
            <h3> Full Name : <?php echo ucwords($name); ?> </h3>
            <p class='mt-5'> Email : <?php echo $email; ?> </p>
            <p> Created : <?php echo date("M d, Y A",strtotime($row['created_at']));?> </p>
            <button type="button" id="btn_update_profile" class="btn btn-info">Update Profile</button>
            <button type="button" id="btn_update_pass" class="btn btn-warning">Update Password</button>
        </div>

       <div class="mt-5">
            <div id="password_form" class="mt-3" style="width: 50%;display:none;">
                <h4>Password</h4>

                <?php include 'succ_err_view.php' ?>
                <form action="<?php echo htmlspecialchars("/dash/index.php?page=profile"); ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label">Previous Password</label>
                        <input type="password" class="form-control <?php echo (!empty($prev_password_err)) ? 'is-invalid' : ''; ?>" 
                        value="<?php echo $prev_password; ?>" name="prev_password">
                        <span class="invalid-feedback"><?php echo $prev_password_err;?></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>" name="new_password">
                        <span class="invalid-feedback"><?php echo $new_password_err;?></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control <?php echo (!empty($confirm_new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_new_password; ?>" name="confirm_new_password">
                        <span class="invalid-feedback"><?php echo $confirm_new_password_err;?></span>
                    </div>

                    <input name="action" value="update" class="hidden">
                    <input name="form" value="password" class="hidden">
                    <div style="text-align: right;">
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>

            <div id="profile_form" class="mt-3" style="width: 50%;display:none;">
                <h4>Profile</h4>

                <?php include 'succ_err_view.php' ?>

                <form action="<?php echo htmlspecialchars("/dash/index.php?page=profile"); ?>" method="post">
                    <div class="mb-4">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input
                            style="padding: 10px"
                            type="text"
                            class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                            id="name"
                            name="name"
                            value="<?php echo $name; ?>"
                        />
                        <span class="invalid-feedback"><?php echo $name_err; ?></span>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input
                            style="padding: 10px"
                            type="email"
                            class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                            id="email"
                            name="email"
                            value="<?php echo $email; ?>"
                        />
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div>

                    <input name="action" value="update" class="hidden">
                    <input name="form" value="profile" class="hidden">
                    <div style="text-align: right;">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
       </div>
    </div>
</div>

<script>
let updateProfileBtn = document.getElementById('btn_update_profile');
let updatePassBtn = document.getElementById('btn_update_pass');
let passwordForm = document.getElementById("password_form");
let profileForm = document.getElementById("profile_form");

updateProfileBtn.addEventListener('click', e => {
    passwordForm.style.display = "none"; // hide password form;
    profileForm.style.display = "block"; // show profile block;
});

updatePassBtn.addEventListener('click', e => {
    passwordForm.style.display = "block"; // show password form;
    profileForm.style.display = "none"; // hide profile block;
});
</script>