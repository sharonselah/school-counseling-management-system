<?php
session_start();


if (!isset($_SESSION['authenticated'])|| $_SESSION["role"] !== 'student') {
    // User is not authenticated, redirect to login page
    header('Location: Login.php');
    exit();
}

// Connect to database and get user ID from URL parameter
include '../Backend/db.php';
$id = $_GET["id"];

// Get user data from database
$stmt = $conn->prepare("SELECT * FROM appointments WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$appointment = $result->fetch_assoc();

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get new name and specialty from form
    $date = $_POST["date"];
    $startTime = $_POST["start-time"];
    $endTime = $_POST["end-time"]; 

    // Update user data in database
    $stmt = $conn->prepare("UPDATE appointments SET date = ?, start_time = ?, end_time = ? WHERE id = ?");
    $stmt->bind_param("sssi", $date, $startTime, $endTime, $id);
    $stmt->execute();

    // Redirect back to user list
    header("Location: studentdashboard.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reschedule Appointment</title>
</head>
<body>
                <form  method="post">
                <h2>Reschedule the Appointment</h2>
                
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value ="<?php echo $appointment['date'];?>"required>
            
                <label for="start-time">Start Time:</label>
                <input type="time" id="start-time" name="start-time" value ="<?php echo $appointment['start_time'];?>" required>

                <label for="end-time">End Time:</label>
                <input type="time" id="end-time" name="end-time" value ="<?php echo $appointment['end_time'];?>" required>

                <button type="submit">Submit</button>
                </form>

</body>
</html>