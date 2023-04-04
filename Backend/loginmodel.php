<?php

include 'db.php'; 

session_start(); 


if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $email = $_POST["email"];
    $password = $_POST["password"];


    $stmt = $conn-> prepare ("SELECT name, password FROM students where email = ?");
    $stmt-> bind_param ('s', $email); 
    $stmt-> execute();
    //retrieve the result from the query 
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        //fetch a single row from the result set
        $row = $result->fetch_assoc();
        $hash = $row['password'];
        $name = $row['name'];
      }

      //check if the given password matches the hashed password

      if (password_verify($password, $hash)) {
        // login successful
        $_SESSION["authenticated"] =TRUE; 
        $_SESSION["name"] = $name; 

        header("Location:../studentdashboard.php");
        exit(); 
      } else {
        // login failed
        $_SESSION["error_message"] = "Wrong password or username"; 
        header("Location:../Login.php"); 
        exit();
      }



    $stmt-> close(); 
}

$conn->close(); 