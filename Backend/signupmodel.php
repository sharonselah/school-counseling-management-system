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
    $execute = $stmt-> execute(); 

        $id= $stmt-> insert_id; 

        $role = "student"; 
        $stmt2 = $conn-> prepare ("INSERT INTO users (name, email, password, role, user_id) VALUES (?, ?, ?, ?, ?)"); 
        $stmt2 ->bind_param('ssssi', $name, $email, $hash, $role, $id); 
        $stmt2-> execute(); 
    
    //check if the query executed

    if ($execute){

        header("Location: ../Login.php");
        exit(); 
    }else {
        echo "Error". $stmt-> error; 
    }

    $stmt-> close (); 
    $stmt2-> close(); 

}

$conn-> close(); 



