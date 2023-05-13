<?php 


 
 $stmt = $conn-> prepare ("SELECT * from referrals Where receiving_therapist_id = ?"); 
 $stmt->bind_param('i', $id); 
 $stmt-> execute(); 
 $result = $stmt->get_result();

 $stmt2 = $conn-> prepare ("SELECT * from referrals Where referring_therapist_id = ?");
 $stmt2->bind_param('i', $id);  
 $stmt2->execute(); 
 $result2 = $stmt2->get_result(); 

?>

<style>
    table{
        width: 100%; 
    }
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
    width: 100%; 
    margin-right: 20px; 
}

</style>

<section class="referrals">
    <h1 style="text-align: center; color: brown; font-size: 105%;">LIST OF REFERRALS YOU RECEIVED</h1>

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

                    $stmt= $conn -> prepare ('SELECT name from students where student_id = ?');
                    $stmt->bind_param('i', $referral["student_id"]);  
                    $stmt-> execute(); 
                    $result= $stmt-> get_result();
                    $student = $result-> fetch_assoc(); 

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
            }}
            
            else{
                echo "<td>No referrals so far</td>"; 
            }
            ?>
            </tbody>
        </table>
        </section>

        
        <section style="margin-top: 200px; background-color: #E5E4E2; min-height: 500px;">

        <h1 style="text-align: center; color: brown; font-size: 105%;">LIST OF REFERRALS YOU SENT OUT</h1>
        
        <table >
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Reason for Referral</th>
                    <th>Date of Referral</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody> <?php 

            if ($result2->num_rows > 0) {

                while ($referrals = $result2->fetch_assoc()) {

                    $stmt= $conn -> prepare ('SELECT name from students where student_id = ?');
                    $stmt->bind_param('i', $referrals["student_id"]);  
                    $stmt -> execute(); 
                    $result = $stmt-> get_result();
                    $student = $result-> fetch_assoc(); 

                    echo "<tr> 
                    <td> ". $student["name"] . "</td>
                    <td> ". $referrals["reason"] . "</td>
                    <td> ". $referrals["date"] . "</td>
                    <td style='color:red;'>";
                    if ($referrals['Accept'] == '') {
                        echo "Pending";
                     
                    } elseif ($referrals["Accept"] == TRUE) {
                        echo "Accepted";
                    } else {
                        echo "Rejected";
                    }
                    echo "</td></tr>";  
                    
            }}
            
            else{
                echo "<td>You have not received any referrals so far</td>"; 
            }
            ?>
            </tbody>
        </table>
        </section>

