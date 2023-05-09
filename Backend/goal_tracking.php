<?php 

include 'db.php'; 

session_start(); 

$goal_id = $_GET["id"]; 



if($_SERVER["REQUEST_METHOD"]=="POST"){

    $accepted = $_POST["achieved"];
    $dayOfWeek = date('l'); // Returns the day of the week in full text"Sunday", "Monday"
    $stmt = $conn-> prepare ("INSERT INTO weekly_goal_progress (goal_id, day_of_week, achieved) VALUES (?, ?,?)"); 
    //bind the ? parameters to prevent SQL injection
    $stmt->bind_param('isi', $goal_id,$dayOfWeek, $accepted);
    $execute = $stmt-> execute(); 
}