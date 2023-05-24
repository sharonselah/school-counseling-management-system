<?php 

    // Connect to database and get user ID from URL parameter
    include '../Backend/db.php';
    $id = $_GET["id"];
    $status = "confirmed";

    // Update user data in the database
    $stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        // Fetch the student_id from the appointments table
        $stmt2 = $conn->prepare("SELECT student_id FROM appointments WHERE id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $result = $stmt2->get_result();
        $row = $result->fetch_assoc();
        $student_id = $row["student_id"];

        // Insert a notification for the student
        $recipient_id = $student_id;
        $message = "Your appointment has been confirmed";
        $query = "INSERT INTO notifications (recipient_id, sender_id, notification_type, message) 
                VALUES ('$recipient_id', '$id', 'appointment_request', '$message')";
        mysqli_query($conn, $query);
    }

    // Close the prepared statements
    $stmt->close();
    $stmt2->close();


    // Redirect back to user list
    header("Location: counselordashboard.php");
    exit();


?>