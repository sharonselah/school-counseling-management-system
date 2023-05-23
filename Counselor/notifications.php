<?php

// Retrieve notifications for the counselor from the database

$query = "SELECT * FROM notifications WHERE recipient_id = $id";

$result = mysqli_query($conn, $query);

// Check if there are any notifications
if (mysqli_num_rows($result) > 0) {
  // Loop through each notification
  while ($row = mysqli_fetch_assoc($result)) {
    $notificationType = $row['notification_type'];
    $message = $row['message'];
    $sender = $row['sender_id'];

    
    $createdTime = new DateTime($row['created_at']);
    $currentDateTime = new DateTime();
    $timeDifference = $currentDateTime->diff($createdTime);
    $hoursDifference = $timeDifference->h;


    // Display the notification on the counselor's dashboard based on the notification type
    echo "<div class='notification'>";
             
    // Add specific actions based on the notification type
    switch ($notificationType) {
      case 'appointment_request':
        echo "
              <p>$message</p>
              <p>$hoursDifference  hours </p>
              <button onclick='confirmAppointment({$row['id']})'>Confirm</button>
              <button onclick='cancelAppointment({$row['id']})'>Cancel</button>";
        break;
        
      case 'cancel':
        $studentName = $row['student_name'];
        echo "<p>Student: $studentName</p>
              <button onclick='rescheduleAppointment({$row['id']})'>Reschedule</button>";
        break;
        
      case 'referral_accept':
        $referringCounselor = $row['referring_counselor'];
        echo "<p>Referring Counselor: $referringCounselor</p>
              <button onclick='acceptReferral({$row['referral_id']})'>Accept</button>
              <button onclick='rejectReferral({$row['referral_id']})'>Reject</button>";
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
}
