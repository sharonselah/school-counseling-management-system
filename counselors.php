<link rel="stylesheet" href="CSS/style.css">


<?php

include 'Backend/db.php'; 

$sql = "SELECT * FROM COUNSELORS";
$result = $conn->query($sql);

if ($result->num_rows > 0){?>
    <h2 style=" text-align: center; color: brown; padding: 10px;">LIST OF COUNSELORS</h2>
    <div class="counselors-container">
        <input type="search" placeholder="search counselor by name ..........." id="search_counselor">
    <div class="counselors">
   <?php while ($counselor = $result->fetch_assoc()){?>
       
            <div class="counselor">
                <div class= "img_container">
                    <img src="Images/user.png" alt="image">
                </div>
                <h3><?php echo $counselor["name"]; ?></h3>
                <p>Email: <?php echo $counselor["email"]; ?></p>
                <p>Specialty: <?php echo $counselor["specialty"];?></p>
            </div>
        
   <?php }?>
    </div>
    </div> 
<?php
}

?>
<script>
    let search_counselor = document.getElementById("search_counselor");
    let counselors = document.querySelectorAll(".counselor");


    search_counselor.addEventListener("input", function(){
        let searchValue = search_counselor.value.trim().toLowerCase();
        counselors.forEach(function(counselor){
            
            let counselorName = counselor.querySelector("h3").textContent.toLowerCase();
           
            if (counselorName.indexOf(searchValue) > -1){
                counselor.style.display ='block';
            }else {
                counselor.style.display ='none'; 
            }
           
        });
    });

    
</script>