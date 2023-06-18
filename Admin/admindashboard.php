<?php
session_start();


if (!isset($_SESSION['authenticated']) || $_SESSION["role"] !== 'admin') {
    // User is not authenticated or is not a admin, redirect to login page
    header('Location: ../Login.php');
    exit();
  }

if (isset($_GET['error']) && $_GET['error']=="too_many_specialties"){
    echo '<script>alert("Choose only 2 specialties Please!!");</script>';

    unset($_GET['delete']);
    header("Refresh:0; admindashboard.php"); //refresh the current page 
}

if (isset($_GET['delete']) && $_GET['delete']=="success"){
    echo '<script>alert("Successfully deleted the counselor XX");</script>';

    unset($_GET['delete']);
    header("Refresh:0; admindashboard.php"); //refresh the current page 
}

if (isset($_GET['delete']) && $_GET['delete']=="failure"){
    echo '<script>alert("Could not delete the counselor");</script>';

    unset($_GET['delete']);
    header("Refresh:0; admindashboard.php"); //refresh the current page 
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

        .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        font-size: 14px;
        color: gray;
        }

        .add-button {
        padding: 5px 35px;
        background-color: #3F5CA4;
        color: white;
        text-decoration: none;
        border-radius: 3px;
        font-size: 14px;
        height: 30px;
        display: flex;
        align-items: center;
        }

        .search-bar input {
        width: 350px;
        height: 40px;
        font-size: 12px;
        padding: 10px;
        border: 1px solid lightgray; 
        border-radius: 6px; 
        color: gray;
        }

        .sort-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
        }

        .sort-buttons p {
        margin: 0;
        }

        .sort-buttons button {
        font-size: 14px;
        padding: 5px 25px;
        border-radius: 5px;
        background-color: #FFFFFF;
        border: 1px solid #CC8E58;
        color: #333333;
        height: 40px;
        }

        .sort-buttons button:hover {
        background-color: #CC8E58;
        color: #FFFFFF;
        }

        td a img{
            width: 30px;
            height: 30px;
        }

        .search_inline{
            height: 40px; 
            width: 300px; 
            border: 1px solid lightgray; 
            border-radius: 5px; 
            margin-left: 10%; 
            margin-bottom: 20px;
            padding: 10px;
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
        
        $sql = "SELECT * FROM counselors  WHERE status ='active' ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) { ?>

            <div class="header">
            <a href="CounselorSignup.php" class="add-button">Add New Counselor+</a>
                <div class="search-bar">
                    <input type="search" name="search" id="search" placeholder="Search by Name">
                </div>
                <div class="sort-buttons">
                    <p>Sort by:</p>
                    <button style="background-color: #CC8E58;" id="Nothing">Default</button>
                    <button id="sortName">Name</button>
                    <button id="sortSpeciality">Specialty</button>
                </div>
            </div>



        <table id ="table" class="table" style="width: 100%;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Speciality</th>
                    <th>Email</th>
                    <th>Start Date</th>
                    <th>Update</th>
                    <th>Delete</th>
                    
                </tr>
            </thead> <?php }?>
            <tbody>
            <tr>
               <?php
               while ($row = $result->fetch_assoc()) {

                $start_time_full = $row["created_at"];
                $start_time = date("Y-m-d", strtotime($start_time_full));
                echo "<tr style='border-bottom: 1px solid lightgray;'><td>" . $row["name"] . "</td><td>" . $row["specialty"] . "</td><td>" . $row["email"] . "</td><td>" . $start_time . "</td>
                <td><a href='editcounselor.php?id= " . $row['counselor_id']. " ?>'><img src='../Images/edit1.png' alt='Edit'></a></td>

                <td><a href='deletecounselor.php?id=". $row ["counselor_id"]."'><img src='../Images/remove.png' alt='Edit'></a></td></tr>"; 
            }

            ?>
            </tr>
            </tbody>
        </table>

        </div>

        <div class="right-d hide">
        <input class ="search_inline"
        type="search" name="search" id="searchCounselors" placeholder="search anything">

        <?php

        /* Specify the time frame for the report (replace with your desired start and end dates)
        $start_date = '2023-01-01';
        $end_date = '2023-12-31';*/

    // Query to retrieve counselor data and the count of their appointments within the specified time frame
    $sql = "SELECT c.name AS counselor_name, c.email, c.status, COUNT(a.id) AS appointment_count
            FROM counselors AS c
            LEFT JOIN appointments AS a ON c.counselor_id = a.counselor_id
            GROUP BY c.counselor_id
            ORDER BY counselor_name ASC";

    $result = $conn->query($sql);

// Check if there are any counselors
if ($result->num_rows > 0) {
    // Output table headers
    echo "<table id ='tableCounselors' class='table'  style='width: 80%; margin: auto;'>
            <tr style='text-align: left;'>
                <th>Counselor Name</th>
                <th>Email</th>
                <th>Appointment Count
                    <span id='sortDowntableCounselors'>&#9660;</span>
                    <span id='sortUptableCounselors'>&#9650;</span>
                </th>
                <th>Status</th>
            </tr>";

    // Output each counselor row
    while ($row = $result->fetch_assoc()) {
       echo "<tr>
        <td>" . $row['counselor_name'] . "</td>
        <td>" . $row['email'] . "</td>
        <td style='color: #C88550;'>" . $row['appointment_count'] . "</td>
        <td> " . $row['status'] . "</td>
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

        <input class ="search_inline" type="search" name="search" id="searchAppointments" placeholder="search anything">
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

<input type="search" class ="search_inline" name="search" id="searchStudents" placeholder="search anything">
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

</div>

<div class="right-g hide">
<!-- referrals -->

<input type="search" class ="search_inline" name="search" id="searchReferrals" placeholder="search anything">

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


<script src="admin.js"></script>



</body>
</html>