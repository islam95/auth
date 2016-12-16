<?php
// add the database connection script.
include_once 'resource/db.php';
include_once 'resource/functions.php';
// process the form.
if (isset($_POST['btn_register'])){
    //initialize an array to store any error message from the form
    $form_errors = array();
    //Form validation
    $required_fields = array('email', 'username', 'password');
    //call the function to check empty field and merge the return data into form_error array
    $form_errors = array_merge($form_errors, isEmptyFields($required_fields));
    //Fields that requires checking for minimum length
    $fields_min_length = array('username' => 2, 'password' => 3);
    //call the function to check minimum required length and merge the return data into form_error array
    $form_errors = array_merge($form_errors, isMinLength($fields_min_length));
    //email validation / merge the return data into form_error array
    $form_errors = array_merge($form_errors, isEmail($_POST));
    // collect form data and store in variables.
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    if(isDuplicate("users", "username", $username, $db)){
        $result = display_message("Username is already taken. Please, try another one.");
    } elseif(isDuplicate("users", "email", $email, $db)){
        $result = display_message("Email is already taken. Please, try another one.");
    }
    //check if error array is empty, if yes process form data and insert record
    elseif(empty($form_errors)) {
        // hashing the password.
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        try {
            // create SQL insert statement.
            $sql = "INSERT INTO users (username, email, password, join_date) VALUES (:username, :email, :password, now())";
            // use PDO prepared to sanitize data.
            $statement = $db->prepare($sql);
            // add the data into the database.
            $statement->execute(array(':username' => $username, ':email' => $email, ':password' => $hashed_password));
            // check if one new row was created.
            if ($statement->rowCount() == 1) {
                $result = display_message("Registration Successful!", "success");
            }
        } catch (PDOException $exception) {
            $result = display_message("An error occurred: ".$exception->getMessage());
        }
    } else {
        if(count($form_errors) == 1){
            $result = display_message("There was 1 error in the form:<br>");
        }else{
            $result = display_message("There were ".count($form_errors)." errors in the form:<br>");
        }
    }
}
?>
<?php
$page_title = "Register page";
include_once 'includes/header.php';
?>
    <div class="container">
    <section class="col col-lg-5">
        <h3>Register Form</h3><hr>
        <?php if(isset($result)) echo $result; ?>
        <?php if(!empty($form_errors)) echo showErrors($form_errors); ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="email"></label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="username"></label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="password"></label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <button type="submit" name="btn_register" class="btn btn-primary">Register</button>
        </form>
    </section>
    <p><a href="index.php">Back</a> </p>
    </div>

<?php include_once 'includes/footer.php'; ?>