<form id="rescheduleForm" action="reschedule.php" method="POST">
  <label for="new_date">New Date:</label>
  <input type="date" name="new_date" id="new_date" required><br>

  <label for="new_time">New Time:</label>
  <input type="time" name="new_time" id="new_time" required><br>

  <input type="hidden" name="appointment_id" value="<?php echo $_GET['id']; ?>">
  <input type="submit" value="Reschedule Appointment">
</form>

<?php
// Connect to the database and retrieve the appointment ID from the URL parameter
include '../Backend/db.php';
$id = $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Get the new date and time from the form submission
  $new_date = $_POST["new_date"];
  $new_time = $_POST["new_time"];

  // Reschedule the appointment to the new date and time
  $stmt = $conn->prepare("UPDATE appointments SET date = ?, start_time = ? WHERE id = ?");
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
  $stmt->bind_param("iis", $student_id, $id, $message);
  $stmt->execute();
  $stmt->close();

  // Redirect back to the counselor dashboard
  header("Location: ../Counselor/counselordashboard.php");
  exit();
}

$conn->close();
?>
