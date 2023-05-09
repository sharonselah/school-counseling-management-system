<?php 


 
 $stmt = $conn-> prepare ("SELECT * from referrals Where receiving_therapist_id = $id"); 
 $stmt-> execute(); 
 //retrieve the result from the query 
 $result = $stmt->get_result();

?>

<style>
.accept-link, .reject-link {
  display: inline-block;
  padding: 8px 16px;
  background-color: #4CAF50;
  color: #fff;
  text-decoration: none;
  border: none;
  border-radius: 4px;
  font-size: 14px;
  font-weight: bold;
  cursor: pointer;
  margin-right: 10px;
}

.accept-link:hover, .reject-link:hover {
  background-color: #3e8e41;
}

.referrals{
    width: 65%; 
    margin-right: 20px; 
}




</style>


<section class="referrals">
    <h1>Referral Requests</h1>

        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Reason for Referral</th>
                    <th>Date of Referral</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody> <?php 

            if ($result->num_rows >0) {

                while ($referral = $result->fetch_assoc()) {

                    $stmt2= $conn -> prepare ('SELECT name from students where student_id = ?');
                    $stmt2->bind_param('i', $referral["student_id"]);  
                    $stmt2 -> execute(); 
                   
                    $result2 = $stmt2-> get_result();
                    
                    $student = $result2-> fetch_assoc(); 

                    echo "<tr> 
                    <td> ". $student["name"] . "</td>
                    <td> ". $referral["reason"] . "</td>
                    <td> ". $referral["date"] . "</td>
                    <td>";
            if ($referral['Accept'] == '') {
                echo "<a href='Referrals/updatereferal.php?id=".$referral["id"]."' class='accept-link'>Accept</a>";
                echo "<a href='Referrals/rejectreferal.php?id=".$referral["id"]."' class='reject-link'>Reject</a>";
            } elseif ($referral["Accept"] == TRUE) {
                echo "Accepted";
            } else {
                echo "Rejected";
            }
            echo "</td></tr>";
            
                    


                
            }}?>
            </tbody>
        </table>
</section>
