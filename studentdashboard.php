<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION["role"] !== 'student') {
  // User is not authenticated or is not a counselor, redirect to login page
  header('Location: Login.php');
  exit();
}


$id= $_SESSION["user_id"]; 
$appointment_id = $_SESSION['appointment_id']; 
include 'Backend/db.php';

//get the time 

// Query the appointments table for the appointment details
$stmt2 = $conn->prepare("SELECT start_time, date FROM appointments 
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
} else {
    $appointment_details = 'No appointments found.';
}

  
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
        <li><a href="">Appointments</a></li>
        <li><a href="">Messages</a></li>
        <li><a href="">Events</a></li>
        </ul>

    

        <p>UNDERSTAND</p>
        <ul>
        <li><a href="">WebMD</a></li>
        <li><a href="">Support</a></li>
        <li><a href="">Chat</a></li>
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
          <p>Beginner <br>(0-5 goals)</p>
        </div>
        
      </div>

      <div class="buttons">
        <button>
          0 <br>Appointments
        </button>

        <button>
          0 <br>Goals
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

        

      <?php  if ($result2->num_rows == 1) {?>

      <div class="division-two">
        <div class="appointment-card">
           
              <div class="details">
                <p style="color: blue;">! APPOINTMENT REQUEST SENT !</p>
                <p> &#10013 CUEA Counseling Department &#10013</p>
                <p>&#9410 <?php echo $_SESSION['cName'];?></p>
                <p>&#9202 <?php echo $appointment_details?></p>
                <p>&#10084 For <?php echo $_SESSION["name"]?></p>
                <p> 
                  <button onclick ="return confirmCancel()"><a href='deleteappointment.php?id=<?php echo $appointment_id; ?>'>Cancel Appointment</a></button> 
                  
                </p>
              </div>
              

              <div class="confirm">
                  <p>&#9808 <span style="font-weight:bold;">Appointment request sent</span> <br>It will be confirmed soon by the therapist</p>
              </div>

      </div> <?php }?>
    </div>
 

     
   <div class="community">
      community 
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