<style>
  #rescheduleForm{
    height: 500px; 
    width: 400px; 
    border-radius: 6px;
    margin: 25px auto ; 
    box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
    padding: 25px; 
    padding-top: 5px; 
  }

  input, select, textarea{
    width: 100%;  
    padding-top: 32px; 
    margin: 10px 0px; 
    border: none; 
    outline: none;
    border: 1px solid black; 
    border-radius: 6px;
  }

  h3{
    text-align: center;
  }

  div{
    display: flex;
    justify-content: center;
  }
  button{
    background-color: gray; 
    height: 45px;
    border: none; 
    outline: none;
    border: 1px solid gray; 
    border-radius: 6px; 
    margin-top: 20px;
    color: white;
 }

 button:hover{
  background-color: black;
 }

  
</style>


<form id="rescheduleForm" action="" method="POST">

  <h3>Reschedule Appointment</h3>
  <label for="new_date">New Date:</label>
  <input type="date" name="new_date" id="new_date" required><br><br>

  <label for="new_time">New Time:</label>
  <input type="time" name="new_time" id="new_time" required><br><br>

  <label for="reason">Reason</label> <br>
  <select name="reason" id="reason">
    <option value="unforeseen_circumstances">Unforeseen Circumstances</option>
    <option value="schedule_conflict">Schedule Conflict</option>
    <option value="medical_emergency">Medical Emergency</option>
    <option value="other">Other</option>
  </select><br>

  <label for="other_reason">Other Reason:</label><br>
  <textarea name="other_reason" id="other_reason" rows="3" cols="25" placeholder="Please specify if you selected 'Other'"></textarea><br>
  <input type="hidden" name="student_id" id="student_id" value="<?php echo $id;?>">

  <input type="hidden" name="appointment_id" value="<?php echo $_GET['id']; ?>">
  <div>
    <button>Reschedule Appointment</button>
  </div>
 
</form>

<?php
// Connect to the database and retrieve the appointment ID from the URL parameter
include '../Backend/db.php';
$id = $_GET["id"];

//counselor _id 
session_start();
$counselor_id = $_SESSION['user_id']; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Get the new date and time from the form submission
  $new_date = $_POST["new_date"];
  $new_time = $_POST["new_time"];
  $reason = $_POST["reason"]; 

  if ($_POST["other_reason"]){
    $reason = $_POST["reason"]; 
  }
  
  // Reschedule the appointment to the new date and time
  $stmt = $conn->prepare("UPDATE appointments SET date = ?, start_time = ?, status = 'rescheduled' WHERE id = ?");
  $stmt->bind_param("ssi", $new_date, $new_time, $id);
  $stmt->execute();
  $stmt->close();

 

  // Retrieve the student ID and current appointment details
  $stmt = $conn->prepare("SELECT student_id, date, start_time FROM appointments WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $stmt->close();

  $student_id = $row["student_id"];
  $current_date = $row["date"];
  $current_time = $row["start_time"];

  // Compose the notification message
  $message = "Your appointment has been rescheduled from $current_date at $current_time to $new_date at $new_time.";

  // Insert the notification for the student
  $stmt = $conn->prepare("INSERT INTO notifications (recipient_id, sender_id, notification_type, message) 
                          VALUES (?, ?, 'appointment_reschedule', ?)");
  $stmt->bind_param("iis", $student_id, $counselor_id, $message);
  $stmt->execute();
  $stmt->close();

   //Fill the rescheduling table 
   $stmt = $conn->prepare ("INSERT INTO rescheduling (appointment_id, counselor_id, student_id, triggered_by, reason)
   VALUES (?,?,?,?,?)");

   $trigger = 'counselor';

   $stmt->bind_param('iiiss', $id, $counselor_id,$student_id, $trigger, $reason);
   $stmt->execute();
   $stmt->close();



  // Redirect back to the counselor dashboard
  header("Location: ../Counselor/counselordashboard.php");
  exit();
}

$conn->close();
?>
