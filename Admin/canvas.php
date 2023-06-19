<?php
//setting header to json
header('Content-Type: application/json');

include ('../Backend/db.php');

$start_date = '2023-01-01';
$end_date = '2023-12-31';


$sql = "SELECT status, COUNT(*) AS appointment_count
        FROM appointments
        WHERE date BETWEEN '$start_date' AND '$end_date'
        GROUP BY status";

$result = $conn->query($sql); 

//loop through the returned data
$data = array();
foreach ($result as $row) {
  $data[] = $row;
}

//now print the data
print json_encode($data);?>

