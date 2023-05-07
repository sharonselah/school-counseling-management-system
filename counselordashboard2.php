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
$sql = "SELECT * FROM appointments where counselor_id = $id  ORDER BY created_at DESC";
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
            font-family :'Times New Roman' !important; 
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
        width: calc(36% + 5px); 
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
        
        background-color:#4CAF50; 
        color: white; 
        padding: 10px 35px;
        border: 1px solid #4CAF50;
        border-radius: 10px;
        cursor: pointer;
        letter-spacing: 1px;
        font-family: 'Times New Roman'; 

        }
      

        #patients{
            padding: 10px 20px; 
            border-radius: 5px; 
            background-color: rgb(255,255,255); 
            
        }

        .panels{
            display: flex; 
            flex-direction: row;
			justify-content: space-between;
            flex-wrap: wrap; 
        }
        .panel {
			background-color: #F0F0F0;
			border: 1px solid #ddd;
			margin: 0px 10px;
            margin-bottom: 25px; 
            width: calc(50% - 30px); 
		}

		.panel-header {
			
            background-color: #F0F0F0; 
			padding: 10px;
			cursor: pointer;
            font-size: 85%; 
            line-height: 1.5; 
            text-align: left; 
            border-left: 8px solid green; 
		}

        .panel-header h2{
            text-align: left; 
        }

		.panel-header:hover {
			
            background-color: #ddd;
		}

		.panel-content {
			padding: 10px;
			display: none;
		}

        .panel-content.show {
            display: block;
            background-color: lightgray; 
            font-size: 80%; 
            line-height: 1.5; 
        }

        .form_referral{
           
        }

        .form_referral.show{
            display: block;
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
                    <th>No</th>
                    <th>Student</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>Status</th>
                    <th>Notes</th>
                    <th>Referral</th>
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

    <section id="patients">
            <div class="container-two">
            
                <div class="make-referral">
                    <button type="button">LIST OF ALL PATIENTS</button>
                </div>
                
                <div class="search">
                    <input type="text" placeholder="Search Patients">
                
                </div>

                <div class="sort">
                    <label for="sort-by">Sort by:</label>
                    <select id="sort-by">
                    <option value="name">Name</option>
                    <option value="status">Status</option>
                    </select>
                </div>
            </div>
        <div class="panels">

            <?php 
            $stmt3= $conn->prepare("SELECT s.name, s.email, a.notes, a.date AS next_meeting
            FROM students AS s
            JOIN appointments AS a ON s.student_id = a.student_id
            WHERE a.counselor_id= ?"
            );

            $stmt3->bind_param("i", $id); 

            $stmt3->execute(); 

                $result3=$stmt3->get_result(); 
                
                if ($result3->num_rows > 0){
                    while ( $panel = $result3-> fetch_assoc()) {
                        $panel['next_meeting'] = date_format(date_create($panel['next_meeting']), 'l j M');
                    
?>
        <div class="panel">
            <div class="panel-header">
                
                <p> <strong><?php echo $panel["name"]; ?></strong></p>
                <p> <strong>Email:</strong> <?php echo $panel["email"]; ?></p>
                <p ><strong>The Next Meeting is on: </strong> <span style="color: green;"><?php echo $panel["next_meeting"]; ?></span></p>

            </div>
            <div class="panel-content">
           
                
                <p><strong>Notes:</strong>
                "There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain..."</p>



                <div class="make-referral">
                    <button type="button">MAKE A REFERRAL</button>
                </div>

                    

                    <form class="form_referral" action="">
                        <p>Refer a Student</p>
                        <p>Send a Referral to a counselor through email</p>
                        
                    
                        <label for="student_name">Student Name:</label>
                        <input type="text" id="student_name" name="student_name" value="<?php echo $panel["name"]; ?>"required>
                        
                        <label for="student_email">Student Email:</label>
                        <input type="email" id="student_email" name="student_email" value ="<?php echo $panel["email"]; ?>" required>
                        
                        <label for="referring_therapist_name">Referring Therapist Name:</label>
                        <input type="text" id="referring_therapist_name" name="referring_therapist_name" value ="<?php  echo $_SESSION["name"]; ?>" required>
                        
                        <label for="receiving_therapist_email">Receiving Therapist Email:</label>
                        <input type="email" id="receiving_therapist_email" name="receiving_therapist_email" required>
                        
                        <label for="issues_topics">Issues/Topics Addressed:</label>
                        <textarea id="issues_topics" name="issues_topics" rows="4" cols="50" required></textarea>
                        
                        <label for="specific_area_concern">Specific Area of Concern:</label>
                        <input type="text" id="specific_area_concern" name="specific_area_concern" required>
                        
                        <input type="submit" value="Submit">
                    </form> 
            
          
            </div>
        </div><?php
       }
     
    }?>
    </div>
       
	</section>



    <section class="referrals">
        
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