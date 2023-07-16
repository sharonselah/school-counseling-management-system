<?php 
session_start(); 

include 'sessiondeleting.php'; 
$message = '';
$success = '';

if (isset($_GET['login'])) {
  if ($_GET['login'] === 'error') {
    $message = 'Incorrect email or password';
  } 

  if ($_GET['login'] === 'success'){
    $success = 'Registration successful! You can now log in with your credentials.';
  }
  //echo '<script>alert("' . $message . '");</script>';
  //unset($_GET['login']);
  //header("Refresh:0; Login.php"); //refresh the current page 
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
      <p style='color:green;'><?php echo $success; ?></p>
        <form onsubmit =" return Validateform()" action="Backend/loginmodel.php" method="post">


                <h2>Create an Account</h2>
                <p>Don't have an account? <a href="Signup.php">Sign Up</a></p>
           
                <label for="email">Email</label> <br>
                <input type="email" name ="email" id ="email" autocomplete="off"> <br>
                <small id="error_email" style="color:red;"></small> <br>

                <label for="password">Password</label><br>
                <input type="password" name ="password" id ="password"  autocomplete="off"> <br>
                <small id ="error_password" style="color:red;"></small><br>

                <button  type="submit" name="submit" id="button_signup">Log In </button>
                <p style='color:red;'><?php echo $message; ?></p>

                <br>

              
                <p>Forgot Password? <a href="forgetpassword.php">Reset Password</a></p>

              
        </form>
     </div>


     <script>
       
        function Validateform(){
          let email = document.getElementById("email").value;
          let password = document.getElementById("password").value;
          let error_email = document.getElementById("error_email");
          let error_password = document.getElementById("error_password");

          if (email.trim() == ""){
            error_email.innerHTML = "Email cannot be empty";
            return false; 
          }

          if (password.trim() == ""){
            error_password.innerHTML = "Password cannot be empty";
            return false; 
          }

          return true;
        }

     </script>
</body>
</html>

