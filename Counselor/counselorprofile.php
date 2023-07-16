<?php 

include '../Backend/db.php';


$id = $_SESSION["user_id"]; 
$name =  $_SESSION["name"]; 
$email = $_SESSION["email"]; 

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = filter_var ($_POST["email"], FILTER_SANITIZE_EMAIL); 
    $phone = filter_var ($_POST["phone"], FILTER_SANITIZE_NUMBER_INT); 
    $image = $_POST['image'];

    $image_path = pathinfo($image);
    $image_basename = $image_path['basename'];


    $stmt = $conn-> prepare("UPDATE counselors SET email =?, phone = ?, profile_image= ? WHERE counselor_id =?"); 
    $stmt -> bind_param('sisi', $email, $phone, $image_basename, $id); 
    
    
        if ($stmt->execute()) {
            header("Location:../Counselor/counselordashboard.php");
            exit();
        } else {
            echo ("Failed to execute statement");
        }
   

    $stmt->close(); 
}
$conn-> close(); 
?>

<head>
    
    <link rel="stylesheet" href="../CSS/style.css">
    <title>Counselor Dashboard</title>

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