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
              <a href="#" style="color:red; font-size: 80%;text-decoration: underline;" onclick="toggleForm(<?php echo $appointment_id; ?>)">Cancel Appointment</a>

                  <form id="cancelForm" action="" method="POST" style="display: none; width: 65%; max-height: 30vh; background-color: white; line-height: 2; ">
                    <label for="reason">Reason for Cancelation:</label><br>
                    <select name="reason" id="reason">
                      <option value="unforeseen_circumstances">Unforeseen Circumstances</option>
                      <option value="schedule_conflict">Schedule Conflict</option>
                      <option value="medical_emergency">Medical Emergency</option>
                      <option value="other">Other</option>
                    </select><br>
                    <label for="other_reason">Other Reason:</label><br>
                    <textarea name="other_reason" id="other_reason" rows="3" cols="25" placeholder="Please specify if you selected 'Other'"></textarea><br>
                    <input type="hidden" name="student_id" id="student_id" value="<?php echo $id;?>">
                    <input type="hidden" name="appointment_id" id="appointment_id" value="">
                    <input type="submit" value="Submit" onclick="return confirm('Are you sure you want to cancel the appointment?');">
                  </form>
          
            </p>
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


  

