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
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<h2>User Authentication System </h2><hr>
<h3>Login Form</h3>
<?php if(isset($result)) echo $result; ?>
<?php if(!empty($form_errors)) echo showErrors($form_errors); ?>
<form method="post" action="">
    <table>
        <tr><td>Username:</td> <td><input type="text" name="username" value=""></td></tr>
        <tr><td>Password:</td> <td><input type="password" name="password" value=""></td></tr>
        <tr><td><a href="forgot_password.php">Forgot Password?</a></td><td><input type="submit" name="btn_login" value="Login"></td></tr>
    </table>
</form>
<p><a href="index.php">Back</a> </p>
</body>
</html>