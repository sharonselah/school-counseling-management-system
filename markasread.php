<?php 

include 'Backend/db.php';

$id = $_GET["id"];

session_start();
$role = $_SESSION['role']; 


$query = "UPDATE notifications SET is_read = 1 WHERE id = $id";
$stmt = $conn->prepare($query);

if ($stmt -> execute()){

    if ($role == 'counselor'){
        header("Location:Counselor/counselordashboard.php");
        exit();
    }else if ($role== 'student'){
        header("Location:Student/studentdashboard.php");
        exit();
    }else {
        echo "The notification does not exist";
    }
}



?>