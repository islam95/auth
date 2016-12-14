<?php
// add the database connection script.
include_once 'resource/db.php';

// process the form.
if (isset($_POST['btn_register'])){
    //initialize an array to store any error message from the form
    $form_errors = array();

    //Form validation
    $required_fields = array('email', 'username', 'password');

    //loop through the required fields array and popular the form error array
    foreach($required_fields as $field){
        if(!isset($_POST[$field]) || $_POST[$field] == NULL){
            $form_errors[] = $field." is a required field.";
        }
    }

    //check if error array is empty, if yes process form data and insert record
    if(empty($form_errors)) {
        // collect form data and store in variables.
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        // hashing the password.
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            // create SQL insert statement.
            $sql = "INSERT INTO users (username, email, password, join_date)
              VALUES (:username, :email, :password, now())";

            // use PDO prepared to sanitize data.
            $statement = $db->prepare($sql);

            // add the data into the database.
            $statement->execute(array(':username' => $username, ':email' => $email, ':password' => $hashed_password));

            // check if one new row was created.
            if ($statement->rowCount() == 1) {
                $result = "<p style='padding:20px; color: green;'> Registration Successful</p>";
            }

        } catch (PDOException $exception) {
            $result = "<p style='padding:20px; color: red;'> An error occurred: " . $exception->getMessage() . "</p>";
        }

    } else {
        if(count($form_errors) == 1){
            $result = "<p style='color: red;'> There was 1 error in the form:<br>";

            $result .= "<ul style='color: red;'>";
            //loop through error array and display all items
            foreach($form_errors as $error){
                $result .= "<li> {$error} </li>";
            }
            $result .= "</ul></p>";

        }else{
            $result = "<p style='color: red;'> There were " .count($form_errors). " errors in the form: <br>";

            $result .= "<ul style='color: red;'>";
            //loop through error array and display all items
            foreach($form_errors as $error){
                $result .= "<li> {$error}</li>";
            }
            $result .= "</ul></p>";
        }
    }

}

?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
<h2>User Authentication System </h2><hr>

<h3>Registration Form</h3>

<?php if (isset($result)) echo $result; ?>

<form method="post" action="">
    <table>
        <tr><td>Email:</td> <td><input type="text" name="email" value=""></td></tr>
        <tr><td>Username:</td> <td><input type="text" name="username" value=""></td></tr>
        <tr><td>Password:</td> <td><input type="password" name="password" value=""></td></tr>
        <tr><td></td><td><input type="submit" name="btn_register" value="Register"></td></tr>
    </table>
</form>
<p><a href="index.php">Back</a> </p>
</body>
</html>