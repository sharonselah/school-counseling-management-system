<?php 

include 'db.php'; 

session_start();  
$student_id =   $_SESSION["user_id"]; 

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    if (isset($_POST['habits'])){
        $goal = $_POST['habits'];  
    }else {
        $goal = $_POST["goal"]; 
    }

   




//use prepared statements
    $stmt = $conn-> prepare ("INSERT INTO goals (student_id, goal) VALUES (?, ?)"); 

    //bind the ? parameters to prevent SQL injection
    $stmt->bind_param('is', $student_id, $goal);
    $execute = $stmt-> execute(); 

    
    //check if the query executed

    if ($execute){
        header("Location: ../studentdashboard.php");
        exit(); 
    }else {
        echo "Error"; 
    }
}
