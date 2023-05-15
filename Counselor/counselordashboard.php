<?php
session_start();
include '../../sessiondeleting.php'; 
include '../Backend/db.php';

if (!isset($_SESSION['authenticated']) || $_SESSION["role"] !== 'counselor') {
    // User is not authenticated or is not a counselor, redirect to login page
    header('Location: ../Login.php');
    exit();
}

if (isset($_GET['referral']) && $_GET['referral'] === 'success') {
    echo '<script>alert("Referral made successfully");</script>';
}


//counselor's id 
$id = $_SESSION['user_id']; 
  
// Retrieve appointments from database
$stmt = $conn-> prepare("SELECT * FROM appointments where counselor_id = ? ORDER BY created_at DESC");
$stmt->bind_param('i', $id); 
$stmt->execute(); 
$result = $stmt->get_result(); 


//retrieving numbers

$stmt4 = $conn->prepare ("SELECT *, 
COUNT(*) AS total_appointments, 
COUNT(CASE WHEN status = 'pending' THEN 1 ELSE NULL END) AS pending_appointments, 
COUNT(CASE WHEN status = 'canceled' THEN 1 ELSE NULL END) AS canceled_appointments, 
COUNT(CASE WHEN status = 'confirmed' THEN 1 ELSE NULL END) AS confirmed_appointments,
COUNT(CASE WHEN status = 'overdue' THEN 1 ELSE NULL END) AS overdue_appointments
FROM appointments
WHERE counselor_id = ?");

$stmt4->bind_param('i', $id); 
$stmt4->execute(); 
$result4 = $stmt4->get_result(); 
$number=$result4->fetch_assoc(); 



//retrieve 

$stmt3= $conn->prepare("SELECT s.student_id, s.name, s.email, COUNT(a.id) AS appointment_count
FROM students AS s
JOIN appointments AS a ON s.student_id = a.student_id
WHERE a.counselor_id = ?
GROUP BY s.student_id"
);

$stmt3->bind_param("i", $id); 
$stmt3->execute(); 
$result3=$stmt3->get_result(); 


//notes 

$stmt5 = $conn->prepare("SELECT * FROM notes where counselor_id = ? and student_id = ?"); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style2.css">
    <title>Document</title>

    <style>
        .sort{ 
            width: 25%;   
           
        }

        .right-c, .right-d, .right-e, .right-f{
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

    <?php include '../headerdashboard.php'; ?>

    <div class="menu-dashboard">
        <p>DASHBOARD</p>
        <ul class="menu_links">
            <li><a href="#">Appointments</a></li>
            <li><a href="#">Patients</a></li>
            <li><a href="#">Referrals</a></li>
            <li><a href="#">Right F</a></li>  
        </ul> 
        <ul>
            <li style="position: absolute; bottom: 100px;"><a href="../../logout.php">Log Out</a></li>
        </ul>
    </div>

    <div class="right-c">
        <p style="text-align:center; color:brown; font-weight: bold; font-size: 105%;">APPOINTMENT DASHBOARD</p>

        <div id="top">

    <!-- stats -->

        <div class="container">
            <div class="box">
                <h2><span style="background-color: blue;" class="bullet"></span>Total</h2>
                <p><?php echo $number["total_appointments"];?></p>
            </div>
            <div class="box">
                <h2><span style="background-color: #FFBF00;" class="bullet"></span>Pending </h2>
                <p><?php echo $number["pending_appointments"];?></p>
            </div>
            <div class="box">
                <h2><span style="background-color: green;" class="bullet"></span>Accepted</h2>
                <p><?php echo $number["confirmed_appointments"];?></p>
            </div>
            <div class="box">
                <h2><span style="background-color: red;" class="bullet"></span>Canceled</h2>
                <p><?php echo $number["canceled_appointments"];?></p>
            </div>
            <div class="box">
                <h2><span style="background-color: brown;" class="bullet"></span>Overdue</h2>
                <p><?php echo $number["overdue_appointments"];?></p>
            </div>
            
	    </div> 
    <!-- end of stats-->


        <section class="appointment">

            <div class="container-two">
                <p style="color: brown; font-weight: bold;">LIST OF APPOINTMENTS</p>

                <div class="search">
                    <input id="searchInput" type="text" name ="search_appointments"
                    placeholder="Search appointments by name">       
                </div> 

                <div class="sort">
                    <label for="status">Status:</label>
                    <select id="status" name="status" style= "padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                        <option value="">-- Select --</option>
                        <option value="pending">pending</option>
                        <option value="confirmed">confirmed</option>
                        <option value="canceled">canceled</option>
                        <option value="overdue">overdue</option>
                    </select>
                </div>
            </div>

            <table id ="myTable" class="table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>Status</th>
                        <th>Notes</th>
                    </tr>
                </thead> 
                
            <?php 
            
            if ($result->num_rows > 0){?>
                <tbody>

                <?php
                while ($row = $result->fetch_assoc()) {

                    //checking status

                    $appointment_date_time = $row['date'];
                    $current_date_time = time();

                    if ($row['status'] == 'pending' && $current_date_time > $appointment_date_time) {
                        // Update the appointment status to overdue
                        $stmt = $conn->prepare("UPDATE appointments SET status = 'overdue' WHERE id = ?");
                        $stmt->bind_param('i', $row['id']); 
                        $stmt->execute(); 
                    }

                        //Name of the student 
                        $stmt2 = $conn->prepare("SELECT * FROM students WHERE student_id = ?");

                        $stmt2->bind_param("i", $row["student_id"]);
                        $stmt2->execute();
                        $result2 = $stmt2->get_result();
                        $student2 = $result2->fetch_assoc();
                    
                        $_SESSION['student_id'] = $student2['student_id'];

                        //Full name of the day of the week; Day of the month; abb name of the month

                    $row['date'] = date_format(date_create($row['date']), 'l j M');

                    switch ($row['status']) {
                        case 'pending':
                            $status_color = '';
                            $status_action = "<a href='confirmappointment.php?id=" . $row['id'] . "' onclick='return confirmAppointment()' id='confirm_btn1'>Confirm</a> <a href='cancelappointment.php?id=" . $row['id'] . "' onclick='return cancelAppointment()' id='confirm_btn2'>Cancel</a>";
                            $notes = 'Activated when Confirmed';
                            break;
                        case 'confirmed':
                            $status_color = 'color: green;';
                            $status_action = '';
                            $notes = "<a href='notes.php' id='confirm_btn1'>Take Notes</a>";
                            break;
                        case 'canceled':
                            $status_color = 'color: red;';
                            $status_action = '';
                            $notes = 'No Notes';
                            break;
                        default:
                            $status_color = 'color: orange;';
                            $status_action = '';
                            $notes = 'No Notes';
                            break;
                    }
                    
                    echo "<tr><td>" . $student2['name'] . "</td><td>" . $row['date'] . "</td><td>" . $row['start_time'] . "</td><td style='" . $status_color . "'>" . $row['status'] . "</td><td>" . $notes . "</td></tr>";
                    
                    
                }
            }

                // Check if there were no rows returned from the query
                if ($result->num_rows == 0) {
                    echo "<tr><td colspan='10' style='text-align:center; font-size: 24px; color: red;'> <br>
                    No pending appointments. It may be a slow season, but keep up the good work!</td></tr>";
                }

                ?>
                
                </tbody>

            </table>

     </section>
     </div>
    </div>
    
     <div class="right-d hide"> <?php include 'Referrals/referal.php'; ?> </div>
    <div class="right-e hide"> <?php include 'Referrals/acceptreferal.php'; ?></div>
  


   
 
    </div><!-- end of right-->



<script>

function confirmAppointment(){
    var confirmation = confirm("Are you sure you want to confirm the appointment?");
    return confirmation; 
  }

  function cancelAppointment(){
    var confirmation = confirm("Are you sure you want to cancel the appointment?");
    return confirmation; 
  }


    const searchInput = document.getElementById('searchInput');
    const statusDropdown = document.getElementById('status');
    const table = document.getElementById('myTable');
    const rows = table.getElementsByTagName('tr');

    function filterTable() {
    const searchValue = searchInput.value.toUpperCase();
    const statusValue = statusDropdown.value.toUpperCase();

    for (let i = 1; i < rows.length; i++) {
        const name = rows[i].getElementsByTagName('td')[0].textContent.toUpperCase();
        const status = rows[i].getElementsByTagName('td')[3].textContent.toUpperCase();
        
        if (name.indexOf(searchValue) > -1 && (statusValue === '' || status === statusValue)) {
        rows[i].style.display = '';
        } else {
        rows[i].style.display = 'none';
        }
    }
    }

    searchInput.addEventListener('input', filterTable);
    statusDropdown.addEventListener('change', filterTable);

    //patient table 

    // Get the input elements
const nameInput = document.getElementById("name");
const emailInput = document.getElementById("email"); 


// Add event listeners to the input elements
nameInput.addEventListener('input', filterRows);
emailInput.addEventListener('input', filterRows);


function filterRows() {
  // Get the table body and all rows
  const tableBody = document.getElementById("tbody"); 
  const rows = tableBody.querySelectorAll('tr');

  // Loop through all rows
  for (const row of rows) {
    // Get the cells for the first name, last name, and age columns
    const nameCell = row.querySelectorAll('td')[0];
    const emailCell = row.querySelectorAll('td')[1];
 

    // Get the input values and trim whitespace
    const nameValue = nameInput.value.trim().toLowerCase();
    const emailValue = emailInput.value.trim().toLowerCase();
   

    // Check if the row should be displayed based on the input values
    const nameMatch = nameValue === '' || nameCell.textContent.trim().toLowerCase().includes(nameValue);
    const emailMatch = emailValue === '' || emailCell.textContent.trim().toLowerCase().includes(emailValue);
   

    // Display or hide the row based on the input values
    if (nameMatch && emailMatch) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  }
}


const links = document.querySelectorAll('.menu_links li a');
const rightDivs = document.querySelectorAll('.right-c, .right-d, .right-e, .right-f');

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