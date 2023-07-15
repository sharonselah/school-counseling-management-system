<?php 

session_start();  

//set session variables
$student_id =   $_SESSION["user_id"]; 
$student_name =  $_SESSION["name"]; 

include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $date = $_POST["date"]; 
    $startTime = $_POST["select"]; 

    //convert date/time string into a Unix timestamp (seconds) - supports relative formats
    //Assume one session takes 1 hour 
    $endTime = date('H:i:s', strtotime('+1 hour', strtotime($startTime)));

    //selecting the counselor 

    if (isset($_POST['counselor_name']) && !empty($_POST['counselor_name'])) {
        $selectedName = $_POST['counselor_name'];
    
        $sql = "SELECT counselor_id FROM counselors WHERE name = '$selectedName'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $counselor_id = $row["counselor_id"]; 
        } 
    } else  
         {
            $stmt = $conn->prepare("SELECT receiving_therapist_id FROM referrals WHERE student_id = ? AND Accept = 1"); 
            $stmt->bind_param("i", $student_id); 
            $stmt->execute(); 
            $result = $stmt->get_result(); 
    
            if ($result->num_rows > 0) {
                $row_referral = $result->fetch_assoc(); 
                $counselor_id = $row_referral['receiving_therapist_id'];
            } else {
                // Check if student has a prior appointment 
                $stmt = $conn->prepare("SELECT counselor_id FROM appointments WHERE student_id = ? ORDER BY date DESC LIMIT 1"); 
                $stmt->bind_param("i", $student_id); 
                $stmt->execute(); 
                $result = $stmt->get_result(); 
    
                if ($result->num_rows > 0) {
                    $prior_app_referral = $result->fetch_assoc(); 
                    $counselor_id = $prior_app_referral['counselor_id'];
                } else {
                    $counselor_id = rand(7, 31); 
                }
            }
        }
    
    

    $status ="pending"; 

    /*
    
    before inserting check if the student has an already existing appointment
    
    filter the results based on the combination of column date and time is greater than now () - date and time currently

    exclude rows with status canceled & overdue
    
    */

    $stmt = $conn-> prepare ("SELECT * FROM appointments 
    WHERE student_id = ? 
    AND CONCAT(date, ' ', start_time) > NOW() 
    AND status != 'canceled'
    AND status != 'overdue'
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
        $recipient_role = 'counselor';
        $sender_role ='student';
        
        $recipient_id = $counselor_id;
        $message = "$student_name has requested an appointment for $date and starting at $startTime. Please review and respond.";
        $query = "INSERT INTO notifications (recipient_id,sender_id, recipient_role, sender_role,  notification_type, message) 
          VALUES ('$recipient_id', '$student_id', '$recipient_role','$sender_role','appointment_request', '$message')";
            mysqli_query($conn, $query);

        header("Location: ../Student/studentdashboard.php");
        exit(); 
    }else {
        echo "Error". $stmt-> error; 
    }
}

    $stmt-> close (); 

}

$conn-> close(); 



