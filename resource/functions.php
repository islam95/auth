<?php
/**
 * @param $required_fields, an array containing the list of all required fields
 * @return array, containing all errors
 */
function isEmptyFields($required_fields){
    //initialize an array to store error messages
    $form_errors = array();
    //loop through the required fields array and populate the form error array
    foreach($required_fields as $field){
        if(!isset($_POST[$field]) || $_POST[$field] == NULL){
            $form_errors[] = $field . " is a required field.";
        }
    }
    return $form_errors;
}
/**
 * @param $fields, an array containing the name of fields
 * for which we want to check min required length e.g. array('username' => 2, 'email' => 5)
 * @return array, containing all errors
 */
function isMinLength($fields){
    //initialize an array to store error messages
    $form_errors = array();
    foreach($fields as $field => $min_length){
        if(strlen(trim($_POST[$field])) < $min_length){
            $form_errors[] = $field . " is too short, must be {$min_length} characters long";
        }
    }
    return $form_errors;
}
/**
 * @param $data, store a key/value pair array where key is the name of the form control
 * in this case 'email' and value is the input entered by the user
 * @return array, containing email error
 */
function isEmail($data){
    //initialize an array to store error messages
    $form_errors = array();
    $key = 'email';
    //check if the key email exist in data array
    if(array_key_exists($key, $data)){
        //check if the email field has a value
        if($_POST[$key] != null){
            // Remove all illegal characters from email
            $key = filter_var($key, FILTER_SANITIZE_EMAIL);
            //check if input is a valid email address
            if(filter_var($_POST[$key], FILTER_VALIDATE_EMAIL) === false){
                $form_errors[] = $key . " is not a valid email address";
            }
        }
    }
    return $form_errors;
}
/**
 * @param $form_errors, the array holding all
 * errors which we want to loop through
 * @return string, list containing all error messages
 */
function showErrors($form_errors){
    $errors = "<p><ul style='color: red;'>";
    //loop through error array and display all items in a list
    foreach($form_errors as $the_error){
        $errors .= "<li> {$the_error} </li>";
    }
    $errors .= "</ul></p>";
    return $errors;
}

function display_message($message, $label = "error"){
    if ($label === "success"){
        $data = "<p style='padding:20px; border: 1px solid gray; color: green;'>{$message}</p>";
    } else{
        $data = "<p style='padding:20px; border: 1px solid gray; color: red;'>{$message}</p>";
    }
    return $data;
}

function redirect($page){
    header("Location: {$page}.php");
}

function isDuplicate($table, $column, $value, $db){
    try {
        $sql = "SELECT * FROM ".$table." WHERE ".$column." = :$column";
        $statement = $db->prepare($sql);
        $statement->execute(array(":$column" => $value));
        if ($row = $statement->fetch()){
            return true;
        }
        return false;
    } catch (PDOException $ex){
        //echo "An error function occurred: ".$ex->getMessage();
    }
}