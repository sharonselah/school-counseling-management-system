<?php 

include 'functions.php'; 


if (isset($_GET['voted'])) {
  if ($_GET['voted'] === 'success') {
    $message = 'You have voted successfully';
  } else if ($_GET['voted'] === 'failure') {
    $message = 'You have voted today. Try again tomorrow!';
  }else if ($_GET['voted']=== 'maximum'){
    $message = 'You can only set 3 goals per week. Please try again later.';
  }else if ($_GET['voted']== 'true'){
    $message = 'You have added a goal successfully'; 
  }
  echo '<script>alert("' . $message . '");</script>';
  unset($_GET['voted']);
  header("Refresh:0; studentdashboard.php"); //refresh the current page 
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <title>Student Dashboard</title>

    
</head>
<body style=" padding: 0; ">

<div class="dashboard-container">

   <?php include "../headerdashboard.php"; 
   
         include 'menudashboard.php'; 
   ?>


<div class="right"> <!-- start of right --> 


<div id="snapshot"> <!-- start of snapshot --> 

    <div class="profile" style=" font-size: 88%;">
      
        <p style="margin-bottom:0px; color: brown;">Your Profile</p>
            <img src="../Images/user-icon.jpg" alt="">
            <p style="margin-bottom:0px;"><?php echo $_SESSION['name']; ?></p>
            <p style="margin-top:5px; color: gray;">Student</p>

            <div style="text-align:center;">
                <div>Appointments: <?php echo $result2->num_rows; ?></div>
                <span> </span>
                <div>Goals: <?php echo $totalGoals; ?></div>
            </div>
          <div class="complete">
            <button><a href="../Backend/editprofile.php" style="color: white;">Manage Your Profile</a></button>
          </div>
    </div><!-- end of profile --> 

    <div class="appointment"> <!-- start of appointment--> 
  <p style="font-size: 88%; font-weight: bolder; color: brown;">Manage Appointments</p>

  <?php if ($result2->num_rows == 0){?>
    <div class="division one">
      <div class="none">

        <p><span style="color: brown; font-size: 35px;">Nothing to see yet ...</span> <br>
        Let's get started! You're one step closer to feeling better &#129315 <br>
        Book an appointment now and
        <span style="color: brown; text-decoration: underline;">take the first step </span> towards a happier, healthier you! 🌟 
        </p>

        <button><a href="appointment2.php" style="color: white; font-size: 110%;">Book an Appointment</a></button>
      </div>
    </div> 
  <?php }?>

  <?php  if ($result2->num_rows == 1) {?>
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

        <div class="confirm"> 
          <?php if ($status == "pending"){?>
            <p>&#128284 <span style="font-weight:bold;">Appointment request sent</span> <br>It will be confirmed soon by the therapist</p>
          <?php } else if ($status== "confirmed"){?>
            <p>&#128394 <span style="font-weight:bold; color: green; ">Appointment confirmed</span> </p>
          <?php }else {?>
            <p>&#10060 <span style="font-weight:bold;color: red; ">Appointment canceled</p>
          <?php }?>
        </div>
      </div>
    </div> 
  <?php }?>
</div> <!-- end of appointment -->










<div class="goal_manage" style="width: 22%;"> <!-- start of goal-->

<div class="managegoals" 
                style=" height: 42vh; background-color: #F5F5F5; 
                border-radius: 10px; padding: 10px; display: flex; flex-direction: column; justify-content: space-between; ">

                <p style="margin-top: 15%; line-height: 3rem; font-size: 90%; ">"&#127919 Setting goals is the first step in turning the invisible into the visible 
                &#128640."</p>

                <button 
                style="
                background-color: #EECBB9; 
                width: 100%; padding: 12px 15px;
                border-radius: 10px;border:none; cursor:pointer; "><a href="#goals">Manage Goals</a></button>
                              
            </div> <!--end of manage goals-->

            <div class="readPsych" style ="height: 25vh; background-color:white;
              padding: 10px;margin-top: 10px; display: flex; flex-direction: column; justify-content: end; ">
                <p style="line-height: 1.5rem; font-size: 80%;" >Equip yourself with knowledge on mental health!! Click to Open 
                <span style ="
              padding: 10px; background-color: #EECBB9;"> <a href="https://psychcentral.com/" 
                style="text-decoration: none; font-size: 20px; "> &#10145;</a></span>
              </p>
              
            </div>
</div>
        
</div> <!-- end of snapshot-->

 
 
  

<div id="goals">
  <?php include 'function_goals.php'; ?>
</div>

   <div id ="appointments">
        <form method="post" action="" >
              <label for="status">Status:</label>
              <select id="status" name="status" style= "padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                <option value="">-- Select --</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="cancelled">Cancelled</option>
              </select>
              <button type="submit" name="Filter" style="
                padding: 5px 10px;
                border-radius: 5px;
                border: none;
                background-color: gray;
                color: #fff;
              " >Filter</button>
        </form>
        <?php 


if (isset($_POST['Filter'])) {
  $status = $_POST['status'];
  if (!empty($status)) {
    $stmt = $conn->prepare("SELECT * FROM appointments WHERE student_id = ? AND status = ? ORDER BY created_at DESC");
    $stmt->bind_param('is', $id, $status);
  } else {
    $stmt = $conn->prepare("SELECT * FROM appointments WHERE student_id = ? ORDER BY created_at DESC");
    $stmt->bind_param('i', $id);
  }
} else {
  $stmt = $conn->prepare("SELECT * FROM appointments WHERE student_id = ? ORDER BY created_at DESC");
  $stmt->bind_param('i', $id);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<table class="table" style="min-width: 100%;">
  <thead>
    <tr>
      <th>Counselor Name</th>
      <th>Date</th>
      <th>Start Time</th>
      <th>Status</th>
    </tr>
  </thead>
  <?php if ($result->num_rows > 0) { ?>
    <tbody>
      <?php while ($row = $result->fetch_assoc()) {
        // checking status
        $appointment_date_time = $row['date'];
        $current_date = date("Y-m-d");
        $counselor_id = $row["counselor_id"]; 
        $stmt2 = $conn->prepare ("SELECT name from counselors where counselor_id = $counselor_id"); 
        $stmt2-> execute(); 
        $result2 = $stmt2->get_result(); 
        $counselor =$result2-> fetch_assoc(); 
        // Full name of the day of the week; Day of the month; abb name of the month
        $row['date'] = date_format(date_create($row['date']), 'l j M');
        echo "<tr><td>" . $counselor["name"] . "</td><td>" . $row["date"] . "</td><td>" . $row["start_time"] . "</td>
              <td style='color:blue;'> " . $row["status"] . "</td></tr>";
      } ?>
    </tbody>
  <?php } else {
    // Check if there were no rows returned from the query
    echo "<tr><td colspan='10' style='text-align:center; font-size: 24px; color: red;'> <br>
      No pending appointments. Book an appointment now!</td></tr>";
  } ?>
</table>
   </div>

   <div id="articles">
      <?php include 'articles.php';?>
   </div>

   <div id="support">
      <?php include 'support.php';?>
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