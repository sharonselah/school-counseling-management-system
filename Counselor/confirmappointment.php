<?php 

    // Connect to database and get user ID from URL parameter
    include '../Backend/db.php';
    $id = $_GET["id"];

    $status = "confirmed"; 

    // Update user data in database
    $stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    // Redirect back to user list
    header("Location: counselordashboard.php");
    exit();


?>