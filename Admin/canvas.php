<?php
//setting header to json
header('Content-Type: application/json');

include ('../Backend/db.php');

$start_date = '2023-01-01';
$end_date = '2023-12-31';

//GROUP BY -groups rows that have similar values into summary rows
$sql = "SELECT status, COUNT(*) AS appointment_count
        FROM appointments
        WHERE date BETWEEN '$start_date' AND '$end_date'
        GROUP BY status";


$result = $conn->query($sql); 

/*

create an empty array called data that will be used to store the data

Note: while $result is also technically an array, it may have an inconsistent 
      structure. Therefore, we need a php array to enforce constitency
*/
$data = array();

//loop through array
foreach ($result as $row) {
  $data[] = $row;
}

//convert the array into json 
print json_encode($data);

?>

