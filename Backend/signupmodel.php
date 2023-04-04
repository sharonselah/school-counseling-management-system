<?php 


include 'db.php'; 


/*process the form 

use the superglobal variable $_SERVER that holds the request method
used to access the page

*/

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $name = $_POST["name"]; 
    $email = $_POST["email"]; 
    $password = $_POST["password"]; 

    //check if the user exists in the database
    $check_result = "SELECT * FROM students WHERE email= ?";
    $stmt = $conn->prepare ($check_result);
    $stmt-> bind_param('s', $email);



    $stmt-> execute();

    if ($stmt-> fetch()){
        header("Location: ../Signup.php?error=email_exists"); 
        exit(); 
    }

    //hash the password
    $hash = password_hash($password, PASSWORD_BCRYPT); 

    //use prepared statements
    $stmt = $conn-> prepare ("INSERT INTO students (name, email, password) VALUES (?, ?, ?)"); 

    //bind the ? parameters to prevent SQL injection
    $stmt->bind_param('sss', $name, $email, $hash);
    
    //check if the query executed

    if ($stmt -> execute()){
        header("Location: ../studentdashboard.php");
        exit(); 
    }else {
        echo "Error". $stmt-> error; 
    }

    $stmt-> close (); 



}

$conn-> close(); 



