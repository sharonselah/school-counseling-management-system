<?php 


include '../../Backend/db.php'; 

session_start();

//counselor's id 
$id = $_SESSION['user_id']; 
$student_id = $_GET['id'];


if ($_SERVER["REQUEST_METHOD"]=="POST"){

    $receiving_therapist_email = $_POST["receiving_therapist_email"]; 
    $reason = $_POST["reason"]; 

    //get therapist id 
    $stmt1 = $conn->prepare("SELECT counselor_id FROM counselors WHERE email= ?");
    $stmt1-> bind_param('s', $receiving_therapist_email);
    $stmt1-> execute();


 
    //retrieve the result from the query 
    $result1 = $stmt1->get_result();

    if ($result1->num_rows == 1) {

        $row = $result1->fetch_assoc();
        $stmt2 = $conn-> prepare ("INSERT INTO referrals (referring_therapist_id,receiving_therapist_id,student_id, reason) VALUES (?, ?, ?,?)"); 
        $stmt2->bind_param('isis', $id, $row["counselor_id"], $student_id, $reason);

        if ($stmt2-> execute()){


           /* $to = $receiving_therapist_email;
            $subject = "Counseling Referral for a Student ";
            $message = "Dear I am writing to refer one of my students, to you for further counseling. The reason for this referral is " 
            . $reason. ". As a counselor, I believe that it would be beneficial for the student to have a different perspective on their current situation.\n\nIf you require any further information, 
            please do not hesitate to contact me at \n\nThank you for considering my referral, and I appreciate your time and attention
             to this matter.\n\nSincerely,\n";
             

            $headers = "From: 1039669@cuea.edu";
            
            mail($to, $subject, $message, $headers);*/
            

            header("Location:../counselordashboard.php?referral=success"); 
            exit();
        }else {
            echo '<p>The Email does not exist</p>'; 
        }

        
         }else{
        //echo '<p style="color:red;">The Email does not exist</p>'; 
        echo '<p style="color:red; margin-left: 30%; ">The email does not exist. You will be redirected in 5 seconds.</p>';
        echo '<script>setTimeout(function(){ window.location.href = "../counselordashboard.php"; }, 5000);</script>';

        }

}?>

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

   
<body>
        <form class="referral_form" action="" method="post">

                    <p>Refer a Student</p>
            <label for="receiving_therapist_email">Receiving Therapist Email:</label>
            <input type="email" id="receiving_therapist_email" name="receiving_therapist_email">
        
            <label for="reason">Reason for Referral:</label>
            <textarea id="reason" name="reason" rows="4" cols="50"></textarea>
            
            <button type="submit">Submit</button>

            
           
        </form>

</body>
</html>