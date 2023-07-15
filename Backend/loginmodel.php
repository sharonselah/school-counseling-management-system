<?php

include 'db.php'; 

session_start(); 


if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); //remove illegal characters in email
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
          header("Location: ../Counselor/counselordashboard.php");
          exit(); 
          break;
      case 'admin':
          header("Location: ../Admin/admindashboard.php");
          exit(); 
          break;
      default:
          // login failed
        header("Location:../Login.php?login=error"); 
        exit();
      } // role redirecting
      
      }// if password matches
      else {
        header("Location:../Login.php?login=error"); 
        exit();
      }
     }// if email matches
      
      else {
    
        // login failed
        header("Location:../Login.php?login=error"); 
        exit();
      }
      $stmt-> close(); 
      } // if submitted

    


$conn->close(); 