<div id="snapshot"> 

    <div class="profile" style=" font-size: 88%;">
      
        <p style="margin-bottom:0px; color: brown;">Your Profile</p>
            <img src="../Images/user-icon.jpg" alt="">
            <p style="margin-bottom:0px;"><?php echo $_SESSION['name']; ?></p>
            <p style="margin-top:5px; color: gray; font-size: 85%;">Student</p>

            <div style="text-align:center; line-height: 1.8;">
                <div>Appointments: <?php echo $totalAppointments; ?></div>
                <span> </span>
                <div>Goals: <?php echo $totalGoals; ?></div>
            </div>
          <div class="complete">
            <button><a href="../Backend/editprofile.php" style="color: white;">Manage Your Profile</a></button>
          </div>
    </div><!-- end of profile --> 

    <div class="appointment"> <!-- start of appointment--> 
  <p style="font-size: 88%; font-weight: bolder; color: brown; margin-bottom: 10px;">Manage Appointments</p>

  <?php if ($result2->num_rows == 0){?>
    <div class="division one">
      <div class="none">

        <p><span style="color: brown; font-size: 35px;">Nothing to see yet ...</span> <br>
        Let's get started! You're one step closer to feeling better &#129315 <br>
        Book an appointment now and
        <span style="color: brown; text-decoration: underline;">take the first step </span> towards a happier, healthier you! 🌟 
        </p>

        <button><a href="../Appointment/appointment.php" style="color: white; font-size: 110%;">Book an Appointment</a></button>
      </div>
    </div> 
  <?php }?>

 <?php include 'viewappointment.php'; ?>


<div class="goal_manage" style="width: 22%;"> <!-- start of goal-->

<div class="managegoals" 
    style=" height: 42vh; background-color: #F5F5F5; 
    border-radius: 10px; padding: 10px; display: flex; flex-direction: column; justify-content: space-between; ">

    <p style="margin-top: 15%; line-height: 3rem; font-size: 90%; ">"&#127919 Setting goals is the first step in turning the invisible into the visible 
    &#128640."</p>

    <button><a href="goals.php">Manage Goals</a></button>
                              
</div> <!--end of manage goals-->

 <div class="readPsych" style ="height: 25vh; background-color:white;
padding: 10px; margin-top: 10px; display: flex; flex-direction: column; justify-content: end; ">
 <p style="line-height: 1.5rem; font-size: 80%;" >Equip yourself with knowledge on mental health!! Click to Open 
 <span style ="padding: 10px; background-color: #00A86B;"> <a href="https://psychcentral.com/" 
 style="text-decoration: none; font-size: 20px; "> &#10145;</a></span> </p></div>
</div>
        
</div> <!-- end of snapshot-->