<div style='width:70%; margin: auto;'>
<p style='text-align:center; font-weight:bold;'>Students Log</p> 


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
    echo "<p style='font-weight: bold; text-align: center;'>Total Number of Students: $result->num_rows </p>";
    echo "<label>Search:</label>";
    echo "<input type='search' style='margin-left: 20px; width: 350px;'class ='search_inline' name='search' id='searchStudents'
     placeholder='Search student name, email, count, or anything'>"; 
    // Output table headers
    echo "<table id ='tableStudents' class='table' style='width: 100%;'>
            <tr style='text-align:left;'>
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
</div>

<script>
    var searchStudents = document.getElementById("searchStudents");

// Add event listener for input changes
        searchStudents.addEventListener("input", function() {
        var filter = searchStudents.value.toUpperCase();
        var tableStudents = document.getElementById("tableStudents");
        var rows = tableStudents.getElementsByTagName("tr");

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


        let sortUp = document.getElementById("sortUp");
        sortUp.addEventListener('click', filterTableStudentsUp); 

        
        let sortDown = document.getElementById("sortDown");
        sortDown.addEventListener('click', filterTableStudentsDown); 
       

        function filterTableStudentsUp(){
            var tableStudents = document.getElementById("tableStudents");
            var tr = tableStudents.getElementsByTagName("tr");
            let rows = Array.from(tr).slice(1);
         
            
           rows.sort((a,b)=>{
               let tdA = a.getElementsByTagName("td")[2].textContent; 
               let tdB = b.getElementsByTagName("td")[2].textContent;
               
               return tdA-tdB; 

            }); 
          

            for (let i=0; i<rows.length; i++){
                tableStudents.appendChild(rows[i]); 
              
                
            }
        }

        function filterTableStudentsDown(){
            var tableStudents = document.getElementById("tableStudents");
            var tr = tableStudents.getElementsByTagName("tr");
            let rows = Array.from(tr).slice(1);
         
            
           rows.sort((a,b)=>{
               let tdA = a.getElementsByTagName("td")[2].textContent; 
               let tdB = b.getElementsByTagName("td")[2].textContent;
               
               return tdB - tdA; 

            }); 
          

            for (let i=0; i<rows.length; i++){
                tableStudents.appendChild(rows[i]); 
              
                
            }
        }

</script>