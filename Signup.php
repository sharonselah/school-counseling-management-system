<?php



//check if the superglobal GET variable contains a variable error
if (isset($_GET['error'])) {

    // if it exists assign its value to variable $error
    $error = $_GET['error'];

    // check if its value is equal to email_exists
    if ($error == 'email_exists') {
        echo "<script>alert('Email already exists');</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">

    <script src="app2.js"></script>
  
    <title>Sign Up Form</title>

  
</head>
<body>

    <div class="signupform">
        <form  id ="form"  onsubmit="return validateForm()" method="POST" action="Backend/signupmodel.php">

                <h2>Create an Account</h2>
                <p>Already have an account? <a href="Login.php">Log In </a></p>

                <div class="form-control">
                    <label for="name">Name</label> <br>
                    <input type="text" name ="name" id ="uname"> <br>
                    <small style="color:red;" id ="name-error"></small>
                </div>

                <div class="form-control">
                    <label for="email">Email</label> <br>
                    <input type="email" name ="email" id ="email"> <br>
                    <small style="color:red;" id ="email-error"></small>
                </div>

                <div class="form-control">
                    <label for="password">Password</label><br>
                    <input type="password" name ="password" id ="password"> <br>
                    <small style="color:red;" id ="pwd-error"></small>
                </div>

                <div class="form-control">
                    <label for="repeat">Repeat Password</label><br>
                    <input type="password" name="passwordCheck" id ="passwordCheck"> <br>
                    <small style="color:red;" id ="pwdCheck-error"></small>
                </div>
                
                <br>
                <button type="submit" name="submit" id="button_signup" >Create Account </button>

                <br>

             

              
        </form>
     </div>
     

   
</body>
</html>

