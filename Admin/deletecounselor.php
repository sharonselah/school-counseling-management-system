<?php


include '../Backend/db.php'; 


if ($_SERVER["REQUEST_METHOD"]=="POST"){
    // Get the user ID from the query parameter
    $id = $_GET["id"];

    $terminationReason = $_POST['termination_reason'];

    if ($terminationReason === 'Other' && isset($_POST['custom_reason'])) {
        $terminationReason = $_POST['custom_reason'];
    }

    // Perform the delete operation
    $stmt = $conn->prepare("UPDATE counselors SET status = ? WHERE counselor_id = ?");
    $status = 'terminated';
    $stmt->bind_param("si", $status, $id);


if ($stmt->execute()){


    //delete from users table 

    $stmt = $conn->prepare ("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()){
        $stmt = $conn->prepare("INSERT INTO counselor_terminations (counselor_id , termination_reason) VALUES (?,?)");
        $stmt->bind_param('is', $id, $terminationReason); 
        if ($stmt->execute()){
              // Redirect back to the admin dashboard
            header("Location: admindashboard.php?delete=success");
            exit();
        }
      
    }

   
}else {
     header("Location: admindashboard.php?delete=failure");
    exit();
}

}

?>


<form method="POST" action="">

  <label for="termination_reason">Termination Reason:</label>

  <select name="termination_reason">
    <option value="Performance Issues">Performance Issues</option>
    <option value="Breach of Code of Conduct">Breach of Code of Conduct</option>
    <option value="Violation of Policies">Violation of Policies</option>
    <option value="Insubordination">Insubordination</option>
    <option value="Attendance Issues">Attendance Issues</option>
    <option value="Misconduct">Misconduct</option>
    <option value="Other">Other</option>
  </select><br><br>
  
  <div id="other_reason" style="display: none;">
    <label for="custom_reason">Specify Other Reason:</label>
    <input type="text" name="custom_reason">
  </div>
  
  <input type="submit" value="Submit">
</form>


<script>
  document.querySelector('select[name="termination_reason"]').addEventListener('change', function() {
    var otherReasonDiv = document.getElementById('other_reason');
    if (this.value === 'Other') {
      otherReasonDiv.style.display = 'block';
    } else {
      otherReasonDiv.style.display = 'none';
    }
  });
</script>

