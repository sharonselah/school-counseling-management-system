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

    <button style="width: 120px; background-color: brown; height: 30px; border: none;padding:10px;  ">
    <a style="color: white;" href="CounselorSignup.php">Add</a></button>

    <?php 
        // Retrieve users from database
        $sql = "SELECT * FROM counselors ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) { ?>

        <table class="table" style="width: 100%; ">
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
            <tr>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>
                <th>Student Name</th>
                <th>Counselor Name</th>
            </tr>";

    // Output each appointment row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['date'] . "</td>
                <td>" . $row['start_time'] . "</td>
                <td>" . $row['end_time'] . "</td>
                <td>" . $row['status'] . "</td>
                <td>" . $row['student_name'] . "</td>
                <td>" . $row['counselor_name'] . "</td>
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
    echo "<table class='table' style='width: 100%;'>
            <tr>
                <th>Referral ID</th>
                <th>Referring Therapist</th>
                <th>Receiving Therapist</th>
                <th>Student Name</th>
                <th>Date</th>
                <th>Reason</th>
                <th>Acceptance Status</th>
            </tr>";

    // Output each referral row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['referring_therapist'] . "</td>
                <td>" . $row['receiving_therapist'] . "</td>
                <td>" . $row['student_name'] . "</td>
                <td>" . $row['date'] . "</td>
                <td>" . $row['reason'] . "</td>
                <td>" . $row['Accept'] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No referrals found.";
}


?>
</div>

<div class="right-h hide">
<!--Progress Report-->

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
    echo "<table class='table'>
            <tr>
                <th>Goal Name</th>
                <th>Goal Count</th>
               
            </tr>";

    // Output each goal progress entry
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['goal'] . "</td>
                <td>" . $row['goal_count'] . "</td>
                
              </tr>";
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
</script>




</body>
</html>