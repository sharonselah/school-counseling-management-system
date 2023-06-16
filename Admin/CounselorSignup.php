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
    <title>Document</title>
    <link rel="stylesheet" href="CSS/style.css">


    <style>
        .signupform{
                height: 580px; 
                width: 400px; 
                border-radius: 6px;
                margin: 25px auto ; 
                box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
                padding: 25px; 
                padding-top: 5px; 
        }

        input{
                width: 100%;  
                padding-top: 32px; 
                margin: 10px 0px; 
                border: none; 
                outline: none;
                border: 1px solid black; 
                border-radius: 6px;
        }

        input:focus{
                border: 2px solid black; 
   
        }

        button{
        background-color: #800000; 
        border: 1px solid #800000; 
        border-radius: 6px; 
        font-size: 18px;
        font-weight: 500;
        line-height: 1.2;
        list-style: none;
        padding: 15px 45px;
        transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
        color: white; 
        margin-left: 30%; 
        }

        p{
                text-align: center;
                font-weight: bold;
        }
    </style>
</head>
<body>
<div class="signupform">
        <form id ="form" onsubmit="return validateSignUpForm()" action="../Backend/counselorsignupmodel.php" method="post" >

                <p>Add New Counselor</p>
                <label for="name">Name</label> <br>
                <input type="text" name ="name" id ="uname" autocomplete="off"> <br>
                <small style="color:red;" id ="name-error"></small><br>

                <label for="email">Email</label>
                <small style="color:red;" id ="email-error"></small><br>
                <input type="text" name ="email" id ="email" autocomplete="off"> <br>

                <label for="password">Password</label><br>
                <input type="password" name ="password" id ="password"  autocomplete="off"> <br>
                <small style="color:red;" id ="pwd-error"></small> <br>

                <label for="repeat">Repeat Password</label><br>
                <input type="password" name="passwordCheck" id ="passwordCheck"> <br>
                <small style="color:red;" id ="pwdCheck-error"></small>
                
                <br>
                <button  type="submit" name="submit" id="button_signup">Add Counselor</button>

                <br>

                <p id="error_message"></p>

              
        </form>
     </div>

     <script>

        

        function validateSignUpForm(event){

        event.preventDefault();
        let uname = document.getElementById("uname").value;
        let email = document.getElementById("email").value; 
        let password = document.getElementById("password").value; 
        let passwordCheck = document.getElementById("passwordCheck").value; 
        
        //errors

        let name_error = document.getElementById("name-error"); 
        let email_error = document.getElementById("email-error"); 
        let pwd_error = document.getElementById("pwd-error"); 
        let pwdCheck_error = document.getElementById("pwdCheck-error"); 
        
        let error = false;


        //validate the name 

        if (uname.trim() == ""){
                name_error.innerHTML="Username is Required"; 
                error = true;
        }
        //validate email 

        if (email.trim() == ""){
                email_error.innerHTML= "Email cannot be empty";
                error = true;
        }


        //\w - alphanumeric characters \. - escape . means new line
        
        if(!email.match(/^[\w.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/)){
                email_error.innerHTML= "Email should be valid";
                error = true;
        }

        //validate password

        if (password.trim() == ""){
                pwd_error.innerHTML=  "Password cannot be empty"; 
                errror = true;
        }

        if (!password.match(/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).*$/)){
                pwd_error.innerHTML= "Weak Password<br /> At least one Uppercase letter <br />At least one Lowercase letter <br /> At least one number";
                errror = true;
        }

        if (password.trim().length <8){
                pwd_error.innerHTML = "Password should have at least 8 characters"; 
                errror = true;
        }

        //validate repeat Password 
        if (passwordCheck.trim() == ""){
                pwdCheck_error.innerHTML=  "Password cannot be empty"; 
                errror = true;
        }
        
        if (passwordCheck.trim() != password.trim()){
                pwdCheck_error.innerHTML=  "Password must match";
                errror = true;
        }

        if (error){
                return false;
        }

        return true; 

        }



</script>
   
</body>
</html>