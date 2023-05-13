<style>
    th, td {
        padding: 10px;
        text-align: center;
        border: 1px solid #ddd;
    }

    th {
        background-color: #edecec;
        color:black; 
        text-transform: uppercase;
    }
</style>

<?php 

include '../Backend/db.php'; 


session_start(); 
//counselor's id 
$id = $_SESSION['user_id']; 

?>

<div class="notes_show">

<table class="table" style="width: 40%; margin: auto; border-collapse: collapse;">
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
        //notes 

 $stmt5 = $conn->prepare("SELECT * FROM notes where counselor_id = ? and student_id = ?"); 
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
            <button 
            style="height: 30px; width: 150px; background-color:lightgray; border: none; padding: 10px; margin-left: 50%;" >
            <a style ="color: black; border-radius: 10px;" href="counselordashboard.php" >Go Back</a></button>

        </div> 
</div>
