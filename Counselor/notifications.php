<style>
  .notification{
    background-color: #E5E4E2;
    border-radius: 8px; 
    padding: 3px 10px; 
    color: #7393B3;
    margin: 5px 0px; 
  }
</style>


<?php

// Retrieve notifications for the counselor from the database

$query = "SELECT * FROM notifications WHERE recipient_id = $id ORDER BY created_at DESC LIMIT 20";

$result = mysqli_query($conn, $query);

// Check if there are any notifications
if (mysqli_num_rows($result) > 0) {
  // Loop through each notification
  while ($row = mysqli_fetch_assoc($result)) {
    $notificationType = $row['notification_type'];
    $message = $row['message'];
    $sender = $row['sender_id'];
    $rowId = $row["id"];

    
    $createdTime = new DateTime($row['created_at']);
    $currentDateTime = new DateTime();
    $timeDifference = $currentDateTime->diff($createdTime);
    $hoursDifference = $timeDifference->h;


   
    // Display the notification on the counselor's dashboard based on the notification type
    echo "<div class='notification' onclick='markasRead(this)'>";
             
    // Add specific actions based on the notification type
    switch ($notificationType) {
      case 'appointment_request':
        echo "
              <p>$message</p>
              <p>$hoursDifference hours ago</p>";

        break;
        
      case 'appointment_cancel':
        echo "<p>$message</p>
              <p>$hoursDifference  hours ago</p>";
        break;
      case 'appointment_reschedule':
          echo "<p>$message</p>
                <p>$hoursDifference hours ago</p>";
          break;
        
      case 'referral_accept':
          echo "<p>$message</p>
          <p>$hoursDifference hours ago</p>";
          break;
      case 'referal_reject':
          echo "<p>$message</p>
          <p>$hoursDifference hours ago</p>";
          break;
      case 'review':
          echo "<p>$message</p>
          <p>$hoursDifference hours ago</p>";
          break;
      // Add more cases for other notification types
      default:
        // Default case for unrecognized notification types
        echo "<p>$message</p>";
        break;
    }
    
    echo "</div>";
   
  }
} else {
  // No notifications found
  echo "<p>No notifications at the moment.</p>";
}?>

<script>

  function markasRead(notification){

    notification.style.backgroundColor = 'white'; 
    notification.style.color='black';
    notification.style.border ="1px solid black";
  }
</script>