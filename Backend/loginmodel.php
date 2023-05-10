<?php

include 'db.php'; 

session_start(); 


if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $email = $_POST["email"];
    $password = $_POST["password"];


    $stmt = $conn-> prepare ("SELECT * FROM users Where email = ?");
    $stmt-> bind_param ('s', $email); 
    $stmt-> execute();
 
    //retrieve the result from the query 
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        //fetch a single row from the result set
        $row = $result->fetch_assoc();
        $hash = $row['password'];
        $name = $row['name'];
        $email = $row['email']; 
        $id = $row['user_id']; 
        $role = $row['role']; 

        //check if the given password matches the hashed password

      if (password_verify($password, $hash)) {
        // login successful
        $_SESSION["authenticated"] =TRUE; 
        $_SESSION["name"] = $name; 
        $_SESSION["email"] = $email; 
        $_SESSION["user_id"]= $id; 
        $_SESSION["role"]= $role; 


        // Redirect to the appropriate dashboard
    switch ($role) {
      case 'student':
          header("Location: ../Student/studentdashboard.php");
          exit(); 
          break;
      case 'counselor':
          header("Location: ../counselordashboard.php");
          exit(); 
          break;
      case 'admin':
          header("Location: ../admindashboard.php");
          exit(); 
          break;
      default:
          die("Invalid user role");
  }
      
      } else {
        // login failed
        $_SESSION["error_message"] = "Wrong password or username"; 
        header("Location:../Login.php"); 
        exit();
      }
 
      } 

    $stmt-> close(); 
}

$conn->close(); 