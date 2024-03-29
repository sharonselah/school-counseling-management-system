<?php 

include 'db.php';

session_start(); 
$id = $_SESSION["user_id"]; 
$name =  $_SESSION["name"]; 
$email = $_SESSION["email"]; 

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = filter_var ($_POST["email"], FILTER_SANITIZE_EMAIL); 
    $phone = filter_var ($_POST["phone"], FILTER_SANITIZE_NUMBER_INT); 
    $gender = filter_var ($_POST["gender"], FILTER_SANITIZE_STRING); 
    $image = $_POST['image'];

    $image_path = pathinfo($image);
    $image_basename = $image_path['basename'];


    $stmt = $conn-> prepare("UPDATE students SET email =?, phone = ?, gender =?, profile_image= ? WHERE student_id =?"); 
    $stmt -> bind_param('sissi', $email, $phone, $gender, $image_basename, $id); 
    
    try {
        if ($stmt->execute()) {
            header("Location:../Student/studentdashboard.php");
            exit();
        } else {
            throw new Exception("Failed to execute statement");
        }
    } catch (Exception $e) { //type of exception and its name ($e can be anything)
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
        input{
            font-size: 14px;
        }
    </style>
</head>

<div class="signupform">
        <form onsubmit = "return ValidateForm()" method="post" >

               <p>Complete Profile</p>

               <div class="form-control">
                    <label for="name">Name</label> <br>
                    <input type="text" name ="name" value="<?php echo $name?>" readonly> <br> <br>  
                </div>

                <div class="form-control">
                    <label for="email">Email</label> <br>
                    <input type="email" name ="email" value="<?php echo $email?>" required> <br> <br>
                </div>

                <div class="form-control">
                    <label for="name">Phone Number</label> <br>
                    <input type="phone" name ="phone" id ="uphone" placeholder="eg 070000000"> <br>
                    <small id ="uphone_error" style ="color:red;" ></small><br>
                </div>

                <div class="form-control">
                    <label for="gender">Gender</label> <br>
                    <select name="gender" id="gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="not_specified">Prefer Not to Say</option>
                    </select>
                </div> <br>

                <div class="form-control">
                    <label for="image">Profile Image</label>
                    <input type="file" name="image" id="image" style="border:none; padding:0;" >
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