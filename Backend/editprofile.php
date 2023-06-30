<?php 

include 'db.php';

session_start(); 
$id = $_SESSION["user_id"]; 
$name =  $_SESSION["name"]; 
$email = $_SESSION["email"]; 

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $phone = filter_var ($_POST["phone"], FILTER_SANITIZE_NUMBER_INT); 
    $gender = filter_var ($_POST["gender"], FILTER_SANITIZE_STRING); 
    $stmt = $conn-> prepare("UPDATE students SET phone = ?, gender =? WHERE student_id =?"); 
    $stmt -> bind_param('isi', $phone, $gender, $id); 
    
    try {
        if ($stmt->execute()) {
            header("Location:../Student/studentdashboard.php");
            exit();
        } else {
            throw new Exception("Failed to execute statement");
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    

    $stmt->close(); 
}
$conn-> close(); 
?>

<head>
    
    <link rel="stylesheet" href="../CSS/style.css">
    <title>Student Dashboard</title>

    <style>
        select{
            width: 100%;  
            padding-top: 32px; 
            margin: 10px 0px; 
            border: none; 
            outline: none;
            border: 1px solid black; 
            border-radius: 6px;
        }
    </style>
</head>

<div class="signupform">
        <form onsubmit = "return ValidateForm()" method="post" >

               <p>Complete Profile</p>

               <div class="form-control">
                    <label for="name">Name</label> <br>
                    <input type="text" name ="name" value="<?php echo $name?>" readonly> <br>  
                </div>

                <div class="form-control">
                    <label for="email">Email</label> <br>
                    <input type="email" name ="email" value="<?php echo $email?>" readonly> <br>
                </div>

                <div class="form-control">
                    <label for="name">Phone Number</label> <br>
                    <input type="phone" name ="phone" id ="uphone"> <br>
                    <small id ="uphone_error" style ="color:red;" ></small><br>
                </div>

                <div class="form-control">
                    <label for="gender">Gender</label> <br>
                    <select name="gender" id="gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="not_specified">Prefer Not to Say</option>
                    </select>
                </div>


                <br>
                <button type="submit" name="submit" >Complete Profile </button>


        </form>
     </div>

     <script>

        function ValidateForm(){
            let uphone = document.getElementById("uphone").value;
            let uphone_error = document.getElementById("uphone_error");
          
            let phone_regex = /^\d{10}$/;

            if (!(phone_regex.test(uphone))){
                uphone_error.innerHTML = "Should have ten digits (07... or 01...)";
                return false;
            }

            return true; 
        }
     </script>