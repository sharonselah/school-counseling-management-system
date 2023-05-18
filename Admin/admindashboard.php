<?php
session_start();


if (!isset($_SESSION['authenticated']) || $_SESSION["role"] !== 'admin') {
    // User is not authenticated or is not a admin, redirect to login page
    header('Location: ../Login.php');
    exit();
  }
  //retrive the counselors
  include '../Backend/db.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <title>Document</title>

    <style>

        .table{
            
        }
        .sort{ 
            width: 25%;     
        }

        .right-c, .right-d, .right-e, .right-f, .right-g, .right-h{
        position: absolute; 
        left: 9%; 
        width: 89%;  
        padding: 15px 10px 10px 10px;
        height: 100vh; 
        overflow-y: scroll; /* enable vertical scrolling */
        background-color: #FAFAFA;
        }

        .hide{
            display: none;
        }
    </style>
</head>
<body style=" padding: 0; ">
    <div class="dashboard-container">
        <div class="header-dashboard">
            <div class="logo">
            CUEA Counseling
            </div>

            <div class="personal-info">
              <h2>Welcome, <?php  echo $_SESSION["name"]; ?></h2>
            </div>
        </div>

  
    <div class="menu-dashboard">
        <p>DASHBOARD</p>
        <ul>
            <li><a href="#">Appointment</a></li>
            <li><a href="#">Count</a></li>
            <li><a href="#">Counselors</a></li>
            <li><a href="#">Students</a></li>
            <li><a href="#">Referrals</a></li>
            <li><a href="#">Goals</a></li>
        </ul>
        <ul>
            <li style="padding-top:180px;"><a href="../logout.php">Log Out</a></li>
        </ul>
    </div>


<div id = "right-c" class="right-c" >

   
    

    <?php 
        // Retrieve users from database
        $sql = "SELECT * FROM counselors ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) { ?>

            <div style="display: flex; align-items: center; gap: 10px; font-size: 14px; color: gray;">
                <a href="CounselorSignup.php" style="text-decoration: none; color: gray;">Add</a>
               
                <input style="width: 200px; height: 30px; font-size: 12px; color: gray;" type="search" name="search" id="search" placeholder="Search by Name">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <p style="margin: 0;">Sort by:</p>
                    <button id="Nothing" style="font-size: 14px;">Default</button>
                    <button id="sortName" style="font-size: 14px;">Name</button>
                    <button id="sortSpeciality" style="font-size: 14px;">Specialty</button>
                </div>
            </div>


        <table id ="table" class="table" style="width: 100%;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Speciality</th>
                    <th>Email</th>
                    <th>Start Date</th>
                    <th>Edit</th>
                    <th>Update</th>
                </tr>
            </thead> <?php }?>
            <tbody>
            <tr>
               <?php
               while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["name"] . "</td><td>" . $row["specialty"] . "</td><td>" . $row["email"] . "</td><td>" . $row["created_at"] . "</td>
                <td><a href='editcounselor.php?id=". $row ["counselor_id"]."'>Edit</a></td>
                <td><a href='deletecounselor.php?id=". $row ["counselor_id"]."'>Delete</a></td></tr>"; 
            }

            ?>
            </tr>
            </tbody>
        </table>

        </div>

        <div class="right-d hide">

        <?php

// Specify the time frame for the report (replace with your desired start and end dates)
$start_date = '2023-01-01';
$end_date = '2023-12-31';

// Query to retrieve counselor data and the count of their appointments within the specified time frame
$sql = "SELECT c.name AS counselor_name, c.specialty, c.email, COUNT(a.id) AS appointment_count
        FROM counselors AS c
        LEFT JOIN appointments AS a ON c.counselor_id = a.counselor_id
        WHERE a.date BETWEEN '$start_date' AND '$end_date'
        GROUP BY c.counselor_id
        ORDER BY counselor_name ASC";

$result = $conn->query($sql);

// Check if there are any counselors
if ($result->num_rows > 0) {
    // Output table headers
    echo "<table class='table'  style='width: 100%;'>
            <tr style='text-align: center;'>
                <th>Counselor Name</th>
                <th>Specialty</th>
                <th>Email</th>
                <th>Appointment Count</th>
            </tr>";

    // Output each counselor row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['counselor_name'] . "</td>
                <td>" . $row['specialty'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['appointment_count'] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No counselors found.";
}


?>

</div>

<div class="right-e hide">

        <!-- appointments --> 


       <?php 
// Specify the time frame for the report (replace with your desired start and end dates)
$start_date = '2023-01-01';
$end_date = '2023-12-31';

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
    // Output table headers
    echo "<table class='table' style='width: 100%;'>
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
                <td>" . $row['start_time'] . "</td>
                <td>" . $row['end_time'] . "</td>
                <td>" . $row['status'] . "</td>
                <td>" . $row['student_name'] . "</td>
                
              </tr>";
    }

    echo "</table>";
} else {
    echo "No appointments found.";
}

?>

</div>

<div class="right-f hide">
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
    // Output table headers
    echo "<table class='table'>
            <tr>
                <th>Student Name</th>
                <th>Email</th>
                <th>Appointment Count</th>
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

<div class="right-g hide">
<!-- referrals -->

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
    echo "<table class='table' style='width: 100%; text-align:left;'>
            <tr>
                <th></th>
                <th><input style='width:120px;' type='search' name='search' id=''></th>
                <th><input style='width:120px;' type='search' name='search' id=''></th>
                <th><input style='width:120px;' type='search' name='search' id=''></th>
                <th><input style='width:120px;' type='search' name='search' id=''></th>
               
            </tr>
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
</div>

<div class="right-h hide">
<!--Progress Report-->

<input type="search" name="search" id="searchgoals">
<?php

// Query to retrieve goal progress data
$sql = "SELECT goal.goal, COUNT(DISTINCT wg.goal_id) AS goal_count
        FROM weekly_goal_progress AS wg
        INNER JOIN goals AS goal ON wg.goal_id = goal.id
        GROUP BY goal.goal
        ORDER BY goal_count DESC";


$result = $conn->query($sql);

// Check if there are any goal progress entries
if ($result->num_rows > 0) {
    // Output table headers
    echo "<table id ='tablegoals' class='table'>
            <tr style='text-align: left;'>
                <th>Number</th>
                <th>Goal Name 
                    <span id='sortArrowNameDown'>&#9660;</span>
                    <span id='sortArrowNameUp'>&#9650;</span>
                </th>
                <th>Goal Count 
                    <span id='sortArrowCountDown'>&#9660;</span>
                    <span id='sortArrowCountUp'>&#9650;</span>
                </th>
               
            </tr>";

    // Output each goal progress entry
    $count = 1; 
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>$count</td>
                <td>" . $row['goal'] . "</td>
                <td>" . $row['goal_count'] . "</td>
                
              </tr>";
              $count++;
    }

    echo "</table>";
} else {
    echo "No goal progress entries found.";
}

// Close the database connection
$conn->close();
?>

</div>


<script>
    const links = document.querySelectorAll('.menu-dashboard ul li a');
const rightDivs = document.querySelectorAll('.right-c, .right-d, .right-e, .right-f, .right-g, .right-h');

links.forEach((link, index) => {
  link.addEventListener('click', () => {
    hideAll();
    rightDivs[index].classList.remove('hide');
  });
});

function hideAll() {
  rightDivs.forEach((rightDiv) => {
    rightDiv.classList.add('hide');
  });
}

        //table 1 searching by name 

        let table = document.getElementById("table"); 
        let rows = table.getElementsByTagName("tr"); 
        let i, td;

        function filterTable(){

            let search = document.getElementById("search");
            let searchValue = search.value.toUpperCase();
            for (i=2; i< rows.length; i++){
            td = rows[i].getElementsByTagName("td")[0];
            tdValue = td.textContent.trim().toUpperCase()
        
             if (tdValue.indexOf(searchValue) > -1){
                    rows[i].style.display= '';
             }else{
                rows[i].style.display= 'none';
             }

        }
        } 
        search.addEventListener('keyup', filterTable);

        //table 1 sorting 
        let buttonNothing = document.getElementById("Nothing"); 
        let buttonName = document.getElementById ("sortName");
        let buttonSpeciality = document.getElementById("sortSpeciality"); 

        function resetTable(){
            location.reload(); //reload the page 
        }


        function sortName(){
               rows = Array.from(rows).slice(2); 

                rows.sort((a,b) =>{
                    let tdA = a.getElementsByTagName("td")[0].textContent;
                    let tdB = b.getElementsByTagName("td")[0].textContent;

                    return tdA.localeCompare(tdB); 
                });
                
                for (let i=1; i<rows.length; i++){
                    table.appendChild(rows[i]);
                }  
        }

        function sortSpeciality(){
               rows = Array.from(rows).slice(2); 

                rows.sort((a,b) =>{
                    let tdA = a.getElementsByTagName("td")[1].textContent;
                    let tdB = b.getElementsByTagName("td")[1].textContent;

                    return tdA.localeCompare(tdB); 
                });
                
                for (let i=1; i<rows.length; i++){
                    table.appendChild(rows[i]);
                }  
        }

        buttonNothing.addEventListener('click', resetTable);
        buttonName.addEventListener('click', sortName);
        buttonSpeciality.addEventListener('click', sortSpeciality); 


        //table goals Name

       
        let sortNameUp = document.getElementById("sortArrowNameUp");
        sortNameUp.addEventListener('click', filterTableGoalsUp); 

        
        let sortNameDown = document.getElementById("sortArrowNameDown");
        sortNameDown.addEventListener('click', filterTableGoalsDown); 
       

        function filterTableGoalsUp(){
            let tableGoals = document.getElementById("tablegoals");
            let tr = tableGoals.getElementsByTagName("tr");
            let rows = Array.from(tr).slice(1);
         
            
           rows.sort((a,b)=>{
               let tdA = a.getElementsByTagName("td")[0].textContent; 
               let tdB = b.getElementsByTagName("td")[0].textContent;
               
               return tdA.localeCompare(tdB);

            }); 
          

            for (let i=0; i<rows.length; i++){
                tableGoals.appendChild(rows[i]); 
              
                
            }
        }

        function filterTableGoalsDown(){
            let tableGoals = document.getElementById("tablegoals");
            let tr = tableGoals.getElementsByTagName("tr");
            let rows = Array.from(tr).slice(1);
         
            
           rows.sort((a,b)=>{
               let tdA = a.getElementsByTagName("td")[0].textContent; 
               let tdB = b.getElementsByTagName("td")[0].textContent;
               
               return tdB.localeCompare(tdA);

            }); 
          

            for (let i=0; i<rows.length; i++){
                tableGoals.appendChild(rows[i]); 
              
                
            }
        }

        //table goals Count 

        let sortCountUp = document.getElementById("sortArrowCountUp");
        sortCountUp.addEventListener('click', filterTableCountUp); 

        let sortCountDown = document.getElementById("sortArrowCountDown");
        sortCountDown.addEventListener('click', filterTableCountDown); 
        
       

        function filterTableCountUp(){
            let tableGoals = document.getElementById("tablegoals");
            let tr = tableGoals.getElementsByTagName("tr");
            let rows = Array.from(tr).slice(1);
         
            
           rows.sort((a,b)=>{
               let tdA = a.getElementsByTagName("td")[1].textContent; 
               let tdB = b.getElementsByTagName("td")[1].textContent;
               
               return tdA-tdB; 

            }); 
          

            for (let i=0; i<rows.length; i++){
                tableGoals.appendChild(rows[i]); 
              
                
            }
        }

        function filterTableCountDown(){
            let tableGoals = document.getElementById("tablegoals");
            let tr = tableGoals.getElementsByTagName("tr");
            let rows = Array.from(tr).slice(1);
         
            
           rows.sort((a,b)=>{
               let tdA = a.getElementsByTagName("td")[1].textContent; 
               let tdB = b.getElementsByTagName("td")[1].textContent;
               
               return tdB- tdA; 

            }); 
          

            for (let i=0; i<rows.length; i++){
                tableGoals.appendChild(rows[i]); 
              
                
            }
        }

        //table goals search 
        let searchGoals = document.getElementById("searchgoals"); 
        searchGoals.addEventListener("input", searchGoal);

        function searchGoal(){
            let searchGoalsValue = searchGoals.value.trim().toUpperCase();
            
            let tableGoals = document.getElementById("tablegoals");
            let rows = tableGoals.getElementsByTagName("tr");
          

            for (let i=1; i< rows.length; i++){
                let td = rows[i].getElementsByTagName("td")[1];
                let tdValue = td.textContent.toUpperCase(); 

                
                if (tdValue.indexOf(searchGoalsValue)> -1){
                    rows[i].style.display = '';
                }else {
                    rows[i].style.display='none';
                }


            }
            
        }


</script>




</body>
</html>