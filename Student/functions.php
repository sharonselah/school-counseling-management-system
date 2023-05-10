<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION["role"] !== 'student') {
  // User is not authenticated or is not a counselor, redirect to login page
  header('Location: ../Login.php');
  exit();
}

if (isset($_SESSION["error_message"])){
  $error_message = $_SESSION["error_message"];
  //clear error message from the session

  unset($_SESSION["error_message"]);
}


$id= $_SESSION["user_id"]; 


include '../Backend/db.php';



// look for the most recent upcoming appointment
$stmt2 = $conn->prepare("SELECT * FROM appointments 
WHERE student_id = ? 
AND CONCAT(date, ' ', start_time) > NOW() 
ORDER BY created_at DESC 
LIMIT 1");

$stmt2->bind_param('s', $id);
$stmt2->execute();
$result2 = $stmt2->get_result();

if ($result2->num_rows == 1) {
    // Fetch a single row from the result set
    $row = $result2->fetch_assoc();
    $start_time = date_format(date_create($row['start_time']), 'H:i');
    $date = date_format(date_create($row['date']), 'l j M');
    $appointment_details = $start_time . ' on ' . $date;
    $appointment_id = $row["id"]; 
    $counselor_id = $row["counselor_id"]; 
    $status = $row["status"]; 
    

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
        
       }
 
} else {
    $appointment_details = 'No appointments found.';
}

//goals 

$stmt3= $conn->prepare("SELECT *, COUNT(*) as count FROM goals WHERE student_id =?"); 
$stmt3->bind_param("i", $id); 
$stmt3->execute(); 
$result3= $stmt3->get_result(); 
$noOfGoals = $result3-> fetch_assoc(); 
$totalGoals = $noOfGoals["count"]; 

?>