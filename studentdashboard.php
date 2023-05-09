<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION["role"] !== 'student') {
  // User is not authenticated or is not a counselor, redirect to login page
  header('Location: Login.php');
  exit();
}


$id= $_SESSION["user_id"]; 


include 'Backend/db.php';




//get the time 

// Query the appointments table for the appointment details
$stmt2 = $conn->prepare("SELECT * FROM appointments 
WHERE student_id = ? 
AND CONCAT(date, ' ', start_time) > NOW() 
ORDER BY created_at DESC 
LIMIT 1");


$stmt2->bind_param('s', $id);
$stmt2->execute();

// Retrieve the result from the query
$result2 = $stmt2->get_result();

if ($result2->num_rows == 1) {
    // Fetch a single row from the result set
    $row = $result2->fetch_assoc();
    $start_time = date_format(date_create($row['start_time']), 'H:i');
    $date = date_format(date_create($row['date']), 'l j M');
    $appointment_details = $start_time . ' on ' . $date;
    $appointment_id = $row["id"]; 

    $counselor_id = $row["counselor_id"]; 

    $status = $row["status"]; 
    

     //Get the name of the counselor 

     $stmt1 = $conn-> prepare("SELECT name FROM counselors where counselor_id = ?"); 
     $stmt1-> bind_param('s', $counselor_id); 
     $stmt1-> execute(); 
 
     //retrieve the result from the query 
     $result1 = $stmt1->get_result();
 
     if ($result1->num_rows == 1) {
 
         //fetch a single row from the result set
         $row = $result1->fetch_assoc();
         $cName = $row['name'];
        
       }
 
} else {
    $appointment_details = 'No appointments found.';
}

//goals 

$stmt3= $conn->prepare("SELECT *, COUNT(*) as count FROM goals WHERE student_id =?"); 
$stmt3->bind_param("i", $id); 
$stmt3->execute(); 
$result3= $stmt3->get_result(); 




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

.goal form {
    margin-top: 15px;
   
  }


  .goal input[type="text"] {
    display: block;
    margin: auto; 
    width: 85%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 85%; 
  }

  input[type="radio"] {
    display: inline-block;
    margin-right: 10px;
    margin-bottom: 10px;
 
    
   
  }

  .goal label{
    font-size: 85%; 
  }

  .goal input[type="submit"] {
    display: block;
    width: 100%;
    padding: 10px;
    margin-top: 20px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
  }
    </style>
</head>
<body style=" padding: 0; ">

<div class="dashboard-container">

    <div class="header-dashboard">

            <div class="logo">
            CUEA Counseling
            </div>
    
          <div class="search">
              <input type="text" placeholder="Search...">
              <button>Search</button>
          </div>

          <div class="personal-info">
              <h2>Welcome, <?php  echo $_SESSION["name"]; ?></h2>
          </div>
      </div>

  
    <div class="menu-dashboard">
        <p>DASHBOARD</p>
        <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="appointment2.php">Appointments</a></li>
        <li><a href="">Goals</a></li>
        <li><a href="">Events</a></li>
        </ul>

    

        <p>UNDERSTAND</p>
        <ul>
        <li><a href="">WebMD</a></li>
        <li><a href="">Support</a></li>
        
        </ul>

        <br><br><br><br><br>

          <ul>
          <li><a href="">Log Out</a></li>
          </ul>


    </div>


<div class="right">

   <div class="profile">
      <div class="title">
        <p>Profile</p>
        <p><a href="">Edit</a></p>
      </div>

      <div class="center">
        <img src="Images/human-vector.jpg" alt="">


        <div class="dets">
          <p style="color: brown;"><?php echo $_SESSION['name']; ?></p>
          <p>Beginner <br> (0-5)goal (s)</p>
        </div>
        
      </div>

      <div class="buttons">
        <button> <?php echo $result2->num_rows; ?>
          <br>Appointment (s)
        </button>

        <button>
        <?php echo $result3->num_rows; ?> <br>Goals
        </button>
      </div>

      <div class="complete">
        <button>
          Complete Your Profile
        </button>
      </div>
   </div>

   <div class="appointment" style="width: 44%; height: 90vh; text-align: center;">
      <p style="font-size: 85%; font-weight: bolder;">Manage Appointments</p>

        <?php if ($result2->num_rows == 0){?>
          <div class="division one">
              <div class="none">

              
               
                <p><span style="color: brown; font-size: 35px;">Nothing to see yet ...</span> <br>
                Let's get started! You're one step closer to feeling better &#129315 <br>
                Book an appointment now and <span style="color: brown;">take the first step </span> towards a happier, healthier you! 🌟 
                </p>

                <button> <a href="appointment2.php">Book an Appointment</a></button>
              </div>
            </div> 
        <?php }?>

        

      <?php  if ($result2->num_rows == 1) {
       ?>

      <div class="division-two">
        <div class="appointment-card">
           
              <div class="details">
                <p style="color: blue;">! APPOINTMENT REQUEST SENT !</p>
                <p> &#10013 CUEA Counseling Department &#10013</p>
                <p>&#9410 <?php echo $cName;?></p>
                <p>&#9202 <?php echo $appointment_details?></p>
                <p>&#10084 For <?php echo $_SESSION["name"]?></p>
                <p> 
                  <button onclick ="return confirmCancel()"><a href='deleteappointment.php?id=<?php echo $appointment_id; ?>'>Cancel Appointment</a></button> 
                  
                </p>
              </div>
              

              <div class="confirm"> <?php
                    if ($status == "pending"){?>

                  <p>&#128284 <span style="font-weight:bold;">Appointment request sent</span> <br>It will be confirmed soon by the therapist</p>
                   <?php } else if ($status== "confirmed"){?>
                      <p>&#128394 <span style="font-weight:bold; color: green; ">Appointment confirmed</span> </p>
                   <?php }else {?>
                      <p>&#10060 <span style="font-weight:bold;color: red; ">Appointment canceled</p>
                   <?php }?>
              </div>

      </div> <?php }?>
    </div>
 
      </div>
     
   <div class="goal"> 
    
    <?php

   if ($result3->num_rows > 0){?>
          <div class="goal-tracking">


          <?php while ($goal = $result3->fetch_assoc()){
              $goal_name = $goal["goal"]; 
              
              $goal_id = $goal["id"]; ?>

              <p>Goal: <?php echo $goal_name;?></p>
              <p>Did you achieve your goal today?</p>
              <form action="Backend/goal_tracking.php?id=<?php echo $goal_id;?>" method="post">
                <input type="hidden" name="tracking_date" value="[Insert tracking date here]">
                <input type="hidden" name="goal_id" value="<?php echo $goal_name;?>">

                
                <input type="radio" id="yes" name="achieved" value="1">
                <label for="yes">Yes</label>
              
                <input type="radio" id="no" name="achieved" value="0">
                <label for="no">No</label>
                <br>
                <input type="submit" value="Submit">
              </form>
        <?php  }  ?>
              
          </div>


   <?php }else {
?>
    

      <p style="text-align:center; font-size: 95%; font-weight: bold;">What do you want to track for a Week? </p>

      <form action ="Backend/goals.php" method="post">
      <input type="text" name="goal" id="goal" placeholder="Name your Goal or Habit">
          <p style="color:lightgray; font-size: 80%;">Track anything you want by entering its name above
            or choose from the options below
          </p>
      <div>
        <input type="radio" id="exercising" name="habits" value="exercising">
        <label for="exercising">Exercising</label>
      </div>
      <div>
        <input type="radio" id="meditating" name="habits" value="meditating">
        <label for="meditating">Meditating</label>
      </div>
      <div>
        <input type="radio" id="no_alcohol" name="habits" value="no_alcohol">
        <label for="no_alcohol">No alcohol</label>
      </div>
      <div>
        <input type="radio" id="get_up_early" name="habits" value="get_up_early">
        <label for="get_up_early">Get up early</label>
      </div>
      <div>
        <input type="radio" id="sleep_on_time" name="habits" value="sleep_on_time">
        <label for="sleep_on_time">Sleep on time</label>
      </div>
      <div>
        <input type="radio" id="budget" name="habits" value="budget">
        <label for="budget">Budget</label>
      </div>

    
     <input type="submit" value="Set Goal">

</form>

    <?php }?>
    
   </div>


</div> <!-- end of right-->
      

<script>

  function confirmCancel(){
    var confirmation = confirm("Are you sure you want to cancel the appointment?");
    return confirmation;

  }
</script>

</body>
</html>