<?php 

include '../Backend/db.php';
$id = $_GET["id"];

$query = "UPDATE notifications SET is_read = 1 WHERE id = $id";
$stmt = $conn->prepare($query);

if ($stmt -> execute()){

    if ($_SESSION["role"] == 'counselor'){
        header("Location:counselordashboard.php");
        exit();
    }else if ($_SESSION["role"]== 'student'){
        header("Location:../Student/studentdashboard.php");
        exit();
    }else {
        echo "The notification does not exist";
    }
}










?>