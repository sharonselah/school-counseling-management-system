<?php

function processForm($table, $name, $email, $password, $role) {

include 'db.php'; 

//check if the user exists in the database
$check_result = "SELECT * FROM $table WHERE email= ?";
$stmt = $conn->prepare ($check_result);
$stmt-> bind_param('s', $email);

$stmt-> execute();

// checks if there is at least one row returned by the query using the fetch() method.

if ($stmt-> fetch()){
    session_start();
    $rolez = $_SESSION["role"];
    
    if ($rolez == 'admin') {
        header('Location: ../Admin/CounselorSignup.php?error=email_exists');
        exit();
    }else {
        header("Location: ../Signup.php?error=email_exists"); 
        exit(); 
    }
  
}

//hash the password
$hash = password_hash($password, PASSWORD_BCRYPT); 

//use prepared statements
$stmt = $conn-> prepare ("INSERT INTO $table (name, email, password) VALUES (?, ?, ?)"); 

//bind the ? parameters to prevent SQL injection
$stmt->bind_param('sss', $name, $email, $hash);
$execute = $stmt-> execute(); 

//returns the auto-generated ID that was inserted into a table from the previous insert stmt 
$id= $stmt-> insert_id; 

$stmt2 = $conn-> prepare ("INSERT INTO users (name, email, password, role, user_id) VALUES (?, ?, ?, ?, ?)"); 
$stmt2 ->bind_param('ssssi', $name, $email, $hash, $role, $id); 
$stmt2-> execute(); 

//check if the query executed
if ($execute){
    header("Location: ../Login.php");
    exit(); 
} else {
    echo "Error". $stmt-> error; 
}

$stmt-> close (); 
$stmt2-> close(); 
$conn-> close(); 
}
