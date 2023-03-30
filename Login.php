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
        <form  action="" method="post">


                <h2>Create an Account</h2>
                <p>Don't have an account? <a href="Login.php">Sign Up</a></p>
           
                <label for="email">Email</label> <br>
                <input type="text" name ="email" id ="email" autocomplete="off"> <br>
                <label for="password">Password</label><br>
                <input type="password" name ="pwd" id ="password"  autocomplete="off"> <br>
              <br>
                

                <button  type="submit" name="submit" id="button_signup">Log In </button>

                <br>

                <p id="error_message">HEY</p>
                <p>Forgot Password? <a href="forgetpassword.php">Reset Password</a></p>

              
        </form>
     </div>
</body>
</html>

