<?php
    
// Specify the time frame for the report
$start_date = '2023-01-01';
$end_date = '2023-12-31';


$sql = "SELECT status, COUNT(*) AS appointment_count
        FROM appointments
        WHERE date BETWEEN '$start_date' AND '$end_date'
        GROUP BY status";

$result = $conn->query($sql); 
?>



<table class='table'>
        <thead>
            <tr>
                <th>Status</th>
                <th>Appointment Count</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there is appointment data
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['status'] . "</td>
                            <td>" . $row['appointment_count'] . "</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No appointment data available</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
   
    <?php
        include 'draw.php'; 
    ?>