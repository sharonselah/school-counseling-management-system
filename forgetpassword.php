<?php

include 'Backend/db.php';

if (isset($_POST['submit'])) {
    // Retrieve the email address entered in the form
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT email FROM users where email = ?"); 
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result(); 

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
                <input type="text" name ="email" id ="email" autocomplete="off" required> <br><br>
                <button  type="submit" name="submit" id="button_signup">RESET PASSWORD</button>

                <?php
                
                if ($result->num_rows ==1){
                    echo "<p style='color:green;'>Check Your Email and Click on the link sent to your email</p>";
                }else {
                    echo "<p style='color:red;'>The email does not exist</p>"; 
                }
                ?>
              
        </form>
     </div>
</body>
</html>

