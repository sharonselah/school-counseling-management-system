<?php

include 'db.php'; 

session_start();  
$student_id = $_SESSION["user_id"]; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get current date
    $current_date = date("Y-m-d");

    // Count the number of goals added by the student in the past week
    $stmt = $conn->prepare("SELECT COUNT(*) FROM goals WHERE student_id = ? AND created_at >= ?");
    $week_ago = date('Y-m-d', strtotime('-7 days'));
    $stmt->bind_param('is', $student_id, $week_ago);
    $stmt->execute();
    $stmt->bind_result($num_goals);
    $stmt->fetch();
    $stmt->close();

    if ($num_goals >= 3) {
        // If the student has already added 3 goals within the past week, show an error message
        
        header("Location: ../Student/studentdashboard.php?voted=maximum");
        exit(); 
    } else {

        if (isset($_POST['habits'])) {
            $goal = $_POST['habits'];  
        } else {
            $goal = $_POST["goal"]; 
        }

        // Use prepared statements to insert the new goal
        $stmt = $conn->prepare("INSERT INTO goals (student_id, goal) VALUES (?, ?)"); 
        $stmt->bind_param('is', $student_id, $goal);
        $execute = $stmt->execute(); 

        // Check if the query executed
        if ($execute) {
            header("Location: ../Student/studentdashboard.php?voted=true");
            exit(); 
        } else {
            echo "Error"; 
        }
    }
}
