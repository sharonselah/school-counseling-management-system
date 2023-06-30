
<div id ="appointments">
    <h2 style="text-align: center;" >Appointments</h2>
        
              <label for="status">Status:</label>
              <select id="status" name="status" style= "padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                  <option value="">-- Select --</option>
                  <option value="pending">pending</option>
                  <option value="confirmed">confirmed</option>
                  <option value="canceled">canceled</option>
                  <option value="overdue">overdue</option>
              </select>
             
        <?php 
      $stmt = $conn->prepare("SELECT * FROM appointments WHERE student_id = ? ORDER BY created_at DESC");
      $stmt->bind_param('i', $id);              
      $stmt->execute();
      $result = $stmt->get_result();
    ?>

<table id ="myTable" class="table" style="min-width: 100%;">
  <thead>
    <tr>
      <th>Counselor Name</th>
      <th>Date</th>
      <th>Start Time</th>
      <th>Status</th>
    
    </tr>
  </thead>
  <?php if ($result->num_rows > 0) { ?>
    <tbody>
      <?php while ($row = $result->fetch_assoc()) {
        // checking status
        $appointment_date_time = $row['date'];
        $current_date = date("Y-m-d");
        $counselor_id = $row["counselor_id"]; 
        $stmt2 = $conn->prepare ("SELECT name from counselors where counselor_id = $counselor_id"); 
        $stmt2-> execute(); 
        $result2 = $stmt2->get_result(); 
        $counselor =$result2-> fetch_assoc(); 
        // Full name of the day of the week; Day of the month; abb name of the month
        $row['date'] = date_format(date_create($row['date']), 'l j M');
        echo "<tr><td>" . $counselor["name"] . "</td><td>" . $row["date"] . "</td><td>" . $row["start_time"] . "</td>
              <td style='color:blue;'>" .$row["status"]. "</td></tr>";
      } ?>
    </tbody>
  <?php } else {
    // Check if there were no rows returned from the query
    echo "<tr><td colspan='10' style='text-align:center; font-size: 24px; color: red;'> <br>
      No pending appointments. Book an appointment now!</td></tr>";
  } ?>
</table>
   </div>