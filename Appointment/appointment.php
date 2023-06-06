<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION["role"] !== 'student') {
    // User is not authenticated or is not a counselor, redirect to login page
    header('Location: ../Login.php');
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
        <form id ="form" onsubmit ="return validateForm()" action="../Backend/submit_booking.php" method="post" class="form_appointment">
            <p>Book a Consultation</p>
                    
                <label class="label" for="student">Student</label> 
                <input readonly type="text" value="<?php echo $_SESSION["name"]; ?>">

                <label class="label" for="specific_counselor">Do You Want to Choose a Specific Counselor?</label>
                <div>
                    <input style="margin-left: 35%; margin-top: 10px;" type="radio" name="specific_counselor" id="specific_counselor_yes" value="yes">
                    <label class="label" for="specific_counselor_yes">Yes</label>
                    
                    <input type="radio" name="specific_counselor" id="specific_counselor_no" value="no" checked>
                    <label class="label" for="specific_counselor_no">No</label>
                </div>

                <div id="counselor_name_input" style="display: none;">
                    <label class="label" for="counselor_name">Counselor Name</label>  
                    <select id="counselor_name" name="counselor_name">
                        <option value="">Select a counselor</option>
                        <?php
                        // Query your database to fetch counselor names
                        $sql = "SELECT  name FROM counselors ORDER BY name DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                    
                                $counselorName = $row["name"];
                                echo '<option value="' . $counselorName . '">' . $counselorName . '</option>';
                            }
                        }
                        ?>
                    </select>   
                </div>


                <label class="label" for="date">Date</label>  
                <input type="date" id="date" name="date" required> <span class="error" id ="error_date"></span>
                <br> <br>
                
                
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
    <script>
        var specificCounselorInput = document.getElementById("specific_counselor_yes");
        var specificCounselorInputNo = document.getElementById("specific_counselor_no");
        var counselorNameInput = document.getElementById("counselor_name_input");

        // Add event listener to the radio button
        specificCounselorInput.addEventListener("change", function() {
            if (specificCounselorInput.checked) {
                counselorNameInput.style.display = "block";
            } else {
                counselorNameInput.style.display = "none";
            }
        });

        specificCounselorInputNo.addEventListener("change", function() {
            if (specificCounselorInputNo.checked) {
                counselorNameInput.style.display = "none";
            } 
        });

        //validating the form 

        function validateForm(){

            let date = document.getElementById("date");
            let error_date = document.getElementById("error_date"); 

            let todaysDate = new Date();
            let chosenDate = new Date (date.value);


            if (chosenDate < todaysDate){
                error_date.innerHTML = "You cannot choose a date that has passed and book one day in advance"; 
                return false;  
            }
            
            //validate for weekends

          
            let chosenDay = chosenDate.getDay(); //0 is sunday 

            if (chosenDay == 0 || chosenDay == 6){
                error_date.innerHTML = "Cannot book an appointment on weekend"; 
                return false; 
                
            }

          return true; 
          

        };
     

            
            
        

    </script>

</body>
</html>


