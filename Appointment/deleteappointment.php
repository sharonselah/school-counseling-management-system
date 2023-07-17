<?php

include '../Backend/db.php';

session_start();
$name = $_SESSION["name"];
$id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the cancellation form is submitted
    if (isset($_GET['id'])) {
        $student_id = $_POST["student_id"];
        $appointmentId = $_GET['id'];
        $reason = $_POST["reason"];

        if ($reason == "other") {
            $reason = $_POST["other_reason"];
        }

        // Additional validation and processing code here

        // Update the notifications table if the appointment is rescheduled
        $stmt_reschedule = $conn->prepare("UPDATE rescheduling SET accepted = 0 WHERE appointment_id = ?");
        $stmt_reschedule->bind_param("i", $appointmentId);
        $stmt_reschedule->execute();

        // Insert the cancellation record into the database
        $stmt = $conn->prepare("INSERT INTO cancellations (appointment_id, student_id, reason) 
                                VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $appointmentId, $student_id, $reason);

        if ($stmt->execute()) {
            $stmt->close();
            // Update the appointment status in the appointments table
            $stmt2 = $conn->prepare("UPDATE appointments SET status = 'canceled' WHERE id = ?");
            $stmt2->bind_param("i", $appointmentId);

            if ($stmt2->execute()) {
                $stmt2->close();
                $message = "$name has canceled a request";

                $stmt = $conn->prepare("SELECT counselor_id FROM appointments WHERE id = ? LIMIT 1");
                $stmt->bind_param('i', $appointmentId);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $counselor_id = $row["counselor_id"];
                $recipient_id = $counselor_id;

                $recipient_role = 'counselor';
                $sender_role = 'student';

                $query = "INSERT INTO notifications (recipient_id, sender_id, recipient_role, sender_role, notification_type, message) 
                          VALUES (?, ?, ?, ?, 'appointment_cancel', ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('iisss', $recipient_id, $student_id, $recipient_role, $sender_role, $message);
                $stmt->execute();
            }
        }

        // Redirect back to the user list page
        header("Location: ../Student/studentdashboard.php");
        exit();
    }
}


?>

<style>
  #cancelForm{
  margin: 30px auto;
  width: 25%;
  border-radius:10px; 
  box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
  padding: 20px; 
  font-family: 'Times New Roman', Times, serif;
  text-align: center;
}

label, input{
    display: block;
}
</style>


 <form id="cancelForm" action="" method="POST">
    <h2>Cancelation Form</h2>
    <p style="color: red; font-style: italic;">Note: The action cannot be undone</p>
    <label for="reason">Reason for Cancelation:</label><br>
    <select name="reason" id="reason">
      <option value="unforeseen_circumstances">Unforeseen Circumstances</option>
      <option value="schedule_conflict">Schedule Conflict</option>
      <option value="medical_emergency">Medical Emergency</option>
      <option value="other">Other</option>
    </select><br><br>
    <label for="other_reason">Other Reason:</label><br>
    <textarea name="other_reason" id="other_reason" rows="3" cols="35" placeholder="Please specify if you selected 'Other'"></textarea><br>
    <input type="hidden" name="student_id" id="student_id" value="<?php echo $id;?>">
    <input type="submit" value="Submit" style="margin-left:40%; margin-top: 10px;" onclick="return confirm('Are you sure you want to cancel the appointment?');">  
</form>
<div style='text-align: center;'>
    <a href="../Student/studentdashboard.php">Go back to dashboard</a>
</div>

