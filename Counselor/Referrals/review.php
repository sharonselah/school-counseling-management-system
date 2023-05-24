<?php 


include '../Backend/db.php';

// Retrieve the student ID from the URL parameter
$student_id = $_GET['id'];
$id = $_SESSION['user_id']; 

// Compose the notification message
$message = "You have received a new review from your counselor.
 It aims to find out how you are getting on with the therapy sessions so far.
& how you would like future sessions to pan out.";

// Insert the notification for the student
$query = "INSERT INTO notifications (recipient_id, sender_id,notification_type, message) 
          VALUES (?, 'review', ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $student_id,$id, $message);
$stmt->execute();

// Redirect back to the counselor dashboard or any other desired page
header("Location: ../Counselor/counselordashboard.php");
exit();
?>



