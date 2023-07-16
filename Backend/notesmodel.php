<?php

session_start(); 

include 'db.php'; 

$id = $_SESSION['user_id']; 
$student_id =  $_SESSION['student_id']; 

if($_SERVER['REQUEST_METHOD']=="POST"){
    $title = $_POST['title'];
    $content = $_POST['content']; 


    $stmt = $conn->prepare("INSERT INTO notes (student_id, counselor_id, title, content) VALUES (?, ?, ?, ?)"); 
    $stmt->bind_param('iiss', $student_id, $id, $title, $content); 
  

    if ($stmt-> execute()){
        header("Location:../Counselor/counselordashboard.php");
        exit(); 
    }else {
        echo "Error". $stmt-> error; 
    }

    $stmt->close(); 
}

$conn-> close(); 


?>