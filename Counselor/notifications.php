<style>
  .notification{
    background-color: #E5E4E2;
    border-radius: 8px; 
    padding: 3px 10px; 
    color: #7393B3;
    margin: 5px 0px; 
  }

  .notification button{
    background-color: blue;
    border: none;
    border-radius: 5px; 
    padding: 5px;
    margin-left: 65%;
    margin-bottom: 3px;
  }

  .notification button a{
    color: white;
    text-decoration: none;
  }
</style>

<?php

include '../Backend/db.php';

// Retrieve notifications for the counselor from the database

$query = "SELECT * FROM notifications WHERE recipient_id = $id AND is_read = 0 ORDER BY created_at DESC LIMIT 20";

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
    //diff() method of the DateTime class to calculate the difference between two DateTime objects.
    $timeDifference = $currentDateTime->diff($createdTime);
    //The h property holds the number of hours in the time difference between the two DateTime objects. 
    $hoursDifference = $timeDifference->h + ($timeDifference->days * 24);;


   
    // Display the notification on the counselor's dashboard based on the notification type
    echo "<div class='notification'>";
             
    // Add specific actions based on the notification type
    switch ($notificationType) {
      case 'appointment_request':
        echo "
              <p>$message</p>
              <p>$hoursDifference hours ago</p>
              <button><a href='markasread.php?id=$rowId'>Mark as Read</a></button>
              ";

        break;
        
      case 'appointment_cancel':
        echo "<p>$message</p>
              <p>$hoursDifference  hours ago</p>
              <button><a href='markasread.php?id=$rowId'>Mark as Read</a></button>";
        break;
      case 'appointment_reschedule':
          echo "<p>$message</p>
                <p>$hoursDifference hours ago</p>
                <button><a href='markasread.php?id=$rowId'>Mark as Read</a></button>";
          break;
        
      case 'referral_accept':
          echo "<p>$message</p>
          <p>$hoursDifference hours ago</p>
          <button><a href='markasread.php?id=$rowId'>Mark as Read</a></button>";
          break;
      case 'referal_reject':
          echo "<p>$message</p>
          <p>$hoursDifference hours ago</p>
          <button><a href='markasread.php?id=$rowId'>Mark as Read</a></button>";
          break;
      case 'review':
          echo "<p>$message</p>
          <p>$hoursDifference hours ago</p>
          <button><a href='markasread.php?id=$rowId'>Mark as Read</a></button>";
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

