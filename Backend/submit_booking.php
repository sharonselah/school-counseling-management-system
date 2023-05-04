<?php 

session_start();  

include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $date = $_POST["date"]; 
    $startTime = $_POST["select"]; 
    $endTime = date('H:i:s', strtotime('+1 hour', strtotime($startTime)));
    
    

    $counselor_id = rand(2,7); 

    //Get the name of the counselor 

    $stmt1 = $conn-> prepare("SELECT name FROM counselors where counselor_id = ?"); 
    $stmt1-> bind_param('s', $counselor_id); 
    $stmt1-> execute(); 

    //retrieve the result from the query 
    $result1 = $stmt1->get_result();

    if ($result1->num_rows == 1) {

        //fetch a single row from the result set
        $row = $result1->fetch_assoc();
        $cName = $row['name'];
        $_SESSION['cName']= $cName; 
      }

    
    $status ="pending"; 

    //look for the student-id 

    $name = $_SESSION["name"]; 

    $stmt = $conn-> prepare ("SELECT student_id FROM students where name = ?");
    $stmt-> bind_param ('s', $name); 
    $stmt-> execute();
    //retrieve the result from the query 
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        //fetch a single row from the result set
        $row = $result->fetch_assoc();
        $id = $row['student_id'];
        
      }

    //use prepared statements
    $stmt = $conn-> prepare ("INSERT INTO appointments (student_id, counselor_id, date, start_time, end_time, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?)"); 

    //bind the ? parameters to prevent SQL injection
    $stmt->bind_param('iisssss', $id, $counselor_id, $date, $startTime, $endTime, $status, $notes);
    $execute = $stmt-> execute(); 
    $appointment_id = $stmt->insert_id;

    $_SESSION['appointment_id']= $appointment_id; 
    
    //check if the query executed

    if ($execute){
        header("Location: ../studentdashboard.php");
        exit(); 
    }else {
        echo "Error". $stmt-> error; 
    }

    $stmt1->close(); 
    $stmt-> close (); 

}

$conn-> close(); 



