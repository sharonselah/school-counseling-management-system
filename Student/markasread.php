<?php 

include '../Backend/db.php';

$id = $_GET["id"];



$query = "UPDATE notifications SET is_read = 1 WHERE id = $id";
$stmt = $conn->prepare($query);

if ($stmt -> execute()){

   
        header("Location:studentdashboard.php");
        exit();
   
}