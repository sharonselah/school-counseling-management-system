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
    <div class="reset">
        <form  id ="form" onsubmit="return validateResetForm()" action="" method="post" >


                <h2>Reset Password</h2>
                <p>Enter the new password</p>
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


                <button  type="submit" name="submit" id="button_signup">Reset Password</button>

              
        </form>
     </div>
</body>
</html>

