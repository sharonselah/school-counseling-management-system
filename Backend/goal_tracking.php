<?php 

include 'db.php'; 

session_start(); 




if($_SERVER["REQUEST_METHOD"]=="POST"){
    $goal_id = $_POST["goal_id"];
    $accepted = $_POST["achieved"];
    $date = date("Y-m-d");

   

    $stmt = $conn->prepare("SELECT COUNT(*) as count 
    FROM weekly_goal_progress 
    WHERE goal_id = ? AND created_at = ?
    ");


    $stmt->bind_param('is', $goal_id, $date); 
    $stmt->execute(); 
    $result = $stmt->get_result(); 

    if ($result-> num_rows == 1){
        echo "You already voted today"; 
    }else {

    $stmt = $conn-> prepare ("INSERT INTO weekly_goal_progress (goal_id, achieved) VALUES (?,?)"); 
    //bind the ? parameters to prevent SQL injection
    $stmt->bind_param('isi', $goal_id, $accepted);
    $execute = $stmt-> execute(); 
}

$stmt->close(); 
}

$conn->close(); 