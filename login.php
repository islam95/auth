<?php
include_once 'resource/session.php';
include_once 'resource/db.php';
include_once 'resource/functions.php';
if (isset($_POST['btn_login'])) {
    //an array to store any errors
    $form_errors = array();
    //validation
    $required_fields = array('username', 'password');
    $form_errors = array_merge($form_errors, isEmptyFields($required_fields));
    if(empty($form_errors)) {
        //collect form data
        $user = $_POST['username'];
        $password = $_POST['password'];
        //check if user exists in the database
        $sql = "SELECT * FROM users WHERE username = :username";
        $statement = $db->prepare($sql);
        $statement->execute(array(':username' => $user));
        while($row = $statement->fetch()){
            $id = $row['id'];
            $hashed_password = $row['password'];
            $username = $row['username'];
            // PHP function for verifying the password
            if(password_verify($password, $hashed_password)){
                $_SESSION['id'] = $id;
                $_SESSION['username'] = $username;
                redirect("index");
            }else{
                $result = display_message("Invalid username or password.");
            }
        }
    } else {
        if(count($form_errors) == 1){
            $result = display_message("There was 1 error:");
        }else{
            $result = display_message("There were ".count($form_errors)." errors:");
        }
    }
}
?>

<?php
$page_title = "Login page";
include_once 'includes/header.php';
?>

<div class="container">
    <section class="col col-lg-5">
        <h3>Login Form</h3><hr>
        <div>
        <?php if(isset($result)) echo $result; ?>
        <?php if(!empty($form_errors)) echo showErrors($form_errors); ?>
        </div>
        <div class="clearfix"></div>
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="*************">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
            </div>
            <a href="forgot_password.php" class="pull-right">Forgot password?</a>
            <button type="submit" name="btn_login" class="btn btn-primary">Login</button>
        </form>
    </section>
    <p><a href="index.php">Back</a> </p>
</div>

<?php include_once 'includes/footer.php'; ?>