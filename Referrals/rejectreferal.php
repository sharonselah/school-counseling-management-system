<?php 
include '../Backend/db.php'; 

$referral_id = $_GET['id'];

$accept = FALSE; 

$stmt = $conn-> prepare ("UPDATE referrals SET Accept = ? where id =? "); 
$stmt->bind_param ('si', $accept, $referral_id); 

if ($stmt-> execute()){
    header("Location:../counselordashboard.php "); 
    exit(); 
}




