<?php 

session_start();  

$student_id =   $_SESSION["user_id"]; 
$student_name =  $_SESSION["name"]; 

include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $date = $_POST["date"]; 
    $startTime = $_POST["select"]; 
    $endTime = date('H:i:s', strtotime('+1 hour', strtotime($startTime)));

    //selecting the counselor 

    $stmt = $conn-> prepare ("SELECT receiving_therapist_id FROM referrals WHERE student_id = ?"); 
    $stmt->bind_param("i", $student_id); 
    $stmt-> execute(); 
    $result= $stmt-> get_result(); 

    if ($result->num_rows>0){
        $row_referral = $result -> fetch_assoc(); 
        $counselor_id = $row_referral['receiving_therapist_id'];
    }else {
        //check if student has a prior appointment 
        $stmt = $conn-> prepare ("SELECT counselor_id FROM appointments 
                                            WHERE student_id = ? 
                                            ORDER BY date 
                                            DESC LIMIT 1"); 
        $stmt->bind_param("i", $student_id); 
        $stmt-> execute(); 
        $result= $stmt-> get_result(); 

        if ($result->num_rows>0){
            $prior_app_referral = $result -> fetch_assoc(); 
            $counselor_id = $prior_app_referral['counselor_id'];
        }else {
            $counselor_id = rand (7, 24); 
        }
    }

    $status ="pending"; 

    //before inserting check if the student has an already existing appointment
    $stmt = $conn-> prepare ("SELECT * FROM appointments 
    WHERE student_id = ? 
    AND CONCAT(date, ' ', start_time) > NOW() 
    ORDER BY created_at DESC 
    LIMIT 1");
    $stmt-> bind_param ("i", $student_id); 
    $stmt ->execute(); 
    $result= $stmt-> get_result(); 

    if ($result->num_rows>0){
        $_SESSION["error_message"] = "Sorry, you cannot book another appointment at this time. You already have a pending appointment." ; 
        header("Location: ../Appointment/appointment.php");
        exit();
    }else {

   

    //use prepared statements
    $stmt = $conn-> prepare ("INSERT INTO appointments (student_id, counselor_id, date, start_time, end_time, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?)"); 

    //bind the ? parameters to prevent SQL injection
    $stmt->bind_param('iisssss', $student_id, $counselor_id, $date, $startTime, $endTime, $status, $notes);
    $execute = $stmt-> execute(); 
    $appointment_id = $stmt->insert_id;

    $_SESSION['appointment_id']= $appointment_id; 
    
    //check if the query executed

    if ($execute){
        header("Location: ../Student/studentdashboard.php");
        exit(); 
    }else {
        echo "Error". $stmt-> error; 
    }
}

    $stmt-> close (); 

}

$conn-> close(); 



