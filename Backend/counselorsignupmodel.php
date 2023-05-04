<?php 


include 'db.php'; 


/*process the form 

use the superglobal variable $_SERVER that holds the request method
used to access the page

*/

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $name = $_POST["name"]; 
    $spec = $_POST["spec"]; 
    $email = $_POST["email"]; 
    $password = $_POST["password"]; 

    //check if the user exists in the database
    $check_result = "SELECT * FROM counselors WHERE email= ?";
    $stmt = $conn->prepare ($check_result);
    $stmt-> bind_param('s', $email);



    $stmt-> execute();

    if ($stmt-> fetch()){
        header("Location: ../CounselorSignup.php?error=email_exists"); 
        exit(); 
    }

    //hash the password
    $hash = password_hash($password, PASSWORD_BCRYPT); 

    //use prepared statements
    $stmt = $conn-> prepare ("INSERT INTO counselors (name, specialty, email, password) VALUES (?, ?, ?,?)"); 

    //bind the ? parameters to prevent SQL injection
    $stmt->bind_param('ssss', $name, $spec, $email, $hash);
    $execute = $stmt-> execute(); 
    

        $id= $stmt-> insert_id; 

        $role = "counselor"; 
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
    $stmt2->close(); 



}

$conn-> close(); 



