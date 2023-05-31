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

    if (uname.trim() == ""){
        name_error.innerHTML="Username is Required"; 
        hasErrors = true; 
    }
    //validate email 

    if (email.trim() == ""){
        email_error.innerHTML= "Email cannot be empty";
        hasErrors = true; 
    }
    
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
    
    if (!passwordCheck.trim() == password.trim()){
        pwdCheck_error.innerHTML=  "Password must match";
        hasErrors = true; 
    }


    if (hasErrors) {
        return false;
      }

    


    
return true; 

}


