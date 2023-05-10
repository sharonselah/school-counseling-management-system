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
    

    if($stmt-> execute()){
        header("Location:../Student/studentdashboard.php"); 
        exit(); 
    }else {
        echo "error"; 
    }

    $stmt->close(); 
}
$conn-> close(); 
?>

<head>
    
    <link rel="stylesheet" href="../CSS/style.css">
    <title>Student Dashboard</title>
</head>

<div class="signupform">
        <form method="post">

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
                </div>

                <div class="form-control">
                    <label for="gender">Gender</label> <br>
                    <input type="gender" name ="gender" id ="gender"> <br>
                </div>

                <br>
                <button type="submit" name="submit" >Complete Profile </button>


        </form>
     </div>