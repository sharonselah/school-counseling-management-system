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
        <form  id ="form"  onsubmit="return validateSignUpForm()" method="POST" action="Backend/signupmodel.php">

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
                    <label for="password">Password <span style='color:gray;'>(8+ characters, uppercase, lowercase, & number)</span></label><br>
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
     
<script>
    function validateSignUpForm(){
    let uname = document.getElementById("uname").value;
    let email = document.getElementById("email").value; 
    let password = document.getElementById("password").value; 
    let passwordCheck = document.getElementById("passwordCheck").value; 
    
    //errors

    let name_error = document.getElementById("name-error"); 
    let email_error = document.getElementById("email-error"); 
    let pwd_error = document.getElementById("pwd-error"); 
    let pwdCheck_error = document.getElementById("pwdCheck-error"); 
 
    let hasErrors = false;


    //validate the name 

    if (uname.trim() == ""){
        name_error.innerHTML="Username is Required"; 
        hasErrors = true; 
    }
    //validate email 

    if (email.trim() == ""){
        email_error.innerHTML= "Email cannot be empty";
        hasErrors = true; 
    }

    //\w - alphanumeric characters \. - escape . means new line
    
    if(!email.match(/^[\w.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/)){
        email_error.innerHTML= "Email should be valid";
        hasErrors = true; 
    }

    //validate password

    if (password.trim() == ""){
        pwd_error.innerHTML=  "Password cannot be empty"; 
        hasErrors = true; 
    }

    if (!password.match(/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).*$/)){
        pwd_error.innerHTML= "Weak Password<br /> At least one Uppercase letter <br />At least one Lowercase letter <br /> At least one number";
        hasErrors = true; 
    }

    if (password.trim().length <8){
        pwd_error.innerHTML = "Password should have at least 8 characters"; 
    }

    //validate repeat Password 
     if (passwordCheck.trim() == ""){
        pwdCheck_error.innerHTML=  "Password cannot be empty"; 
        hasErrors = true; 
    }
    
  if (passwordCheck.trim() != password.trim()){
        pwdCheck_error.innerHTML=  "Password must match";
        hasErrors = true; 
    }




    if (hasErrors) {
        return false;
      }
 
return true; 

}



</script>
   
</body>
</html>

