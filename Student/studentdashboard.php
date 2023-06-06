<?php 
include '../sessiondeleting.php'; 

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

    <style>
       .right-c{
        position: absolute; 
        left: 9%; 
        width: 89%;  
        padding: 15px 10px 10px 10px;
        height: 100vh; 
        overflow-y: scroll; /* enable vertical scrolling */
        background-color: #FAFAFA;
        }

        .hide{
            display: none;
        }

        .button-appoint:hover{
          background-color: yellow; 
        }
    </style>

    
</head>
<body style=" padding: 0; ">

<div class="dashboard-container">

   <?php include "../headerdashboard.php"; 
   
         include 'menudashboard.php'; 
   ?>


<div class="right-c"> <!-- start of right --> 


<div id="snapshot"> <!-- start of snapshot --> 

    <div class="profile" style=" font-size: 88%;">
      
        <p style="margin-bottom:0px; color: brown;">Your Profile</p>
            <img src="../Images/user-icon.jpg" alt="">
            <p style="margin-bottom:0px;"><?php echo $_SESSION['name']; ?></p>
            <p style="margin-top:5px; color: gray; font-size: 85%;">Student</p>

            <div style="text-align:center; line-height: 1.8;">
                <div>Appointments: <?php echo $totalAppointments; ?></div>
                <span> </span>
                <div>Goals: <?php echo $totalGoals; ?></div>
            </div>
          <div class="complete">
            <button><a href="../Backend/editprofile.php" style="color: white;">Manage Your Profile</a></button>
          </div>
    </div><!-- end of profile --> 

    <div class="appointment"> <!-- start of appointment--> 
  <p style="font-size: 88%; font-weight: bolder; color: brown; margin-bottom: 10px;">Manage Appointments</p>

  <?php if ($result2->num_rows == 0){?>
    <div class="division one">
      <div class="none">

        <p><span style="color: brown; font-size: 35px;">Nothing to see yet ...</span> <br>
        Let's get started! You're one step closer to feeling better &#129315 <br>
        Book an appointment now and
        <span style="color: brown; text-decoration: underline;">take the first step </span> towards a happier, healthier you! 🌟 
        </p>

        <button><a href="../Appointment/appointment.php" style="color: white; font-size: 110%;">Book an Appointment</a></button>
      </div>
    </div> 
  <?php }?>

  <?php  if ($result2->num_rows == 1) {?>
    <div class="division-two"> 
      <div class="appointment-card">
        <div class="details">
          <p style="color: red;">!! APPOINTMENT REQUEST SENT !!</p>
          <p> &#10013 CUEA Counseling Department &#10013</p>
          <p>&#9410 <?php echo $cName;?></p>
          <p>&#9202 <?php echo $appointment_details?></p>
          <p>&#10084 For <?php echo $_SESSION["name"]?></p>
          <p> 
          <button style="color: red;
          text-decoration: underline;
          background-color: transparent;
          border: none;
          cursor: pointer;"onclick="toggleForm(<?php echo $appointment_id; ?>)">Cancel Appointment</button>

                <form id="cancelForm" action="" method="POST" style="display: none; width: 65%; max-height: 30vh; background-color: white; line-height: 2; ">
                  <label for="reason">Reason for Cancelation:</label><br>
                  <select name="reason" id="reason">
                    <option value="unforeseen_circumstances">Unforeseen Circumstances</option>
                    <option value="schedule_conflict">Schedule Conflict</option>
                    <option value="medical_emergency">Medical Emergency</option>
                    <option value="other">Other</option>
                  </select><br>
                  <label for="other_reason">Other Reason:</label><br>
                  <textarea name="other_reason" id="other_reason" rows="3" cols="25" placeholder="Please specify if you selected 'Other'"></textarea><br>
                  <input type="hidden" name="student_id" id="student_id" value="<?php echo $id;?>">
                  <input type="hidden" name="appointment_id" id="appointment_id" value="">
                  <input type="submit" value="Submit" onclick="return confirm('Are you sure you want to cancel the appointment?');">
                </form>

                
                <script>
                  function toggleForm(appointmentId) {
                    var form = document.getElementById("cancelForm");
                    var formAction = "../Appointment/deleteappointment.php?id=" + appointmentId;
                    form.action = formAction;
                    
                    if (form.style.display === "none") {
                      form.style.display = "block";
                      document.getElementById("appointment_id").value = appointmentId;
                    } else {
                      form.style.display = "none";
                      document.getElementById("appointment_id").value = "";
                    }
                  }
                </script>

 
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
             ><a href="#goals">Manage Goals</a></button>
                              
            </div> <!--end of manage goals-->

            <div class="readPsych" style ="height: 25vh; background-color:white;
              padding: 10px;margin-top: 10px; display: flex; flex-direction: column; justify-content: end; ">
                <p style="line-height: 1.5rem; font-size: 80%;" >Equip yourself with knowledge on mental health!! Click to Open 
                <span style ="
              padding: 10px; background-color: #00A86B;"> <a href="https://psychcentral.com/" 
                style="text-decoration: none; font-size: 20px; "> &#10145;</a></span>
              </p>
              
            </div>
</div>
        
</div> <!-- end of snapshot-->


    <div id="goals">
      <?php include 'function_goals.php'; ?>
    </div>



   <div id ="appointments">
    <h2 style="text-align: center;" >Appointments</h2>
        
              <label for="status">Status:</label>
              <select id="status" name="status" style= "padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                  <option value="">-- Select --</option>
                  <option value="pending">pending</option>
                  <option value="confirmed">confirmed</option>
                  <option value="canceled">canceled</option>
                  <option value="overdue">overdue</option>
              </select>
             
        <?php 
      $stmt = $conn->prepare("SELECT * FROM appointments WHERE student_id = ? ORDER BY created_at DESC");
      $stmt->bind_param('i', $id);              
      $stmt->execute();
      $result = $stmt->get_result();
    ?>

<table id ="myTable" class="table" style="min-width: 100%;">
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
              <td style='color:blue;'>" .$row["status"]. "</td></tr>";
      } ?>
    </tbody>
  <?php } else {
    // Check if there were no rows returned from the query
    echo "<tr><td colspan='10' style='text-align:center; font-size: 24px; color: red;'> <br>
      No pending appointments. Book an appointment now!</td></tr>";
  } ?>
</table>
   </div>


   <div id="notes" style="margin-top: 10px; min-height: 50vh; box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;">
    <h2>Notes</h2>
    <?php
    // Query the notes table for the student's notes and counselor's name
    $sql = "SELECT n.*, c.name AS counselor_name
            FROM notes AS n
            INNER JOIN counselors AS c ON n.counselor_id = c.counselor_id
            WHERE n.student_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo '<table style="width: 80%;margin:auto; border-collapse: collapse;">';
      echo '<tr><th style="padding: 8px; text-align: left;">Counselor Name</th><th style="padding: 8px; text-align: left;">Notes</th></tr>';

      while ($note = $result->fetch_assoc()) {
          echo '<tr>';
          echo '<td style="padding: 8px;">' . $note["counselor_name"] . '</td>';
          echo '<td style="padding: 8px;"><a href="#" onclick="showNoteContent(' . $note["note_id"] . ')" style="color: blue; text-decoration: underline; cursor: pointer;">View Notes</a></td>';
          echo '</tr>';
          echo '<tr id="note_content_' . $note["note_id"] . '" style="display: none;">';
          echo '<td colspan="2">';
          echo '<label>Title:</label>';
          echo '<textarea name="title" readonly style="width: 100%; resize: none; margin-bottom: 8px;">' . $note["title"] . '</textarea>';
          echo '<label>Content:</label>';
          echo '<textarea rows="10" cols="40" name="content" readonly style="width: 100%; resize: vertical;">' . $note["content"] . '</textarea>';
          echo '</td>';
          echo '</tr>';
      }

        echo '</table>';
    } else {
        echo '<div style="height: 30vh; width: 100%; display: flex; justify-content: center; align-items: center;">
                <p style="text-align: center;">No notes found. <br>
                Please book and attend a counseling session to get notes</p>
              </div>';
    }
    ?>
</div>

<script>
    function showNoteContent(noteId) {
        var noteContent = document.getElementById("note_content_" + noteId);
        if (noteContent.style.display === "none") {
            noteContent.style.display = "table-row";
        } else {
            noteContent.style.display = "none";
        }
    }
</script>



   <div id="articles">
      <?php include 'articles.php';?>
   </div>


   <div id="support">
      <?php include 'support.php';?>
   </div>

   <div id="notificationList" class="notification-list">

    <div class="header" 
        style="display: flex;
        justify-content: center;
        border-bottom:2px solid whitesmoke;">
        <h3>Notifications</h3>
        
    </div>


  <?php include '../Counselor/notifications.php';?>    

</div>


</div>

 
<script>

  function confirmCancel(){
    var confirmation = confirm("Are you sure you want to cancel the appointment?");
    return confirmation;
  }

    const statusDropdown = document.getElementById('status');
    const table = document.getElementById('myTable');
    const rows = table.getElementsByTagName('tr');

    function filterTable() {
    
    const statusValue = statusDropdown.value.toUpperCase();

    for (let i = 1; i < rows.length; i++) {
        const status = rows[i].getElementsByTagName('td')[3].textContent.toUpperCase();
 
        if (status === statusValue || statusValue === '') {
        rows[i].style.display = '';
       
        } else {
        rows[i].style.display = 'none';
       
        }
    }
    }
    statusDropdown.addEventListener('change', filterTable);

    



</script>

</body>
</html>