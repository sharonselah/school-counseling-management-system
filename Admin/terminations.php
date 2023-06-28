<?php 

$sql = "SELECT c.name, c.email, t.termination_date, t.termination_reason
FROM counselors AS c
INNER JOIN counselor_terminations AS t ON c.counselor_id = t.counselor_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
echo "<table class='table'>
    <thead>
        <tr>
            <th>Counselor Name</th>
            <th>Email</th>
            <th>Termination Date</th>
            <th>Termination Reason</th>
        </tr>
    </thead>
    <tbody>";

while ($row = $result->fetch_assoc()) {
echo "<tr>
        <td>" . $row['name'] . "</td>
        <td>" . $row['email'] . "</td>
        <td>" . $row['termination_date'] . "</td>
        <td>" . $row['termination_reason'] . "</td>
      </tr>";
}

echo "</tbody></table>";
} else {
echo "No terminated counselors found.";
}


?>