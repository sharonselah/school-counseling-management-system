<?php

if (isset($_POST['submit'])) {
    // Retrieve the email address entered in the form
    $email = $_POST['email'];
    $email = '1039669@cuea.edu';
    
    // Generate a new random password
    $newPassword = generateRandomPassword(); // Function to generate a random password
    
    // Store the new password in your database for the associated email
    // Update the user's password with the new password
    
    // Send an email with the new password
  
    $to = $email;
    $subject = "Password Reset";
    $message = "Your new password is: " . $newPassword;
    //set content-type header for sending HTML email
    
    $headers .= "From: sellaah.sharon2001@gmail.com";
    
    // Send the email (you may need to configure your server to send emails)
    if (mail($to, $subject, $message, $headers)) {
        echo "An email has been sent with your new password.";
    } else {
        echo "Failed to send the email. Please try again later.";
    }
}

function generateRandomPassword($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $password .= $characters[$index];
    }
    return $password;
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Sign Up Form</title>
</head>
<body>
    <div class="reset">
        <form  action="" method="post">


                <h2>Reset Your Password</h2>
                <p style="color: gray;">Lost your password? Please enter your email address. You will
                    receive a link to create a new password via email.
                </p>
           
                <label for="email">Email</label> <br>
                <input type="text" name ="email" id ="email" autocomplete="off"> <br>
               
              <br>
                

                <button  type="submit" name="submit" id="button_signup">RESET PASSWORD</button>

                <p id="error_message"></p>
               

              
        </form>
     </div>
</body>
</html>

