<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION["role"] !== 'student') {
    // User is not authenticated or is not a counselor, redirect to login page
    header('Location: Login.php');
    exit();
  }

if (isset($_SESSION["error_message"])){
    $error_message = $_SESSION["error_message"];
    //clear error message from the session
    unset($_SESSION["error_message"]);
  }
  
    //retrieve the time slots
    include '../Backend/db.php';
 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <title>Appointment</title>
</head>
<body>
        <form action="../Backend/submit_booking.php" method="post" class="form_appointment">
            <p>Book a Consultation</p>
                
            <span>Please Select an Appointment Date and Time</span> <br><br>
                   
                <label class="label" for="student">Student</label> 
                <input type="text" value="<?php echo $_SESSION["name"]; ?>">

                <label class="label" for="date">Date</label>  
                <input type="date" id="date" name="date" required> <br>
                
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

                
                <?php 
                    if (isset($error_message)){
                      ?>
                      <p id="error_message" style="color:red;"> <?php echo $error_message; ?>  </p>
                      <?php }
                  ?>
                </form>

</body>
</html>


