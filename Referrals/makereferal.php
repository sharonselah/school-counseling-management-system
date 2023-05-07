<?php 


include '../Backend/db.php'; 

session_start();

//counselor's id 
$id = $_SESSION['user_id']; 
$student_id = $_GET['id'];






/*process the form 

use the superglobal variable $_SERVER that holds the request method
used to access the page

*/

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $student_name = $_POST["name"]; 
    $receiving_therapist_email = $_POST["receiving_therapist_email"]; 
    $reason = $_POST["reason"]; 

//get therapist id 
    $stmt1 = $conn->prepare("SELECT counselor_id FROM counselors WHERE email= ?");
    $stmt1-> bind_param('s', $receiving_therapist_email);
    $stmt1-> execute();
    $result1 = $stmt1->get_result();
    $therapist = $result1->fetch_assoc();
      


    //use prepared statements
    $stmt2 = $conn-> prepare ("INSERT INTO referrals (referring_therapist_id,receiving_therapist_id,student_id, reason) VALUES (?, ?, ?,?)"); 

    //bind the ? parameters to prevent SQL injection
    $stmt2->bind_param('isis', $id, $therapist["counselor_id"], $student_id, $reason);
    

    if ($stmt2-> execute()){
        header("Location:../counselordashboard.php"); 
    }


    $stmt1-> close (); 
    $stmt2-> close(); 

}





?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Referral</title>

    <style>
            .referral_form{
                height: 580px; 
                width: 400px; 
                border-radius: 6px;
                margin: auto; 
                box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
                padding: 25px; 
                padding-top: 5px; 
            }

            .referral_form label, input{
                display: block; 
            }

            .referral_form input, textarea{
                width: 100%;  
                padding-top: 32px; 
                margin: 10px 0px; 
                border: none; 
                outline: none;
                border: 1px solid black; 
                border-radius: 6px;
            }

            .referral_form button{
                background-color: #800000; 
                border: 1px solid #800000; 
                border-radius: 6px; 
                font-size: 16px; 
                line-height: 1.2;
                padding: 10px 45px;
                color: white; 
                margin-left: 30%; 
            }
        
    </style>
</head>
<body>
        <form class="referral_form" action="" method="post">
<?php
            // get name 
            $stmt = $conn->prepare("SELECT name FROM students WHERE student_id= ?");
            $stmt-> bind_param('i', $student_id);
            $stmt-> execute();
            $result = $stmt->get_result();


        if ($result->num_rows>0){
            if ( $row = $result->fetch_assoc() ){
                echo ' <label for="name">Name:</label>'; 
                echo '<input type="name" id="name" name="name" value="'. $row["name"].'" required>'; 
            }
        

  
      }?>
            
            <label for="receiving_therapist_email">Receiving Therapist Email:</label>
            <input type="email" id="receiving_therapist_email" name="receiving_therapist_email" required>
        
            <label for="reason">Reason for Referral:</label>
            <textarea id="reason" name="reason" rows="4" cols="50" required></textarea>
            
            <button type="submit">Submit</button>
            
           
        </form>

</body>
</html>