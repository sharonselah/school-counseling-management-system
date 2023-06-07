<?php

include '../Backend/db.php'; 

session_start();
$name = $_SESSION["name"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    echo $counselor_id;
  // Check if the cancellation form is submitted
    if (isset($_POST["appointment_id"]) && isset($_POST["reason"])) {
    $student_id = $_POST["student_id"];
    $appointmentId = $_POST["appointment_id"];
    $reason = $_POST["reason"];

    if ($reason == "other"){
        $reason = $_POST["other_reason"];
    }


    // Additional validation and processing code here

    // Insert the cancellation record into the database
    $stmt = $conn->prepare("INSERT INTO cancellations (appointment_id, student_id, reason) 
                            VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $appointmentId, $student_id, $reason);

    if ($stmt->execute()){
        $stmt->close();
        // Update the appointment status in the appointments table
        $stmt2 = $conn->prepare("UPDATE appointments SET status = 'canceled' WHERE id = ?");
        $stmt2->bind_param("i", $appointmentId);

        if ($stmt2->execute()){
            $stmt2->close();
                $message = "$name has canceled a request";
            
                $stmt = $conn-> prepare ("SELECT counselor_id FROM appointments where 
                id = ? LIMIT 1"); 
                $stmt->bind_param('i',$appointmentId);
                $stmt-> execute();
                $result = $stmt-> get_result();
                $row = $result-> fetch_assoc(); 
                $counselor_id = $row["counselor_id"];
                $recipient_id = $counselor_id;
            $query = "INSERT INTO notifications (recipient_id, sender_id, notification_type, message) 
                    VALUES ('$recipient_id', '$student_id', 'appointment_cancel', '$message')";
            mysqli_query($conn, $query);
        }    

    }
    
  
    // Redirect back to the user list page
    header("Location: ../Student/studentdashboard.php");
    exit();

  }
}
?>
?>
