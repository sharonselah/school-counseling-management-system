<?php
session_start();
include 'Backend/db.php';


if (!isset($_SESSION['authenticated']) || $_SESSION["role"] !== 'counselor') {
    // User is not authenticated or is not a counselor, redirect to login page
    header('Location: Login.php');
    exit();
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
COUNT(CASE WHEN status = 'confirmed' THEN 1 ELSE NULL END) AS confirmed_appointments
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
    <link rel="stylesheet" href="CSS/style2.css">
    <title>Document</title>

    <style>
        .sort{
            
            width: 25%; 
          
        }
    </style>
</head>
<body style=" padding: 0; ">

<div class="dashboard-container">

    <?php include 'header-dashboard.php'; ?>

  
    <div class="menu-dashboard">
        <p>DASHBOARD</p>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="#top">Appointments </a></li>
            <li><a href="">Patients</a></li>
            <li><a href="#notes">Notes</a></li>
            <li><a href="">Referrals</a></li>
            <li><a href="">Reports</a></li>  
        </ul>

        <ul>
            <li style="padding-top:240px;"><a href="">Log Out</a></li>
        </ul>
    </div>


<div class="right-c">

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
		
	</div> 
    <!-- end of stats-->


    <section class="appointment">

        <div class="container-two">
           
            
            <div class="make-referral">
                <button type="button">LIST OF APPOINTMENTS</button>
            </div>
          
            <div class="search">
                <input type="text" placeholder="Search appointments">
            </div>
            <div class="sort">
                <label for="sort-by">Sort by:</label>
                <select id="sort-by">
                <option value="name">Name</option>
                <option value="status">Status</option>
                </select>
            </div>
        </div>

        <table class="table">
        
            <thead>
                <tr>
                    
                    <th>Student</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>Status</th>
                    <th>Notes</th>
                </tr>
            </thead> 
            
           <?php if ($result->num_rows > 0){?>
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

                if ($row['status']== 'pending'){
                    echo "<tr><td> ". $student2["name"]." </td><td>" . $row["date"] . "</td><td>" . $row["start_time"] . "</td>
                    <td><a href= 'confirmappointment.php?id=". $row ["id"]."' onclick = 'return confirmAppointment()' id='confirm_btn1'>Confirm</a> 
                    <a href='cancelappointment.php?id=". $row ["id"]." ' onclick = 'return cancelAppointment()'id='confirm_btn2'>Cancel</a>
                    <span id='status-".$row["id"]."'></span></td><td>Activated when Confirmed</td></tr>";
                   
                }else if ($row['status'] == 'confirmed'){
                    echo "<tr><td> ". $student2["name"]." </td><td>" . $row["date"] . "</td><td>" . $row["start_time"] . "</td>
                    <td style='color: green;'>" . $row["status"] . "</td><td><a href='notes.php' id='confirm_btn1'>Take Notes</a></td></tr>";
                   
                }
                else if  ($row['status'] == 'canceled'){
                echo "<tr><td> ". $student2["name"]." </td><td>" . $row["date"] . "</td><td>" . $row["start_time"] . "</td>
                <td style='color: red;'>" . $row["status"] . "</td><td>No Notes</td></tr>";
                }else {
                echo "<tr><td> ". $student2["name"]." </td><td>" . $row["date"] . "</td><td>" . $row["start_time"] . "</td>
                <td style='color: orange;'>" . $row["status"] . "</td><td>No Notes</td></tr>";
                }
            
                
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

    <?php include 'Referrals/referal.php'; ?>



    <section class="referrals">
        
    </section>

    <div id="notes">
                
    </div>


</div> <!-- end of right-->



<script>

function confirmAppointment(){
    var confirmation = confirm("Are you sure you want to confirm the appointment?");

    return confirmation; 
   

  }

  function cancelAppointment(){
    var confirmation = confirm("Are you sure you want to cancel the appointment?");

    return confirmation; 
   

  }

  
const panels = document.querySelectorAll('.panel');

panels.forEach(panel => {
  const header = panel.querySelector('.panel-header');
  const content = panel.querySelector('.panel-content');

  header.addEventListener('click', () => {
    content.classList.toggle('show');
  });
});


</script>


</body>
</html>