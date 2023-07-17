<?php
session_start();

include '../sessiondeleting.php'; 

$page = 'counselors.php';

if (isset($_GET['page'])){
    $page = $_GET['page'];
}


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

        .main{
        position: absolute; 
        left: 9%; 
        width: 89%;  
        padding: 15px 10px 10px 10px;
        height: 100vh; 
        overflow-y: scroll; /* enable vertical scrolling */
        background-color: #FAFAFA;
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

        .progress {
        width: 100%;
        background-color: #f2f2f2;
        border-radius: 4px;
    }
    
    .progress-bar {
        height: 20px;
        background-color: #C88550;
        border-radius: 4px;
    }
    #chart {
            width: 400px;
            height: 400px;
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
            <li><a href="?page=counselors.php">Counselors</a></li>
            <li><a href="?page=performance.php">Performance</a></li>
            <li><a href="?page=appointlog.php">Appointment Log</a></li>
            <li><a href="?page=appointanalysis.php">Appointment Analysis</a></li>
            <li><a href="?page=students.php">Students</a></li>
            <li><a href="?page=referrals.php">Referrals</a></li>
            <li><a href="?page=goals.php">Goals</a></li>
            <li><a href="?page=terminations.php">Terminations</a></li>
        </ul>
        <ul>
            <li style="position: fixed; bottom: 0px;"><a href="../logout.php">Log Out</a></li>
        </ul>
    </div>

    <div class="main">
        <?php include $page; ?>
    </div>

<script src="admin.js"></script>



</body>
</html>