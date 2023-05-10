<?php 

include 'db.php'; 
session_start(); 
$id= $_SESSION["user_id"]; 

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $status = $_POST['status'];

    $stmt = $conn->prepare("SELECT * FROM appointments 
    WHERE student_id = ? AND status = ?
    ORDER BY created_at DESC"); 
    $stmt->bind_param("is", $id, $status);
    $stmt->execute();
    $result = $stmt->get_result(); 
    


// Display the filtered appointments
if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()) { ?>
      <table>
  <thead>
    <tr>
      <th>Date</th>
      <th>Start Time</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
      <tr>
        <td><?php echo $row["date"]; ?></td>
        <td><?php echo $row["start_time"]; ?></td>
        <td><?php echo $row["status"]; ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table><?php

} }else {
  echo "No appointments found.";
} 


// Close the database connection
$conn->close();
?>



