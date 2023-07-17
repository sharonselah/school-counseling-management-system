<?php 

    // Connect to database and get user ID from URL parameter
    include '../Backend/db.php';
    session_start();
    $id= $_SESSION["user_id"]; 
    $appointment_id = $_GET["id"];
    $status = "confirmed";

    // Update user data in the database
    $stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $appointment_id);

    if ($stmt->execute()) {
        // Fetch the counselor_id from the appointments table
        $stmt2 = $conn->prepare("SELECT counselor_id FROM appointments WHERE id = ?");
        $stmt2->bind_param("i", $appointment_id);
        $stmt2->execute();
        $result = $stmt2->get_result();
        $row = $result->fetch_assoc();
        $counselor_id = $row["counselor_id"];

        // Insert a notification for the student
        $recipient_id = $counselor_id;
        $message = "Your appointment has been confirmed";
        $query = "INSERT INTO notifications (recipient_id, sender_id, recipient_role, sender_role, notification_type, message) 
        VALUES ('$recipient_id', '$id', 'counselor', 'student', 'appointment_request', '$message')";
        mysqli_query($conn, $query);


        

        //update the notifications table 
        $stmt_reschedule = $conn->prepare("UPDATE rescheduling SET accepted = ? WHERE appointment_id = ?");
        $accepted = 1;
        $stmt_reschedule->bind_param("ii", $accepted, $appointment_id);

        $stmt_reschedule->execute();

        // Redirect back to user list
        header("Location: studentdashboard.php");
        exit();

    
       
    }

    // Close the prepared statements
    $stmt->close();
    $stmt2->close();
    $stmt_reschedule->close();


    

?>