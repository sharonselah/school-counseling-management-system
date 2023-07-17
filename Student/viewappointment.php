<style>
  
  #snapshot .appointment .division-two .details p{
  border-left: 12px solid #66CDAA;
  border-right: 12px solid #66CDAA;
  padding: 6px; 
  border-bottom: 1px solid lightgrey; 
}

</style>

<?php  if ($result2->num_rows == 1) {

    if ($status == 'rescheduled'){?>
        <div class="division-two"> 
          
          <div class="appointment-card">
            <div class="details">
              <p style="color: red;">!! APPOINTMENT HAS BEEN RESCHEDULED!!</p>
              <p> &#10013 CUEA Counseling Department &#10013</p>
              <p>&#9410 <?php echo $cName;?></p>

              <p>&#9202 <?php echo $appointment_details?></p>
              <p>&#10084 For <?php echo $_SESSION["name"]?></p>
              <p style="display: flex; justify-content: space-between;align-items: center;"> 
              <a style="color:blue; font-size: 80%;text-decoration: underline;"href="confirmappointment.php?id=<?php echo $appointment_id;?>">Confirm Appointment</a>
              <a style ='color:red;  text-decoration: underline; font-size:80%;' href="../Appointment/deleteappointment.php?id=<?php echo $appointment_id;?>">Cancel Appointment</a></p>
          </div>

          <div class="confirm"> 
            <?php if ($status == "rescheduled"){?>
              <p>&#128284 <span style="font-weight:bold;">Appointment has been rescheduled. <br>
              Confirm your attendance </p>
            <?php }?>
              
          </div>
        </div>
      </div>
   <?php }
    else {
        ?>

    
    <div class="division-two"> 
      <div class="appointment-card">
        <div class="details">
          <p style="color: red;">!! APPOINTMENT REQUEST SENT !!</p>
          <p> &#10013 CUEA Counseling Department &#10013</p>
          <p>&#9410 <?php echo $cName;?></p>
          <p>&#9202 <?php echo $appointment_details?></p>
          <p>&#10084 For <?php echo $_SESSION["name"]?></p>
          <p><a style ='color:red;  text-decoration: underline; cursor:pointer; font-size:80%;' href="../Appointment/deleteappointment.php?id=<?php echo $appointment_id;?>">Cancel Appointment</a></p>
        </div>

        <div class="confirm"> 
          <?php if ($status == "pending"){?>
            <p>&#128284 <span style="font-weight:bold;">Appointment request sent</span> <br>It will be confirmed soon by the therapist</p>
          <?php } else if ($status== "confirmed"){?>
            <p>&#128394 <span style="font-weight:bold; color: green; ">Appointment confirmed</span> </p>
          <?php }else {?>
            <p>&#10060 <span style="font-weight:bold;color: red; ">Appointment canceled</p>
          <?php }?>
        </div>

      </div>

    </div> 
    <?php
}?>
  <?php }?>
</div> <!-- end of appointment -->


  

