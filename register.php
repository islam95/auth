<?php
// add the database connection script.
include_once 'resource/db.php';

if (isset($_POST['email'])){
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    //hashing the password
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
        if($statement->rowCount() == 1) {
            $result = "<p style='padding:20px; color: green;'> Registration Successful</p>";
        }

    } catch (PDOException $exception){
        $result = "<p style='padding:20px; color: red;'> An error occurred: ".$exception->getMessage()."</p>";
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
        <tr><td></td><td><input type="submit" value="Register"></td></tr>
    </table>
</form>
<p><a href="index.php">Back</a> </p>
</body>
</html>