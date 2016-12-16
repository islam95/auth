<?php
//add the database connection
include_once 'resource/db.php';
include_once 'resource/functions.php';
//process the form if the reset password button is clicked
if(isset($_POST['btn_password_reset'])){
    //initialize an array to store any error message from the form
    $form_errors = array();
    //Form validation
    $required_fields = array('email', 'new_password', 'confirm_password');
    //call the function to check empty field and merge the return data into form_error array
    $form_errors = array_merge($form_errors, isEmptyFields($required_fields));
    //Fields that requires checking for minimum length
    $fields_min_length = array('new_password' => 3, 'confirm_password' => 3);
    //call the function to check minimum required length and merge the return data into form_error array
    $form_errors = array_merge($form_errors, isMinLength($fields_min_length));
    //email validation / merge the return data into form_error array
    $form_errors = array_merge($form_errors, isEmail($_POST));
    //check if error array is empty, if yes process form data and insert record
    if(empty($form_errors)){
        //collect form data and store in variables
        $email = $_POST['email'];
        $password1 = $_POST['new_password'];
        $password2 = $_POST['confirm_password'];
        //check if new password and confirm password is same
        if($password1 != $password2){
            $result = display_message("New password and confirm password does not match.");
        }else{
            try{
                //create SQL select statement to verify if email address input exist in the database
                $sql = "SELECT email FROM users WHERE email = :email";
                //use PDO prepared to sanitize data
                $statement = $db->prepare($sql);
                //execute the query
                $statement->execute(array(':email' => $email));
                //check if record exist
                if($statement->rowCount() == 1){
                    //hash the password
                    $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
                    //SQL statement to update password
                    $sqlUpdate = "UPDATE users SET password = :password WHERE email = :email";
                    //use PDO prepared to sanitize SQL statement
                    $statement = $db->prepare($sqlUpdate);
                    //execute the statement
                    $statement->execute(array(':password' => $hashed_password, ':email' => $email));
                    $result = display_message("Password Reset Successful!", "success");
                }
                else{
                    $result = display_message("The email address provided does not exist in our database, please try again.");
                }
            }catch (PDOException $ex){
                $result = display_message("An error occurred: ".$ex->getMessage());
            }
        }
    }
    else{
        if(count($form_errors) == 1){
            $result = display_message("There was 1 error in the form: <br>");
        }else{
            $result = display_message("There were ".count($form_errors)." errors in the form: <br>");
        }
    }
}
?>

<?php
$page_title = "Password reset page";
include_once 'includes/header.php';
?>
    <div class="container">
        <section class="col col-lg-5">
            <h3>Reset Password</h3><hr>
            <?php if(isset($result)) echo $result; ?>
            <?php if(!empty($form_errors)) echo showErrors($form_errors); ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="email"></label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="new_password"></label>
                    <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New password">
                </div>
                <div class="form-group">
                    <label for="confirm_password"></label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
                </div>
                <button type="submit" name="btn_password_reset" class="btn btn-primary">Reset Password</button>
            </form>
        </section>
        <p><a href="index.php">Back</a> </p>
    </div>

<?php include_once 'includes/footer.php'; ?>