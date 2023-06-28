<?php 
        
        $sql = "SELECT * FROM counselors  WHERE status ='active' ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) { ?>

            <div class="header">
                <a href="CounselorSignup.php" class="add-button">Add New Counselor+</a>
                    <div class="search-bar">
                        <input type="search" name="search" id="search" placeholder="Search by Name">
                    </div>
                    <div class="sort-buttons">
                        <p>Sort by:</p>
                        <button style="background-color: #CC8E58;" id="Nothing">Default</button>
                        <button id="sortName">Name</button>
                        <button id="sortSpeciality">Specialty</button>
                    </div>
            </div>

            <p style="" ><?php echo "Total Number of Active Counselors:" . $result->num_rows; ?></p>



        <table id ="table" class="table" style="width: 100%;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Speciality</th>
                    <th>Email</th>
                    <th>Start Date</th>
                    <th>Update</th>
                    <th>Delete</th>
                    
                </tr>
            </thead> <?php }?>
            <tbody>
            <tr>
               <?php
               while ($row = $result->fetch_assoc()) {

                $start_time_full = $row["created_at"];
                $start_time = date("Y-m-d", strtotime($start_time_full));
                echo "<tr style='border-bottom: 1px solid lightgray;'><td>" . $row["name"] . "</td><td>" . $row["specialty"] . "</td><td>" . $row["email"] . "</td><td>" . $start_time . "</td>
                <td><a href='editcounselor.php?id= " . $row['counselor_id']. " ?>'><img src='../Images/edit1.png' alt='Edit'></a></td>

                <td><a href='deletecounselor.php?id=". $row ["counselor_id"]."'><img src='../Images/remove.png' alt='Edit'></a></td></tr>"; 
            }

            ?>
            </tr>
            </tbody>
        </table>