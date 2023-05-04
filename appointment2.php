<?php
session_start();


if (!isset($_SESSION['authenticated'])) {
    // User is not authenticated, redirect to login page
    header('Location: Login.php');
    exit();
}
//retrieve the time slots
include 'Backend/db.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Document</title>

    <style>

        .form_appointment{
            margin: 30px auto;
            width: 25%;
            border-radius:10px; 
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
            box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
            height: 85vh; 
            padding: 20px; 
            font-family: 'Times New Roman', Times, serif;
          
        }

        .form_appointment p{
            text-align: center; 
            font-weight: bold; 
            line-height: 1.25 rem; 
        }

        input[type="date"], input[type="text"]{
            margin: 10px 20px ; 
            font-size: 90%; 
            width: 83%; 
            padding: 5px; 
            display: block; 
          
        }

        .label{
            margin: 0px 19px; 
            font-size: 90%; 
            
        }
        span{
            padding-left: 8%; 
            font-size: 82%; 
            text-align: center; 
            color: gray; 
            
        }

    
        .wrapper {
        padding: 0px 20px; 
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        }

        .input {
        width: 40%; 
        margin-bottom: 10px;
        border:1px solid black; 
        }

        .form_appointment button{
            width: 83%; 
            height: 50px; 
            text-align: center; 
            margin:10px 8%; 
            background-color:#800020; 
            color: white; 
            border: 1px solid brown; 
            font-size:80%; 
        }
    </style>
</head>
<body>
                <form action="Backend/submit_booking.php" method="post" class="form_appointment">
                <p>Book a Consultation</p>
                
                <span>Please Select an Appointment Date and Time</span>
                    <br>
                    <br>
                    <label class="label" for="student">Student</label> 
                    <input type="text" value="<?php echo $_SESSION["name"]; ?>">

                    
                    <label class="label" for="date">Date</label>  
                    <input type="date" id="date" name="date" required>
                 <br>

                <?php 

                    // Retrieve timeslots from database
                    $sql = "SELECT * FROM time_slots";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0){
                        echo '<div class="wrapper">';
                        // output data of each row
                        $count = 1;
                        while($row = $result->fetch_assoc()) {
                            
                            echo '<div class="input">';
                            echo '<input type="radio" name="select" id="slot'.$count.'" value="'.$row["start_time"].'">';
                            echo '<label for="slot'.$count.'">'.$row["start_time"].'</label>';
                            echo '</div>';
                            
                            $count++;
                        }
                        echo '</div>';
                    } else {
                        echo "No time slots available";
                    }
                  
                    ?>

                <button type="submit">Confirm Date and Time</button>
                </form>

</body>
</html>


