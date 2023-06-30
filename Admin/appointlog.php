<p style='text-align:center; font-weight:bold;'>Appointment Log</p> <br>
<form method="POST" action="" style="display: flex; align-items: center;">
            <input class ="search_inline" style="margin: 0px; margin-right: 120px; width: 450px;"
            type="search" name="search" id="searchAppointments" 
            placeholder="Search counselor name, date, status, student name, or anything">
           
            <label for="start_date" style="margin-right: 10px;">Start Date:</label>
            <input type="date" name="start_date" id="start_date" style="margin-right: 10px; height: 25px; padding: 3px 15px;"><br>

            <label for="end_date" style="margin-right: 10px;">End Date:</label>
            <input type="date" name="end_date" id="end_date" style="margin-right: 10px; height: 25px; padding: 3px 15px;"><br>

            <input style ="height: 33px; padding: 3px 20px; "type="submit" value="Search">
        

           
        </form>

       <?php 
        // Specify the time frame for the report (replace with your desired start and end dates)
        $default_start_date = '2023-01-01';
        $default_end_date = '2023-12-31';

        // Retrieve the start date and end date from the form submission
        $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : $default_start_date;
        $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : $default_end_date;

        // Query to retrieve appointment data within the specified time frame
        $sql = "SELECT a.date, a.start_time, a.end_time, a.status, s.name AS student_name, c.name AS counselor_name
                FROM appointments AS a
                INNER JOIN students AS s ON a.student_id = s.student_id
                INNER JOIN counselors AS c ON a.counselor_id = c.counselor_id
                WHERE a.date BETWEEN '$start_date' AND '$end_date'
                ORDER BY a.date ASC";

        $result = $conn->query($sql);

// Check if there are any appointments
if ($result->num_rows > 0) {
    echo "<p>Total Number of Appointments: $result->num_rows</p>";
    // Output table headers
    echo "<table id ='tableAppointments' class='table' style='width: 100%;'>
            <tr style='text-align: left;'>
                <th>Counselor Name</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>
                <th>Student Name</th>
                
            </tr>";

    // Output each appointment row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['counselor_name'] . "</td>
                <td>" . $row['date'] . "</td>
                <td>" . date('H', strtotime($row['start_time'])) ."</td>
                <td>" . date('H', strtotime($row['end_time'])) ."</td>
                <td>" . $row['status'] . "</td>
                <td>" . $row['student_name'] . "</td>
                
              </tr>";
    }

    echo "</table>";
} else {
    echo "No appointments found.";
}

?>

<script>
    //table Appointments 
      // Get the input element
      var searchAppointments = document.getElementById("searchAppointments");

// Add event listener for input changes
        searchAppointments.addEventListener("input", function() {
        var filter = searchAppointments.value.toUpperCase();
        var tableAppointments = document.getElementById("tableAppointments");
        var rows = tableAppointments.getElementsByTagName("tr");

    // Iterate through each row of the table
    for (var i = 1; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName("td");
        var match = false;

        // Iterate through each cell of the row
        for (var j = 0; j < cells.length; j++) {
            var cell = cells[j];

            // Check if the cell content contains the search keyword
            if (cell.innerHTML.toUpperCase().indexOf(filter) > -1) {
                match = true;
                break;
            }
        }

        // Show/hide the row based on the match
        if (match) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
});

</script>

