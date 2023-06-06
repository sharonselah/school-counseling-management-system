<?php 

include '../Backend/db.php'; 

$id = $_GET['id'];

// Update the appointment status in the appointments table
$stmt = $conn->prepare("UPDATE appointments SET status = 'missed' WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()){
    header("Location: ../Counselor/counselordashboard.php"); 
    exit();
}else {
    echo "error"; 
}


?>