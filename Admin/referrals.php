<input style='margin:0px;' type="search" class ="search_inline" name="search" id="searchReferrals" placeholder="search anything">

<?php


// Query to retrieve referral data
$sql = "SELECT r.id, c1.name AS referring_therapist, c2.name AS receiving_therapist, s.name AS student_name, r.date, r.reason, r.Accept
        FROM referrals AS r
        INNER JOIN counselors AS c1 ON r.referring_therapist_id = c1.counselor_id
        INNER JOIN counselors AS c2 ON r.receiving_therapist_id = c2.counselor_id
        INNER JOIN students AS s ON r.student_id = s.student_id
        ORDER BY r.date DESC";

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