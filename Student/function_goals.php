<link rel="stylesheet" href="../CSS/style.css">
<div class="goal_div habits">
          <p style="text-align:center; font-size: 95%; font-weight: bold; margin: 20px 0px;">
          What do you want to track for a Week? </p>

          <form action ="../Backend/goals.php" method="post">
          <input type="text" name="goal" id="goal" placeholder="Name your Goal or Habit">
              <p style="color:lightgray; font-size: 80%; text-align: center; margin-bottom: 10px;">Track anything you want by entering its name above
                or choose from the options below
              </p>
          <div>
            <input type="radio" id="exercising" name="habits" value="exercising">
            <label for="exercising">Exercising</label>
          </div>
          <div>
            <input type="radio" id="meditating" name="habits" value="meditating">
            <label for="meditating">Meditating</label>
          </div>
          <div>
            <input type="radio" id="no_alcohol" name="habits" value="no_alcohol">
            <label for="no_alcohol">No alcohol</label>
          </div>
          <div>
            <input type="radio" id="get_up_early" name="habits" value="get_up_early">
            <label for="get_up_early">Get up early</label>
          </div>
          <div>
            <input type="radio" id="sleep_on_time" name="habits" value="sleep_on_time">
            <label for="sleep_on_time">Sleep on time</label>
          </div>
          <div>
            <input type="radio" id="budget" name="habits" value="budget">
            <label for="budget">Budget</label>
          </div>


          <input type="submit" value="Set Goal">

          <?php if(isset($error_message)): ?>
              <p style="color:red; text-align: center; font-size: 80%;"><?php echo $error_message; ?></p>
          <?php endif; ?>


          </form>
        </div> <!--end of first div-->


<div class="goal_div"
        style=" width: 40%;">
            <!-- tracking things-->

         <?php 
            $stmt = $conn->prepare("SELECT id, goal FROM goals WHERE student_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL 1 WEEK)");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $goal_id = $row['id'];
                $goal_name = $row['goal'];
            ?>
                <div class="goal_track">
                    <form action="../Backend/goal_tracking.php" method="post">    
                        <p>Did you achieve your goal today of <span style="text-decoration: underline; color: #00A86B; "><?php echo $goal_name; ?></span> ?</p>
                        <input type="hidden" name="goal_id" value="<?php echo $goal_id; ?>">
                        <input type="radio" id="yes" name="achieved" value="1">
                        <label for="yes">Yes</label>                    
                        <input type="radio" id="no" name="achieved" value="0">
                        <label for="no">No</label> <br>
                        <input type="submit" value="Submit">
                    </form>
                </div>
            <?php
            } 
            
            if ($result->num_rows == 0){
              ?>

              <div class="goal_track">
                  <p>No Goal to track</p>
              </div> <?php
            }
            
            $stmt->close(); ?>

                
</div>



<div class="goal_div">
     
      <input id="goal_name" placeholder=' search goal name' style="width: 75%; height: 30px; margin-bottom: 10px;border: 1px solid #ddd;border-radius: 5px;">
            <?php 
    $stmt = $conn->prepare ("SELECT TIMESTAMPDIFF(DAY, created_at, NOW()) > 7 AS result, id, goal
          FROM goals
          WHERE student_id = ?
          ORDER BY created_at ASC;");
           $stmt->bind_param ('i', $id); 
  
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows>0){

              $counter = 0;
              
              $count_goal = 0; 
              while ($data= $result->fetch_assoc()){
              $goal_name = $data["goal"]; 
              $stmt2 = $conn->prepare ("SELECT COUNT(*) as achieved_count 
              FROM weekly_goal_progress 
              WHERE goal_id = ? AND achieved = 1;
              ");
                $goalID = $data["id"];
                $stmt2->bind_param('i', $goalID );
                $stmt2-> execute(); 
                $result2 = $stmt2-> get_result();
                $row = $result2->fetch_assoc();
                $achieved_count = $row['achieved_count']; 
                $counter++;
                ?>

                <p class="goal-progress" style="margin-bottom: 10px;font-size: 85%;">
                  <strong><?php echo $counter;?></strong>. <?php echo $goal_name; ?>
                  <progress style='width: 140px;' value="<?php echo $achieved_count; ?>" max="7"></progress>
                  <span style="margin-left: 30%; "><?php echo $achieved_count; ?>/7</span>
                </p> <?php 
                 

            if ($counter >= 10) {
              break;
            }

          }}else {
            ?>

            <p class="goal-progress" style="margin-bottom: 10px;">
              No Goal Found!!
            </p> <?php 
          }

          ?>
</div>

<script>

  // Retrieve the input field and paragraphs
  var input = document.getElementById("goal_name");
  var paragraphs = document.getElementsByClassName("goal-progress");

  // Add an event listener to the input field
  input.addEventListener("input", function() {
    var inputValue = input.value.toLowerCase();

  // Loop through each paragraph
  for (var i = 0; i < paragraphs.length; i++) {
    var paragraph = paragraphs[i];
    var goalName = paragraph.textContent.toLowerCase();

    // Check if the goal name matches the input value
    if (goalName.includes(inputValue)) {
      paragraph.style.display = "block"; // Show the paragraph
    } else {
      paragraph.style.display = "none"; // Hide the paragraph
    }
  }
});

</script>