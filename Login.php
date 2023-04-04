<?php 
session_start(); 

if (isset($_SESSION["error_message"])){
  $error_message = $_SESSION["error_message"];
  //clear error message from the session

  unset($_SESSION["error_message"]);
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
    <div class="login">
        <form  action="Backend/loginmodel.php" method="post">


                <h2>Create an Account</h2>
                <p>Don't have an account? <a href="Signup.php">Sign Up</a></p>
           
                <label for="email">Email</label> <br>
                <input type="email" name ="email" id ="email" autocomplete="off"> <br>
                <label for="password">Password</label><br>
                <input type="password" name ="password" id ="password"  autocomplete="off"> <br>
              <br>
                

                <button  type="submit" name="submit" id="button_signup">Log In </button>

                <br>

                
                  <?php 
                    if (isset($error_message)){
                      ?>
                      <p id="error_message"> <?php echo $error_message; ?>  </p>
                      <?php }
                  ?>

              
                <p>Forgot Password? <a href="forgetpassword.php">Reset Password</a></p>

              
        </form>
     </div>


     <script>
        const errorMessage = document.getElementById("error_message");
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');

        // Set a timer to hide the error message when the user starts typing
        let timerId;
        emailInput.addEventListener('input', startTimer);
        passwordInput.addEventListener('input', startTimer);

        function startTimer() {
    // Clear the previous timer if it exists
    if (timerId) {
      clearTimeout(timerId);
    }

     // Set a new timer to hide the error message after 2 seconds
     timerId = setTimeout(function() {
      errorMessage.style.display = 'none';
    }, 500);
  }


     </script>
</body>
</html>

