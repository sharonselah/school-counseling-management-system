


<p style='text-align:center; font-weight:bold;'>Performance</p>

<form method="POST" action="" style="display: flex; align-items: center; padding-block: 20px;">


    <input style='margin:0px; margin-right: 125px; width: 425px;' class="search_inline" type="search" name="search" id="searchCounselors"
        placeholder="Search counselor name, total count, status, or anything">



            <label for="start_date" style="margin-right: 10px;">Start Date:</label>
            <input type="date" name="start_date" id="start_date" style="margin-right: 10px; height: 25px; padding: 3px 15px;"><br>

            <label for="end_date" style="margin-right: 10px;">End Date:</label>
            <input type="date" name="end_date" id="end_date" style="margin-right: 10px; height: 25px; padding: 3px 15px;"><br>

            <input style ="height: 30px; padding: 3px 20px; "type="submit" value="Search">
         
        </form>

   <?php 
    // Specify the time frame for the report (replace with your desired start and end dates)
    $default_start_date = '2023-01-01';
    $default_end_date = '2023-12-31';

    // Retrieve the start date and end date from the form submission
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : $default_start_date;
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : $default_end_date;
       

    // Query to retrieve counselor data and the count of their appointments within the specified time frame
    $sql = "SELECT c.name AS counselor_name, c.status AS counselor_status, COUNT(a.id) AS total_appointments,
    COUNT(CASE WHEN a.status = 'completed' THEN 1 END) AS completed_appointments
    FROM counselors AS c
    LEFT JOIN appointments AS a ON c.counselor_id = a.counselor_id
    WHERE a.date BETWEEN '$start_date' AND '$end_date'
    GROUP BY c.counselor_id
    ORDER BY c.name ASC";

    $result = $conn->query($sql);

// Check if there are any counselors
if ($result->num_rows > 0) {
    // Output table headers
    echo "<table id ='tableCounselors' class='table'  style='width: 100%; margin: auto;'>
            <tr style='text-align: left;'>
                <th>Counselor Name</th>
                <th>Total Count
                    <span id='sortDowntableCounselors'>&#9660;</span>
                    <span id='sortUptableCounselors'>&#9650;</span>
                </th>
                <th>Completed</th>
                <th>Progress</th>
                <th>Status</th>    
            </tr>";
            $i = 0;
    // Output each counselor row
    while ($row = $result->fetch_assoc()) {
        $totalAppointments = $row['total_appointments'];
        $completedAppointments = $row['completed_appointments'];
        $completionPercentage = ($totalAppointments > 0) ? ($completedAppointments / $totalAppointments) * 100 : 0;
     
        echo "<tr>
                <td>" . $row['counselor_name'] . "</td>
                <td>" . $totalAppointments . "</td>
                <td>" . $completedAppointments . "</td>
                <td>
                    <div class='progress'>
                        <div class='progress-bar' role='progressbar' style='width: " . $completionPercentage . "%;' aria-valuenow='" . $completionPercentage . "' aria-valuemin='0' aria-valuemax='100'></div>
                    </div>
                </td>
                <td style='color: #C88550;'> " . $row['counselor_status'] . "</td>
            </tr>";
        
        $i= $i+1;
    }

    echo "</table>";
} else {
    echo "No counselors found.";
}

?>
<script>

    // Get the input element
var searchCounselors = document.getElementById("searchCounselors");

// Add event listener for input changes
        searchCounselors.addEventListener("input", function() {
        var filter = searchCounselors.value.toUpperCase();
        var tableCounselors = document.getElementById("tableCounselors");
        var rows = tableCounselors.getElementsByTagName("tr");

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

//table Counselors

 //table goals Count 

 let sortCounselorsUp = document.getElementById("sortUptableCounselors");
 sortCounselorsUp.addEventListener('click', filterTableCounselorsUp); 

 let sortCounselorsDown = document.getElementById("sortDowntableCounselors");
 sortCounselorsDown.addEventListener('click', filterTableCounselorsDown); 
 

 function filterTableCounselorsUp(){
    let tableCounselors = document.getElementById("tableCounselors");
    let tr = tableCounselors.getElementsByTagName("tr");
    let rows = Array.from(tr).slice(1);
 
    
   rows.sort((a,b)=>{
       let tdA = a.getElementsByTagName("td")[1].textContent; 
       let tdB = b.getElementsByTagName("td")[1].textContent;
       
       return tdB-tdA; 

    }); 
  

    for (let i=0; i<rows.length; i++){
        tableCounselors.appendChild(rows[i]); 
        
    }
 }

 function filterTableCounselorsDown(){
    let tableCounselors = document.getElementById("tableCounselors");
    let tr = tableCounselors.getElementsByTagName("tr");
    let rows = Array.from(tr).slice(1);
 
    
   rows.sort((a,b)=>{
       let tdA = a.getElementsByTagName("td")[1].textContent; 
       let tdB = b.getElementsByTagName("td")[1].textContent;
       
       return tdA-tdB; 

    }); 
  

    for (let i=0; i<rows.length; i++){
        tableCounselors.appendChild(rows[i]); 
        
    }
}

</script>