function validateForm(){
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

    if (uname == ""){
        name_error.innerHTML="Username is Required"; 
        hasErrors = true; 
    }
    //validate email 

    if (email == ""){
        email_error.innerHTML= "Email cannot be empty";
        hasErrors = true; 
    }
    
    if(!email.match(/^\S+@\S+\.\S+$/)){
        email_error.innerHTML= "Email should be valid";
        hasErrors = true; 
    }

    //validate password

    if (password == ""){
        pwd_error.innerHTML=  "Password cannot be empty"; 
        hasErrors = true; 
    }
    
    if (!password.match(/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{8,16}$/)){
        pwd_error.innerHTML= "Weak Password <br />Minimum 8 characters <br />Upper & lowercase letters <br /> At least one number <br /> -- At least one special character";
        hasErrors = true; 
    }

    //validate repeat Password 
    if (passwordCheck == ""){
        pwdCheck_error.innerHTML=  "Password cannot be empty"; 
        hasErrors = true; 
    }
    
    if (!passwordCheck == password){
        pwdCheck_error.innerHTML=  "Password must match";
        hasErrors = true; 
    }


    if (hasErrors) {
        return false;
      }

    


    
return true; 

}


