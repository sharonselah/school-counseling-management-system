


<style> 
        .container-three{
        display: flex; 
        flex-direction: row;   
        
        }

       .panels{
        width: 65%; 
        margin-right: 20px; 
       }

       
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


          

</style>

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

            <div class="container-three">
                <div  class="panels">

                    <table class="table">
                        <thead>
                            <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Total Appointments</th>
                            <th>All Notes</th>
                            <th>Referal</th>
                            </tr>
                        </thead> 
                        <tbody> 

                        <?php 

                    if ($result3->num_rows > 0){

                    while ( $panel = $result3-> fetch_assoc()) {?>
                    <tr>
                    <td><?php echo $panel["name"];  ?></td>  
                    <td><?php echo $panel["email"];  ?></td>  
                    <td><?php echo $panel["appointment_count"];?></td>  
                    <td><a href="?id=<?php echo $panel["student_id"]; ?>" class="open-notes">View Notes</a></td>
                    <td><a href="Referrals/makereferal.php?id=<?php echo $panel["student_id"];?>" id="confirm_btn1">Refer</a></td>
                    
                    </tr> <?php }}?>
                </tbody>
                </table>
            </div> 

            <div id="div2" style="">

            <div class="notes_show">

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Open</th>
                        
                    </tr>
                 </thead>
                
                <tbody>

                    
          <?php 

                if (isset($_GET['id'])) {
                    $student = $_GET['id'];
                    $stmt5->bind_param('ii', $id, $student);
                    $stmt5-> execute(); 
                    $result5 = $stmt5->get_result();
                      
                
                        if ($result5-> num_rows >0){
                            $noteid =1; 
                
                                while ($notes=$result5->fetch_assoc()){
                                    echo"<tr>
                                    <td>".$noteid++."</td>
                                    <td>".$notes["title"]."</td>
                                    <td><a href='opennote.php?id=". $notes["note_id"]."' class='open-notes'>Open</a></td>
                                    </tr>"; 
                                
                                    
                                }  
                        }

                        else {
                                echo "<tr><td style='color:red;'>No Notes to show</td></tr>";
                               
                            } 
                        
                        }?>
                            
                            </tbody>
                               </table>
                               <button class="remove"><a href="?" >Remove ID</a></button>

                             

                              

                               </div> 

            </div>
                       

            

            
        </div>
       
	</section>
