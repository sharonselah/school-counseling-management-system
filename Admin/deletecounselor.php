<?php

include '../Backend/db.php'; 
// Get the user ID from the query parameter
$id = $_GET["id"];

$time_limit = date('Y-m-d H:i:s', strtotime('-48 hours'));

// Perform the delete operation
$stmt = $conn->prepare("DELETE FROM counselors WHERE counselor_id = ? AND created_at > ?");
$stmt->bind_param("is", $id, $time_limit);
$stmt->execute();

// Redirect back to the user list page
header("Location: admindashboard.php");
exit();
?>
