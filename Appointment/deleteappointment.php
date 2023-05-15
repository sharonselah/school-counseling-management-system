<?php

include '../Backend/db.php'; 

// Get the user ID from the query parameter
$id = $_GET["id"];


// Perform the delete operation
$stmt = $conn->prepare("DELETE FROM appointments WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// Redirect back to the user list page
header("Location: ../Student/studentdashboard.php");
exit();
?>
