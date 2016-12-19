<?php
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

                // call sweet alert
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
