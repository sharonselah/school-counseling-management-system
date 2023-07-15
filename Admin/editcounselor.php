<?php



// Connect to database and get user ID from URL parameter
include '../Backend/db.php';
$id = $_GET["id"];

// Get user data from database
$stmt = $conn->prepare("SELECT * FROM counselors WHERE counselor_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$userSpecialties = explode(',', $user['specialty']); //break a string into an array

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get new name and specialty from form
    $name = $_POST["name"];
    $userSpecialties = $_POST['specialties']; // stores the data as an array
    $email = $_POST['email'];


    //count method - returns the number of elements in an array
    if (count($userSpecialties) > 2) {
        // More than 2 specialties user
        header("Location: admindashboard.php?error=too_many_specialties");
        exit();
    }

    $userSpecialties = implode(',', $_POST['specialties']); // change to a string
    

    // Update user data in database
    $stmt = $conn->prepare("UPDATE counselors SET name = ?, specialty = ?, email =? WHERE counselor_id = ?");
    $stmt->bind_param("sssi", $name, $userSpecialties, $email, $id);

    if ( $stmt->execute()){
        
        // Redirect back to user list
        header("Location: admindashboard.php");
        exit();
    }else {
        echo "Could not update";
    }
   

}
?>

<style>

    form{

    height: 400px; 
    width: 400px; 
    border-radius: 6px;
    margin: 20px auto; 
    box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
    padding: 25px; 
    padding-top: 5px; 
}

input[type="text"]{
    width: 100%;  
    padding-top: 32px; 
    margin: 10px 0px; 
    border: none; 
    outline: none;
    border: 1px solid black; 
    border-radius: 6px;
}

button{
    background-color: #800000; 
    border: 1px solid #800000; 
    border-radius: 6px; 
    font-size: 18px;
    font-weight: 500;
    line-height: 1.2;
    list-style: none;
    padding: 15px 45px;
    transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
    color: white; 
    margin-left: 30%; 
}



</style>

<!-- Display form with current user data -->

    <form method="POST" id="edit_form">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $user['name']; ?>"><br><br>
        <label for="specialty">Specialty: (Choose upto 2) </label><br> <br>

        <div style="display:flex; justify-content:space-around;">
        <!-- in array -searches an array for a specific value -->
        <div>
            <input type="checkbox" name="specialties[]" value="Substance Abuse Counseling" <?php if (in_array('Substance Abuse Counseling', $userSpecialties)) echo 'checked'; ?>> Substance Abuse Counseling <br><br>
            <input type="checkbox" name="specialties[]" value="Trauma Therapy" <?php if (in_array('Trauma Therapy', $userSpecialties)) echo 'checked'; ?>> Trauma Therapy <br> <br>
            <input type="checkbox" name="specialties[]" value="Career Counseling" <?php if (in_array('Career Counseling', $userSpecialties)) echo 'checked'; ?>> Career Counseling <br> <br>
            
        </div>

        <div>
            <input type="checkbox" name="specialties[]" value="Stress Management" <?php if (in_array('Stress Management', $userSpecialties)) echo 'checked'; ?>> Stress Management<br> <br>
            <input type="checkbox" name="specialties[]" value="Self-esteem Building" <?php if (in_array('Self-esteem Building', $userSpecialties)) echo 'checked'; ?>> Self-esteem Building<br> <br>
            <input type="checkbox" name="specialties[]" value="Relationship Counseling" <?php if (in_array('Relationship Counseling', $userSpecialties)) echo 'checked'; ?>> Relationship Counseling<br> <br>
        </div>

        </div>
            
<!-- Add more specialties as needed -->

        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo $user['email']; ?>"><br><br>
        <button type="submit" id="edit-button">Save</button>
    </form>


<script>

document.getElementById('edit-button').addEventListener('click', function(){ 
    confirm('Are you Sure you want to update?') });

    
</script>
