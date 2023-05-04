<?php
session_start();


if (!isset($_SESSION['authenticated']) || $_SESSION["role"] !== 'admin') {
    // User is not authenticated or is not a admin, redirect to login page
    header('Location: Login.php');
    exit();
  }
  //retrive the counselors
  include 'Backend/db.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Document</title>
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
            <li><a href="">Students </a></li>
            <li><a href="">Counselors </a></li>
            <li><a href="">Appointments </a></li>
        </ul>

        <ul>
            <li style="padding-top:240px;"><a href="">Log Out</a></li>
        </ul>


    </div>


<div class="right">

    <div class="top">

    <button><a href="CounselorSignup.php">Add</a></button>

    <?php 
       
        // Retrieve users from database
        $sql = "SELECT * 
        FROM counselors 
        ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) { ?>

    
    
        <table class="table">
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

        <div class="pagination">
            <button class="prev-btn">Previous</button>
            <button class="next-btn">Next</button>
        </div>
    </div>

    <div class="bottom">

    </div>


</div> <!-- end of right-->




</body>
</html>