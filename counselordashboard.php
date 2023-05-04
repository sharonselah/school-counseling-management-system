<?php
session_start();


if (!isset($_SESSION['authenticated']) || $_SESSION["role"] !== 'counselor') {
    // User is not authenticated or is not a counselor, redirect to login page
    header('Location: Login.php');
    exit();
}

$id = $_SESSION['user_id']; 

  //retrive the counselors
  include 'Backend/db.php';

       
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
    table {
        width: 1160px;
        border-collapse: collapse;
        
    }

    th, td {
        padding: 10px;
        text-align: center;
        border: 1px solid #ddd;
    }

    th {
        background-color: #80000;
    }

    #confirm_btn1, #confirm_btn2{
        color: white; 
        border: none; 
        padding: 9px 25px; 
        background-color: red; 
       
    }

    #confirm_btn1{
  
        background-color: green; 
        margin-right: 30px; 
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
            <li><a href="">Appointments </a></li>
            <li><a href="">Time Slots </a></li>
            <li><a href="">Documents</a></li>
            
        </ul>

        <ul>
            <li style="padding-top:240px;"><a href="">Log Out</a></li>
        </ul>


    </div>


<div class="right">

    <div class="top">

    <button><a href="CounselorSignup.php">Add</a></button>

   
        <table class="table">
        
            <thead>
                <tr>
                <th>No</th>
                <th>Student</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>Status</th>
        
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

                    //Full name of the day of the week; Day of the month; abb name of the month

                $row['date'] = date_format(date_create($row['date']), 'l j M');

                if ($row['status']== 'pending'){
                    echo "<tr><td>" . $row["id"] . "</td><td> ". $student2["name"]." </td><td>" . $row["date"] . "</td><td>" . $row["start_time"] . "</td>
                    <td><a href= 'confirmappointment.php?id=". $row ["id"]."' onclick = 'return confirmAppointment()' id='confirm_btn1'>Confirm</a> 
                    <a href='cancelappointment.php?id=". $row ["id"]." ' onclick = 'return cancelAppointment()'id='confirm_btn2'>Cancel</a>
                    <span id='status-".$row["id"]."'></span></td>";
                   
                }else if ($row['status'] == 'confirmed'){
                    echo "<tr><td>" . $row["id"] . "</td><td> ". $student2["name"]." </td><td>" . $row["date"] . "</td><td>" . $row["start_time"] . "</td>
                    <td style='color: green;'>" . $row["status"] . "</td>";
                   
                }else {
                    echo "<tr><td>" . $row["id"] . "</td><td> ". $student2["name"]." </td><td>" . $row["date"] . "</td><td>" . $row["start_time"] . "</td>
                    <td style='color: red;'>" . $row["status"] . "</td>";
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
</script>


</body>
</html>