<input type="search" style="margin: 0;"class ="search_inline" name="search" id="searchStudents" placeholder="search anything">
<!-- Students -->

<?php

// Query to retrieve student data, appointment count, and goal progress
$sql = "SELECT s.name AS student_name, s.email, COUNT(a.id) AS appointment_count
        FROM students AS s
        LEFT JOIN appointments AS a ON s.student_id = a.student_id
        GROUP BY s.student_id
        ORDER BY student_name ASC";

$result = $conn->query($sql);

// Check if there are any students
if ($result->num_rows > 0) {
    echo "<p style='font-weight: bold; margin-left: 14%;'>Total Number of Students: $result->num_rows </p>";
    
    // Output table headers
    echo "<table id ='tableStudents' class='table'>
            <tr>
                <th>Student Name</th>
                <th>Email</th>
                <th>Appointment Count 
                    <span id='sortDown'>&#9660;</span>
                    <span id='sortUp'>&#9650;</span>
                </th>
            </tr>";

    // Output each student row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['student_name'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['appointment_count'] . "</td>
             
              </tr>";
    }

    echo "</table>";
} else {
    echo "No students found.";
}

?>