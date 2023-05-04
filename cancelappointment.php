<?php 

    // Connect to database and get user ID from URL parameter
    include 'Backend/db.php';
    $id = $_GET["id"];

    $status = "canceled"; 

    // Update user data in database
    $stmt = $conn->prepare("DELETE FROM appointments  WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Redirect back to user list
    header("Location: counselordashboard.php");
    exit();


?>