

<form method = "GET" action="admindashboard.php">
    <input type="hidden" name="page" value="referrals.php">
    <input type="text" name="search" placeholder="Search by Anything">
    <input type="submit" value="Search">
</form> 

<?php


// Query to retrieve referral data
$sql = "SELECT r.id, c1.name AS referring_therapist, c2.name AS receiving_therapist, s.name AS student_name, r.date, r.reason, r.Accept
        FROM referrals AS r
        INNER JOIN counselors AS c1 ON r.referring_therapist_id = c1.counselor_id
        INNER JOIN counselors AS c2 ON r.receiving_therapist_id = c2.counselor_id
        INNER JOIN students AS s ON r.student_id = s.student_id";

if (isset($_GET['search']) && $_GET['search']!= ''){
    $searchTerm = $_GET['search'];
    $sql .= " WHERE c2.name LIKE '%$searchTerm%' OR c1.name LIKE '%$searchTerm%' OR s.name LIKE '%$searchTerm%' OR r.reason LIKE '%$searchTerm%'";

}

$result = $conn->query($sql);

// Check if there are any referrals
if ($result->num_rows > 0) {
    // Output table headers
    echo "<table id ='tableReferrals' class='table' style='width: 100%; text-align:left;'>
            <tr>
                <th>Number</th>
                <th>Referring Therapist</th>
                <th>Receiving Therapist</th>
                <th>Student Name</th>
                <th>Reason</th>
                <th>Date</th>
                <th>Acceptance Status</th>
            </tr>";

    // Output each referral row
    $count = 1; 
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td> $count </td>
                <td>" . $row['referring_therapist'] . "</td>
                <td>" . $row['receiving_therapist'] . "</td>
                <td>" . $row['student_name'] . "</td>
                <td>" . $row['reason'] . "</td>
                <td>" . $row['date'] . "</td>
                <td>" . $row['Accept'] . "</td>
              </tr>";
              $count++;
    }

    echo "</table>";
} else {
    echo "No referrals found.";
}


?>