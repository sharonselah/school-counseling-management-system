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
        <form  action="" method="post"  onsubmit="return validateForm()" >


                <h2>Reset Password</h2>
                <p>Enter the new password</p>
            
                <label for="password">Password</label><br>
                <input type="password" name ="pwd" id ="password"  autocomplete="off"> <br>
                <label for="repeat">Repeat Password</label><br>
                <input type="password" name="pwdrepeat" id ="repeatpassword"  autocomplete="off"> <br>
                
                <br>


                <button  type="submit" name="submit" id="button_signup">Reset Password</button>

                <p id="error_message">HEY</p>

              
        </form>
     </div>
</body>
</html>

