<link rel="stylesheet" href="../CSS/style.css">

<style>
  #rescheduleForm{
    min-height: 550px; 
    width: 400px; 
    border-radius: 6px;
    margin: 25px auto ; 
    box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
    padding: 25px; 
    padding-top: 5px; 
  }

  input, select, textarea{
    width: 100%;  
    padding-top: 22px; 
    margin: 10px 0px; 
    border: none; 
    outline: none;
    border: 1px solid black; 
    border-radius: 6px;
  }
  input[type="radio"]{
    height: 10px;
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
  <input type="date" name="new_date" id="new_date"><br><br>

  <label for="new_time">New Time:</label><br><br>
  <?php 
  include '../Backend/db.php';
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

  <label for="reason">Reason for Rescheduling</label> <br>
  <select name="reason" id="reason">
    <option value="unforeseen_circumstances">Unforeseen Circumstances</option>
    <option value="schedule_conflict">Schedule Conflict</option>
    <option value="medical_emergency">Medical Emergency</option>
    <option value="other">Other</option>
  </select><br>

  <textarea name="other_reason" id="other_reason" style="display: none;" rows="2" cols="25" placeholder="Please specify if you selected 'Other'"></textarea><br>
  
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
  $startTime = $_POST["select"]; 
  $reason = $_POST["reason"]; 

  if ($_POST["other_reason"]){
    $reason = $_POST["reason"]; 
  }
  

  // Retrieve the student ID and current appointment details
  $stmt = $conn->prepare("SELECT student_id FROM appointments WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $stmt->close();

  $student_id = $row["student_id"];
  

  // Compose the notification message
  $message = "Your appointment has been rescheduled to $new_date at $new_time.";

  // Insert the notification for the student
  // Insert the notification for the student
  $stmt = $conn->prepare("INSERT INTO notifications (recipient_id, sender_id, recipient_role, sender_role, notification_type, message) 
  VALUES (?, ?, ?, ?, ?, ?)");

  $recipient_role = 'student';
  $sender_role = 'counselor';
  $type = 'appointment_reschedule';

  $stmt->bind_param("iissss", $student_id, $counselor_id, $recipient_role, $sender_role, $type, $message);
  $stmt->execute();
  $stmt->close();


    // Reschedule the appointment to the new date and time
    $stmt = $conn->prepare("UPDATE appointments SET date = ?, start_time = ?, status = 'rescheduled' WHERE id = ?");
    $stmt->bind_param("ssi", $new_date, $new_time, $id);
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
<script>
  // Get references to the select and textarea elements
const reasonSelect = document.getElementById("reason");
const otherReasonTextarea = document.getElementById("other_reason");

// Add event listener to the select element
reasonSelect.addEventListener("change", function() {
  // Check if "other" option is selected
  if (reasonSelect.value === "other") {
    otherReasonTextarea.style.display = "block"; // Show the textarea
  } else {
    otherReasonTextarea.style.display = "none"; // Hide the textarea
  }
});

document.getElementById("rescheduleForm").addEventListener("submit", function(event) {
  // Prevent form submission if validations fail
  event.preventDefault();

  // Validate date selection
  const dateInput = document.getElementById("new_date");
  const selectedDate = new Date(dateInput.value);

  // Check if a date is selected
  if (!dateInput.value) {
    alert("Please select a date.");
    return;
  }

  // Check if the selected date is on a weekend
  if (selectedDate.getDay() === 0 || selectedDate.getDay() === 6) {
    alert("Please select a date that is not on a weekend.");
    return;
  }

  // Check if the selected date has passed
  const today = new Date();
  if (selectedDate < today) {
    alert("Please select a future date.");
    return;
  }

  // Validate time slot selection
  const timeSlots = document.querySelectorAll('input[name="select"]');
  let isTimeSlotSelected = false;

  // Check if at least one time slot is selected
  timeSlots.forEach(function(slot) {
    if (slot.checked) {
      isTimeSlotSelected = true;
      return;
    }
  });

  if (!isTimeSlotSelected) {
    alert("Please select a time slot.");
    return;
  }

  // Submit the form if validations pass
  this.submit();
});


</script>