<?php 

include '../../Backend/db.php';

$referral_id = $_GET['id'];
$accept = true;

// Update the referral status to "accept" in the database
$stmt = $conn->prepare("UPDATE referrals SET Accept = ? WHERE id = ?");
$stmt->bind_param("si", $accept, $referral_id);
if ($stmt->execute()) {
    // Get the relevant referral information
    $stmt = $conn->prepare("SELECT referring_therapist_id, receiving_therapist_id FROM referrals WHERE id = ?");
    $stmt->bind_param("i", $referral_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $sender_id = $row['referring_therapist_id'];
    $recipient_id = $row['receiving_therapist_id'];

    // Compose the notification message
    $message = "Referral accepted by the counselor.";

    // Insert the notification for the recipient counselor
    $query = "INSERT INTO notifications (recipient_id, sender_id, recipient_role, sender_role, notification_type, message) 
              VALUES (?, ?, ?, ?, 'referral_accept', ?)";
    $stmt = $conn->prepare($query);
    $recipient_role = 'counselor';
    $sender_role = 'counselor';
    $stmt->bind_param("iisss", $recipient_id, $sender_id,  $recipient_role, $sender_role, $message);
    $stmt->execute();

    // Redirect back to the counselor dashboard
    header("Location: ../counselordashboard.php#");
    exit();
} else {
    
    echo "Referral acceptance failed.";
}