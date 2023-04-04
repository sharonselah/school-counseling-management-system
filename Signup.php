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
    <title>Sign Up Form</title>
</head>
<body>
    <div class="signupform">
        <form  action="Backend/signupmodel.php" method="post" >


                <h2>Create an Account</h2>
                <p>Already have an account? <a href="Login.php">Log In </a></p>
                <label for="name">Name</label> <br>
                
                <input type="text" name ="name" id ="name" autocomplete="off"> <br>

                <label for="email">Email</label> <br>
                <input type="text" name ="email" id ="email" autocomplete="off"> <br>
                <label for="password">Password</label><br>
                <input type="password" name ="password" id ="password"  autocomplete="off"> <br>
                <label for="repeat">Repeat Password</label><br>
                <input type="password" name="pwdrepeat" id ="repeatpassword"  autocomplete="off"> <br>
                
                <br>
                <button  type="submit" name="submit" id="button_signup">Create Account </button>

                <br>

                <p id="error_message">HEY</p>

              
        </form>
     </div>
</body>
</html>

