<?php 
include '../sessiondeleting.php'; 

include 'functions.php'; 

$page ='snapshot.php';
if(isset($_GET['page'])){
  $page = $_GET['page']; 
}


if (isset($_GET['voted'])) {
  if ($_GET['voted'] === 'success') {
    $message = 'You have voted successfully';
  } else if ($_GET['voted'] === 'failure') {
    $message = 'You have voted today. Try again tomorrow!';
  }else if ($_GET['voted']=== 'maximum'){
    $message = 'You can only set 3 goals per week. Please try again later.';
  }else if ($_GET['voted']== 'true'){
    $message = 'You have added a goal successfully'; 
  }
  echo '<script>alert("' . $message . '");</script>';
  unset($_GET['voted']);
  header("Refresh:0; studentdashboard.php"); //refresh the current page 
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <title>Student Dashboard</title>

    <style>
       .main{
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

        .button-appoint:hover{
          background-color: yellow; 
        }
    </style>

    
</head>
<body style=" padding: 0; ">

<div class="dashboard-container">

   <?php include "../headerdashboard.php"; 
   
         include 'menudashboard.php'; 
   ?>


<div class="main"> 
<?php include $page; ?>

<div id="notificationList" class="notification-list">

<div class="header" 
    style="display: flex;
    justify-content: center;
    border-bottom:2px solid whitesmoke;">
    <h3>Notifications</h3>
    
</div>


<?php 

include '../notifications.php';?>    

</div>

</div>
</div>

 
<script>

  function confirmCancel(){
    var confirmation = confirm("Are you sure you want to cancel the appointment?");
    return confirmation;
  }

    const statusDropdown = document.getElementById('status');
    const table = document.getElementById('myTable');
    const rows = table.getElementsByTagName('tr');

    function filterTable() {
    
    const statusValue = statusDropdown.value.toUpperCase();

    for (let i = 1; i < rows.length; i++) {
        const status = rows[i].getElementsByTagName('td')[3].textContent.toUpperCase();
 
        if (status === statusValue || statusValue === '') {
        rows[i].style.display = '';
       
        } else {
        rows[i].style.display = 'none';
       
        }
    }
    }
    statusDropdown.addEventListener('change', filterTable);

    



</script>

</body>
</html>