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
$sql = "SELECT * FROM appointments where counselor_id =$id  ORDER BY created_at DESC";
$result = $conn->query($sql);

  



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Document</title>

    <style>

        body{
            font-family :'Times New Roman'; 
        }
    table {
        width: 100%; 
        border-collapse: collapse;
        
      
        
    }

    th, td {
        padding: 10px;
        text-align: center;
        border: 1px solid #ddd;
    }

    th {
        background-color: #edecec;
        color:black; 
        text-transform: uppercase;
    }

    #confirm_btn1, #confirm_btn2{
        color: white; 
        border: none; 
        border-radius: 5px; 
        padding: 9px 25px; 
        background-color: red; 
       
    }

    #confirm_btn1{
  
        background-color: green; 
        margin-right: 30px; 
    }

    .container {
			display: flex;
			flex-direction: row;
			align-items: center;
			justify-content: space-between;
			width: 100%;
			height: 100px;
			background-color: #fafafa8a; 
			padding: 10px;
		}
		.box {
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			width: calc(18% - 20px);
			height: 80px;
			background-color: #fff;
			border: 1px solid #ddd;
			border-radius: 5px;
			text-align: center;
		}
		.box h2 {
			margin: 0;
			font-size: 85%; 
			font-weight: bold;
		}
		.box p {
			margin: 4px 0px;
			font-size: 80%; 
		}

        .right-c{
            position: absolute; 
            left: 9%; 
            width: 89%;  
            padding: 15px 10px 10px 10px;
            height: 100vh; 
            overflow-y: scroll; /* enable vertical scrolling */
            background-color: #FAFAFA;
        }

        .appointment{
            border-top:1px solid lightgray; 
            margin-top: 20px; 
        }

        .bullet {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            
            margin-right: 10px;
            }

        .container-two {
           padding: 10px;  
            display: flex;
            justify-content: space-between;
            align-items: center;
          
        }

        .search {
        width: calc(36% + 35px); 
        display: flex;
        justify-content: space-between; 
        align-items: center;
        }

        .search input[type="text"] {
            width: 100%; 
            margin-right: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-family :'Times New Roman'; 
        }

        .sort{
            margin-left: 20%; 
        }


        .sort label {
        
        margin-right: 5px;
        font-family :'Times New Roman'; 
        }

        .sort select {
        padding: 10px 28px;
        border-radius: 5px;
        border: 1px solid #ccc;
        
        }

        .make-referral button {
        margin-right: -10px; 
        background: none; 
        color: green; 
        padding: 10px 32px;
        border: 1px solid #4CAF50;
        border-radius: 10px;
        cursor: pointer;

        }



    

</style>
</head>
<body style=" padding: 0; ">

<div class="dashboard-container">

    <div class="header-dashboard">

            <div class="logo">
            CUEA Counseling
            </div>
    
          <div class="search">
              <input type="text" placeholder="Search...">
              <button>Search</button>
          </div>

          <div class="personal-info">
              <h2>Welcome, <?php  echo $_SESSION["name"]; ?></h2>
          </div>
      </div>

  
    <div class="menu-dashboard">
        <p>DASHBOARD</p>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="#top">Appointments </a></li>
            <li><a href="">Patients</a></li>
            <li><a href="">Tasks</a></li>
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
			<h2><span style="background-color: blue;" class="bullet"></span>Total Appointments</h2>
			<p>6</p>
		</div>
		<div class="box">
			<h2><span style="background-color: #FFBF00;" class="bullet"></span>Pending</h2>
			<p>1</p>
		</div>
		<div class="box">
			<h2><span style="background-color: green;" class="bullet"></span>Accepted</h2>
			<p>1</p>
		</div>
		<div class="box">
			<h2><span style="background-color: red;" class="bullet"></span>Canceled</h2>
			<p>1</p>
		</div>
		<div class="box">
			<h2><span style="background-color: purple;" class="bullet"></span>Completed</h2>
			<p>3</p>
		</div>
	</div> 
    <!-- end of stats-->


    <section class="appointment">

        <div class="container-two">
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
            <div class="make-referral">
                <button type="button">MAKE REFERRAL</button>
            </div>
    </div>


  

        <table class="table">
        
            <thead>
                <tr>
                <th>No</th>
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
                    echo "<tr><td>" . $row["id"] . "</td><td> ". $student2["name"]." </td><td>" . $row["date"] . "</td><td>" . $row["start_time"] . "</td>
                    <td><a href= 'confirmappointment.php?id=". $row ["id"]."' onclick = 'return confirmAppointment()' id='confirm_btn1'>Confirm</a> 
                    <a href='cancelappointment.php?id=". $row ["id"]." ' onclick = 'return cancelAppointment()'id='confirm_btn2'>Cancel</a>
                    <span id='status-".$row["id"]."'></span></td><td>Activated when Confirmed</td></tr>";
                   
                }else if ($row['status'] == 'confirmed'){
                    echo "<tr><td>" . $row["id"] . "</td><td> ". $student2["name"]." </td><td>" . $row["date"] . "</td><td>" . $row["start_time"] . "</td>
                    <td style='color: green;'>" . $row["status"] . "</td><td><a href='notes.php' id='confirm_btn1'>Take Notes</a></td></tr>";
                   
                }else {
                    echo "<tr><td>" . $row["id"] . "</td><td> ". $student2["name"]." </td><td>" . $row["date"] . "</td><td>" . $row["start_time"] . "</td>
                    <td style='color: red;'>" . $row["status"] . "</td><td>None</td></tr>";
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

    <section class="profile">
            profile
    </section>



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
</script>


</body>
</html>