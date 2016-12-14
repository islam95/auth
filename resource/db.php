<?php
// initialize variables to hold connection parameters.
$dsn = 'mysql:host=localhost; dbname=register';
$user = 'root';
$password = '';

try {
    // create an instance of the PDO class with the required parameters.
    $db = new PDO($dsn, $user, $password);
    // set PDO error mode to exception.
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // display success message.
    //echo "Connected to the database.";
} catch (PDOException $exception){
    // display error message.
    echo "Database connection failed: ".$exception->getMessage();
}