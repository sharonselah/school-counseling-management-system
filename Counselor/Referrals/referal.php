
<style> 
       
       .open-notes {
        color: blue; 
        font-size: 95%; 
        text-decoration: underline; 
          
        }

        .remove{
            padding: 10px 28px; 
            background-color:gray;
            border:1px solid gray; 
            margin-left: 140px;  
            
        }

        .remove a{
            color: white; 
        }

        #top, #patients{
            min-height: 500px; 
        }

        #name, #email{
            height: 20px; 
            border:1px solid gray; 
            border-radius: 10px; 
            padding: 10px; 
            
        }
        .p{
            text-align:center; 
            color:brown; 
            font-weight: bold; 
            font-size: 105%;
        }

</style>

<section id="patients">
    <p class="p">PATIENT DASHBOARD</p>
    <p class="p" style="font-size: 100%;">List of all my Patients</p>
    <p class="p" style="font-size: 100%;">Total Number of Patients: <?php echo $result3->num_rows;?></p>
      
 

            <div class="container-three">
               
                    <table class="table">
                        <thead>
                        <tr>
                            <th><input id ="name" type="text" placeholder="Filter by name"/></th>
                            <th><input id ="email" type="text" placeholder="Filter by email"/></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Total Appointments</th>
                            <th>All Notes</th>
                            <th>Review</th>
                            <th>Referal</th>
                        </tr>
                        </thead> 
                        <tbody id="tbody"> 

                        <?php 

                    if ($result3->num_rows > 0){

                    while ( $panel = $result3-> fetch_assoc()) {?>
                    <tr>
                    <td><?php echo $panel["name"];  ?></td>  
                    <td><?php echo $panel["email"];  ?></td>  
                    <td><?php echo $panel["appointment_count"];?></td>  
                    <td><a href="viewnotes.php?id=<?php echo $panel["student_id"];?>" class="open-notes">View Notes</a></td>
                    <td><a href="Referrals/makereview.php?id=<?php echo $panel["student_id"];?>" id="confirm_btn1">Review</a></td>
                    <td><a href="Referrals/makereferal.php?id=<?php echo $panel["student_id"];?>" id="confirm_btn1">Refer</a></td>
                   
                    </tr> <?php }}?>
                </tbody>
                </table>
            </div> 
            </section>

          
